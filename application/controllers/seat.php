<?php

class Seat_Controller extends Base_Controller {
    public $restful = true;

    //renders list of all seats for a particular cluster
    public function get_index($id){
        $this_cluster = Cluster::find($id);
        $seats = ClusterSeats::where('cluster_id', '=', $id)->get();
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
        $input = Input::all();
        $cluster_id = Input::get('cluster');
        $validation = ClusterSeats::validate($input);

        if ($validation->fails()){
            $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
            return Redirect::to_route('new_seat')->with_errors($validation)->with_input()->with('clusters', $clusters); 
        } else {
            insertSeat($input);
            $message = "Seat was succesfully created!";
            return Redirect::to_route('cluster_seats', array($cluster_id))
                ->with('message', $message);
        }
    }

    // deletes an entry
    public function delete_remove(){
        removeSeat(Input::all());
        $cluster_id = Input::get('clusid');
        $message = 'Seat is deleted!';
        return Redirect::to_route('cluster_seats', array($cluster_id))
            ->with('message', $message);
    }
}

// Helper Functions
function insertSeat($input){
    ClusterSeats::create(array(
        'cluster_id'=>$input['cluster'],
        'seat_title'=>$input['title'],
    ));        
}

function removeSeat($input){
    ClusterSeats::find($input['id'])->delete();
}
