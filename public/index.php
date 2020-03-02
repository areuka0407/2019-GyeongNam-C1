<?php
session_start();

define("DS", DIRECTORY_SEPARATOR);
define("_ROOT", dirname(__DIR__));
define("_SRC", _ROOT.DS."src");
define("_PUBLIC", __DIR__);
define("_VIEW", _SRC.DS."Views");


require _SRC.DS."autoload.php";
require _SRC.DS."helper.php";
require _SRC.DS."web.php";