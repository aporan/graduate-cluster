<?php

function sendEmail($input) {
    $text = $input['allmail'];

    if (isset($input['sendall'])) {
        
        $clusters = $user = DB::table('graduate_cluster')->get(array('email'));
        $temp_to = "";
        foreach ($clusters as $cluster) {
            $temp_to .= $cluster->email;
            $temp_to .= ',';
        }
        $to = rtrim($temp_to,",");
        
    } else {
        
        $cluster_id = $input['cluster'];
        $email = Cluster::find($cluster_id)->email;
        $to      = 'ahnaf_siddiqi@mymail.sutd.edu.sg';
    }
    
    $subject = 'Notification from Graduate Cluster Office';
    $message = $text;
    $headers = 'From: webmaster@example.com' . "\r\n" .
        'Reply-To: webmaster@example.com' . "\r\n" .
        'X-Mailer: PHP/';

    return mail($to, $subject, $message, $headers);
}

?>