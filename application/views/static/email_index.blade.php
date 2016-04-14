@layout('base.default')

@section('mainbody')
    @if(Session::has('email_error'))
      <div id="alert" class="row">
	<div class="small-12 large-12 columns">
	  <div class="alert-box alert radius">
	    {{ Session::get('email_error') }}
	    <a id="trig" href="#" class="close" onClick="alertClose(this.id)">⊗</a>
	  </div>
	</div>
      </div>
    @endif

    <div class="page-center">
      {{ Form::open('email/send', 'POST') }}
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

        <div class="row" style="margin-top: 10">
          <div class="small-6 large-12 columns">
	    {{ Form::textarea('allmail', Input::old('allmail'), array('id'=>'emailarea')) }}
          </div>
	</div>

	<div class="row" style="margin-top: 20px">
	  <div class="small-4 large-2 columns">
	    {{ Form::submit('SEND', array('class'=>'button expand')) }}
	  </div>
	</div>
      
      {{ Form::close() }}

    </div>

    @if(Session::has('email_error'))
      <script>
	function alertClose($id){
          var alert_id = $("#"+$id).closest("div").parent().parent().attr("id");
          $("#"+alert_id).slideUp("slow", function(){
             $(this).remove();
          });
        }
      </script>
    @endif  

    
    <script>
      tinymce.init({
        selector: '#emailarea'
      });
    </script>

@endsection
