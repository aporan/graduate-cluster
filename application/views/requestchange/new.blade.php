@layout('base.default')

@section('mainbody')

     {{ render('error.validation') }}

      <div class="row">
	<div class="large-12 columns">
	  <h2>Change Form</h2>
	  <hr/>
	</div>
      </div>

      <div class="booking">
	{{ Form::open('requestchange/pageone', 'POST') }}
	{{ Form::token() }}

	<div class="row">
	  <div class="small-12 large-12 columns">
	    {{ Form::hidden('thestud', e($thestud)) }}
	  </div>
	</div>

	<div class="row" style="margin-top: 30px">
	  <div class="small-2 large-2 columns">Provide Reason for Request</div>
	  <div class="small-10 large-10 columns">
	    {{ Form::textarea('areason', null, array('rows'=>'7')) }}
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
	  <div class="large-2 large-offset-10 columns">
	    {{ Form::submit('NEXT', array('class'=>'button expand right')) }}
	  </div>
	</div>

	{{ Form::close() }}
	
      </div>
      
      {{ render('error.validation_js') }}  
@endsection

      
