<?php

namespace rad\app\lib;


class Auth  {


Public $lang = array('email_required' => "Email is requierd",
'email_not_valid' => "please enter a vlalid email",
'password_required' => "password is requierd",
'email_password_incorrect' => "Wrong email or password");

	protected $userdata = false;

Public function islogged(){
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true) return true;
}
Public function logout(){
session_destroy();
session_start();
}

public function login($remember = 0, $captcha = NULL){
if($this->islogged()){
return array("already sighnd in");
}
$_POST = \mem::get("validate")->sanitize($_POST);

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'username' => 'required|valid_email',
    'password' => 'required'
) , // errors
array('usernamevalidate_required' => $this->lang["email_required"],
'usernamevalidate_valid_email' => $this->lang["email_not_valid"],
'passwordvalidate_required' => $this->lang["password_required"]
)
);
if($is_valid !== true) return $is_valid;

$username = $_POST['username'];
$password = $_POST['password'];

    if(!$this->getuserdata($username)){
			return array("الايميل خطا تاكد من كتابة الايميل بشكل صحيح");
    }
   if($this->userdata['user_password'] != $this->hashpassword($password,$this->userdata['user_salt'])){
			return array("كلمة المرور خاطئه تاكد من كتابة كلمة السر بشكل صحيح");
   }
   $_SESSION['loggedin'] = true;
   $_SESSION['username'] = $username;
   return true;
}


public function getuserdata($username){
if($this->userdata) return $this->userdata;
return $this->userdata = \mem::get('db')->table('users')->eq('user_email', $username)->findOne();
}

public function userinfo(){
return $this->getuserdata($_SESSION['username']);
}


public function hashpassword( $input )
{        
$salt = "asd";
    // Initialize an incremental hashing context
    $hashed = hash_init('sha256', HASH_HMAC, $salt);
        
    // Set active hashing context
    hash_update($hashed, $input);
        
    // Return hashed password
    return md5(hash_final($hashed));
}

}
