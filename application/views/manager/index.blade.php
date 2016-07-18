@layout('base.default')

@section('mainbody')
<div class="row">
  <div class="small-12 large-12 columns">
    <h2>User Manager</h2>
    <hr/>
  </div>
</div>


<div class="row">
  <div class="small-12 large-12 columns">
    <h5>Admin:</h5>
    <table> 
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
        </tr>
      </thead>
      
      <tbody>
      @foreach($admins as $admin)
        <tr>
          <td>{{ e(ucwords($admin->first_name)).e(" ".ucwords($admin->last_name)) }}</td>
          <td>{{ $admin->email }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="small-12 large-12 columns">
    <h5>General:</h5>
    <table> 
      <thead>
        <tr>
          <th>Name</th>
          <th>Email</th>
          <th>Delete?</th>
        </tr>
      </thead>
      
      <tbody>
      @foreach($generals as $general)
        <tr>
          <td>{{ HTML::link_to_route('assign_users', e(ucwords($general->first_name)).e(" ".ucwords($general->last_name)) , array($general->id)) }}</td>
          <td>{{ $general->email }}</td>
          <td>
 	    {{ Form::open('manager/delete', 'DELETE', array('style'=>'padding-top:20px;')) }}
  	    {{ Form::hidden('id', e($general->id)) }}
	    {{ Form::submit('Delete', array('class'=>'button tiny alert round')) }}
	    {{ Form::close() }}
	  </td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>

@if(!empty($professors))
 <div class="row">
   <div class="small-12 large-12 columns">
     <h5>Professor:</h5>
     <table> 
       <thead>
         <tr>
           <th>Name</th>
           <th>Email</th>
           <th>Delete?</th>
         </tr>
       </thead>
      
       <tbody>
       @foreach($professors as $professor)
         <tr>
           <td>{{ HTML::link_to_route('assign_users', e(ucwords($professor->first_name)).e(" ".ucwords($professor->last_name)) , array($professor->id)) }}</td>
           <td>{{ $professor->email }}</td>
           <td>
 	    {{ Form::open('manager/delete', 'DELETE', array('style'=>'padding-top:20px;')) }}
  	    {{ Form::hidden('id', e($professor->id)) }}
	    {{ Form::submit('Delete', array('class'=>'button tiny alert round')) }}
	    {{ Form::close() }}
	  </td>
         </tr>
       @endforeach
       </tbody>
     </table>
   </div>
 </div>
@endif
      
@endsection
