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
                    <select name="types[]" class="form-control" onchange="toggleOptions(this)">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="select">Dropdown</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control options-field" name="options[]" placeholder="Comma-separated options (only for dropdown)" style="display: none;">
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
    document.getElementById('add-field').addEventListener('click', function () {
        const container = document.getElementById('field-container');
        const fieldGroup = container.querySelector('.field-group');
        const clone = fieldGroup.cloneNode(true);
        clone.querySelectorAll('input').forEach(input => input.value = '');
        clone.querySelector('.options-field').style.display = 'none';
        container.appendChild(clone);
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-field')) {
            const groups = document.querySelectorAll('.field-group');
            if (groups.length > 1) {
                e.target.closest('.field-group').remove();
            }
        }
    });

    function toggleOptions(select) {
        const optionsInput = select.closest('.field-group').querySelector('.options-field');
        optionsInput.style.display = select.value === 'select' ? 'block' : 'none';
    }
</script>
@endsection
