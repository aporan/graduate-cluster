<?php

class StaticPages_Controller extends Base_Controller {

    public $restful = true;

    // renders the welcome page
    public function get_index(){
        return View::make('static.index');
    }

    // renders the admin index page
    public function get_admin_index(){
        return View::make('static.admin_index');
    }

    // renders the email page
    public function get_email_index(){
        $clusters = Cluster::order_by('id')->lists('cluster_name', 'id');
        return View::make('static.email_index')
            ->with('clusters', $clusters);
    }

    // sends a new email after receiving info from the page
    public function post_email_send(){
        $input = Input::all();
        $sent = sendEmail($input);
        if ($sent) {
            $message = "Your email has been delivered!";
            return Redirect::to('admin')
                ->with('message', $message);
        } else {
            $message = "Your message was not delivered! Please try again or contact adminstrator." ;
            return Redirect::to_route('email_index')
                ->with('email_error', $message)
                ->with_input();
        }
    }

    // renders login page
    public function get_login(){
        return View::make('static.login');
    }

}

// helper functions

function sendEmail($input){
    $text = $input['allmail'];

    if (isset($input['sendall'])){
        $clusters = $user = DB::table('graduate_cluster')->get(array('email'));
        $temp_to = "";
        foreach ($clusters as $cluster){
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