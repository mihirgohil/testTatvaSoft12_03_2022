@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12 mb-3 mt-3">
        <form action="{{ route('event.store') }}" name="eventFrom" method="POST" onsubmit="return validateForm()">
            @csrf
            <h4> {{ empty($id)? 'Add' : 'Edit' }} Event</h4>
            <div class="mb-3">
                <input type="hidden" value="{{ $id ?? null}}" name="id">
                <label for="exampleFormControlInput1" class="form-label">Title</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ $data->title ?? old('title') }}">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                <input type="date" class="form-control" name="start_date" value="{{ $data->start_date ?? old('start_date') }}">    
                @error('start_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">End Date</label>
                <input type="date" class="form-control" name="end_date" value="{{ $data->end_date ?? old('end_date') }}">
                @error('end_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3">
                <div class="row">
                    <div class="col">
                        <select name="recurrence_type" class="form-control">
                            @foreach($recurrence_type as $key => $value)
                                <option value="{{ $key }}"
                                @if (!empty($data) && !empty($data->recurrence_type))
                                    {{ $data->recurrence_type == $key ? 'selected' : ''}}
                                @else
                                    {{ old('recurrence_type') == $key ? 'selected' : ''}}
                                @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('recurrence_type')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col">
                        <select name="recurrence_frequency" class="form-control">
                            @foreach($recurrence_frequency as $key => $value)
                                <option value="{{ $key }}"
                                @if (!empty($data) && !empty($data->recurrence_frequency))
                                    {{ $data->recurrence_frequency == $key ? 'selected' : ''}}
                                @else
                                    {{ old('recurrence_frequency') == $key ? 'selected' : ''}}
                                @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                        @error('recurrence_frequency')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <ul id="form-errors">
            </ul>
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{ route('event.index') }}" class="btn btn-danger">Back</a>
            </div>
        </form>
    </div>
</div>
@endsection