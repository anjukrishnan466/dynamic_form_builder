@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Form</h2>
    <form method="POST" action="{{ route('form.store') }}">
        @csrf

        <div class="mb-3">
            <label for="form_name" class="form-label">Form Name</label>
            <input type="text" class="form-control" id="form_name" name="form_name" required>
        </div>

        <hr>
        <h4>Add Fields</h4>
        <div id="field-container">
            <div class="field-group row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="labels[]" placeholder="Label" required>
                </div>
                <div class="col-md-3">
                    <select name="types[]" class="form-control type-selector" onchange="toggleOptions(this)" required>
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="email">Email</option>
                        <option value="textarea">Textarea</option>
                        <option value="select">Dropdown</option>
                        <option value="checkbox">Checkbox</option>
                        <option value="radio">Radio</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control options-field" name="options[]" placeholder="Comma-separated options (for select, checkbox, radio)" style="display: none;">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field">Remove</button>
                </div>
            </div>
        </div>

        <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>
        <button type="submit" class="btn btn-primary">Create Form</button>
    </form>
</div>

<script>
    function toggleOptions(selectElement) {
        const selectedType = selectElement.value;
        const fieldGroup = selectElement.closest('.field-group');
        const optionsField = fieldGroup.querySelector('.options-field');

        if (['select', 'checkbox', 'radio'].includes(selectedType)) {
            optionsField.style.display = 'block';
        } else {
            optionsField.style.display = 'none';
        }
    }

    document.getElementById('add-field').addEventListener('click', function () {
        const container = document.getElementById('field-container');
        const firstFieldGroup = container.querySelector('.field-group');
        const clone = firstFieldGroup.cloneNode(true);

        // Reset values
        clone.querySelectorAll('input').forEach(input => input.value = '');
        clone.querySelector('.options-field').style.display = 'none';
        clone.querySelector('select').selectedIndex = 0;

        container.appendChild(clone);
    });

    document.addEventListener('change', function (e) {
        if (e.target && e.target.classList.contains('type-selector')) {
            toggleOptions(e.target);
        }
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-field')) {
            const fieldGroups = document.querySelectorAll('.field-group');
            if (fieldGroups.length > 1) {
                e.target.closest('.field-group').remove();
            }
        }
    });
</script>
@endsection
