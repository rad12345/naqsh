<?php
namespace rad\app\model;

class messages{



public static function getmessage($id){
$message = \mem::get('db')->table('messages')->eq('message_id', $id)->findOne();
if($message['message_read'] == 0) \mem::get('db')->table('messages')->eq('message_id', $id)->save(
array('message_read'=>1));
return $message;
}


public static function unreaded(){
return \mem::get('db')->table('messages')->eq('message_read',0)->count();
}



public static function getmessages($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$messages = \mem::get('db')->table('messages')->limit($num_rec_per_page)->offset($start_from)->desc('message_id')->findAll();


$total_records =  \mem::get('db')->table('messages')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('messages'=>$messages,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('messages')->eq('message_id', $id)->remove();

}

}

?>