@layout('base.default')

@section('mainbody')

  {{ render('error.validation') }}

  <div class="row">
    <div class="small-12 large-12 columns">
      <h2>Assign Seats</h2>
      <hr/>
    </div>
  </div>

  {{ Form::open('manager/assign', 'POST') }}
  {{ Form::token() }}

  {{ Form::hidden('user', $user) }}
  
  @foreach($unassigned_seats as $cluster_id => $seats)
    @if($seats)
    <div class="row">
      <div class="small-12 large-12 columns">
        <h4>{{ getClusterName($cluster_id) }}</h4>
        <ul>
          <div class="row">
            @foreach($seats as $seat)
              <div class="small-6 large-2 columns left">
                <li style="list-style:none;">
                  {{ Form::checkbox($seat->number , $seat->id) }}
                  <span>{{ $seat->number }}</span>
                </li>
              </div>
            @endforeach
          </div>
        </ul>
      </div>
    </div>
    @endif
  @endforeach
    
  <div class="row">
    <div class="large-3 columns">
      {{ Form::submit('Assign', array('class'=>'button expand')) }}
    </div>
  </div>
      
  {{ Form::close() }}

  @if(checkAssigned($assigned_seats))

  <div class="row">
    <div class="small-12 large-12 columns">
      <h2>Unassign Seats</h2>
      <hr/>
    </div>
  </div>


  {{ Form::open('manager/unassign', 'POST') }}
  {{ Form::token() }}

  {{ Form::hidden('user', $user) }}
  
  @foreach($assigned_seats as $cluster_id => $seats)
    @if($seats)
    <div class="row">
      <div class="small-12 large-12 columns">
        <h4>{{ getClusterName($cluster_id) }}</h4>
        <ul>
          <div class="row">
            @foreach($seats as $seat)
              <div class="small-6 large-2 columns left">
                <li style="list-style:none;">
                  {{ Form::checkbox($seat->number, $seat->seat_id) }}
                  <span>{{ $seat->number }}</span>
                </li>
              </div>
            @endforeach
          </div>
        </ul>
      </div>
    </div>
    @endif
  @endforeach
    
  <div class="row">
    <div class="large-3 columns">
      {{ Form::submit('Unassign', array('class'=>'button expand')) }}
    </div>
  </div>
      
  {{ Form::close() }}

  @endif

  {{ render('error.validation_js') }}
    
@endsection
