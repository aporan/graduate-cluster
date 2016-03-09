@layout('base.default')

@section('mainbody')
  <div class="row">
    <table>
      <thead>
	<tr>
	  <th width="35%">Name</th>
	  <th width="25%">Email</th>
	  <th width="10%">Building</th>
	  <th width="10%">Level</th>
	  <th width="10%">Total Seats</th>
	  <th width="10%"></th>
	</tr>
      </thead>
      <tbody>
	@foreach($clusters as $cluster)
	  <tr>
	    <td>{{ $cluster->cluster_name }}</td>
	    <td>{{ $cluster->email }}</td>
	    <td>{{ $cluster->building }}</td>
	    <td>{{ $cluster->level }}</td>
	    <td>{{ $cluster->max_seats }}</td>
	    <td>
	      {{ Form::open('cluster/delete', 'DELETE', array('style'=>'padding-top:20px;')) }}
	      {{ Form::hidden('id', $cluster->id) }}
	      {{ Form::submit('Delete', array('class'=>'button tiny alert round')) }}
	      {{ Form::close() }}
	    </td>
	  </tr>
	  @endforeach
      </tbody>
    </table>
  </div>
@endsection
