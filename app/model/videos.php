<?php
namespace rad\app\model;

class videos{

public static function getsvideos($start,$num){
$start = $start-2;
$images = \mem::get('db')->table('videos')->gt('video_id', $start)->limit($num)->findAll();


return $images;

}


public static function getthumb($url){
if(strpos($url, 'soundcloud.com') !== false){
$icloudurl = "http://soundcloud.com/oembed?format=json&url=".$url."&iframe=true";
$json = file_get_contents($icloudurl);
$obj = json_decode($json);
return $obj->thumbnail_url;
}


    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "http://img.youtube.com/vi/$2/0.jpg",
        $url
    );

}

public static function getemped($url,$width="100%",$height="400"){
if(strpos($url, 'soundcloud.com') !== false){
$icloudurl = "http://soundcloud.com/oembed?format=json&url=".$url."&iframe=true";
$json = file_get_contents($icloudurl);
$obj = json_decode($json);
$obj->html = str_replace("400",$height,$obj->html);
return $obj->html;
}
    return preg_replace(
        "/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
        "<iframe width='". $width ."' height='". $height ."' src=\"//www.youtube.com/embed/$2\" allowfullscreen></iframe>",
        $url
    );


}




public static function getvideos($page=1,$num_rec_per_page=8){


$start_from = ($page-1) * $num_rec_per_page; 

$videos = \mem::get('db')->table('videos')->limit($num_rec_per_page)->offset($start_from)->desc('video_id')->findAll();


$total_records =  \mem::get('db')->table('videos')->count();  //count number of records
$total_pages = ceil($total_records / $num_rec_per_page); 


return array('videos'=>$videos,'pagesnumber'=>$total_pages);

}

public static function delete($id){

return \mem::get('db')->table('videos')->eq('video_id', $id)->remove();

}






public static function checkpost(){

$is_valid = \mem::get("validate")->validate($_POST, 
array(   'title' => 'required',
    'url' => 'required|valid_url'
) , // errors
array('titlevalidate_required' => "يجب عليك كتابة عنوان للفيديو",
'urlvalidate_required' => "يجب عليك كتابة رابط الملف",
'urlvalidate_valid_url' => "يجب عليك كتابة رابط صحيح"
)
);
return $is_valid; 
}



public static function newvideo(){
$is_valid = self::checkpost();
if($is_valid !== true) return $is_valid;
$emped = self::getemped($_POST['url']);
\mem::get('db')->table('videos')->save(
array('video_image'=>self::getthumb($_POST['url']),'video_emped'=>$emped,'video_title'=>$_POST['title'],'video_url' => $_POST['url']));


return true;

}




public static function getvideo($id){
return \mem::get('db')->table('videos')->eq('video_id', $id)->findOne();
}



public static function getlastvideo(){
return \mem::get('db')->table('videos')->desc('video_id')->findOne();
}






}

?>