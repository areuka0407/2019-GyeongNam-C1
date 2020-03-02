<?php
function classLoader($c){
    $filePath = _SRC.DS. $c.".php";
    if(is_file($filePath)) require $filePath;
}

spl_autoload_register("classLoader");