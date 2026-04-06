<?php

namespace App\Http\Controllers;

use App\Models\WilayaInspectorate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminWilayaInspectorateController extends Controller
{
    public function index(): View
    {
        return view('admin.inspectorates.index', [
            'inspectorates' => WilayaInspectorate::query()->withCount('branches')->orderBy('name')->paginate(15),
        ]);
    }

    public function create(): View
    {
        return view('admin.inspectorates.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', 'unique:wilaya_inspectorates,name'],
            'code' => ['required', 'string', 'max:60', 'unique:wilaya_inspectorates,code'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        WilayaInspectorate::query()->create($data);

        return redirect()->route('admin.inspectorates.index')->with('status', 'Inspectorate created successfully.');
    }

    public function edit(WilayaInspectorate $inspectorate): View
    {
        return view('admin.inspectorates.edit', [
            'inspectorate' => $inspectorate,
        ]);
    }

    public function update(Request $request, WilayaInspectorate $inspectorate): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:150', Rule::unique('wilaya_inspectorates', 'name')->ignore($inspectorate->id)],
            'code' => ['required', 'string', 'max:60', Rule::unique('wilaya_inspectorates', 'code')->ignore($inspectorate->id)],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);

        $inspectorate->update($data);

        // Keep branch wilaya synchronized with inspectorate name.
        $inspectorate->branches()->update(['wilaya' => $inspectorate->name]);

        return redirect()->route('admin.inspectorates.index')->with('status', 'Inspectorate updated successfully.');
    }

    public function destroy(WilayaInspectorate $inspectorate): RedirectResponse
    {
        if ($inspectorate->branches()->exists()) {
            return back()->withErrors([
                'inspectorate' => 'Cannot delete inspectorate while it has linked branches.',
            ]);
        }

        $inspectorate->delete();

        return redirect()->route('admin.inspectorates.index')->with('status', 'Inspectorate deleted successfully.');
    }
}