@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Form</h2>
    <form method="POST" action="{{ route('form.update', $form->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="form_name" class="form-label">Form Name</label>
            <input type="text" class="form-control" id="form_name" name="form_name" value="{{ $form->title }}" required>
        </div>

        <hr>
        <h4>Edit Fields</h4>
        <div id="field-container">
            @foreach($form->fields as $field)
            <div class="field-group row mb-3">
                <input type="hidden" name="field_ids[]" value="{{ $field->id }}">
                <div class="col-md-3">
                    <input type="text" class="form-control" name="labels[]" value="{{ $field->label }}" placeholder="Label" required>
                </div>
                <div class="col-md-3">
                    <select name="types[]" class="form-control" onchange="toggleOptions(this)">
                        <option value="text" {{ $field->type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="number" {{ $field->type == 'number' ? 'selected' : '' }}>Number</option>
                        <option value="select" {{ $field->type == 'select' ? 'selected' : '' }}>Dropdown</option>
                    </select>
                </div>
                <div class="col-md-4">
@php
    $optionsArray = [];

    if ($field->type === 'select') {
        if (is_array($field->options)) {
            // Already array
            $optionsArray = $field->options;
        } else {
            $decoded = json_decode($field->options, true);

            if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                $optionsArray = $decoded;
            } else {
                // Assume comma-separated string fallback
                $optionsArray = explode(',', $field->options ?? '');
            }
        }
    }
@endphp

<input type="text"
    class="form-control options-field"
    name="options[]"
    value="{{ implode(',', $optionsArray) }}"
    placeholder="Comma-separated options (only for dropdown)"
    style="{{ $field->type == 'select' ? '' : 'display:none;' }}">              </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger remove-field">Remove</button>
                </div>
            </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary" id="add-field">Add Field</button>
        <button type="submit" class="btn btn-primary">Update Form</button>
    </form>
</div>

<script>
    document.getElementById('add-field').addEventListener('click', function () {
        const container = document.getElementById('field-container');
        const html = `
        <div class="field-group row mb-3">
            <input type="hidden" name="field_ids[]" value="">
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
                <input type="text" class="form-control options-field" name="options[]" placeholder="Comma-separated options" style="display: none;">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-field">Remove</button>
            </div>
        </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-field')) {
            const group = e.target.closest('.field-group');
            const groups = document.querySelectorAll('.field-group');
            if (groups.length > 1) {
                group.remove();
            }
        }
    });

    function toggleOptions(select) {
        const optionsInput = select.closest('.field-group').querySelector('.options-field');
        optionsInput.style.display = select.value === 'select' ? 'block' : 'none';
    }
</script>
@endsection
