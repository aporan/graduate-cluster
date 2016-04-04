@layout('base.default')

@section('mainbody')

    {{  render('error.validation') }}    
    
    <div class="row">
      <div class="small-12 large-12 columns">
	<h2>Add Seat</h2>
	<hr/>
      </div>
    </div>

    {{ Form::open('seat/create', 'POST') }}
        {{ Form::token() }}
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
	  <div class="small-2 large-3 columns">
	    {{ Form::label('title', 'Desk Number / Title:', array('class'=>'inline')) }}
	  </div>
	  <div class="small-2 large-4 columns">
	    {{ Form::text('title', Input::old('title')) }}
	  </div>
	  <div class="small-2 large-5 columns"></div>
	</div>

	<div class="row">
          <div class="small-2 large-7 columns">
            {{ Form::submit('ADD', array('class'=>'button tiny round right')) }}
	  </div>
	</div>

    {{ Form::close() }}

    {{ render('error.validation_js') }}

@endsection