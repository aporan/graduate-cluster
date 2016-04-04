@layout('base.default')

@section('mainbody')

   {{ render('error.validation') }}

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

	@if($errors->has())

  	  {{ render('cluster.edit_validation_error', array('cluster'=>$cluster)) }}

	@else

	  {{ render('cluster.edit_partial', array('cluster'=>$cluster)) }}
	
	@endif
	  
	{{ Form::close() }}

      </div>
      
      <div class="small-12 large-6 columns">
	<h2 class="subheader" style="margin-top: 0px;">Current Preview</h2>
	{{ HTML::image($cluster->image_path) }}
      </div>
      
    </div>

    {{ render('error.validation_js') }}
    
@endsection
