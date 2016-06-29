<?php

include(path('app').'/helpers/staticpages.php');

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
            $message = "Your message was not delivered! Please try again or contact adminstrator.";
            return Redirect::to_route('email_index')
                ->with('email_error', $message)
                ->with_input();
        }
    }

}

?>