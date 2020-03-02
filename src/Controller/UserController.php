<?php
namespace Controller;

use App\DB;

class UserController {
    function isLogined(){
        echo json_encode(user());
    }

    function login(){
        emptyCheck("closeLogin");
        extract($_POST);

        $found = DB::fetch("SELECT * FROM users WHERE user_id = ?", [$user_id]);
        if(!$found) result("아이디와 패스워드가 일치하지 않습니다.", "stay");
        if(hash("sha256", $password.$found->password_salt) !== $found->password) result("아이디와 패스워드가 일치하지 않습니다.", "stay");
        
        $_SESSION['user'] = $found;
        result("로그인 되었습니다.", "loading");
    }

    function logout(){
        unset($_SESSION['user']);
        result("로그아웃 되었습니다.", "loading");
    }
}