<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\WilayaInspectorate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminBranchController extends Controller
{
    public function index(): View
    {
        return view('admin.branches.index', [
            'branches' => Branch::query()->with('inspectorate')->orderBy('wilaya')->orderBy('name')->paginate(20),
        ]);
    }

    public function create(): View
    {
        return view('admin.branches.create', [
            'inspectorates' => WilayaInspectorate::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:60', 'unique:branches,code'],
            'wilaya_inspectorate_id' => ['required', 'exists:wilaya_inspectorates,id'],
        ]);

        $inspectorate = WilayaInspectorate::query()->findOrFail((int) $data['wilaya_inspectorate_id']);

        Branch::query()->create([
            'name' => $data['name'],
            'code' => $data['code'],
            'wilaya_inspectorate_id' => $inspectorate->id,
            'wilaya' => $inspectorate->name,
        ]);

        return redirect()->route('admin.branches.index')->with('status', 'Branch created successfully.');
    }

    public function edit(Branch $branch): View
    {
        return view('admin.branches.edit', [
            'branch' => $branch,
            'inspectorates' => WilayaInspectorate::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Branch $branch): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150'],
            'code' => ['required', 'string', 'max:60', Rule::unique('branches', 'code')->ignore($branch->id)],
            'wilaya_inspectorate_id' => ['required', 'exists:wilaya_inspectorates,id'],
        ]);

        $inspectorate = WilayaInspectorate::query()->findOrFail((int) $data['wilaya_inspectorate_id']);

        $branch->update([
            'name' => $data['name'],
            'code' => $data['code'],
            'wilaya_inspectorate_id' => $inspectorate->id,
            'wilaya' => $inspectorate->name,
        ]);

        return redirect()->route('admin.branches.index')->with('status', 'Branch updated successfully.');
    }

    public function destroy(Branch $branch): RedirectResponse
    {
        if ($branch->users()->exists() || $branch->reports()->exists()) {
            return back()->withErrors([
                'branch' => 'Cannot delete branch while linked users or reports exist.',
            ]);
        }

        $branch->delete();

        return redirect()->route('admin.branches.index')->with('status', 'Branch deleted successfully.');
    }
}