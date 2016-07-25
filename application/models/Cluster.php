<?php

class Cluster extends Eloquent {

    public static $table = 'clusters';
    public static $timestamps = False;
    public static $accessible = array('name', 'booked_seats', 'allocated_seats', 'available_seats', 'level', 'building', 'image_path');

    public static $rules = array(
        'clusname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'clusseats' => 'required|integer',
        'cluslev' => 'required|integer',
        'clusbuild' => 'required|alpha_dash',
        'cluster_image' => 'required|image'
    );
    
    public static $rules_update = array(
        'clusname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'clusseats' => 'required|integer',
        'cluslev' => 'required|integer',
        'clusbuild' => 'required|alpha_dash',
        'cluster_image' => 'required|image'
    );

    public static function validate($data){
        return Validator::make($data, Cluster::$rules);
    }

    public static function validate_update($data){
        return Validator::make($data, Cluster::$rules_update);
    }

    public function seats(){
        return $this->has_many('ClusterSeat');
    }
    
}

?>