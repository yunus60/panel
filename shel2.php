<?php 
header("Access-Control-Allow-Origin: *");
$restream = 0;
$hls_folder = "hls/";
//print_r(getTSFiles($file));
	if ($restream == 0) {
		$files = getTSFiles($hls_folder."3-k.m3u8");
		if ($files) {
			if ($_GET["t"] == "ts") {
				header("Content-type: video/MP2T");
				header('Content-Disposition: attachment; filename="1.ts"');
				$segments = 8*2 ;
				foreach ($files as $file) {
					if (file_exists($hls_folder.$file)) {
						readfile($hls_folder.$file);
					}else{
						exit();
					}
				}
	        	$getFile = array_pop($files);
	        	preg_match("/-k-(.*)\\./", $getFile, $clean);
	        	$segment = $clean["1"];
	        	$t = 0;
	        	while (($t <= $segment) && file_exists($hls_folder."1-k.m3u8")) {
	        		$sonraki = sprintf("1-k-%03d.ts", $segment + 1);
	        		$dahasonraki = sprintf("1-k-%03d.ts", $segment + 2);
	        		//echo $sonraki ."  ".$dahasonraki;
	        		if (file_exists($hls_folder.$sonraki)) {
	        			$ffopen = fopen($hls_folder.$sonraki, "r");
	        			while (($t <= $segment) && !file_exists($hls_folder.$dahasonraki)) {
	        				$line = stream_get_line($ffopen, 4096);
		                    if (empty($line)) {
		                        sleep(1);
		                        ++$t;
		                        continue;
		                    }
		                    echo $line;
	        				$t = 0 ;
	        			}
	        			echo stream_get_line($ffopen, filesize($hls_folder.$sonraki) - ftell($ffopen));
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

			if($_GET["t"] == "m3u8"){
				header('Content-Type: application/octet-stream');
    			header('Content-Disposition: attachment; filename="3.m3u8"');
				$oku = file_get_contents($hls_folder."3-k.m3u8");
				//echo "<pre>";
				//print_r($oku);
				preg_match_all("/(.*?).ts/", $oku, $data);
				foreach ($data[0] as $value) {
					$oku = str_replace($value, "http://localhost:10101/canli2/yunus/konyar/".$value, $oku);
				}
				echo $oku;
	        }
    	}
	}else{
		$bytes = 0;
		$fd = fopen($file, "r");
        while (!feof($fd)) {
            echo fread($fd, 1024 * 5);
            $bytes += 1024 * 5;
            ob_flush();
            flush();
        }
        fclose($fd);
        exit();
        die();
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