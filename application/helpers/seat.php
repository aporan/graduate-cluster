<?php

function insertSeat($input){
    ClusterSeats::create(array(
        'cluster_id'=>$input['cluster'],
        'seat_title'=>$input['title'],
    ));        
}

function removeSeat($input){
    ClusterSeats::find($input['id'])->delete();
}


?>