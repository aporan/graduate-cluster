@layout('base.default')

@section('mainbody')

  {{ render('error.validation') }}

  <div class="booking">
    {{ Form::open('requestchange/update', 'POST') }}
    {{ Form::token() }}

    <div class="row">
      <div class="large-12 columns">
	<h2>Change Form</h2>
	<hr/>
      </div>
    </div>
    
    <div class="row">
      <div class="small-2 large-3 columns">
      	{{ Form::label('seat', 'Select Seat: ', array('class'=>'inline')) }}
      </div>
      <div class="small-2 large-4 columns">
      	{{ Form::select('seat', $seats) }}
      </div>
      <div class="small-2 large-5 columns"></div>
    </div>

    <div class="row">
      <div class="large-12 columns">
	<h4 class="subheader">1. Booking Duration</h4>
      </div>
    </div>
      
    <div class="row">
      <div class="large-2 columns">
	{{ Form::label('bookfro', 'Booking From:', array('class'=>'required', 'style'=>'padding-top: 7px')) }}
      </div>
      <div class="large-3 columns">
	{{ Form::text('bookfro', null, array('placeholder'=>'yy-mm-dd', 'id'=>'from')) }}
      </div>
      <div class="large-2 columns">
	{{ Form::label('booktill', 'Booking Till:', array('style'=>'padding-top: 7px;')) }}
      </div>
      <div class="large-3 columns end">
	{{ Form::text('booktill', null, array('placeholder'=>'yy-mm-dd', 'id'=>'to')) }}
      </div>
    </div>

    <div class="row">
      <div class="large-12 columns">
	<h4 class="subheader">2. Terms and Conditions </h4>
      </div>
    </div>

    <div class="row">
      <div class="small-6 large-10 columns">
      	{{ Form::checkbox('terms', '1') }}
	<span>Please check the terms and condtions before proceeding</span>
      </div>
      <div class="small-6 large-2 columns"></div>
    </div>

    <div class="row">
      <div class="large-2 large-offset-10 columns">
	{{ Form::submit('SUBMIT', array('class'=>'button expand right')) }}
      </div>
    </div>

    {{ Form::close() }}
  </div>

  {{ render('error.validation_js') }}

  <script>
    $(function() {
        $( "#from" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $( "#to" ).datepicker( "option", "minDate", selectedDate );
            }
        });
        $( "#to" ).datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            dateFormat: "yy-mm-dd",
            onClose: function( selectedDate ) {
                $( "#from" ).datepicker( "option", "maxDate", selectedDate );
            }
        });
    });
  </script>

@endsection    

