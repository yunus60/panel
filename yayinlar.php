<?php 
require 'ayar.php';

$query = $db->query("SELECT * FROM yayin", PDO::FETCH_ASSOC);
if ( $query->rowCount() ){
     foreach( $query as $row ){
          echo $row['y_adi'];
          if($row['y_durum'] == 0){
          	echo " Kapalı ";
               echo '<a href="ajax.php?yid='.$row['id'].'&i=b">Başlat</a> | ';
          }else{
          	echo " Açık ";
               echo '<a href="ajax.php?yid='.$row['id'].'&i=d">Durdur</a> | ';
          }
          echo '<a href="yayin_duzenle.php?id='.$row['id'].'">Düzenle</a> | ';
          echo '<a href="ajax.php?yid='.$row['id'].'&i=s">Sil</a><br>';
     }
}
?>