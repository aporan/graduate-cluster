@layout('base.default')

@section('mainbody')
    <div class="row">
      <div class="small-12 large-12 columns">
	<h2>{{ $this_cluster->name }}</h2>
	<hr/>
      </div>
    </div>

    <div class="row">
      <div class="small-12 large-12 columns">
	<h4 class="subheader">List of Desk Spaces :</h4>
      </div>
    </div>
    
    <div class="row">
      <div class="small-12 large-12 columns">
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
		<td>{{ $seat->number }}</td>
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
    </div>
    
@endsection
    
