@layout('base.default')

@section('mainbody')
  <div class="page-centre">
    <div class="row">
      <div class="small-7 large-centered columns">
	<div class="row">
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('clusters', 'GRADUATE CENTERS', array(), array('class'=>'button expand main')) }}</div>
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('new_seat', 'ADD DESK SPACE', array(), array('class'=>'button expand main')) }}</div>
	</div>
      </div>
    </div>

    <div class="row">
      <div class="small-7 large-centered columns">
	<div class="row">
	  <div class="large-12 columns">{{ HTML::link_to_ROUTE('manager_index', 'MANAGE USERS', array(), array('class'=>'button expand main')) }}</div>
	</div>
      </div>
    </div>
  </div>

@endsection
