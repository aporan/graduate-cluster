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
    

}



?>