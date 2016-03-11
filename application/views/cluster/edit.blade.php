@layout('base.default')

@section('mainbody')
    <div class="row">
      <div class="small-2 large-3 columns">
	<h2>Edit Cluster</h2>
      </div>
    </div>

    {{ Form::open('cluster/update', 'PUT') }}
        {{ Form::token() }}

          <div class="row">
            <div class="small-2 large-4 columns">
	      {{ Form::hidden('clus', e($cluster->id)) }}
	      {{ Form::text('clusname', e($cluster->cluster_name)) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::email('clusmail',e($cluster->email)) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('clusbuild', e($cluster->building)) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('cluslev', e($cluster->level)) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-2 large-4 columns">
              {{ Form::text('clusseats', e($cluster->max_seats)) }}
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
              {{ Form::submit('UPDATE', array('class'=>'button tiny round')) }}
	    </div>
	    <div class="small-10 large-8 columns"></div>
	  </div>
	  
    {{ Form::close() }}

@endsection
