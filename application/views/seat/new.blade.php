@layout('base.default')

@section('mainbody')
    <div class="row">
      <div class="small-2 large-3 columns">
	<h2>Add Seat</h2>
      </div>
    </div>

    {{ Form::open('seat/create', 'POST') }}
        {{ Form::token() }}
        <div class="row">
	  <div class="small-2 large-3 columns">
	    {{ Form::label('cluster', 'Select Graduate Cluster:', array('class'=>'inline')) }}
	  </div>
	  <div class="small-2 large-4 columns">
	    {{ Form::select('cluster', $clusters) }}
	  </div>
	  <div class="small-2 large-5 columns"></div>
	</div>

	<div class="row">
	  <div class="small-2 large-3 columns">
	    {{ Form::label('title', 'Seat Number / Title:', array('class'=>'inline')) }}
	  </div>
	  <div class="small-2 large-4 columns">
	    {{ Form::text('title') }}
	  </div>
	  <div class="small-2 large-5 columns"></div>
	</div>

	<div class="row">
          <div class="small-2 large-7 columns">
            {{ Form::submit('ADD', array('class'=>'button tiny round right')) }}
	  </div>
	</div>

    {{ Form::close() }}
    


@endsection
