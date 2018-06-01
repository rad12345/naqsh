<?php
namespace rad\app\model;

class membership{

public static function newmembership(){

if(isset($_POST['action'])){

if(isset($_POST["captcha"])&&$_POST["captcha"]!="" && isset($_SESSION["code"])  && $_SESSION["code"]==$_POST["captcha"]){
$_SESSION["code"] = \rad\app\lib\Upload::random_string(20);

$is_valid = \mem::get("validate")->validate($_POST, 
array(
   'firstname' => 'required',
   'fathername' => 'required',
   'middlename' => 'required',
   'familyname' => 'required',
   'age' => 'required',
   'gender' => 'required',
   'address' => 'required',
   'workaddress' => 'required',
   'birthday' => 'required',
   'mobile' => 'required'
) , // errors
array(
'firstnamevalidate_required' => \mem::get('lang')->container['requierd_firstname'],
'fathernamevalidate_required' => \mem::get('lang')->container['requierd_fathername'],
'middlenamevalidate_required' => \mem::get('lang')->container['requierd_middlename'],
'familynamevalidate_required' => \mem::get('lang')->container['requierd_familyname'],
'agevalidate_required' => \mem::get('lang')->container['requierd_age'],
'gendervalidate_required' => \mem::get('lang')->container['requierd_gender'],
'addressvalidate_required' => \mem::get('lang')->container['requierd_address'],
'workaddressvalidate_required' => \mem::get('lang')->container['requierd_workaddress'],
'birthdayvalidate_required' => \mem::get('lang')->container['requierd_birthday'],
'mobilevalidate_required' => \mem::get('lang')->container['requierd_mobile']
)
);





}else{
$is_valid = array(\mem::get('lang')->container['wrongcaptcha']);
}


if($is_valid === true){
\mem::get('db')->table('membership')->save(
array(
'membership_firstname'=>$_POST['firstname'],
'membership_fathername'=>$_POST['fathername'],
'membership_middlename' => $_POST['middlename'],
'membership_familyname' => $_POST['familyname'],
'membership_age' => $_POST['age'],
'membership_gender' => $_POST['gender'],
'membership_address' => $_POST['address'],
'membership_workaddress' => $_POST['workaddress'],
'membership_birthday' => $_POST['birthday'],
'membership_learneddabka' => $_POST['learneddabka'],
'membership_whereldabka' => $_POST['whereldabka'],
'membership_phone' => $_POST['phone'],
'membership_mobile' => $_POST['mobile'],
'membership_time' => time()
));




unset($_POST);


}

return $is_valid;

}



}




public static function getmembership($id){
$membership = \mem::get('db')->table('membership')->eq('membership_id', $id)->findOne();
if($membership['membership_readed'] == 0) \mem::get('db')->table('membership')->eq('membership_id', $id)->save(
array('membership_readed'=>1));
return $membership;
}


public static function unreaded(){
return \mem::get('db')->table('membership')->eq('membership_readed',0)->count();
}



public static function getmemberships($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$membership = \mem::get('db')->table('membership')->limit($num_rec_per_page)->offset($start_from)->desc('membership_id')->findAll();


$total_records =  \mem::get('db')->table('membership')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('membership'=>$membership,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('membership')->eq('membership_id', $id)->remove();

}

}

?>