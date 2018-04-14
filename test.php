<?php
function start(){
	$streamCheck = 'ffprobe -analyzeduration 1000000 -probesize 9000000 -i "http://trtcanlitv-lh.akamaihd.net/i/TRTMUZIK_1@181845/index_1200_av-p.m3u8" -v  quiet -print_format json -show_streams 2>&1';
	$streamCheck = shell_exec($streamCheck);
 	$hlspath="/home/ubuntu/workspace/www/html/hl";
 	if ($streamCheck){
		$params = 'ffmpeg -y -probesize 15000000 -analyzeduration 12000000 -i http://trtcanlitv-lh.akamaihd.net/i/TRTMUZIK_1@181845/index_1200_av-p.m3u8 -strict -2 -dn -crf 28 -user_agent "VLC/2.1.4 LibVLC/2.1.4" -acodec copy -vcodec copy -hls_flags delete_segments -hls_time 10 -hls_list_size 8 -hls_segment_filename C:\hlsserver\nginx\tmp\hls\3_file-%03d.ts C:\hlsserver\nginx\tmp\hls\3_.m3u8';
		$pid = shell_exec($params);
		$this->DB->execute("UPDATE streams SET pid = ".$pid.",status = 1, running = 1 WHERE id =".$this->id." ");
		return true;
	}else{
		return false;
	}
}
?>
