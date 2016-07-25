<?php

function insertSeat($input){

    $number = trim($input['title']);
    $cluster_id = $input['cluster'];
    $this_cluster = Cluster::find($cluster_id);

    if (seatInsertable($this_cluster)) {
        
        updateAvailableSeats($this_cluster, "INC");
    
        ClusterSeat::create(array(
            'cluster_id'=>$cluster_id,
            'number'=>$number,
            'available'=>1
        ));

        return True;
        
    } else {
        
        return False;
    }

}

function seatInsertable($this_cluster) {
    $tot_seats = $this_cluster->allocated_seats;
    $ava_seats = $this_cluster->available_seats;
    $check = $ava_seats + 1;
    $res = ($check <= $tot_seats ? True : False);
    return $res;
}

function updateAvailableSeats($this_cluster, $type) {

    $ava_seats = $this_cluster->available_seats;
    if ($type == "DEC") {
        $this_cluster->available_seats = $ava_seats - 1;
    } else {
        $this_cluster->available_seats = $ava_seats + 1;
    }
    $this_cluster->save();
}

function removeSeat($input){
    $this_seat = ClusterSeat::find($input['id']);
    $cluster_id = $this_seat->cluster_id;
    $this_cluster = Cluster::find($cluster_id);
    updateAvailableSeats($this_cluster, "DEC");
    $this_seat->delete();
}


?>