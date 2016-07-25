<?php

include(path('app').'/helpers/booking.php');

class Booking_Controller extends Base_Controller {

    public $restful = true;

    public function get_new() {
        $all_countries = listOfCountries();
        return View::make('booking.new_details')
            ->with('countries', $all_countries);
    }

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

    public function get_pagetwo() {
        if (isAdmin()) {
            
            $clusters = Cluster::order_by('id')->lists('name', 'id');
            
        } else {
            
            $user_id = Auth::user()->id;
            $clusters = getUserCluster($user_id);

        }

        return View::make('booking.new_selection')
            ->with('clusters', $clusters);
    }

    public function post_pagetwo() {
        $input = Input::all();
        $validation = Booking::validation_details($input);

        if ($validation->fails()) {
            
            $clusters = Cluster::order_by('id')->lists('name', 'id');
            return Redirect::to_route('new_pagetwo')
                ->with_errors($validation)
                ->with_input();
        } else {
            
            storeDataInSessionTwo($input);
            return Redirect::to_route('new_pagethree');
        }
    }

    public function get_pagethree() {
        $session_details = Session::get('pagetwo_details');
        $selected_cluster = $session_details["cluster"];
        $image_path = Cluster::find($selected_cluster)->image_path;

        if (isAdmin()) {

            $seats = ClusterSeat::where('cluster_id', '=',  $selected_cluster)
                ->where('available', '=', 1)
                ->lists('number','id');

        } else {
            
            $user_id = Auth::user()->id;
            $seats = getUserSeats($user_id, $selected_cluster);

        }
        
        return View::make('booking.new_final')
            ->with('seats', $seats)
            ->with('path', $image_path);
    }

    public function post_create() {
        $input = Input::all();
        $validation = Booking::validation_final($input);

        if ($validation->fails()) {
            
            return Redirect::to_route('new_pagethree')
                ->with_errors($validation)
                ->with_input();
            
        } else {

            $user = Auth::user();
            createBooking($input, $user);
            $message = "Booking Successful!";
            return Redirect::to_route('index')
                ->with('message', $message);
        }
    }

    public function get_edit($id) {
        $booking = Booking::find($id);
        return View::make('booking.edit')
            ->with('booking', $booking);
    }

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
            return Redirect::to_route('index')
                ->with('message', $message);
        }
    }

    public function delete_remove() {}
}

?>