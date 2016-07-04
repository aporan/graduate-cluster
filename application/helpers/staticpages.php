<?php

function sendEmail($input) {
    $text = $input['allmail'];

    if (isset($input['sendall'])) {
        
        $students = DB::table('bookings')->get(array('email'));
        $to = prepEmailList($students);
        
    } else {
        
        /* $cluster_id = $input['cluster']; */
        /* $students = DB::table('bookings') */
        /*     ->where('cluster_id', '=', $cluster_id) */
        /*     ->get(array('email')); */
        /* $to = prepEmailList($students); */
        $to = 'ahnaf_siddiqi@mymail.sutd.edu.sg';
    }
    
    $subject = 'Notification from Graduate Cluster Office';
    $message = $text;
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/';

    return mail($to, $subject, $message, $headers);
}

function prepEmailList($students){
    $temp_to = "";
    foreach ($students as $stud) {
        $temp_to .= $stud->email;
        $temp_to .= ',';
    }
    $to = rtrim($temp_to,",");
    return $to;
}

function isAdmin() {
    $current_user = Auth::user();
    $user_type = $current_user->type;
    $is_admin = ($user_type == 'admin') ? True : False;
    return $is_admin;
}

?>

