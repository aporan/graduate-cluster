<?php

class Cluster_Controller extends Base_Controller {

    public $restful = true;

    // renders list of all clusters
    public function get_index(){
        $clusters = Cluster::order_by('cluster_name')->get();
        return View::make('cluster.index')
            ->with('clusters',$clusters);
    }

    // renders new page for creating cluster space  
    public function get_new(){
        return View::make('cluster.new');
    }

    // creates an entry in cluster table
    public function post_create(){
        $input = Input::all();
        $validation = Cluster::validate($input);

        if ($validation->fails()){
            return Redirect::to_route('new_cluster')
                ->with_errors($validation)
                ->with_input();
        } else {
            insertCluster(Input::all());
            $message = 'Success!';
            return Redirect::to_route('clusters')
                ->with('message', $message);
        }
    }

    // creates an edit page for individual author
    public function get_edit($id){
        $cluster = Cluster::find($id);
        return View::make('cluster.edit')
            ->with('cluster', $cluster);
    }

    // updates individual cluster pages
    public function put_update(){
        updateCluster(Input::all());
        $message = "Cluster Updated!";
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }

    // deletes an entry from the cluster table
    public function delete_remove(){
        removeCluster(Input::all());
        $message = 'Cluster Removed!';
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }
}

// Helper Functions

function uploadImage($name){
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

function parseImagename($name){
    $temp_name = trim($name);
    $temp_name = strtolower($temp_name);
    $name_array = explode(" ", $temp_name);
    $final_name = "";
    foreach ($name_array as $name){
        $final_name = $final_name.$name;
    }
    return $final_name;
}

function getImagePath($input){
    $file_name = parseImagename($input['clusname']);
    $file_extension = uploadImage($file_name);
    $image_path = 'img/uploads/'.$file_name.'.'.$file_extension;
    return $image_path;
}

function removePhysicalImage($id){
    $this_cluster = Cluster::find($id);
    $stored_path = $this_cluster->image_path;
    $path = 'public/'.$stored_path;
    if (file_exists($path)){
        File::delete($path);
    }
}

function insertCluster($input){
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

function updateCluster($input){
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

function removeCluster($input){
    $id = $input['id'];
    removePhysicalImage($id);
    Cluster::find($id)->delete();
}

?>