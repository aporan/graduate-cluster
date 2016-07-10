@layout('base.default')

@section('mainbody')

    <div class="page-center">
      {{ Form::open('report/view', 'POST') }}
        {{ Form::token() }}

        <div class="row">
          <div class="large-12 columns">
            <h2>Report</h2>
            <hr/>
          </div>
        </div>
        
        <div class="row">
          <div class="small-2 large-3 columns">
	    {{ Form::label('cluster', 'Select Cluster:', array('class'=>'inline')) }}
	  </div>
	  <div class="small-2 large-4 columns">
	    {{ Form::select('cluster', $clusters) }}
	  </div>
	  <div class="small-2 large-5 columns"></div>
	</div>

	<div class="row">
      	  <div class="small-6 large-10 columns">
      	    {{ Form::checkbox('all', '1') }}
	    <span>Generate <b>Combined</b> Report</span>
      	  </div>
	  <div class="small-6 large-2 columns"></div>
	</div>

	<div class="row" style="margin-top: 20px">
	  <div class="small-4 large-2 columns">
	    {{ Form::submit('Generate', array('class'=>'button expand')) }}
	  </div>
	</div>
      
      {{ Form::close() }}

    </div>

@endsection
