<?php 
require("ayar.php");
require("models/kullanici.php");
$kullanici = new Kullanici;
$mesaj = [];
if (isset($_POST["submit"])) {
	$kullanici_adi = $_POST["ad"];
	$kullanici_sifre = $_POST["sifre"];
	if (empty($kullanici_adi) || empty($kullanici_sifre)) {
		$mesaj["tip"] = "danger";
		$mesaj["icerik"] = "Kullanıcı adı ve şifresi boş bırakılamaz";
	}else{
		$aktif = 0;
		if (isset($_POST["aktif"])) {
			$aktif = 1;
		}
		$kul = $kullanici->kullanici_ekle($kullanici_adi,$kullanici_sifre,$aktif);
		$mesaj["tip"] = "success";
		$mesaj["icerik"] = "Kullanıcı başarılı bir şekilde eklendi";
	}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Kullanıcı Ekle</title>
</head>
<body>
	<form action="" method="post">
		<label for="ad">Kullanıcı Adı : </label>
		<input type="text" name="ad"><br>
		<label for="sifre">Kullanıcı Şifresi : </label>
		<input type="text" name="sifre"><br>
		<label for="aktif">Kullanıcı Aktif : </label>
		<input type="checkbox" name="aktif"><br>
		<button type="submit" name="submit">Ekle</button>
	</form>
	<?php if (isset($_POST["submit"])) {
		echo $mesaj["icerik"];
	} ?>
</body>
</html>