<?php
namespace rad\app\model;

class admins{


public static function userscheckpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'username' => 'required|valid_email',
'password' => 'required',
'vpassword' => 'required'
) , // errors
array('usernamevalidate_required' => "يجب عليك كتابة ايميل",
'usernamevalidate_valid_email' => "يجب عليك كتابة ايميل صحيح",
'passwordvalidate_required' => "يجب عليك كتابة كلمة المرور",
'vpasswordvalidate_required' => "يجب عليك تاكيد كلمة السر"
)
);
return $is_valid; 
}


public static function adduser(){
$is_valid = self::userscheckpost();
if($is_valid !== true) return $is_valid;
if($_POST['password'] != $_POST['vpassword']) return array("كلمات السر غير متطابقة");
if(\mem::get('db')->table('users')->eq('user_email', $_POST['username'])->count() > 0) return array("الايميل مستخدم من قبل مدير اخر");
$password = \mem::get("user")->hashpassword($_POST['password']);
\mem::get('db')->table('users')->save(array('user_email' => $_POST['username'],'user_password' => $password));

return true;
}

public static function updateuser($id){
$is_valid = self::userscheckpost();
if($is_valid !== true) return $is_valid;
$admininfo = self::getuser($id);
if($admininfo['user_email'] != $_POST['username']){
if(\mem::get('db')->table('users')->eq('user_email', $_POST['username'])->count() > 0 && $admininfo['user_email'] != $_POST['username']) return array("الايميل مستخدم من قبل مدير اخر");
}
$password = \mem::get("user")->hashpassword($_POST['password']);
\mem::get('db')->table('users')->eq('user_id',$id)->save(
array('user_email' => $_POST['username'],'user_password' => $password));

return true;
}

public static function deleteuser($id){
return \mem::get('db')->table('users')->eq('user_id', $id)->remove();
}


public static function getuser($id){
return \mem::get('db')->table('users')->eq('user_id', $id)->findOne();
}


public static function getusers(){
return \mem::get('db')->table('users')->findAll();

}










}

?>