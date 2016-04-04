@layout('base.default')

@section('mainbody')

  {{ render('error.validation') }}

  <div class="booking">
    {{ Form::open('booking/pageone', 'POST') }}
      {{ Form::token() }}

      <div class="row">
	<div class="large-12 columns">
	  <h2>New Booking</h2>
	  <hr/>
	</div>
      </div>

      <div class="row">
	<div class="large-12 columns">
	  <h4 class="subheader">1. Basic Info</h4>
	</div>
      </div>
      
      <div class="row">
	<div class="large-3 columns">
	  {{ Form::text('studfirst', null, array('placeholder'=>'First Name')) }}
	</div>
	<div class="large-3 columns">
	  {{ Form::text('studlast', null, array('placeholder'=>'Last Name')) }}
	</div>
	<div class="large-6 columns"></div>
      </div>

      <div class="row radio">
	<div class="large-1 columns">
	  {{ Form::label('gender', 'Gender:') }}
	</div>
	<div class="large-3 columns">
	  {{ Form::radio('gender', 'male') }}<span>Male</span>
	  {{ Form::radio('gender', 'female') }}<span>Female</span>
	</div>
	<div class="large-2 columns">
	  {{ Form::label('nation', 'Nationality:', array('style'=>'padding-top: 3px;')) }}
	</div>
	<div class="large-3 columns">
	  {{ Form::select('nation', $countries) }}
	</div>
	<div class="large-3 columns"></div>
      </div>


      <div class="row">
	<div class="large-12 columns">
	  <h4 class="subheader">2. Department</h4>
	</div>
      </div>
      
      <div class="row radio">
	<div class="large-3 columns">
	  {{ Form::label('pillar', 'Pillar (Please select one):') }}
	</div>
	<div class="large-9 columns">
	  {{ Form::radio('pillar', 'asd') }}<span>ASD</span>
	  {{ Form::radio('pillar', 'istd') }}<span>ISTD</span>
	  {{ Form::radio('pillar', 'epd') }}<span>EPD</span>
	  {{ Form::radio('pillar', 'esd') }}<span>ESD</span>
	  {{ Form::radio('pillar', 'hass') }}<span>HASS</span>
	</div>
      </div>

      <div class="row radio">
	<div class="large-3 columns">
	  {{ Form::label('studtyp', 'Position:') }}
	</div>
	<div class="large-9 columns">
	  {{ Form::radio('studtyp', 'phd') }}<span>PhD</span>
	  {{ Form::radio('studtyp', 'masters' ) }}<span>Masters</span>
	  {{ Form::radio('studtyp', 'postdoc') }}<span>Postdoc</span>
	  {{ Form::radio('studtyp', 'researcher') }}<span>Researcher</span>
	</div>
      </div>

      <div class="row">
	<div class="large-2 large-offset-10 columns">
	  {{ Form::submit('NEXT', array('class'=>'button expand right')) }}
	</div>
      </div>

    {{ Form::close() }}

    {{ render('error.validation_js') }}  
@endsection
