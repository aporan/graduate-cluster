@layout('base.default')

@section('mainbody')
  <div class="row" style="margin-top: 30px;">
    <h2>My Bookings</h2>
    <hr/>
  </div>

  <div class="row">
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
	    <td>{{ HTML::link_to_route('edit_booking', e($booking->first_name).e(" ".$booking->last_name) , array($booking->id)) }}</td>
	    <td>{{ e($booking->email) }}</td>
	    <td class="text-center">{{ e($booking->mobile) }}</td>
	    <td class="text-center">{{ e($booking->pillar) }}</td>
	    <td class="text-center">{{ e($booking->category) }}</td>
	    <td class="text-center">{{ e($booking->booking_from) }}</td>
	    <td class="text-center">{{ e($booking->booking_till) }}</td>
	    <td class="text-center">{{ e($booking->nationality) }}
	    <td class="text-center">{{ e(getClusterName($booking->cluster_id)) }}</td>
	  @endforeach
      </tbody>
    </table>
  </div>
@endsection




