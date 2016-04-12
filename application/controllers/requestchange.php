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
        # validate();
        $student_booking_id = $id;
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('requestchange.new')
            ->with('clusters', $clusters)
            ->with('thestud', $student_booking_id);
    }

    // updates student booking
    public function post_pageone(){
        storeDataInSessionOne(Input::all());
        $session_details = Session::get('change_request');
        $selected_cluster = $session_details["cluster"];
        $seats = ClusterSeats::where('cluster_id', '=',  $selected_cluster)->lists('seat_title','id');
        return View::make('requestchange.new_change')
            ->with('seats', $seats);
    }

    public function post_update(){
        updateDeskSpace(Input::all());
        $current_user = Faculty::find(1);
        $bookings = Booking::where('faculty_id', '=', $current_user->id)->get();
        return Redirect::to_route('change_index')
            ->with('bookings', $bookings);
    }

}

// helper functions
function updateDeskSpace($input){
    # TODO: validation
    $session_details = Session::get('change_request');
    $booking_id = $session_details['thestud'];
    $reason = $session_details['areason'];
    $cluster_id = $session_details['cluster'];
    ChangeReasons::create(array(
        'reasons' => $reason
    ));

    $last_reason_id = ChangeReasons::order_by('id', 'desc')->first()->id;
    Booking::update($booking_id, array(
        'reasons_id' => $last_reason_id,
        'cluster_id' => $cluster_id
    ));
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