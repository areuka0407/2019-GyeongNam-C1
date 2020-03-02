<?php
namespace Controller;

use App\DB;

class MainController {
    function __construct(){
        $JSON_PATH = _PUBLIC.DS."json";

        // 유저
        $userExist = DB::fetchAll("SELECT * FROM users");
        if($userExist == FALSE){
            $memberList = json_decode(file_get_contents($JSON_PATH.DS."members.json"));
            foreach($memberList->members as $member){
                $salt = random_str(32);
                $password = hash("sha256", $member->password . $salt);
                DB::query("INSERT INTO users(user_id, password, password_salt) VALUES (?, ?, ?)", [$member->id, $password, $salt]);
            }
        }

        // 음악 목록
        $musicExist = DB::fetchAll("SELECT * FROM musics");
        if($musicExist == FALSE){
            $musicList = json_decode(file_get_contents($JSON_PATH.DS."music_list.json"));
            foreach($musicList as $m){
                DB::query("INSERT INTO musics(idx, name, release_at, albumName, albumImage, artist, url, lyrics, genre) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)",
                    [$m->idx, $m->name, $m->release, $m->albumName, $m->albumImage, $m->artist, $m->url, $m->lyrics, $m->genre]);
            }
        }

        // 재생 목록
        $plExist = DB::fetch("SELECT * FROM playlist");
        if($plExist == FALSE){
            $playList = json_decode(file_get_contents($JSON_PATH.DS."playlists.json"));
            foreach($playList->list as $p){
                $uid = DB::fetch("SELECT * FROM users WHERE user_id = ?", [$p->maker])->id;
                DB::query("INSERT INTO playlist(uid, name, list) VALUES (?, ?, ?)", [$uid, "재생목록{$p->idx}", json_encode($p->list)]);
            }
        }
    }

    function indexPage(){
        view("index");
    }
    
    function libPage(){
        view("library");
    }

    function queuePage(){
        view("queue");
    }

    function listPage(){
        view("playlist");
    }
}