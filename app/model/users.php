<?php
namespace rad\app\model;

class users{



public static function getusers(){
return \mem::get('db')->table('users')->findAll();
}



public static function getuserbyname($name){
return \mem::get('db')->table('users')->eq('user_name', $name)->findOne();
}
}

?>