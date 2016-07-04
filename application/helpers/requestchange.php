<?php

function updateDeskSpace($input){
    $session_details = Session::get('change_request');
    $booking_id = $session_details['thestud'];
    $text = trim($session_details['areason']);
    $cluster_id = $session_details['cluster'];
    $seat_id = $input['seat'];
    $booking_from = $input['bookfro'];
    $booking_till = $input['booktill'];
    $user_id = Auth::user()->id;
    
    $reason = new ChangeReason(array('reasons'=>$text));
    $booking = Booking::find($booking_id);
    $booking->reasons()->insert($reason);

    $previous_seat_id = $booking->seat_id;
    Booking::update($booking_id, array(
        'cluster_id' => $cluster_id,
        'seat_id' => $seat_id,
        'booking_from' => $booking_from,
        'booking_till' => $booking_till,
        'user_id' => $user_id
    ));
    
    updateSeatAvailability($seat_id, $previous_seat_id);
    checkSession('change_request');
}

function storeDataInSessionOne($input){
    checkSession('change_request');
    $session_array = storePageOneInfo($input);
    Session::put('change_request', $session_array);
}

function storePageOneInfo($input){
    $temp_array = array();
    foreach($input as $key => $value){
        if ($key == 'cluster' || $key == 'areason' || $key == 'thestud'){
            $temp_array[$key] = $value;
        }
    }
    return $temp_array;
}

function checkSession($session_name) {
    if(Session::has($session_name)){
        Session::forget($session_name);
    }
}

function updateSeatAvailability($current_seat_id, $previous_seat_id) {
    #TODO: Update Available Seats
    $this_seat = ClusterSeat::find($current_seat_id);
    $this_seat->available = 0;
    $this_seat->save();

    echo $this_seat->number.'<br/>';
    echo $this_seat->available.'<br/>';

    $this_seat = ClusterSeat::find($previous_seat_id);
    $this_seat->available = 1;
    $this_seat->save();

    echo $this_seat->number.'<br/>';
    echo $this_seat->available.'<br/>';


    
}


function isAdmin() {
    $current_user = Auth::user();
    $user_type = $current_user->type;
    $is_admin = ($user_type == 'admin') ? True : False;
    return $is_admin;
}

function getUserCluster($user_id) {
    $assigned_clusters = DB::table('cluster_seats')
        ->distinct()
        ->join('seat_managers', 'cluster_seats.id', '=', 'seat_managers.seat_id')
        ->where('seat_managers.user_id', '=', $user_id)
        ->order_by('cluster_id')
        ->get(array('cluster_id'));
    
    $clusters = array();
    
    foreach($assigned_clusters as $cluster) {
        $id = $cluster->cluster_id;
        $clusters[$id] = Cluster::find($id)->name;
    }

    return $clusters;
}

function getUserSeats($user_id, $cluster_id) {
    $assigned_seats = DB::table('cluster_seats')
        ->join('seat_managers', 'cluster_seats.id', '=', 'seat_managers.seat_id')
        ->where('seat_managers.user_id', '=', $user_id)
        ->where('cluster_seats.cluster_id', '=', $cluster_id)
        ->where('cluster_seats.available', '=', 1)
        ->get(array('cluster_seats.number', 'cluster_seats.id'));
        
    $seats = array();

    foreach($assigned_seats as $seat) {
        $id = $seat->id;
        $seats[$id] = $seat->number;
    }

    return $seats;
}


?>