<?php

class RequestChange_Controller extends Base_Controller {

    public $restful = true;

    // renders index page of all bookings
    public function get_index(){
        $current_user = Faculty::find(2);
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

// helper functions
function updateDeskSpace($input){
    $session_details = Session::get('change_request');
    $booking_id = $session_details['thestud'];
    $text = $session_details['areason'];
    $cluster_id = $session_details['cluster'];
    $seat_id = $input['seat'];
    $booking_from = $input['bookfro'];
    $booking_till = $input['booktill'];
    
    $reason = new ChangeReasons(array('reasons'=>$text));
    $booking = Booking::find($booking_id);
    $booking->reasons()->insert($reason);

    Booking::update($booking_id, array(
        'cluster_id' => $cluster_id,
        'seat_id' => $seat_id,
        'booking_from' => $booking_from,
        'booking_till' => $booking_till
    ));

    checkSession('change_request');
}

function getClusterName($id){
    $this_cluster = Cluster::find($id);
    return $this_cluster->cluster_name;
}

function storeDataInSessionOne($input){
    checkSession('change_request');
    $session_array = storePageOneInfo($input);
    Session::put('change_request', $session_array);
}

function storePageOneInfo($input){
    $temp_array = array();
    foreach($input as $key => $value){
        if ($key == 'cluster' || $key == 'areason' || $key == 'thestud'){
            $temp_array[$key] = $value;
        }
    }
    return $temp_array;
}

function checkSession($session_name){
    if(Session::has($session_name)){
        Session::forget($session_name);
    }
}

?>