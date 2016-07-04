<?php

include(path('app').'/helpers/authentication.php');

class Authentication_Controller extends Base_Controller {

    public $restful = true;

    public function get_view_login() {  return View::make('static.login');  }
    
    public function post_login() {
        $input = Input::all();
        $validation = User::validateLogin($input);

        if ($validation->fails()) {

            return Redirect::to_route('login')
                ->with_errors($validation);
            
        } else {
            
            $email = trim($input['email']);
            $password = trim($input['password']);
            $credentials = array('username'=>$email, 'password'=>$password);
            if (Auth::attempt($credentials)) {

                $user = User::where_email($email)->first();
                $message = 'Hi <b>'. ucwords($user->first_name) .'</b>! Glad you could make it.';
                return Redirect::to_route('index')
                    ->with('message', $message);

            } else {

                $error = array('Login'=>'Invalid <code><b>Email / Password</b></code> Combination');
                $invalid_credentials = new Messages($error);
                return Redirect::to_route('login')
                    ->with_errors($invalid_credentials);
            }
        }
    }

    public function get_view_register() {  return View::make('static.register');  }

    public function post_register() {
        $input = Input::all();
        $validation = User::validateRegistration($input);

        if ($validation->fails()) {

            return Redirect::to_route('register')
                ->with_errors($validation)
                ->with_input();

        } else {

            insertUser($input);
            sendRegistrationEmail($input);
            $message = "Registration is successful! Please login to access the website";
            return Redirect::to_route('login')
                ->with('message', $message);
              
        }
    }

    public function post_logout() {
        if (Auth::check()) {
            Auth::logout();
            return Redirect::to_route('login');
        }
    }

    public function get_view_verify() {  return View::make('static.verify');  }

    public function post_verify() {
        $input = Input::all();
        $validation = User::verifyEmail($input);

        if ($validation->fails()) {

            Return Redirect::to_route('verify')
                ->with_errors($validation);

        } else {

            $email = trim($input['email']);
            if (registeredUser($email)) {

                storeUserEmail($email);
                return Redirect::to_route('reset');
                    
            } else {
                
                $error = array('Login'=>'<code><b>Email</b></code> is not registered! Please Sign Up.');
                $invalid_credentials = new Messages($error);
                return Redirect::to_route('verify')
                    ->with_errors($invalid_credentials);                
            }
        }
    }

    public function get_view_reset() {  return View::make('static.reset');  }

    public function post_reset() {
        $input = Input::all();
        $validation = User::validateNewPassword($input);

        if ($validation->fails()) {

            return Redirect::to_route('reset')
                ->with_errors($validation);

        } else {

            changePassword($input);
            $message = "Password has been updated! Please login to continue.";
            return Redirect::to_route('login')
                ->with('message', $message);
        }
    }
}

?>
