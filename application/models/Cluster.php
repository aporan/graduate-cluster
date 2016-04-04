<?php

class Cluster extends Eloquent {

    public static $table = 'graduate_cluster';
    public static $accessible = array('cluster_name', 'email', 'max_seats', 'level', 'building', 'image_path');

    public static $rules = array(
        'clusname' => 'required|match:/^[A-Za-z0-9\s-_]+$/',
        'clusmail' => 'required|unique:graduate_cluster,email',
        'clusseats' => 'required|integer',
        'cluslev' => 'required|integer',
        'clusbuild' => 'required|alpha_dash',
        'cluster_image' => 'required|image'
    );
    
    public static $rules_update = array(
        'clusname' => 'required|match:/^[A-Za-z0-9\s-_]+$/',
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
    
}

?>