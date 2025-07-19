@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Submissions for Form: {{ $form->title }}</h2>

    @if ($submissions->isEmpty())
        <div class="alert alert-warning">No submissions found.</div>
    @else
        @foreach ($submissions as $submission)
            <div class="card mb-3">
                <div class="card-header">
                    Submitted at: {{ $submission->created_at->format('d M Y, h:i A') }}
                </div>
                <div class="card-body">
                    @foreach ($submission->submitted_data as $label => $value)
                        <div class="mb-2">
                            <strong>{{ $label }}:</strong>
                            @if(is_array($value))
                                {{ implode(', ', $value) }}
                            @else
                                {{ $value }}
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
