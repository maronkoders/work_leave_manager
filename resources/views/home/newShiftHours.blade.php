@extends('master')
@section('content')
<!-- <link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css"> -->
<link href="{{asset('css/jquery.timepicker.css')}}" rel="stylesheet"/>
<link href="{{asset('css/jquery.timepicker.min.css')}}" rel="stylesheet"/>
<style>
[class*="timepicker-"] {
     font-size: 12px; 
}
</style>

<script src="{{asset('js/jquery-1.10.2.js')}}"></script>
<script src="{{asset('js/jquery.timepicker.js')}}"></script>


    <script>
        var $a = jQuery.noConflict();
        $a(document).ready(function(){
            $a('#startTime').timepicker({
                template: 'modal',
                 timeFormat: 'H:i',
                 interval: 30,
                minTime: '00:00:00',
                 maxTime:'23:00:00'
            });

        });

        var $b = jQuery.noConflict();
        $b(document).ready(function(){
            $b('#endTime').timepicker({
                template: 'modal',
                timeFormat: 'H:i',
                interval: 30,
                  minTime: '00:00:00',
                maxTime:'23:00:00'
            });
        });
    </script>
   
    <ol class="breadcrumb hidden-xs">
        <li><a href="{{ url('welcome') }}">Home</a></li>       
        <li class="active"> Add Shift Form</li>
    </ol>
    <h4 class="page-title">Shifts</h4>


    <div class="block-area" id="basic">
        <h3 class="block-title"> Shift  Details</h3>
        <div class="tile p-15">

            <hr class="whiter m-t-20">
            <hr class="whiter m-b-20">
            {!! Form::open(['url' => 'addShift', 'method' => 'post', 'class' => 'form-horizontal', 'id'=>"addPositionForm" ]) !!}

            <div class="form-group">
               {!! Form::label('Shift Name', 'Shift Name', array('class' => 'col-md-2 control-label')) !!}
               <div class="col-md-10">
                  {!! Form::text('name',NULL,['class' => 'form-control input-sm','id' => 'name' ,'autocomplete' =>'off']) !!}
               
                   @if ($errors->has('name')) <p class="help-block red">*{{ $errors->first('name') }}</p> @endif
               </div>
           </div>

           <div class="form-group">
               {!! Form::label('Start Time', 'Start Time', array('class' => 'col-md-2 control-label')) !!}
               <div class="col-md-10">
               
                   <p><input type = "text"   value="{{ old('timeIn') }}"   name="timeIn" placeholder ="Choose start time" id = "startTime" class="form-control input-sm"></p>
                   @if ($errors->has('acronym')) <p class="help-block red">*{{ $errors->first('acronym') }}</p> @endif
               </div>
           </div>

           <div class="form-group">
               {!! Form::label('End Time', 'End Time', array('class' => 'col-md-2 control-label')) !!}
               <div class="col-md-10">
                   <p><input type = "text"   value="{{ old('timeOut') }}"   name="timeOut" placeholder ="Choose end time" id = "endTime" class="form-control input-sm"></p>
                   @if ($errors->has('acronym')) <p class="help-block red">*{{ $errors->first('acronym') }}</p> @endif
               </div>
           </div>

           <div class="form-group">
               <div class="col-md-offset-2 col-md-10">
                   <button type="submit" id='submitUpdateDepartmentForm' type="button" class="btn btn-sm">Add Shift</button>
               </div>
           </div>
       </div>
      
       {!! Form::close() !!}
           
        </div>
    </div>

@endsection
