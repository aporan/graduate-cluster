@layout('base.default')

@section('mainbody')
  <div class="row">
    <div class="small-7 large-centered columns">
     <div class="row">
       <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('clusters', 'GRADUATE CENTERS', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
       <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('new_seat', 'ADD DESK SPACE', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
     </div>
    </div>
   </div>

   <div class="row">
     <div class="small-7 large-centered columns">
       <div class="row">
	 <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('admin_index', 'REPORT PAGE', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
	 <div class="small-2 large-6 columns">{{ HTML::link_to_ROUTE('admin_index', 'SEND EMAILS', array(), array('class'=>'button', 'style'=>'width: 100%')) }}</div>
       </div>
     </div>
   </div>

@endsection