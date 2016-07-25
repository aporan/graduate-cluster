<?php

function uploadImage($name) {
    $img_identifier = 'cluster_image';
    $file = Input::file($img_identifier);
    $extension = File::extension($file['name']);
    $upload_path = 'public/img/uploads';
    $res = Input::upload($img_identifier, $upload_path, $name.'.'.$extension);
    if ($res){
        return $extension;
    } else {
        // TODO: change this to something better
        echo "Didn't work!";
    }
}

function parseImageName($name) {
    $temp_name = trim($name);
    $temp_name = strtolower($temp_name);
    $name_array = explode(" ", $temp_name);
    $final_name = "";
    foreach ($name_array as $name){
        $final_name = $final_name.$name;
    }
    return $final_name;
}

function getImagePath($input) {
    $file_name = parseImageName($input['clusname']);
    $file_extension = uploadImage($file_name);
    $image_path = 'img/uploads/'.$file_name.'.'.$file_extension;
    return $image_path;
}

function removePhysicalImage($this_cluster) {
    $stored_path = $this_cluster->image_path;
    $path = 'public/'.$stored_path;
    if (file_exists($path)){
        File::delete($path);
    }
}

function checkAvailableSeats($this_cluster, $new_total_seats) {
    $current_tot_seats = $this_cluster->allocated_seats;
    $ava_seats = $this_cluster->available_seats;
    $res = ($ava_seats > $new_tot_seats ? True : False);
    return $res;
}

function insertCluster($input) {
    $image_path = getImagePath($input);

    $name = ucwords(strtolower(trim($input['clusname'])));
    $level = trim($input['cluslev']);
    $building = trim($input['clusbuild']);
    $tot_seats = trim($input['clusseats']);
    $ava_seats = trim($input['clusseats']);
    
    Cluster::create(array(
        'name'=>$name,
        'booked_seats'=>0,
        'allocated_seats'=>$ava_seats,
        'available_seats'=>0,
        'level'=>$level,
        'building'=>$building,
        'image_path'=>$image_path
    ));
}

function updateCluster($input) {
    $cluster_id = $input['clus'];
    $this_cluster = Cluster::find($cluster_id);
    removePhysicalImage($this_cluster);

    $image_path = getImagePath($input);
    $name = ucwords(strtolower(trim($input['clusname'])));
    $level = trim($input['cluslev']);
    $building = trim($input['clusbuild']);
    $tot_seats = trim($input['clusseats']);

    if (checkAvailableSeats($this_cluster, $tot_seats)) {  return False;  }

    Cluster::update($cluster_id, array(
        'name'=>$name, 
        'allocated_seats'=>$tot_seats,
        'level'=>$level,
        'building'=>$building,
        'image_path'=>$image_path
    ));
    return True;
}

function removeCluster($input) {
    $this_cluster = Cluster::find($input['id']);
    removePhysicalImage($this_cluster);
    $this_cluster->delete();
}

?>