@layout('base.default')

@section('mainbody')

    <div class="page-center">
      {{ Form::open('email/create', 'POST') }}
        {{ Form::token() }}


        <div class="row">
	  <div class="large-12 columns">
	    <h2>Emails</h2>
	    <hr/>
	  </div>
	</div>

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
      	  <div class="small-6 large-10 columns">
      	    {{ Form::checkbox('sendall', '1') }}
	    <span>Send to <b>ALL</b> Graduate Clusters</span>
      	  </div>
	  <div class="small-6 large-2 columns"></div>
	</div>

	<div class="row">
	  <div class="large-12 columns">
	    <h4 class="subheader">Compose: </h4>
	  </div>
	</div>

        <div class="row">
          <div class="small-6 large-12 columns">
	    {{ Form::textarea('allmail', null, array('id'=>'emailarea')) }}
          </div>
	</div>

	<div class="row">
	  <div class="small-4 large-2 columns">
	    {{ Form::submit('SEND', array('class'=>'button expand')) }}
	  </div>
	</div>
      
      {{ Form::close() }}

    </div>


    <script>
      tinymce.init({
        selector: '#emailarea'
      });
    </script>

@endsection
