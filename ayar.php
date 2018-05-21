<?php 
session_start();
date_default_timezone_set('Europe/Istanbul');

define('DATABASE_NAME', 'iptv');
define('DATABASE_USER', 'root');
define('DATABASE_PASS', '');
define('DATABASE_HOST', 'localhost');
define('FFMPEG_PATH', 'C:\Users\KNYR\Desktop\bin\\');
define('HLS_PATH', 'C:\Users\KNYR\Desktop\nginx\html\hls\\');
define('HIDE_CMD', 'C:\Users\KNYR\Desktop\nginx\RunHiddenConsole.exe');

	try{
		$db = new PDO('mysql:host=localhost;dbname=myiptv;charset=utf8','root','');
	}catch(PDOException $e){
		echo 'Hata: '.$e->getMessage();
	}

require 'fonksiyonlar.php';

?>