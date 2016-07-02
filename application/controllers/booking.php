<?php

include(path('app').'/helpers/booking.php');

class Booking_Controller extends Base_Controller {

    public $restful = true;

    // renders index page
    public function get_index() {
        // TODO: retrieve current logged in faculty;
        $current_user = Faculty::find(1);
        $bookings = Booking::where('faculty_id', '=', $current_user->id)->get();
        return View::make('booking.index')
            ->with('bookings', $bookings);
    }

    // renders new booking page
    public function get_new() {
        $all_countries = list_of_countries();
        return View::make('booking.new_details')
            ->with('countries', $all_countries);
    }

    // stores the basic info in a session 
    public function post_pageone() {
        $input = Input::all();
        $validation = Booking::validation_basic($input);

        if ($validation->fails()) {
            return Redirect::to_route('new_booking')
                ->with_errors($validation)
                ->with_input();
        } else {
            storeDataInSessionOne($input);
            return Redirect::to_route('new_pagetwo');
        }
    }

    // returns the booking details page 
    public function get_pagetwo() {
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('booking.new_selection')
            ->with('clusters', $clusters);
    }

    // stores the booking details in a session 
    public function post_pagetwo() {
        $input = Input::all();
        $validation = Booking::validation_details($input);

        if ($validation->fails()) {
            
            $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
            return Redirect::to_route('new_pagetwo')
                ->with_errors($validation)
                ->with_input();
        } else {
            
            storeDataInSessionTwo($input);
            return Redirect::to_route('new_pagethree');
        }
    }

    // get final page
    public function get_pagethree() {
        $session_details = Session::get('pagetwo_details');
        $selected_cluster = $session_details["cluster"];
        $image_path = Cluster::find($selected_cluster)->image_path;
        $seats = ClusterSeats::where('cluster_id', '=',  $selected_cluster)->lists('seat_title','id');
        return View::make('booking.new_final')
            ->with('seats', $seats)
            ->with('path', $image_path);
    }

    // creates an entry in the booking table
    public function post_create() {
        $input = Input::all();
        $validation = Booking::validation_final($input);

        if ($validation->fails()) {
            
            return Redirect::to_route('new_pagethree')
                ->with_errors($validation)
                ->with_input();
        } else {
            
            createBooking($input);
            $message = "Booking Successful!";
            return Redirect::to_route('bookings')
                ->with('message', $message);
        }
    }

    // creates an edit page for individual booking entry
    public function get_edit($id) {
        $booking = Booking::find($id);
        return View::make('booking.edit')
            ->with('booking', $booking);
    }

    // updates individual booking entry
    public function put_update() {
        $input = Input::all();
        $validation = Booking::validation_update($input);

        if ($validation->fails()) {

            $id = $input['booking'];
            $booking = Booking::find($id);
            return Redirect::to_route('edit_booking', array($id))
                ->with_errors($validation)
                ->with_input()
                ->with('booking', $booking);
            
        } else {

            updateBooking($input);
            $message = "Booking Updated!";
            return Redirect::to_route('bookings')
                ->with('message', $message);
        }
    }

    // removes a booking entry from the bookings table
    public function delete_remove() {}

}

?>