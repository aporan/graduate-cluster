@layout('base.default')

@section('mainbody')
    <div class="row"><h2>{{ $this_cluster->cluster_name }}</h2></div>

    <div class="row">
      <div class="small-2 large-2 columns" style="padding-top: 4px; padding-left:0px">Add New Seat:</div>
      <div class="small-2 large-4 columns" style="padding-left:0px">
	{{ HTML::link_to_route('new_seat','Add Seat', array(), array('class'=>'button tiny round')) }}
      </div>
      <div class="small-8 large-5"></div>
    </div>

    <div class="row"><h4 class="subheader">List of available seats:</h4></div>
    <div class="row">
      <table>
	<thead>
	  <tr>
	    <th>#</th>
	    <th> Number / Title</th>
	    <th width="20%"></th>
	  </tr>
	</thead>
	<tbody>
	  <?php $i = 1; ?>
	  @foreach($seats as $seat)
   	    <tr>
	      <td>{{ $i++ }}</td>
	      <td>{{ $seat->seat_title }}</td>
	      <td>
 	        {{ Form::open('seat/delete', 'DELETE', array('style'=>'padding-top:20px;')) }}
  	        {{ Form::hidden('id', e($seat->id)) }}
		{{ Form::hidden('clusid', e($this_cluster->id)) }}
	        {{ Form::submit('Delete', array('class'=>'button tiny alert round')) }}
	        {{ Form::close() }}
	      </td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>


    
@endsection
