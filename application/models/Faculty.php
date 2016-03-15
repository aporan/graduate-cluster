<?php

class Faculty extends Eloquent {

    public static $table = 'faculty';
    public static $accessbile = array('first_name', 'last_name', 'email');

}

?>