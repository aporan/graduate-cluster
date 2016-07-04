<?php

include(path('app').'/helpers/cluster.php');

class Cluster_Controller extends Base_Controller {

    public $restful = true;

    // renders list of all clusters
    public function get_index(){
        $clusters = Cluster::order_by('name')->get();
        return View::make('cluster.index')
            ->with('clusters', $clusters);
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
            insertCluster($input);
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
        $input = Input::all();
        $validation = Cluster::validate_update($input);

        if ($validation->fails()){
            $id = $input['clus'];
            $cluster = Cluster::find($id);
            return Redirect::to_route('edit_cluster', array($id))
                ->with_errors($validation)
                ->with_input()
                ->with('cluster', $cluster);
            
        } else {
            updateCluster($input);
            $message = "Cluster is succesfully updated!";
            return Redirect::to_route('clusters')
                ->with('message', $message);
        }
    }

    // deletes an entry from the cluster table
    public function delete_remove(){
        removeCluster(Input::all());
        $message = 'Cluster Removed!';
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }
}

?>