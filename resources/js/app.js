import './bootstrap';

const normalizeCommaSeparated = (rawValue) => {
    if (!rawValue) {
        return [];
    }

    return rawValue
        .split(',')
        .map((item) => item.trim())
        .filter((item) => item.length > 0);
};

const parseCatalog = (rawCatalog) => {
    if (!rawCatalog) {
        return {};
    }

    try {
        return JSON.parse(rawCatalog);
    } catch {
        return {};
    }
};

const setupDynamicChecklist = (repeater, config) => {
    const catalog = parseCatalog(repeater?.dataset?.[config.catalogDatasetKey]);
    if (!Object.keys(catalog).length) {
        return;
    }

    const ensureItemInCatalog = (groupKey, label) => {
        const value = label.trim();
        if (!groupKey || !value) {
            return;
        }

        if (!Array.isArray(catalog[groupKey])) {
            catalog[groupKey] = [];
        }

        const exists = catalog[groupKey].some((item) => item.toLowerCase() === value.toLowerCase());
        if (!exists) {
            catalog[groupKey].push(value);
        }
    };

    const renderOptions = (row, selectedValues = []) => {
        const groupSelect = row.querySelector(config.groupSelectSelector);
        const optionsContainer = row.querySelector(config.optionsContainerSelector);

        if (!groupSelect || !optionsContainer) {
            return;
        }

        const groupKey = groupSelect.value;
        const options = catalog[groupKey] ?? [];
        const namePrefix = optionsContainer.dataset.namePrefix;
        const selectedSet = new Set((selectedValues ?? []).map((item) => item.toLowerCase()));

        optionsContainer.innerHTML = '';

        options.forEach((optionValue, idx) => {
            const inputId = `${config.idPrefix}_${Math.random().toString(36).slice(2)}_${idx}`;
            const label = document.createElement('label');
            label.className = 'inline-flex items-center gap-2 text-sm';
            label.setAttribute('for', inputId);

            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.className = 'rounded border-slate-300 text-indigo-600 focus:ring-indigo-500';
            checkbox.name = namePrefix;
            checkbox.value = optionValue;
            checkbox.id = inputId;
            checkbox.checked = selectedSet.has(optionValue.toLowerCase());

            const text = document.createElement('span');
            text.textContent = optionValue;

            label.appendChild(checkbox);
            label.appendChild(text);
            optionsContainer.appendChild(label);
        });
    };

    const initRow = (row) => {
        const groupSelect = row.querySelector(config.groupSelectSelector);
        const addButton = row.querySelector(config.addButtonSelector);
        const customInput = row.querySelector(config.customInputSelector);

        if (!groupSelect) {
            return;
        }

        groupSelect.addEventListener('change', () => renderOptions(row));

        if (addButton && customInput) {
            addButton.addEventListener('click', () => {
                const groupKey = groupSelect.value;
                const newValues = normalizeCommaSeparated(customInput.value);

                if (!newValues.length) {
                    return;
                }

                newValues.forEach((value) => ensureItemInCatalog(groupKey, value));
                renderOptions(row, newValues);
            });
        }

        renderOptions(row);
    };

    repeater.querySelectorAll(config.rowSelector).forEach((row) => initRow(row));
};

const hydrateDiseaseRows = (repeater) => {
    setupDynamicChecklist(repeater, {
        catalogDatasetKey: 'diseaseCatalog',
        rowSelector: '[data-disease-row]',
        groupSelectSelector: '[data-disease-species]',
        optionsContainerSelector: '[data-disease-options]',
        customInputSelector: '[data-custom-disease-input]',
        addButtonSelector: '[data-add-disease]',
        idPrefix: 'disease',
    });
};

const hydrateMedicineRows = (repeater) => {
    setupDynamicChecklist(repeater, {
        catalogDatasetKey: 'medicineCatalog',
        rowSelector: '[data-medicine-row]',
        groupSelectSelector: '[data-medicine-category]',
        optionsContainerSelector: '[data-medicine-options]',
        customInputSelector: '[data-custom-medicine-input]',
        addButtonSelector: '[data-add-medicine]',
        idPrefix: 'medicine',
    });
};

document.addEventListener('click', (event) => {
    const addButton = event.target.closest('[data-add-item]');

    if (addButton) {
        const repeater = addButton.closest('[data-repeater]');
        if (!repeater) {
            return;
        }

        const list = repeater.querySelector('[data-list]');
        const template = repeater.querySelector('template');
        const index = list.children.length;
        const html = template.innerHTML.replace(/__INDEX__/g, String(index));
        list.insertAdjacentHTML('beforeend', html);

        hydrateDiseaseRows(repeater);
        hydrateMedicineRows(repeater);
    }

    const removeButton = event.target.closest('[data-remove-item]');
    if (removeButton) {
        removeButton.closest('[data-item]')?.remove();
    }
});

document.querySelectorAll('[data-disease-catalog]').forEach((repeater) => hydrateDiseaseRows(repeater));
document.querySelectorAll('[data-medicine-catalog]').forEach((repeater) => hydrateMedicineRows(repeater));

const branchSelect = document.getElementById('branch_id');
const wilayaInput = document.getElementById('wilaya_input');

if (branchSelect && wilayaInput) {
    const updateWilaya = () => {
        const selected = branchSelect.options[branchSelect.selectedIndex];
        wilayaInput.value = selected?.dataset?.wilaya ?? '';
    };

    branchSelect.addEventListener('change', updateWilaya);
    updateWilaya();
}
