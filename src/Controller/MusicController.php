<?php
namespace Controller;

use App\DB;

class MusicController {
    function getList(){
        $list = DB::fetchAll("SELECT * FROM musics");
        json_response($list);
    }

    // PlayList
    function getPlaylist(){
        if(!user()) json_response([]);

        $list = DB::fetchAll("SELECT * FROM playlist WHERE uid = ?", [user()->id]);
        json_response($list);
    }
    function setPlaylist(){
        $inputList = json_decode(file_get_contents("php://input"));
        foreach($inputList as $p){
            DB::query("UPDATE playlist SET uid = ?, name = ?, list = ? WHERE idx = ?", [user()->id, $p->name, json_encode($p->list), $p->idx]);
        }
        $result = DB::fetchAll("SELECT * FROM playlist WHERE uid = ?", [user()->id]);
        json_response($result);
    }

    function addPlaylist(){
        $input = json_decode(file_get_contents("php://input"));
        DB::query("INSERT INTO playlist(name, uid, list) VALUES (?, ?, '[]')", [$input->name, user()->id]);
        $data = DB::fetch("SELECT * FROM playlist WHERE idx = ?", [DB::getDB()->lastInsertId()]);
        json_response($data);
    }

    function removePlaylist(){
        $idx = isset($_GET['idx']) ? $_GET['idx'] : 0;
        $item = DB::fetch("SELECT * FROM playlist WHERE idx = ?" , [$idx]);
        if(!$item) result("삭제할 재생목록을 찾을 수 없습니다.");
        DB::query("DELETE FROM playlist WHERE idx = ?", [$idx]);
        result("재생목록이 삭제되었습니다.", "loading");
    }


    function getAllPlaylist(){
        $list = DB::fetchAll("SELECT * FROM playlist");
        json_response($list);
    }


    // History
    function setHistory(){
        $input = file_get_contents("php://input");
        DB::query("UPDATE history SET list = ? WHERE uid = ?", [$input, user()->id]);
        json_response(["list" => $input]);
    }

    function getHistory(){
        if(!user()) json_response(["list" => "[]"]);

        $result = DB::fetch("SELECT * FROM history WHERE uid = ?", [user()->id]);
        if(!$result){
            DB::query("INSERT INTO history(uid, list) VALUES (?, '[]')", [user()->id]);
            $result = DB::fetch("SELECT * FROM history WHERE uid = ?", [user()->id]);
        }
        json_response($result);
    }
}
