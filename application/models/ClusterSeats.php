<?php

class ClusterSeats extends Eloquent {

    public static $table = 'cluster_seats';
    public static $accessible = array('seat_title', 'available', 'cluster_id');

}

?>