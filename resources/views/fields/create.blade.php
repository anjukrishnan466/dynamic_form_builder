@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Field to Form: <strong>{{ $form->title }}</strong></h2>

    <form method="POST" action="{{ route('field.store', $form->id) }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Field Label</label>
            <input type="text" name="label" class="form-control" required>
            @error('label')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Field Type</label>
            <select name="type" class="form-control" required>
                <option value="text">Text</option>
                <option value="number">Number</option>
                <option value="email">Email</option>
                <option value="textarea">Textarea</option>
                <option value="select">Select</option>
                <option value="checkbox">Checkbox</option>
                <option value="radio">Radio</option>
            </select>
            @error('type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Options (comma separated - for select, checkbox, radio only)</label>
            <input type="text" name="options" class="form-control">
            @error('options')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Add Field</button>
    </form>
</div>
@endsection
