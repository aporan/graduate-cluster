<?php

class Cluster extends Eloquent {

    public static $table = 'graduate_cluster';
    public static $accessible = array('cluster_name', 'email', 'max_seats', 'level', 'building', 'image_path');

}

?>