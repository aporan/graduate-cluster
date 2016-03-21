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
        return View::make('static.email_index');
    }

    // sends a new email after receiving info from the page
    public function post_email_create(){
        // validate form entry
        return Redirect::to('admin');
    }

    // renders login page
    public function get_login(){
        return View::make('static.login');
    }
    

}

?>