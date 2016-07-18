<?php

function insertUser($input) {

    $firstname = strtolower(trim($input['firstname']));
    $lastname = strtolower(trim($input['lastname']));
    $email = strtolower(trim($input['email']));
    $password = trim($input['password']);
    $hashed_password = hashPassword($password);
    $type= $input['type'];
    
    User::create(array(
        'first_name'=>$firstname,
        'last_name'=>$lastname,
        'email'=>$email,
        'password'=>$hashed_password,
        'type'=>$type
    ));
}

function sendRegistrationEmail($input) {
    $subject = 'You\'ve successfully registered!'. "\r\n" . "\r\n" .
    $message = 'Your registration was successful.'. "\r\n" . "\r\n" .
        'Your login details are:'. "\r\n" .
        'email: '.$input['email']. "\r\n" .
        'password: '.$input['password']. "\r\n" . "\r\n" .
        'Thank you for registering with us!'. "\r\n" .
        'Have a good day!'
        ;
    $headers = 'From: donotreply@graduateoffice.com' . "\r\n" . 'X-Mailer: PHP/';
    $to = 'ahnaf_siddiqi@mymail.sutd.edu.sg'; # need to change to input['email'];
    return mail($to, $subject, $message, $headers);
}

function hashPassword($password) {  return Hash::make($password);  }

function checkSession($session_name){
    if(Session::has($session_name)){
        Session::forget($session_name);
    }
}

function registeredUser($email) {
    $user = User::where_email($email)->first();
    $res = ($user) ? True : False;
    return $res;
}

function storeUserEmail($email) {
    checkSession('reset_password');
    $email_array = array('verify_email' => $email);
    Session::put('reset_password', $email_array);
}

function changePassword($input) {
    $reset_password = Session::get('reset_password');
    $email = trim($reset_password['verify_email']);
    $password = trim($input['password']);
    
    $user = User::where_email($email)->first();
    $user_id = $user->id;
    $hashed_password = hashPassword($password);
    User::update($user_id, array(
        'password'=>$hashed_password
    ));

    checkSession('reset_password');
}

?>
