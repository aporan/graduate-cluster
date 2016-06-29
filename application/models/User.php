<?php

class User extends Eloquent {

    public static $table = 'users';
    public static $accessbile = array('first_name', 'last_name', 'email', 'password', 'type');

}

?>