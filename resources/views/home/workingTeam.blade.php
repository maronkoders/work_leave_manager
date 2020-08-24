@extends('master')

@section('content')
@include('Errors.error')

    @if(Auth::user())
            <ol class="breadcrumb hidden-xs">
                <li><a href="{{url('welcome')}}">Home</a></li>
                <li class="active">Working Team List</li>
            </ol>

        <h4 class="page-title">Working Team List</h4>
        <!-- Alternative -->
        <div class="block-area" id="alternative-buttons">
            <h3 class="block-title">Working Team List</h3>

            @if(Auth::user()->gradeId!=11 || Auth::user()->roleId!=1)
                <a class="btn btn-sm hidden"  href="{{url('allocateShifts')}}" >Allocate Shift
                </a>
            @endif
            @endif

            <a class="btn btn-sm" href ="{{url('workingHours')}}">View Working Hours
            </a>
        </div>



        <div class="block-area" id="responsiveTable">

            <div class="table-responsive overflow">
                <table class="table tile table-striped" id="shiftTable">
                    <thead>
                    <tr>
                        <th>Id</th>
                        <th>Staff name</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Working Hours</th>
                        <th>Actions</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
        {{--@include('departments.edit')--}}
        @include('home.newShiftHours')
@endsection
@push('scripts')
    <script>
        $(function() {
            $('#shiftTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{!!url('/getShiftTeam/')!!}',
                columns:
                    [
                        {data: 'id', name: 'id'},
                        {data:  function(d)
                            {
                                return d.staff.name +' '+ d.staff.surname;
                            },name: 'name'},

                        {data: function(d)
                            {
                                return d.hour.timeIn;
                            }, name: 'timeIn'},
                        {data: function(d)
                            {
                                return d.hour.timeOut;
                            }, name: 'timeOut'},
                        {data: function(d)
                            {
                                return d.hour.workingHours;
                            }, name: 'workingHours'},
                        {data: 'action', name: 'action', orderable: false, searchable: false}
                    ]
            });
        });
    </script>
@endpush
