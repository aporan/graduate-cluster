<?php

class User extends Eloquent {

    public static $table = 'users';
    public static $accessbile = array('first_name', 'last_name', 'email', 'password', 'type');

    public static $rules = array(
        'firstname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'lastname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'email' => 'required|unique: users, email',
        'password'=>'confirmed'
    );

    public static function validate($data){
        return Validator::make($data, User::$rules);
    }

    public function bookings(){
        return $this->has_many('Booking');
    }



}

?>