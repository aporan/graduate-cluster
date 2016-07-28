<?php

class Booking extends Eloquent {

    public static $table = 'bookings';
    public static $accessbile = array('first_name', 'last_name', 'email', 'mobile', 'sex', 'gov_identifier', 'pillar', 'category', 'booking_from', 'booking_till', 'nationality', 'user_id', 'cluster_id', 'seat_id');

    public static $rules_basic = array(
        'studfirst' => 'required|match:/^[A-Za-z\s-_ ]+$/',
        'studlast' => 'required|match:/^[A-Za-z\s-_ ]+$/',
        'gender' => 'required|in:male,female',
        'nation' => 'required',
        'pillar' => 'required|in:asd,istd,epd,esd,hass',
        'studtyp' => 'required|in:phd,masters,postdoc,researcher'
    );

    public static $rules_details = array(
        'studemail' => 'required|email:unique',
        'studmob' => 'required|integer',
        'studgov' => 'required|alpha_dash|unique:bookings,gov_identifier',
        'bookfro' => 'required|date_format:Y-m-d',
        'booktill'=> 'required|date_format:Y-m-d',
        'cluster' => 'required|integer'
    );

    public static $rules_final = array(
        'seat' => 'required|integer',
    );

    public static $rules_update = array(
        'studfirst' => 'required|match:/^[A-Za-z\s-_ ]+$/',
        'studlast' => 'required|match:/^[A-Za-z\s-_ ]+$/',
        'studmob' => 'required|integer',
        'bookfro' => 'required|date_format:Y-m-d',
        'booktill'=> 'required|date_format:Y-m-d',
    );

    public static function validation_basic($data){
        return Validator::make($data, Booking::$rules_basic);
    }

    public static function validation_details($data){
        return Validator::make($data, Booking::$rules_details);
    }

    public static function validation_final($data){
        return Validator::make($data, Booking::$rules_final);
    }

    public static function validation_update($data){
        return Validator::make($data, Booking::$rules_update);
    }

    public function reasons(){
        return $this->has_many('ChangeReason');
    }

    public function user(){
        return $this->belongs_to('User');
    }
}

?>