@layout('base.default')

@section('mainbody')

  {{ render('error.validation') }}

  <div class="booking">
    {{ Form::open('booking/create', 'POST') }}
      {{ Form::token() }}

      <div class="row">
	<div class="large-12 columns">
	  <h2>New Booking</h2>
	  <hr/>
	</div>
      </div>

      <div class="row">
	<div class="small-12 large-12 columns">
	  {{  HTML::image($path) }}
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
	  <h4 class="subheader">6. Seat Selection </h4>
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
	<div class="large-2 large-offset-10 columns">
	  {{ Form::submit('SUBMIT', array('class'=>'button expand right')) }}
	</div>
      </div>

    {{ Form::close() }}

    {{ render('error.validation_js') }}

@endsection


      

