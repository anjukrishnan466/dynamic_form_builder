@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Form List</h2>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('form.create') }}" class="btn btn-primary mb-3">Create New Form</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Form Title</th>
                <th>Total Fields</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($forms as $index => $form)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $form->title }}</td>
                <td>{{ $form->fields->count() }}</td>
                <td>
                    <a href="{{ route('form.edit', $form->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('form.destroy', $form->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this form?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('field.create', $form->id) }}" class="btn btn-sm btn-success">Add Field</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">No forms found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection