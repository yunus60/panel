<?php 
include "config.php";
use Models\User;
use Models\Ayarlar;
use Models\Yayin;
if (isset($_GET["u"]) && isset($_GET["p"]) && isset($_GET["t"]) && isset($_GET["id"]) ) {
	$kul_adi = $_GET['u'];
	$kul_sifre = $_GET['p'];
	$user = User::where('k_adi','=',$kul_adi)->where('k_sifre','=',$kul_sifre)->first();
	$ayar = Ayarlar::first();
	$yayin = Yayin::find($_GET['id']);
	if ($user) {
		if ($yayin) {
			$files = getTSFiles($ayar->hls_folder.'/'.$yayin->id."-k.m3u8");
			if ($files) {
				if ($_GET['t'] == 'ts') {
					header("Content-type: video/MP2T");
					header('Content-Disposition: attachment; filename="'.$yayin->id.'.ts"');
					$segments = 8*2 ;
					foreach ($files as $file) {
						if (file_exists($ayar->hls_folder.'/'.$file)) {
							readfile($ayar->hls_folder.'/'.$file);
						}else{
							exit();
						}
					}
		        	$getFile = array_pop($files);
		        	preg_match("/-k-(.*)\\./", $getFile, $clean);
		        	$segment = $clean["1"];
		        	$t = 0;
		        	while (($t <= $segment) && file_exists($ayar->hls_folder.'/'.$yayin->id."-k.m3u8")) {
		        		$sonraki = sprintf($yayin->id."-k-%03d.ts", $segment + 1);
		        		$dahasonraki = sprintf($yayin->id."-k-%03d.ts", $segment + 2);
		        		if (file_exists($ayar->hls_folder.'/'.$sonraki)) {
		        			$ffopen = fopen($ayar->hls_folder.'/'.$sonraki, "r");
		        			while (($t <= $segment) && !file_exists($ayar->hls_folder.'/'.$dahasonraki)) {
		        				$line = stream_get_line($ffopen, 4096);
			                    if (empty($line)) {
			                        sleep(1);
			                        ++$t;
			                        continue;
			                    }
			                    echo $line;
		        				$t = 0 ;
		        			}
		        			echo stream_get_line($ffopen, filesize($ayar->hls_folder.'/'.$sonraki) - ftell($ffopen));
			                fclose($ffopen);
			                $t = 0;
			                $segment++;
		        		}else{
		        			sleep(1);
		        			$t++;
		        			continue;
		        		}
		        	}
				}
				elseif ($_GET['t'] == 'm3u8') {
					header('Content-Type: application/octet-stream');
	    			header('Content-Disposition: attachment; filename="'.$yayin->id.'.m3u8"');
					$oku = file_get_contents($ayar->hls_folder.'/'.$yayin->id."-k.m3u8");
					preg_match_all("/(.*?).ts/", $oku, $data);
					foreach ($data[0] as $value) {
						$oku = str_replace($value, $ayar->web_adres.":".$ayar->web_port."/canli2/".$kul_adi."/".$kul_sifre."/".$value, $oku);
					}
					echo $oku;
				}else{
					die('Bu uzantıda yayın bulunmamaktadır.');
				}
			}else{
				die('Yayın dosyası bulunamadı.');
			}
		}else{
			die('Yayın Bulunamadı');
		}
	}else{
		die("Kullanıcı Bulunamadı");
	}
}

function getTSFiles($file)
{
    if (file_exists($file)) {
        $file = file_get_contents($file);

        if (preg_match_all("/(.*?).ts/", $file, $data)) {
            return $data[0];
        }
    }

    return false;
}
?>