<?php

function dump(){
    foreach(func_get_args() as $arg){
        echo "<pre>";
        var_dump($arg);
        echo "</pre>";
    }
}

function dd(){
    dump(...func_get_args());
    exit;
}

function view($pageName, $data = []){
    $data['pageName'] = $pageName;
    extract($data);

    require _VIEW.DS."template".DS."header.php";
    require _VIEW.DS.$pageName.".php";
    require _VIEW.DS."template".DS."footer.php";
}


function result($message, $result = "stay"){
    json_response(["result" => $result, "message" => $message]);
    exit;
}

function user(){
    return isset($_SESSION['user']) ? $_SESSION['user'] : null;
}

function json_response($data){
    header("Content-Type: application/json");
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

function emptyCheck($actionAtFail){
    foreach($_POST as $item){
        if(trim($item) === "") {
            result("모든 정보를 기입해 주세요", $actionAtFail);
            exit;
        }
    }
}

function random_str($length){
    $str = "qwertyuiopasdfghjklzxcvbnm1234567890";
    $result = "";
    for($i = 0; $i < $length; $i++){
        $result .= $str[random_int(0, strlen($str) - 1)];
    }
    return $result;
}