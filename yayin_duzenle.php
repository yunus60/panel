<?php 
require("ayar.php");
if (isset($_GET["id"])) {
	# code...
	$yayin = $db->query("SELECT * FROM yayin WHERE id = '{$_GET['id']}'")->fetch(PDO::FETCH_ASSOC);
}
if (isset($_POST["submit"])) {
	# code...
	$duzenle_q = $db->prepare("UPDATE yayin SET y_kaynak = :y_kaynak, y_adi = :y_adi WHERE id = :id");
	$duzenle = $duzenle_q->execute(array(	"id" => $yayin['id'],
											"y_adi" => $_POST['yadi'],
											"y_kaynak" => $_POST['kaynak']));
	if ( $duzenle ){
		print "başarılı bir şekilde başlatıldı!";
	}
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
 	<title>Yayın Düzenleme Sayfası</title>
 </head>
 <body>
 	<form action="" method="post">
 		<label for="kaynak">Yayın Adı : </label>
 		<input type="text" name="yadi" value="<?php echo $yayin['y_adi'] ?>"><br>
 		<label for="kaynak">Yayın Kaynağı : </label>
 		<input type="text" name="kaynak" value="<?php echo $yayin['y_kaynak'] ?>"><br>
 		<button type="submit" name="submit" class="btn btn-success">Kaydet</button>
 	</form>
 </body>
 </html>