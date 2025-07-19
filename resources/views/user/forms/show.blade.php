@extends('layouts.user')

@section('content')
<div class="container mt-5 d-flex justify-content-center">
    <div class="w-100" style="max-width: 900px;"> {{-- Set max width for better focus --}}
        <h2 class="text-center mb-4">{{ $form->title }}</h2>

        @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('user.forms.submit', $form->id) }}" class="p-4 border rounded bg-white shadow-sm">
            @csrf

            @php
                $fields = $form->fields;
                $half = ceil($fields->count() / 2);
            @endphp

            <div class="row">
                <div class="col-md-6">
                    @foreach ($fields->take($half) as $field)
                        <div class="mb-3">
                            <label class="form-label">{{ $field->label }}</label>
                            @php $options = json_decode($field->options ?? '[]', true); @endphp

                            @if(in_array($field->type, ['text', 'number', 'email']))
                                <input type="{{ $field->type }}" name="field_{{ $field->id }}" class="form-control" required>

                            @elseif($field->type === 'textarea')
                                <textarea name="field_{{ $field->id }}" class="form-control" rows="3" required></textarea>

                            @elseif($field->type === 'select')
                                <select name="field_{{ $field->id }}" class="form-control" required>
                                    @if(is_array($options) && count($options))
                                        @foreach($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No options available</option>
                                    @endif
                                </select>

                            @elseif($field->type === 'radio' && is_array($options))
                                @foreach($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="field_{{ $field->id }}" value="{{ $option }}" required>
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach

                            @elseif($field->type === 'checkbox' && is_array($options))
                                @foreach($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_{{ $field->id }}[]" value="{{ $option }}">
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>

                <div class="col-md-6">
                    @foreach ($fields->slice($half) as $field)
                        <div class="mb-3">
                            <label class="form-label">{{ $field->label }}</label>
                            @php $options = json_decode($field->options ?? '[]', true); @endphp

                            @if(in_array($field->type, ['text', 'number', 'email']))
                                <input type="{{ $field->type }}" name="field_{{ $field->id }}" class="form-control" required>

                            @elseif($field->type === 'textarea')
                                <textarea name="field_{{ $field->id }}" class="form-control" rows="3" required></textarea>

                            @elseif($field->type === 'select')
                                <select name="field_{{ $field->id }}" class="form-control" required>
                                    @if(is_array($options) && count($options))
                                        @foreach($options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    @else
                                        <option disabled>No options available</option>
                                    @endif
                                </select>

                            @elseif($field->type === 'radio' && is_array($options))
                                @foreach($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="field_{{ $field->id }}" value="{{ $option }}" required>
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach

                            @elseif($field->type === 'checkbox' && is_array($options))
                                @foreach($options as $option)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="field_{{ $field->id }}[]" value="{{ $option }}">
                                        <label class="form-check-label">{{ $option }}</label>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary px-5">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
