@layout('base.default')

@section('mainbody')

    {{  render('error.validation') }}    

    <div class="row">
      <div class="small-12 large-12 columns">
	<h2>Add Cluster</h2>
	<hr/>
      </div>
    </div>
    
    {{ Form::open_for_files('cluster/create', 'POST') }}
        {{ Form::token() }}
          <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::label('clusname', 'Name') }}
	      {{ Form::text('clusname') }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::label('clusbuild', 'Building') }}
              {{ Form::text('clusbuild') }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::label('cluslev', 'Level') }}
              {{ Form::text('cluslev') }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::label('clusseats', 'Total Seats') }}
              {{ Form::text('clusseats') }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::file('cluster_image') }}
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

    {{ render('error.validation_js') }}
	  
@endsection
