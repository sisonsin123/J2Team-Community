<?php
ini_set('max_execution_time', 0);
//token full quyền
$token      = "EAAAAUaZA8jlABAD5mgw5XZBNz5nMDwwLUTe69Wx1MSbvoHn9Aa4BXArXadZCV7rmjUkk6n8hT6INVyOqvZA8SDCjVh3xZAnbKEuD2ZCzj1zuzbkJpHwicnRfdP9mZAOBBu19yjoPCBVjcsNZAlpMKhO5MKaPXKCQIVIZD";
//điền ID nhóm, hoặc trang, hoặc cá nhân
$id_can_xoa = "100004767250221";
//Tùy chỉnh thời gian xóa, điền true nếu muốn chọn tính năng này
$option = "false";
if($option=="true"){
    //Lưu ý điền đúng theo quy tắc năm tháng ngày
    //Điền thời gian từ ngày bao nhiêu
    $since = "2014-01-01";
    //Điền thời gian tới ngày bao nhiêu
    $until = "2017-12-13";
    $link  = "https://graph.facebook.com/$id_can_xoa/feed?fields=id&limit=5000&access_token=$token&since=$since&until=$until";
}
else{
   $link = "https://graph.facebook.com/$id_can_xoa/feed?fields=id&limit=5000&access_token=$token"; 
}
while (true) {
   $curl    = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => $link,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => false
    ));
    $response = curl_exec($curl);
    curl_close($curl);
    $data     = json_decode($response,JSON_UNESCAPED_UNICODE);
    $datas = $data["data"];
    foreach($datas as $each){
        $id_lay = $each["id"];
        $link   = "https://graph.facebook.com/$id_lay?method=delete&access_token=$token";
        $curl   = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $link,
            CURLOPT_RETURNTRANSFER => false,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false
        ));
        curl_exec($curl);
        curl_close($curl);
        sleep(5);
    }
    if(!empty($data["paging"]["next"])){
        $link = $data["paging"]["next"];
    }
    else{
        break;
    }
}

?>
