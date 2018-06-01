<?php
namespace rad\app\model;

class pages{


public static function lang_get($id=false){
if($id){
return \mem::get('db')->table('pages')->eq('page_lang', $_SESSION['lang'])->eq('page_parent', $id)->asc('page_order')->findAll();
}else{
return \mem::get('db')->table('pages')->eq('page_showinm', 0)->eq('page_lang', $_SESSION['lang'])->eq('page_parent', 0)->asc('page_order')->findAll();
}
}
public static function lang_getblocks($id){
return \mem::get('db')->table('pages')->eq('page_type', 1)->eq('page_lang', $_SESSION['lang'])->eq('page_parent', $id)->asc('page_order')->findAll();
}



public static function lang_getpage($id){
return \mem::get('db')->table('pages')->eq('page_id', $id)->eq('page_lang', $_SEESSION['lang'])->findOne();
}


public static function lang_getsub($id=false){
$subpage = \mem::get('db')->table('pages')->columns('page_order','page_id', 'page_lang',  'page_name', 'page_parent')->eq('page_lang', $_SESSION['lang'])->asc('page_order')->neq('page_parent', 0)->findAll();
$newsubpage = array();
foreach ($subpage as $page){
$newsubpage[$page['page_parent']][] = $page;
}
return $newsubpage;
}







public static function get($id=false){
if($id){
return \mem::get('db')->table('pages')->eq('page_parent', $id)->asc('page_order')->findAll();
}else{
return \mem::get('db')->table('pages')->eq('page_parent', 0)->asc('page_order')->findAll();
}
}


public static function getpage($id){
return \mem::get('db')->table('pages')->eq('page_id', $id)->findOne();
}
public static function getupage($id){
return \mem::get('db')->table('pages')->eq('page_uname', $id)->eq('page_lang', $_SESSION['lang'])->findOne();
}

public static function getsub($id=false){
$subpage = \mem::get('db')->table('pages')->neq('page_parent', 0)->asc('page_order')->findAll();
$newsubpage = array();
foreach ($subpage as $page){
$newsubpage[$page['page_parent']][] = $page;
}
return $newsubpage;
}

public static function checkpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'pagetitle' => 'required',
    'mainpage' => 'required',
) , // errors
array('pagetitlevalidate_required' => "يجب عليك كتابة عنوان للصفحة",
'mainpagevalidate_required' => "لا يمكن ترك الصفحة الرئيسية فارغة"
)
);
return $is_valid; 
}


public static function newpage(){

$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('pages')->save(
array('page_type' => $_POST['pagetype'],'page_imagecat' => $_POST['pageimagecat'],'page_showinm' => $_POST['pageshowinm'],'page_name' => $_POST['pagetitle'],'page_uname' => $_POST['pageuname'],'page_content' => $_POST['pagecontents'],'page_parent' => $_POST['mainpage'],'page_desc' => $_POST['pagedesc'],'page_lang' => $_POST['pagelang']));

return true;
}




public static function updatepage($id=0){
 $is_valid = self::checkpost();

 if($is_valid !== true) return $is_valid;
\mem::get('db')->table('pages')->eq('page_id', $id)->save(
array('page_type' => $_POST['pagetype'],'page_imagecat' => $_POST['pageimagecat'],'page_showinm' => $_POST['pageshowinm'],'page_name' => $_POST['pagetitle'],'page_uname' => $_POST['pageuname'],'page_content' => $_POST['pagecontents'],'page_parent' => $_POST['mainpage'],'page_desc' => $_POST['pagedesc'],'page_lang' => $_POST['pagelang']));

return true;
}


public static function deletepage($id){
return \mem::get('db')->table('pages')->eq('page_id', $id)->remove();
}




}

?>