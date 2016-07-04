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
        </tr>
      </thead>
      
      <tbody>
      @foreach($generals as $general)
        <tr>
          <td>{{ HTML::link_to_route('assign_users', e(ucwords($general->first_name)).e(" ".ucwords($general->last_name)) , array($general->id)) }}</td>
          <td>{{ $general->email }}</td>
        </tr>
      @endforeach
      </tbody>
    </table>
  </div>
</div>


      
@endsection
