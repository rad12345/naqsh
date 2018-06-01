<?php
namespace rad\app\model;

class slide{

public static function getslides(){
return \mem::get('db')->table('slide')->limit(10)->desc('slide_id')->findAll();

}

public static function delete($id){

return \mem::get('db')->table('slide')->eq('slide_id', $id)->remove();

}







public static function newslide($lang){
$upload =  \rad\app\lib\Upload::uploadimage($_FILES['slideimage'],"slider/");
if(is_array($upload)){
return $upload;
}else{
\mem::get('db')->table('slide')->save(
array('slide_englishtitle'=>$_POST['slideenglishtitle'],'slide_title'=>$_POST['slidetitle'],'slide_image'=>$upload,'slide_lang' => $lang));
return true;
}

}

public static function newsideslide($lang){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('slides')->save(
array('slide_englishtitle'=>$_POST['slideenglishtitle'],'slide_title' => $_POST['slidetitle'],'slide_shortcontent' => $_POST['slideshortcontent'],'slide_contents' => $_POST['slidecontents'],'slide_color' => $_POST['slidecolor'],'slide_lang' => $lang,'slide_place'=>2));

return true;
}



public static function update($id){
\mem::get('db')->table('slide')->eq('slide_id', $id)->save(
array('slide_englishtitle'=>$_POST['slideenglishtitle'],'slide_title' => $_POST['slidetitle']));

return true;
}


public static function getslide($id){
return \mem::get('db')->table('slide')->eq('slide_id', $id)->findOne();
}








}

?>