<?php
    error_reporting( E_ERROR | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING );
    date_default_timezone_set('Asia/Bangkok');
    header('Content-Type: application/json');

    $token = "VvBQYxbKu8UM3WAUc9ALjb3c9y7xDx1sox17gNFUX4Y"; // Token สำหรับระบบตรวจร่างคำพิพากษาทางสื่ออิเล็กทรอนิกส์

    $judge_name = $_POST["judge_name"];
    $court_name = $_POST["court_name"];
    $type_send = $_POST["type_send"];
    $datetime = $_POST["datetime"];
    $curtime = $_POST["curtime"];

    if($type_send == 1){
        $str = "มีการจ่ายร่าง  [ " . $court_name . " ]  ถึง  [ " . $judge_name . " ]  ในวันที่  [ " . $datetime . " ]  เวลา   [ " . substr($curtime, 0, 5) . " น. ]"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
    }else{
        $str = "มีการจ่ายร่าง  [ " . $court_name . " ]  สำหรับตรวจทางอิเล็กทรอนิกส์ถึง  [ " . $judge_name . " ]  ในวันที่  [ " . $datetime . " ]  เวลา   [ " . substr($curtime, 0, 5) . " น. ]"; //ข้อความที่ต้องการส่ง สูงสุด 1000 ตัวอักษร
    }  

    $app = curl_init(); 

    curl_setopt( $app, CURLOPT_URL, "https://notify-api.line.me/api/notify"); 
    // SSL USE 
    curl_setopt( $app, CURLOPT_SSL_VERIFYHOST, 0); 
    curl_setopt( $app, CURLOPT_SSL_VERIFYPEER, 0); 
    //POST 
    curl_setopt( $app, CURLOPT_POST, 1); 
    curl_setopt( $app, CURLOPT_POSTFIELDS, "message=$str"); 
    curl_setopt( $app, CURLOPT_FOLLOWLOCATION, 1); 

    $headers = array( 'Content-type: application/x-www-form-urlencoded', 'Authorization: Bearer ' . $token . '', );

    curl_setopt($app, CURLOPT_HTTPHEADER, $headers); 
    curl_setopt( $app, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec( $app ); 

    if(curl_error($app)){ 
        // echo 'error:' . curl_error($app); 
        $response->auth = false;
        echo json_encode($response);
    }else { 
        $response->auth = true;
        $response->message = $str;
        echo json_encode($response);
    }

    curl_close( $app ); 
