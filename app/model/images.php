<?php
namespace rad\app\model;

class images{
public static function getlastimages($num_rec_per_page=4){
return \mem::get('db')->table('images')->limit($num_rec_per_page)->desc('image_id')->findAll();
}





public static function getalbums(){
return \mem::get('db')->table('albums')->join('images', 'image_album', 'album_id')->groupBy('album_id')->findAll();

}


public static function catcheckpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'title' => 'required',
'englishtitle' => 'required'
) , // errors
array('titlevalidate_required' => "يجب عليك كتابة عنوان",
'englishtitlevalidate_required' => "يجب عليك كتابة عنوان English")
);
return $is_valid; 
}


public static function addcat(){
$is_valid = self::catcheckpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('albums')->save(
array('album_arabictitle' => $_POST['title'],'album_englishtitle' => $_POST['englishtitle']));

return true;
}


public static function deletecat($id){
return \mem::get('db')->table('albums')->eq('album_id', $id)->remove();
}

public static function updatecat($id){
$is_valid = self::catcheckpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('albums')->eq('album_id',$id)->save(
array('album_arabictitle' => $_POST['title'],'album_englishtitle' => $_POST['englishtitle']));

return true;
}



public static function getcat($id){
return \mem::get('db')->table('albums')->eq('album_id', $id)->findOne();
}















public static function getsimages($start,$num){
$images = \mem::get('db')->table('images')->gt('image_id', $start)->limit($num)->findAll();



return $images;

}






public static function getimages($albumid,$page=1,$num_rec_per_page=12){


$start_from = ($page-1) * $num_rec_per_page; 

$images = \mem::get('db')->table('images')->eq('image_album',$albumid)->limit($num_rec_per_page)->offset($start_from)->desc('image_id')->findAll();


$total_records =  \mem::get('db')->table('images')->eq('image_album',$albumid)->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('images'=>$images,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('images')->eq('image_id', $id)->remove();

}







public static function newimage($albumid,$file){
$thumb = "uploads/portfolio/thumbnail/" . $file;
$image = "uploads/portfolio/" .  $file;
return \mem::get('db')->table('images')->save(
array('image_album'=>$albumid,'image_image'=>$image,'image_thumb' => $thumb));

}




public static function getimage($id){
return \mem::get('db')->table('images')->eq('image_id', $id)->findOne();
}








}

?>