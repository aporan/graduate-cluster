@layout('base.default')

@section('mainbody')
  <div class="row">
    <div class="small-12 large-12 columns">
      <h2>Clusters</h2>
      <hr/>
    </div>
  </div>

  <div class="row">
    <div class="small-2 large-2 columns" style="padding-top: 4px">Add New Cluster:</div>
    <div class="small-2 large-4 columns">
      {{ HTML::link_to_route('new_cluster','Add Cluster', array(), array('class'=>'button tiny round')) }}
    </div>
    <div class="small-8 large-5"></div>
  </div>

  <div class="row">
    <div class="small-12 large-12 columns">
      <h4 class="subheader">List of current clusters:</h4>
    </div>
  </div>
  
  <div class="row">
    <div class="small-12 large-12 columns">
      <table>
	<thead>
	  <tr>
	    <th width="25%">Name</th>
	    <th class="text-center">Building</th>
	    <th class="text-center">Level</th>
            <th class="text-center">Booked Seats</th>
            <th class="text-center">Available Seats</th>
	    <th class="text-center">Total Seat Capacity</th>
            <th></th>
            <th></th>
            <th></th>
	  </tr>
	</thead>
	<tbody>
	  @foreach($clusters as $cluster)
 	    <tr>
	      <td>{{ HTML::link_to_route('edit_cluster', e($cluster->name), array($cluster->id)) }}</td>
	      <td class="text-center">{{ e($cluster->building) }}</td>
	      <td class="text-center">{{ e($cluster->level) }}</td>
              <td class="text-center">{{ e($cluster->booked_seats) }}</td>
              <td class="text-center">{{ e($cluster->available_seats) }}</td>
	      <td class="text-center">{{ e($cluster->allocated_seats) }}</td>
	      <td>
		{{ HTML::link_to_route('cluster_seats', 'Seats', array($cluster->id), array('class'=>'button tiny round right', 'style'=>'margin-bottom:0px; margin-left:30%;' )) }}
	      </td>
	      <td>
		{{ Form::open('cluster/delete', 'DELETE', array('style'=>'padding-top:20px;')) }}
		{{ Form::hidden('id', e($cluster->id)) }}
		{{ Form::submit('Delete', array('class'=>'button tiny alert round right')) }}
		{{ Form::close() }}
	      </td>
	    </tr>
	    @endforeach
	</tbody>
      </table>
    </div>
  </div>
@endsection
