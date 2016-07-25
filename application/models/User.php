<?php

class User extends Eloquent {

    public static $table = 'users';
    public static $accessbile = array('first_name', 'last_name', 'email', 'password', 'type');

    public static $rules_login = array(
        'email'=> 'required|email',
        'password'=> 'required|min:5'
    );

    public static $rules_registration = array(
        'firstname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'lastname' => 'required|match:/^[A-Za-z0-9\s-_ ]+$/',
        'email' => 'required|unique: users, email',
        'password'=>'required|confirmed|alpha_num|min:5',
        'type' => 'required|in:admin, general, professor'
    );

    public static $rules_verify_email = array(
        'email' => 'required|email',
    );

    public static $rules_reset_password = array(
        'password' => 'required|confirmed|alpha_num|min:5'
    );

    public static function validateLogin($data) {
        return Validator::make($data, User::$rules_login);
    }

    public static function validateRegistration($data) {
        return Validator::make($data, User::$rules_registration);
    }

    public static function verifyEmail($data) {
        return Validator::make($data, User::$rules_verify_email);
    }

    public static function validateNewPassword($data) {
        return Validator::make($data, User::$rules_reset_password);
    }

    public function bookings() {
        return $this->has_many('Booking');
    }
}

?>
