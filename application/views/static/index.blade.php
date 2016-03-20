@layout('base.default')

@section('mainbody')

  <div class="page-centre">
    <div class="row">
      <div class="small-7 large-centered columns">
	<div class="row">
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('new_booking', 'NEW BOOKING', array(), array('class'=>'button expand')) }}</div>
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('bookings', 'VIEW BOOKINGS', array(), array('class'=>'button expand')) }}</div>
	</div>
      </div>
    </div>

    <div class="row">
      <div class="small-7 large-centered columns">
	<div class="row">
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('change_index', 'CHANGE OF DESK', array(), array('class'=>'button expand')) }}</div>
	  <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('admin_index', 'ADMIN', array(), array('class'=>'button expand')) }}</div>
	</div>
      </div>
    </div>
  </div>

@endsection
