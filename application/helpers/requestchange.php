<?php

function updateDeskSpace($input){
    $session_details = Session::get('change_request');
    $booking_id = $session_details['thestud'];
    $text = $session_details['areason'];
    $cluster_id = $session_details['cluster'];
    $seat_id = $input['seat'];
    $booking_from = $input['bookfro'];
    $booking_till = $input['booktill'];
    
    $reason = new ChangeReasons(array('reasons'=>$text));
    $booking = Booking::find($booking_id);
    $booking->reasons()->insert($reason);

    Booking::update($booking_id, array(
        'cluster_id' => $cluster_id,
        'seat_id' => $seat_id,
        'booking_from' => $booking_from,
        'booking_till' => $booking_till
    ));

    checkSession('change_request');
}

function getClusterName($id){
    $this_cluster = Cluster::find($id);
    return $this_cluster->cluster_name;
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

function checkSession($session_name){
    if(Session::has($session_name)){
        Session::forget($session_name);
    }
}

?>