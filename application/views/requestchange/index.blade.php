@layout('base.default')

@section('mainbody')
  <div class="row">
    <div class="small-12 large-12 columns">
      <h2>Request for Change of Desk Space</h2>
      <hr/>
    </div>
  </div>

  <div class="row">
    <div class="small-12 large-12 columns">
      <table>
	<thead>
	  <tr>
	    <th>#</th>
	    <th width="11%">Name</th>
	    <th>Email</th>
	    <th class="text-center">Contact</th>
	    <th class="text-center">Pillar</th>
	    <th class="text-center">Category</th>
	    <th class="text-center">Booking From</th>
	    <th class="text-center">Booking Date</th>
	    <th class="text-center">Nationality</th>
	    <!-- TODO: Group by Graduate Cluster -->
	    <th class="text-center">Graduate Center</th>
	  </tr>
	</thead>
	<tbody>
	  <?php $i = 1; ?>
	  @foreach($bookings as $booking)
	    <tr>
	      <td>{{ $i++ }}</td>
	      <td>{{ HTML::link_to_route('new_change', e($booking->first_name).e(" ".$booking->last_name) , array($booking->id)) }}</td>
	      <td>{{ e($booking->email) }}</td>
	      <td class="text-center">{{ e($booking->mobile) }}</td>
	      <td class="text-center">{{ e($booking->pillar) }}</td>
	      <td class="text-center">{{ e($booking->category) }}</td>
	      <td class="text-center">{{ e($booking->booking_from) }}</td>
	      <td class="text-center">{{ e($booking->booking_till) }}</td>
	      <td class="text-center">{{ e($booking->nationality) }}
	      <td class="text-center">{{ e(getClusterName($booking->cluster_id)) }}</td>
	    </tr>
	  @endforeach
	</tbody>
      </table>
    </div>
  </div>
@endsection
