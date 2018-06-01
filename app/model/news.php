<?php
namespace rad\app\model;

class news{

public static function getlastnews($num_rec_per_page=4){
return \mem::get('db')->table('news')->eq('news_lang',$_SESSION['lang'])->limit($num_rec_per_page)->desc('news_id')->findAll();
}


public static function getonenews($id){
return \mem::get('db')->table('news')->eq('news_id', $id)->findOne();
}



public static function getnews($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$news = \mem::get('db')->table('news')->join('newscats', 'cat_id', 'news_cat')->groupBy('news_id')->limit($num_rec_per_page)->offset($start_from)->desc('news_id')->findAll();


$total_records =  \mem::get('db')->table('news')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('news'=>$news,'pagesnumber'=>$total_pages);

}


public static function getlangnews($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$news = \mem::get('db')->table('news')->eq('news_lang',$_SESSION['lang'])->limit($num_rec_per_page)->offset($start_from)->desc('news_id')->findAll();


$total_records =  \mem::get('db')->table('news')->eq('news_lang',$_SESSION['lang'])->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('news'=>$news,'pagesnumber'=>$total_pages);

}




public static function getcatnews($id,$page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$news = \mem::get('db')->table('news')->eq('news_lang',$_SESSION['lang'])->eq('news_cat',$id)->limit($num_rec_per_page)->offset($start_from)->desc('news_id')->findAll();


$total_records =  \mem::get('db')->table('news')->eq('news_lang',$_SESSION['lang'])->eq('news_cat',$id)->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('news'=>$news,'pagesnumber'=>$total_pages);

}











public static function deletenews($id){

return \mem::get('db')->table('news')->eq('news_id', $id)->remove();

}





public static function subjectcheckpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'title' => 'required',
    'desc' => 'required',
    'content' => 'required',
    'cat' => 'required'
    
) , // errors
array('titlevalidate_required' => "يجب عليك كتابة عنوان",
'descvalidate_required' => "يجب عليك كتابة وصف",
'contentvalidate_required' => "يجب عليك كتابة محتوى",
'catvalidate_required' => "يجب عليك اختيار قسم"
)
);
return $is_valid; 
}


public static function newsubject(){
$is_valid = self::subjectcheckpost();
if($is_valid !== true) return $is_valid;
$upload =  \rad\app\lib\Upload::uploadimage($_FILES['image'],"news/");
if(is_array($upload)){
return $upload;
}else{
$cat = self::getcat($_POST['cat']);
\mem::get('db')->table('news')->save(
array(
'news_title' => $_POST['title'],
'news_shortcontent' => $_POST['desc'],
'news_content' => $_POST['content'],
'news_time' => time(),
'news_image' => $upload,
'news_lang' => $cat['cat_lang'],
'news_cat' => $_POST['cat']));
}
return true;
}

public static function savesubject($id){
$is_valid = self::subjectcheckpost();
if($is_valid !== true) return $is_valid;
$cat = self::getcat($_POST['cat']);
\mem::get('db')->table('news')->eq('news_id',$id)->save(array(
'news_title' => $_POST['title'],
'news_shortcontent' => $_POST['desc'],
'news_content' => $_POST['content'],
'news_time' => time(),
'news_lang' => $cat['cat_lang'],
'news_cat' => $_POST['cat']));
return true;
}






public static function catcheckpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'title' => 'required'
) , // errors
array('titlevalidate_required' => "يجب عليك كتابة عنوان")
);
return $is_valid; 
}


public static function addcat($lang){
$is_valid = self::catcheckpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('newscats')->save(array('cat_title' => $_POST['title'],'cat_desc' => $_POST['desc'],'cat_lang' => $lang));

return true;
}

public static function updatecat($id){
$is_valid = self::catcheckpost();
if($is_valid !== true) return $is_valid;
\mem::get('db')->table('newscats')->eq('cat_id',$id)->save(array('cat_title' => $_POST['title'],'cat_desc' => $_POST['desc']));

return true;
}

public static function deletecat($id){
return \mem::get('db')->table('newscats')->eq('cat_id', $id)->remove();
}


public static function getcat($id){
return \mem::get('db')->table('newscats')->eq('cat_id', $id)->findOne();
}


public static function admin_lang_cats(){
$cats = \mem::get('db')->table('newscats')->findAll();
$newscats = array();
foreach ($cats as $cat){
$newscats[$cat['cat_lang']][] = $cat;
}
return $newscats;

}







public static function lang_get($id=false){
if($id){
return \mem::get('db')->table('news')->columns('page_id', 'page_lang', 'page_name', 'page_parent')->eq('page_lang', $_SESSION['lang'])->eq('page_parent', $id)->findAll();
}else{
return \mem::get('db')->table('news')->columns('page_id', 'page_lang', 'page_name', 'page_parent')->eq('page_lang', $_SESSION['lang'])->eq('page_parent', 0)->findAll();
}
}



public static function lang_getpage($id){
return \mem::get('db')->table('news')->eq('page_id', $id)->eq('page_lang', $_SEESSION['lang'])->findOne();
}


public static function lang_getsub($id=false){
$subpage = \mem::get('db')->table('news')->columns('page_id', 'page_lang',  'page_name', 'page_parent')->eq('page_lang', $_SESSION['lang'])->neq('page_parent', 0)->findAll();
$newsubpage = array();
foreach ($subpage as $page){
$newsubpage[$page['page_parent']][] = $page;
}
return $newsubpage;
}







public static function get($id=false){
if($id){
return \mem::get('db')->table('news')->columns('page_id', 'page_lang', 'page_name', 'page_parent')->eq('page_parent', $id)->findAll();
}else{
return \mem::get('db')->table('news')->columns('page_id', 'page_lang', 'page_name', 'page_parent')->eq('page_parent', 0)->findAll();
}
}


public static function getpage($id){
return \mem::get('db')->table('news')->eq('page_id', $id)->findOne();
}

public static function getsub($id=false){
$subpage = \mem::get('db')->table('news')->columns('page_id', 'page_lang',  'page_name', 'page_parent')->neq('page_parent', 0)->findAll();
$newsubpage = array();
foreach ($subpage as $page){
$newsubpage[$page['page_parent']][] = $page;
}
return $newsubpage;
}





public static function updatepage($id=0){
 $is_valid = self::checkpost();

 if($is_valid !== true) return $is_valid;
\mem::get('db')->table('news')->eq('page_id', $id)->save(
array('page_name' => $_POST['pagetitle'],'page_content' => $_POST['pagecontents'],'page_parent' => $_POST['mainpage'],'page_desc' => $_POST['pagedesc'],'page_lang' => $_POST['pagelang']));

return true;
}


public static function deletepage($id){
return \mem::get('db')->table('news')->eq('page_id', $id)->remove();
}




}

?>