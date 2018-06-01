<?php
namespace rad\app\model;

class settings{

public static function getsettings($lang){
return \mem::get('db')->table('settings')->eq('setting_lang', $lang)->findOne();
}
public static function getaboutus(){
return \mem::get('db')->table('aboutuswidget')->eq('aboutuswidget_id', 1)->findOne();
}


public static function updatecomments($aprov){
\mem::get('db')->table('settings')->eq('setting_id', 1)->save(
array(
'setting_comnedaprov' => $aprov
));
\mem::get('db')->table('settings')->eq('setting_id', 2)->save(
array(
'setting_comnedaprov' => $aprov
));


}


public static function updatebackground(){
$upload =  \rad\app\lib\Upload::uploadimage($_FILES['slideimage'],"counter/");
if(is_array($upload)) return $upload;
\mem::get('db')->table('settings')->eq('setting_id', 1)->save(
array(
'setting_background' => $upload
));
\mem::get('db')->table('settings')->eq('setting_id', 2)->save(
array(
'setting_background' => $upload
));
return true;

}




public static function updateaboutus($id=1){
$upload =  \rad\app\lib\Upload::uploadimage($_FILES['slideimage'],"counter/");
if(is_array($upload)){
\mem::get('db')->table('aboutuswidget')->eq('aboutuswidget_id', $id)->save(
array(
'aboutuswidget_artitle' => $_POST['arabictitle'],
'aboutuswidget_entitle' => $_POST['englishtitle']
));
return true;
}else{
\mem::get('db')->table('aboutuswidget')->eq('aboutuswidget_id', $id)->save(
array(
'aboutuswidget_artitle' => $_POST['arabictitle'],
'aboutuswidget_entitle' => $_POST['englishtitle'],
'aboutuswidget_image' => $upload
));
return true;
}

}




}

?>