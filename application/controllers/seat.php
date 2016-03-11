<?php

class Seat_Controller extends Base_Controller {
    public $restful = true;

    //renders list of all seats for a particular cluster
    public function get_index($id){
        $this_cluster = Cluster::find($id);
        $seats = ClusterSeats::all();
        return View::make('seat.index')
            ->with('seats', $seats)
            ->with('this_cluster', $this_cluster);
    }

    // renders a page for creating a new seat
    public function get_new(){
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('seat.new')
            ->with('clusters', $clusters);
    }

    // creates a new seat
    public function post_create(){
        $cluster_id = Input::get('cluster');
        insertData(Input::all());
        return Redirect::to_route('cluster_seats', array($cluster_id));
    }

    // deletes an entry
    public function delete_remove(){
        removeData(Input::all());
        $cluster_id = Input::get('clusid');
        $message = 'Cluster Removed!';
        return Redirect::to_route('cluster_seats', array($cluster_id))
            ->with('message', $message);
    }
}

// Helper Functions
function insertData($input){
    ClusterSeats::create(array(
        'cluster_id'=>$input['cluster'],
        'seat_title'=>$input['title'],
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
    ClusterSeats::find($input['id'])->delete();
}
