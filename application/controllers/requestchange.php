<?php

include(path('app').'/helpers/requestchange.php');

class RequestChange_Controller extends Base_Controller {

    public $restful = true;

    // renders index page of all bookings
    public function get_index(){
        $current_user = Faculty::find(1);
        $bookings = Booking::where('faculty_id', '=', $current_user->id)->get();
        return View::make('requestchange.index')
            ->with('bookings', $bookings);
    }

    // renders new form for change of request
    public function get_new($id){
        $student_booking_id = $id;
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('requestchange.new')
            ->with('clusters', $clusters)
            ->with('thestud', $student_booking_id);
    }

    public function get_pagetwo(){
        $session_details = Session::get('change_request');
        $selected_cluster = $session_details["cluster"];
        $seats = ClusterSeats::where('cluster_id', '=',  $selected_cluster)->lists('seat_title','id');
        return View::make('requestchange.new_change')
            ->with('seats', $seats);
    }

    // updates student booking
    public function post_pageone(){
        $input = Input::all();
        $validation = ChangeReasons::validation_reason($input);

        if ($validation->fails()){
            $student_booking_id = $input['thestud'];
            $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
            return Redirect::to_route('new_change', array($student_booking_id))
                ->with_errors($validation)
                ->with('clusters', $clusters)
                ->with('thestud', $student_booking_id);
        } else {
            storeDataInSessionOne($input);
            return Redirect::to_route('change_pagetwo');
        }
    }

    public function post_update(){
        $input = Input::all();
        $validation = ChangeReasons::validation_update($input);

        if ($validation->fails()){
            return Redirect::to_route('change_pagetwo')
                ->with_errors($validation);

        } else {
            updateDeskSpace($input);
            $current_user = Faculty::find(1);
            $message = 'Your booking has been successfully changed!';
            #$Session::flash('message', $message);
            $bookings = Booking::where('faculty_id', '=', $current_user->id)->get();
            return Redirect::to_route('change_index')
                ->with('message', $message);
        }
    }
}

?>