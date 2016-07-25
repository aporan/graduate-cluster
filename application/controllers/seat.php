<?php

include(path('app').'/helpers/seat.php');

class Seat_Controller extends Base_Controller {
    public $restful = true;

    public function get_index($id){
        $this_cluster = Cluster::find($id);
        $seats = ClusterSeat::where('cluster_id', '=', $id)->get();
        return View::make('seat.index')
            ->with('seats', $seats)
            ->with('this_cluster', $this_cluster);
    }

    public function get_new(){
        $clusters = Cluster::order_by('id')->lists('name', 'id');
        return View::make('seat.new')
            ->with('clusters', $clusters);
    }

    public function post_create(){
        $input = Input::all();
        $cluster_id = Input::get('cluster');
        $validation = ClusterSeat::validate($input);

        if ($validation->fails()){
            
            $clusters = Cluster::order_by('id')->lists('name', 'id');
            return Redirect::to_route('new_seat')
                ->with_errors($validation)
                ->with_input()
                ->with('clusters', $clusters);
            
        } else {
            
            if (insertSeat($input)) {
                $message = "Seat was succesfully created!";
                return Redirect::to_route('cluster_seats', array($cluster_id))
                    ->with('message', $message);
            } else {
                $error = array('InsertSeat'=>'Seats cannot be added. <code><b>Total Seat Capacity</b></code> is reached. Increase <code><b>Seat Capacity</b></code> of Cluster!!');
                $invalid_update = new Messages($error);
                return Redirect::to_route('edit_cluster')
                    ->with_errors($invalid_credentials);
            }
        }
    }

    public function delete_remove(){
        removeSeat(Input::all());
        $cluster_id = Input::get('clusid');
        $message = 'Seat was successfully removed!';
        return Redirect::to_route('cluster_seats', array($cluster_id))
            ->with('message', $message);
    }
}

?>