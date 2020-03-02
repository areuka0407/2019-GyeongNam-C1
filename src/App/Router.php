<?php
namespace App;


class Router {
    static $pages = [];
    static function connect(){
        $current_url = explode("?", $_SERVER['REQUEST_URI'])[0];
        
        foreach(self::$pages as $page){
            if($current_url === $page->url){
                $exp = explode("@", $page->action);
                $conName = "Controller\\{$exp[0]}";
                $con = new $conName();
                $con->{$exp[1]}();
                exit;
            }
        }

        echo "result is not found";
    }

    static function __callStatic($name, $args){
        $name = strtolower($name);
        if($name === strtolower($_SERVER['REQUEST_METHOD'])) {
            self::$pages[] = (object)["url" => $args[0], "action" => $args[1]];
        }
    }
}