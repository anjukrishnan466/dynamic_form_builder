@extends('layouts.user')

@section('content')
<div class="container mt-4">
    <h2 class="text-center mb-4">{{ $form->title }}</h2>

    <form method="POST" action="{{ route('user.forms.submit', $form->id) }}">
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

                        @if($field->type === 'text' || $field->type === 'number')
                            <input 
                                type="{{ $field->type }}" 
                                name="field_{{ $field->id }}" 
                                class="form-control" 
                                required>
                        @elseif($field->type === 'select')
                            <select 
                                name="field_{{ $field->id }}" 
                                class="form-control" 
                                required>

                                @php
                                    $options = json_decode($field->options ?? '[]', true);
                                @endphp

                                @if(is_array($options))
                                    @foreach($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
                        @endif
                    </div>
                @endforeach
            </div>

            <div class="col-md-6">
                @foreach ($fields->slice($half) as $field)
                    <div class="mb-3">
                        <label class="form-label">{{ $field->label }}</label>

                        @if($field->type === 'text' || $field->type === 'number')
                            <input 
                                type="{{ $field->type }}" 
                                name="field_{{ $field->id }}" 
                                class="form-control" 
                                required>
                        @elseif($field->type === 'select')
                            <select 
                                name="field_{{ $field->id }}" 
                                class="form-control" 
                                required>

                                @php
                                    $options = json_decode($field->options ?? '[]', true);
                                @endphp

                                @if(is_array($options))
                                    @foreach($options as $option)
                                        <option value="{{ $option }}">{{ $option }}</option>
                                    @endforeach
                                @endif
                            </select>
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
@endsection
