<?php

class Authentication_Controller extends Base_Controller {

    public $restful = true;

    // renders login page
    public function get_login(){
        return View::make('static.login');
    }

    public function get_register(){
        return View::make('static.register');
    }

    public function post_create(){
        $input = Input::all();
        $validation = User::validate($input);

        if ($validation->fails()){

            return Redirect::to_route('register')
                ->with_errors($validation)
                ->with_input();

        } else {
            echo "It works!";
        }
    }


}

?>