@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-12 mt-3">
        <h4> Event Details</h4>
        <div class="col-12">
            <label for="exampleFormControlInput1" class="form-label">Event Name: {{ $event->title }}</label>
        </div>
        <div class="col-12">
            <h5>
                <label for="exampleFormControlInput1" class="form-label">Total Occurances: {{ count($data) }}</label>
            </h5>
        </div>
        <div class="col-12">
            <label for="exampleFormControlInput1" class="form-label">Event Occurances</label>
            <table class="table table-striped mt-3">
                <thead>
                    <th>Date</th>
                    <th>Day</th>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d['date'] }}</td>
                            <td>{{ $d['day'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
    </div>
</div>
@endsection