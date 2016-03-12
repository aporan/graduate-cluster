@layout('base.default')

@section('mainbody')
  <div class="row">
    <div class="small-7 large-centered columns">
     <div class="row">
       <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('clusters', 'NEW BOOKING', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
       <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('clusters', 'CHANGE OF DESK', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
     </div>
    </div>
   </div>

   <div class="row">
     <div class="small-7 large-centered columns">
       <div class="row">
	 <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('clusters', 'UPDATE BOOKING', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
	 <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('admin_index', 'ADMIN', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
       </div>
     </div>
   </div>

@endsection
