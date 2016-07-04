<?php

function insertSeat($input){

    $number = trim($input['title']);
    
    ClusterSeat::create(array(
        'cluster_id'=>$input['cluster'],
        'number'=>$number,
        'available'=>1
    ));        
}

function removeSeat($input){
    ClusterSeat::find($input['id'])->delete();
}


?>