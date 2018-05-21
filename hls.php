<?php 
$username = "yunus";
$password = "konyar";

if (isset($_GET["u"]) && isset($_GET["p"]) && isset($_GET["t"])) {
	if ($_GET["u"] == $username && $_GET["p"] == $password) {
		if (file_exists("hls/".$_GET["t"])) {
			header("Content-type: video/MP2T");
			header('Content-Disposition: attachment; filename="'.$_GET["t"].'"');
			readfile("hls/".$_GET["t"]);
		}
		die();
	}
}
 ?>