@layout('base.default')

@section('mainbody')
    <div class="row">
      <div class="small-12 large-12 columns">
	<h2>Edit Cluster</h2>
	<hr/>
      </div>
    </div>

    <div class="row">
      <div class="small-12 large-6 columns">
	{{ Form::open_for_files('cluster/update', 'PUT') }}
        {{ Form::token() }}

          <div class="row">
            <div class="small-10 large-10 columns">
	      {{ Form::hidden('clus', e($cluster->id)) }}
	      {{ Form::text('clusname', e($cluster->cluster_name)) }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-10 large-10 columns">
              {{ Form::email('clusmail',e($cluster->email)) }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-10 large-10 columns">
              {{ Form::text('clusbuild', e($cluster->building)) }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-10 large-10 columns">
              {{ Form::text('cluslev', e($cluster->level)) }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-10 large-10 columns">
              {{ Form::text('clusseats', e($cluster->max_seats)) }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-10 large-10 columns">
	      {{ Form::file('cluster_image') }}
	    </div>
	    <div class="small-2 large-2 columns"></div>
	  </div>

	  <div class="row">
            <div class="small-6 large-6 columns">
              {{ Form::submit('UPDATE', array('class'=>'button tiny round')) }}
	    </div>
	    <div class="small-6 large-6 columns"></div>
	  </div>
	  
	  {{ Form::close() }}

      </div>
      
      <div class="small-12 large-6 columns">
	<h2 class="subheader" style="margin-top: 0px;">Current Preview</h2>
	{{ HTML::image($cluster->image_path) }}
      </div>
      
    </div>  
    
@endsection
