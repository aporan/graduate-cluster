@layout('base.default')

@section('mainbody')
    <div class="row">
      <div class="small-12 large-12 columns">
	<h2>Add Cluster</h2>
	<hr/>
      </div>
    </div>

    {{ Form::open('cluster/create', 'POST') }}
        {{ Form::token() }}
          <div class="row">
            <div class="small-2 large-4 columns">
	      {{ Form::text('clusname', null, array('placeholder'=>'Name')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::email('clusmail', null, array('placeholder'=>'Email')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('clusbuild', null, array('placeholder'=>'Building')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('cluslev', null, array('placeholder'=>'Level')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('clusseats', null, array('placeholder'=>'Max Seats')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('image', null, array('placeholder'=>'Image path to be done')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::submit('ADD', array('class'=>'button tiny round')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>
	  
    {{ Form::close() }}
@endsection
