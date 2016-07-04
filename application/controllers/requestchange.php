<?php

include(path('app').'/helpers/requestchange.php');

class RequestChange_Controller extends Base_Controller {

    public $restful = true;

    // renders index page of all bookings
    public function get_index() {
        $cluster_bookings = array();
        $clusters = DB::table('bookings')->distinct()->get(array('cluster_id'));
        
        if (isAdmin()) {
            foreach ($clusters as $cluster) {
                $id = $cluster->cluster_id;
                $cluster_bookings[$id] = Booking::where('cluster_id', '=', $id)->get();
            }


        } else {

            $user_id = Auth::user()->id;
            foreach($clusters as $cluster) {
                $id = $cluster->cluster_id;
                $cluster_bookings[$id] = DB::table('seat_managers')
                    ->join('bookings', 'bookings.seat_id', '=', 'seat_managers.seat_id')
                    ->where('seat_managers.user_id', '=', $user_id)
                    ->where('cluster_id', '=', $id)
                    ->get();
            }
        }

        return View::make('requestchange.index')
                ->with('cluster_bookings', $cluster_bookings);
    }

    // renders new form for change of request
    public function get_new($id) {
        $student_booking_id = $id;
        
        if (isAdmin()) {
            
            $clusters = Cluster::order_by('id')->lists('name', 'id');
            
        } else {
            
            $user_id = Auth::user()->id;
            $clusters = getUserCluster($user_id);

        }

        return View::make('requestchange.new')
            ->with('clusters', $clusters)
            ->with('thestud', $student_booking_id);
    }

    public function get_pagetwo() {
        $session_details = Session::get('change_request');
        $selected_cluster = $session_details["cluster"];
        $image_path = Cluster::find($selected_cluster)->image_path;

        if (isAdmin()) {
            $seats = ClusterSeat::where('cluster_id', '=', $selected_cluster)
                ->where('available', '=', 1)
                ->lists('number','id');

        } else {
            
            $user_id = Auth::user()->id;
            $seats = getUserSeats($user_id, $selected_cluster);

        }
        return View::make('requestchange.new_change')
            ->with('seats', $seats)
            ->with('path', $image_path);
    }

    // updates student booking
    public function post_pageone() {
        $input = Input::all();
        $validation = ChangeReason::validation_reason($input);

        if ($validation->fails()){
            $student_booking_id = $input['thestud'];
            return Redirect::to_route('new_change', array($student_booking_id))
                ->with_errors($validation);

        } else {
            storeDataInSessionOne($input);
            return Redirect::to_route('change_pagetwo');
        }
    }

    public function post_update() {
        $input = Input::all();
        $validation = ChangeReason::validation_update($input);

        if ($validation->fails()){
            return Redirect::to_route('change_pagetwo')
                ->with_errors($validation);

        } else {
            updateDeskSpace($input);
            $message = 'Your booking has been successfully changed!';
            return Redirect::to_route('index')
                ->with('message', $message);
        }
    }
}

?>