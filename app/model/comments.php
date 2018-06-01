<?php
namespace rad\app\model;

class comments{

public static function getcomments($place,$opjectid,$approved){


$images = \mem::get('db')->table('comments')->eq('comment_opjectid',$opjectid)->eq('comment_approved',$approved)->eq('comment_place',$place)->desc('comment_id')->findAll();




return $images ;

}


public static function admin_getcomments($page=1,$num_rec_per_page=10){


$start_from = ($page-1) * $num_rec_per_page; 

$comments = \mem::get('db')->table('comments')->desc('comment_id')->limit($num_rec_per_page)->offset($start_from)->findAll();


$total_records =  \mem::get('db')->table('comments')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('comments'=>$comments,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('comments')->eq('comment_id', $id)->remove();

}


public static function aprov($id){

return \mem::get('db')->table('comments')->eq('comment_id', $id)->save(array('comment_approved'=>1));

}




public static function checkpost(){

if(isset($_POST["captcha"])&&$_POST["captcha"]!=""&&$_SESSION["code"]==$_POST["captcha"]){
$_SESSION["code"] = \rad\app\lib\Upload::random_string(20);

}else{
return array(\mem::get('lang')->container['wrongcaptcha']);
}

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'writer' => 'required',
    'comment' => 'required'
) , // errors
array('writervalidate_required' => \mem::get('lang')->container['writename'],
'commentvalidate_required' => \mem::get('lang')->container['writecomment']
)
);
return $is_valid; 
}


public static function save($place,$opjectid){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
$approved = \mem::get('config')->setting['setting_comnedaprov'];
\mem::get('db')->table('comments')->save(
array('comment_approved'=>$approved,'comment_place' => $place,'comment_opjectid' => $opjectid,'comment_writer' => $_POST['writer'],'comment_comment' => $_POST['comment'],'comment_time' => time()));

return true;
}







}

?>