<?php

class Booking extends Eloquent {

    public static $table = 'student_booking';
    public static $accessible = array('first_name', 'last_name', 'email', 'mobile', 'sex', 'gov_identifier',
    'pillar', 'category', 'booking_from', 'booking_till', 'nationality', 'faculty_id', 'cluster_id', 'seat_id');

}

?>