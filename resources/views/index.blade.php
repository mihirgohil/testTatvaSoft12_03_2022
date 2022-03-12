@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mt-3">
        <div class="row">
            <div class="col">
                <h4> Events List</h4>
            </div>
            <div class="col text-end">
                <a href="{{ route('event.create')}}" class="btn btn-primary">Add Event</a>
            </div>
        </div>
       
        <table class="table table-striped mt-3">
            <thead>
                <th>#</th>
                <th>Title</th>
                <th>Dates</th>
                <th>Occurrence</th>
                <th>Action</th>
            </thead>
            <tbody>
               
                @foreach ($events as $event)
                    @if(!empty(config('constants.recurrence.type.'.$event->recurrence_type)) && !empty(config('constants.recurrence.frequency.'.$event->recurrence_frequency)))
                    <tr>
                        <td>{{ $event->id }}</td>
                        <td>{{ $event->title }}</td>
                        <td>{{ date('Y-m-d',strtotime($event->start_date)).' to '.date('Y-m-d',strtotime($event->end_date)) }}</td>
                        <td>{{ config('constants.recurrence.type.'.$event->recurrence_type) }} {{ config('constants.recurrence.frequency.'.$event->recurrence_frequency) }}</td>
                        <td>
                            <a href="{{ route('event.show',['event' => $event->id])}}" class="btn btn-primary">View</a>
                            <a href="{{ route('event.edit',['event' => $event->id])}}" class="btn btn-warning">Edit</a>
                            <a class="btn btn-danger delete-record" data-id="{{ $event->id }}">Delete</a>
                        </td>
                    </tr>
                    @endif
                @endforeach
                
            </tbody>
                
        </table>
        {{ $events->links() }}
    </div>
</div>
@endsection

@push('scripts')
    <script>
        $(document).on('click','.delete-record',function(){
            var id = $(this).attr('data-id');
            var text = "Press ok to delete this record.";
            if(confirm(text) == true){
                    $.ajax({
                    'url' : '{{ route('event.index') }}/'+id,
                    'type' : 'delete',
                    success: function (response){
                        if(response.status){    
                            alert(response.message);
                            setTimeout(function () {
                                location.reload(true);
                            }, 1000);
                        }else{
                            alert(response.message);
                        }
                    },
                    error: function(error) {
                        alert('Something went wrong!');
                    }
                });
            }
        });
    </script>
@endpush