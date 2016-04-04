<?php

class Booking extends Eloquent {

    public static $table = 'student_booking';
    public static $accessbile = array('first_name', 'last_name', 'email', 'mobile', 'sex', 'gov_identifier', 'pillar', 'category', 'booking_from', 'booking_till', 'nationality', 'faculty_id', 'cluster_id', 'seat_id');

    public static $rules_basic = array(
        'studfirst' => 'required|alpha',
        'studlast' => 'required|alpha',
        'gender' => 'required|in:male, female',
        'nation' => 'required',
        'pillar' => 'required|in:asd, istd, epd, esd, hass',
        'studtyp' => 'required|in:phd, masters, postdoc, researcher'
    );

    public static function validation_basic($data){
        return Validator::make($data, Booking::$rules_basic);
    }
    
}

?>