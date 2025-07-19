@extends('layouts.user')

@section('content')
<h2>Available Forms</h2>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<ul class="list-group">
    @forelse($forms as $form)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <a href="{{ route('user.forms.show', $form->id) }}">{{ $form->title }}</a>
        <span class="badge bg-primary rounded-pill">{{ $form->fields_count }} fields</span>
    </li>
    @empty
    <li class="list-group-item">No forms available.</li>
    @endforelse
</ul>
@endsection