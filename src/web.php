<?php

use App\Router;

// Main

Router::get("/", "MainController@indexPage");
Router::get("/queue", "MainController@queuePage");
Router::get("/library", "MainController@libPage");
Router::get("/playlist", "MainController@listPage");


// User

Router::post("/login", "UserController@login");
Router::post("/logout", "UserController@logout");
Router::post("/users/is-logined", "UserController@isLogined");

// Music
Router::post("/musics/get-list", "MusicController@getList");

Router::post("/playlist/add", "MusicController@addPlaylist");
Router::post("/playlist/remove", "MusicController@removePlaylist");
Router::post("/playlist/set-list", "MusicController@setPlaylist");
Router::post("/playlist/get-list", "MusicController@getPlaylist");

Router::post("/history/set-list", "MusicController@setHistory");
Router::post("/history/get-list", "MusicController@getHistory");

Router::connect();