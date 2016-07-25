<?php

include(path('app').'/helpers/cluster.php');

class Cluster_Controller extends Base_Controller {

    public $restful = true;

    public function get_index(){
        $clusters = Cluster::order_by('name')->get();
        return View::make('cluster.index')
            ->with('clusters', $clusters);
    }

    public function get_new(){
        return View::make('cluster.new');
    }

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

    public function get_edit($id){
        $cluster = Cluster::find($id);
        return View::make('cluster.edit')
            ->with('cluster', $cluster);
    }

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
            
            if (updateCluster($input)) {
                
                $message = "Cluster is succesfully updated!";
                return Redirect::to_route('clusters')
                    ->with('message', $message);
                
            } else {

                $error = array('SeatUpdate'=>'<code><b>Total Seat Capacity</b></code> must be greater than available seats!');
                $invalid_update = new Messages($error);
                return Redirect::to_route('edit_cluster')
                    ->with_errors($invalid_credentials);

            }
        }
    }

    public function delete_remove(){
        removeCluster(Input::all());
        $message = 'Cluster Removed!';
        return Redirect::to_route('clusters')
            ->with('message', $message);
    }
}

?>