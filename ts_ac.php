<?php 
include "config.php";
use Models\User;
if (isset($_GET["u"]) && isset($_GET["p"]) && isset($_GET["t"])) {
	$kul_adi = $_GET['u'];
	$kul_sifre = $_GET['p'];
	$user = User::where('k_adi','=',$kul_adi)->where('k_sifre','=',$kul_sifre)->first();
	if ($user) {
		ts_oku($_GET['t']);
	}else{
		die("Kullanıcı Bulunamadı");
	}
}
die();
function ts_oku ($ts){
	if (file_exists("hls/".$ts)) {
			header("Content-type: video/MP2T");
			header('Content-Disposition: attachment; filename="'.$ts.'"');
			readfile("hls/".$ts);
	}else{
		die('Ts dosyası yok');
	}
}
?>
