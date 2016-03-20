@layout('base.default')

@section('mainbody')
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
	<h4 class="subheader">7. Terms and Conditions </h4>
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

@endsection    

