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

function removePhysicalImage($id) {
    $this_cluster = Cluster::find($id);
    $stored_path = $this_cluster->image_path;
    $path = 'public/'.$stored_path;
    if (file_exists($path)){
        File::delete($path);
    }
}

function insertCluster($input) {
    $image_path = getImagePath($input);

    Cluster::create(array(
        'cluster_name'=>$input['clusname'],
        'email'=>$input['clusmail'],
        'max_seats'=>$input['clusseats'],
        'level'=>$input['cluslev'],
        'building'=>$input['clusbuild'],
        'image_path'=>$image_path
    ));
}

function updateCluster($input) {
    $cluster_id = $input['clus'];
    removePhysicalImage($cluster_id);
    $image_path = getImagePath($input);

    Cluster::update($cluster_id, array(
        'cluster_name'=>$input['clusname'],
        'email'=>$input['clusmail'],
        'max_seats'=>$input['clusseats'],
        'level'=>$input['cluslev'],
        'building'=>$input['clusbuild'],
        'image_path'=>$image_path
    ));
}

function removeCluster($input) {
    $id = $input['id'];
    removePhysicalImage($id);
    Cluster::find($id)->delete();
}

?>