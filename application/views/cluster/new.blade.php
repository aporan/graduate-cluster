@layout('base.default')

@section('mainbody')

     @if($errors->has())
     <?php $i = 0; ?>
      @foreach ($errors->all() as $error)
        <?php $i++ ?>
        <div id="alerts_{{ $i }}" class="row">
	  <div class="small-12 large-12 columns">
	    <div class="alert-box alert radius">
	      {{ $error }}<br/>
	      <a id="trig_{{ $i }}" href="#" class="close" onClick="alertClose(this.id)">⊗</a>
	    </div>
	  </div>
	</div>
      @endforeach
    @endif

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

    <script>
      function alertClose($id){
         var alert_id = $("#"+$id).closest("div").parent().parent().attr("id");
         $("#"+alert_id).slideUp("slow", function(){
           $(this).remove();
         });
      }
    </script>

@endsection
