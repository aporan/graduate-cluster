<?php

class Cluster_Controller extends Base_Controller {

    public $restful = true;

    // renders list of all clusters
    public function get_index(){
        return View::make('cluster.index')
            ->with('clusters',Cluster::order_by('cluster_name')->get());
    }

    // renders new page for creating cluster space  
    public function get_new(){
        return View::make('cluster.new');
    }

    // creates an entry in cluster table
    public function post_create(){
        insertData(Input::all());
        return Redirect::to_route('clusters')->with('message', 'Success!');
    }

    public function delete_remove(){
        removeCluster(Input::all());
        return Redirect::to_route('clusters')->with('message', 'Cluster Removed!');
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

function removeCluster($input){
    Cluster::find($input['id'])->delete();
}


?>