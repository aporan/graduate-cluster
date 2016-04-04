<?php

class Cluster extends Eloquent {

    public static $table = 'graduate_cluster';
    public static $accessible = array('cluster_name', 'email', 'max_seats', 'level', 'building', 'image_path');

    public static $rules = array(
        'clusname' => 'required|alpha_dash',
        'clusmail' => 'required|unique:graduate_cluster,email',
        'clusseats' => 'required|integer',
        'cluslev' => 'required|integer',
        'clusbuild' => 'required|alpha_dash',
        'cluster_image' => 'required|image'
    );

    public static $messages = array(
        'cluslev' => array(
            'required' => 'Level field is required!',
            'integer' => 'Level field requires you to input numbers only!'
        )
    );

    public static function validate($data){
        return Validator::make($data, Cluster::$rules);
    }

}

?>