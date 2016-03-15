@layout('base.default')

@section('mainbody')
  <div class="booking">
    {{ Form::open('booking/pagetwo', 'POST') }}
      {{ Form::token() }}

      <div class="row">
	<div class="large-12 columns">
	  <h2>New Booking</h2>
	  <hr/>
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
	  <h4 class="subheader">3. Contact Info</h4>
	</div>
      </div>

      <div class="row">
	<div class="large-4 columns">
	  {{ Form::email('studemail', null, array('placeholder'=>'Email')) }}
	</div>
	<div class="large-4 columns">
	  {{ Form::text('studmob', null, array('placeholder'=>'Mobile')) }}
	</div>
	<div class="large-4 columns">
	  {{ Form::text('studgov', null, array('placeholder'=>'NRIC/FIN')) }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
	  <h4 class="subheader">4. Booking Duration</h4>
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
	  <h4 class="subheader">5. Student Center</h4>
	</div>
      </div>

      <div class="row">
        <div class="small-2 large-3 columns">
	  {{ Form::label('cluster', 'Select Graduate Center:', array('class'=>'inline')) }}
	</div>
	<div class="small-2 large-4 columns">
	  {{ Form::select('cluster', $clusters) }}
	</div>
	<div class="small-2 large-5 columns"></div>
      </div>

      <div class="row">
	<div class="large-2 large-offset-10 columns">
	  {{ Form::submit('NEXT', array('class'=>'button expand right')) }}
	</div>
      </div>

    {{ Form::close() }}
  </div>

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
