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
        insertData(Input::all());
        $message = 'Success!';
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }

    // creates an edit page for individual author
    public function get_edit($id){
        $cluster = Cluster::find($id);
        return View::make('cluster.edit')
            ->with('cluster', $cluster);
    }

    // updates individual cluster pages
    public function put_update(){
        updateData(Input::all());
        $message = "Cluster Updated!";
        return Redirect::to_route('clusters')
            ->with('message', $message);
            
    }

    // deletes an entry from the cluster table
    public function delete_remove(){
        removeData(Input::all());
        $message = 'Cluster Removed!';
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }
}

// Helper Functions
function insertData($input){
    Cluster::create(array(
        'cluster_name'=>$input['clusname'],
        'email'=>$input['clusmail'],
        'max_seats'=>$input['clusseats'],
        'level'=>$input['cluslev'],
        'building'=>$input['clusbuild'],
    ));        
}

function updateData($input){
    $cluster_id = $input['clus'];
    Cluster::update($cluster_id, array(
        'cluster_name'=>$input['clusname'],
        'email'=>$input['clusmail'],
        'max_seats'=>$input['clusseats'],
        'level'=>$input['cluslev'],
        'building'=>$input['clusbuild'],
    ));
}

function removeData($input){
    Cluster::find($input['id'])->delete();
}

?>