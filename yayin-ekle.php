<?php 
	require 'ayar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Yayın Ekle</title>
</head>
<body>
	<form action="ajax.php">
		<label for="kaynak">Yayın kaynağı : </label>
		<input type="text" name="kaynak"><br>
		<label for="k_adi">Kanal Adı : </label>
		<input type="text" name="k_adi"><br>
		<button>Yayını başlat</button>
	</form>
</body>
</html>