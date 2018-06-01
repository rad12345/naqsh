<?php
namespace rad\app\model;

class dabkarequest{

public static function newdabkarequest(){

if(isset($_POST['action'])){

if(isset($_POST["captcha"])&&$_POST["captcha"]!="" && $_SESSION["code"]==$_POST["captcha"]){
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
'birthdayvalidate_required' => \mem::get('lang')->container['requierd_birthday'],
'mobilevalidate_required' => \mem::get('lang')->container['requierd_mobile']
)
);





}else{
$is_valid = array(\mem::get('lang')->container['wrongcaptcha']);
}


if($is_valid === true){
\mem::get('db')->table('dabkarequest')->save(
array(
'dabkarequest_firstname'=>$_POST['firstname'],
'dabkarequest_fathername'=>$_POST['fathername'],
'dabkarequest_middlename' => $_POST['middlename'],
'dabkarequest_familyname' => $_POST['familyname'],
'dabkarequest_age' => $_POST['age'],
'dabkarequest_gender' => $_POST['gender'],
'dabkarequest_address' => $_POST['address'],
'dabkarequest_birthday' => $_POST['birthday'],
'dabkarequest_learneddabka' => $_POST['learneddabka'],
'dabkarequest_whereldabka' => $_POST['whereldabka'],
'dabkarequest_phone' => $_POST['phone'],
'dabkarequest_mobile' => $_POST['mobile'],
'dabkarequest_havebrothers' => $_POST['havebrothers'],
'dabkarequest_brothername' => $_POST['brothername'],
'dabkarequest_fathermobile' => $_POST['fathermobile'],
'dabkarequest_time' => time()
));




unset($_POST);


}

return $is_valid;

}



}




public static function getdabkarequest($id){
$dabkarequest = \mem::get('db')->table('dabkarequest')->eq('dabkarequest_id', $id)->findOne();
if($dabkarequest['dabkarequest_readed'] == 0) \mem::get('db')->table('dabkarequest')->eq('dabkarequest_id', $id)->save(
array('dabkarequest_readed'=>1));
return $dabkarequest;
}


public static function unreaded(){
return \mem::get('db')->table('dabkarequest')->eq('dabkarequest_readed',0)->count();
}



public static function getdabkarequests($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$dabkarequest = \mem::get('db')->table('dabkarequest')->limit($num_rec_per_page)->offset($start_from)->desc('dabkarequest_id')->findAll();


$total_records =  \mem::get('db')->table('dabkarequest')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('dabkarequest'=>$dabkarequest,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('dabkarequest')->eq('dabkarequest_id', $id)->remove();

}

}

?>