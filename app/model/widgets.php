<?php
namespace rad\app\model;

class widgets{

public static function getsidewidgets(){
$contentwidgets = \mem::get('db')->table('widgets')->eq('widget_place',2)->findAll();
$newwidgets = array();
foreach ($contentwidgets as $widget){
$newwidgets[$widget['widget_lang']][] = $widget;
}
return $newwidgets;

}



public static function admin_getcontentrows(){
$contentrows = \mem::get('db')->table('rows')->asc('row_order')->eq('row_place', 1)->findAll();
$newwidgets = array();
foreach ($contentrows as $row){
$newwidgets[$row['row_lang']][] = $row;
}
return $newwidgets;

}


public static function admin_getwidgets(){
$contentrows = \mem::get('db')->table('widgets')->eq('widget_widgetid',0)->findAll();
$newwidgets = array();
foreach ($contentrows as $row){
$newwidgets[$row['widget_rowid']][] = $row;
}
return $newwidgets;

}


public static function checkpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'widgettitle' => 'required'
) , // errors
array('widgettitlevalidate_required' => "يجب عليك كتابة عنوان")
);
return $is_valid; 
}


public static function newwidget($id,$widgetid=0){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('widgets')->save(
array('widget_widgetid'=>$widgetid,'widget_title' => $_POST['widgettitle'],'widget_blockfile' => $_POST['blockfile'],'widget_shortcontent' => $_POST['widgetshortcontent'],'widget_contents' => $_POST['widgetcontents'],'widget_color' => $_POST['widgetcolor'],'widget_rowid' => $id));

return true;
}

public static function newsidewidget($lang){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('widgets')->save(
array('widget_blockfile' => $_POST['blockfile'],'widget_title' => $_POST['widgettitle'],'widget_shortcontent' => $_POST['widgetshortcontent'],'widget_contents' => $_POST['widgetcontents'],'widget_color' => $_POST['widgetcolor'],'widget_lang' => $lang,'widget_place'=>2));

return true;
}



public static function update($id,$rowid){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('widgets')->eq('widget_id', $id)->save(
array('widget_title' => $_POST['widgettitle'],'widget_blockfile' => $_POST['blockfile'],'widget_shortcontent' => $_POST['widgetshortcontent'],'widget_contents' => $_POST['widgetcontents'],'widget_color' => $_POST['widgetcolor'],'widget_rowid' => $rowid));

return true;
}


public static function getwidget($id){
return \mem::get('db')->table('widgets')->eq('widget_id', $id)->findOne();
}




public static function newrow($lang){

return \mem::get('db')->table('rows')->save(
array('row_place'=>1,'row_lang'=>$lang));

}


public static function deleterow($id){
return \mem::get('db')->table('rows')->eq('row_id', $id)->remove();
}

public static function deletewidget($id){
return \mem::get('db')->table('widgets')->eq('widget_id', $id)->remove();
}





public static function lang_getcontentrows(){
return \mem::get('db')->table('rows')->eq('row_lang', $_SESSION['lang'])->eq('row_place', 1)->asc('row_order')->findAll();
}






public static function lang_getcontentwigets(){
$widgets = \mem::get('db')->table('widgets')->eq('widget_widgetid',0)->findAll();
$newwidgets = array();
foreach ($widgets as $widget){
$newwidgets[$widget['widget_rowid']][] = $widget;
}
return $newwidgets;
}

public static function lang_subgetcontentwigets(){
$widgets = \mem::get('db')->table('widgets')->neq('widget_widgetid',0)->findAll();
$newwidgets = array();
foreach ($widgets as $widget){
$newwidgets[$widget['widget_widgetid']][] = $widget;
}
return $newwidgets;
}












}

?>