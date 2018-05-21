<?php
require 'ayar.php';
// Kaynak Ekleme İşlemi
if(isset($_GET['kaynak']) && isset($_GET['k_adi'])){
	$query = $db->prepare("INSERT INTO yayin SET
	y_adi = :adi,
	y_kaynak = :kaynak,
	y_durum = :durum");
	$insert = $query->execute(array(
	      "adi" => $_GET['k_adi'],
	      "kaynak" => $_GET['kaynak'],
	      "durum" => 0,
	));
	if ( $insert ){
	    $last_id = $db->lastInsertId();
	    print "insert işlemi başarılı!";
	}
	//kaynak işlemleri
}elseif (isset($_GET['yid']) && isset($_GET['i'])) {
	$query = $db->query("SELECT * FROM yayin WHERE id = '{$_GET['yid']}'")->fetch(PDO::FETCH_ASSOC);
	if ($_GET['i'] == "b") {
		if ($query['y_durum'] == 0) {
			# Yayin Kapalıysa
			$ff_cmd = ffmpeg_cmd($query['y_kaynak'],$query['id']);
			$pid = yayin_baslat_2($ff_cmd);
			$guncelle = $db->prepare("UPDATE yayin SET
				y_durum = :y_durum,
				y_pid = :y_pid
				WHERE id = :id");
				$update = $guncelle->execute(array(
				     "id" => $query['id'],
				     "y_durum" => 1,
				     "y_pid" => $pid
				));
				if ( $update ){
				     print "yayınınız ".$pid." pid numarası ile başarılı bir şekilde başlatıldı!";
				}
		}else{
			echo 'Yayın Zaten Aktif Durumda';
		}
	}elseif ($_GET['i'] == "d") {
		# Yayını Durduracağız
		yayin_durdur($query['y_pid']);
		$dos_sil = 'DEL /F /Q /A C:\Users\knyr\Desktop\nginx\html\hls\\'.$query['id'].'-k*';
		shell_exec($dos_sil);
		$guncelle = $db->prepare("UPDATE yayin SET
				y_durum = :durum,
				y_pid = :pid
				WHERE id = :id");
				$update = $guncelle->execute(array(
				     "id" => $query['id'],
				     "durum" => 0,
				     "pid" => 0
				));
				if ( $update ){
				     print "yayınınız ".$query['y_pid']." pid numarası durduruldu!";
				}
		echo "Durduruldu";
	}elseif ($_GET['i'] == "s") {
		# Yayını Sileceğiz
		echo "s";
	}
}
?>