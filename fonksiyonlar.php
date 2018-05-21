<?php 
function yayin_baslat($a){
	$command = 'wmic process call create "'.$a.'" | find "ProcessId"';
	$run = shell_exec($command);
	$parcala = explode("=",$run);
	$pid = str_replace(";", "", $parcala[1]);
	return $pid;
}
function ffmpeg_cmd($a,$b){
	$cmd = '-y -probesize 15000000 -analyzeduration 12000000 -i '.$a.' -strict -2 -dn -crf 28 -user_agent ClientStreaming -acodec copy -vcodec copy -hls_flags delete_segments -hls_time 10 -hls_list_size 8 -hls_segment_filename '.HLS_PATH.$b.'-k-%03d.ts '.HLS_PATH.$b.'-k.m3u8';
	return $cmd;
}
function yayin_durdur($p){
	# Taskkill /PID 4567 /F
	$command = 'Taskkill /PID '.$p.' /F';
	$run = shell_exec($command);
	return true;
}
function pid_bul($id){
	$yeni="wmic process where \"name='ffmpeg.exe'\" get ProcessID, CommandLine /FORMAT:LIST";
	$run = shell_exec($yeni);
	preg_match_all('#[0-9]{1,6}-file-%03d.ts#', $run, $cmd);
	preg_match_all("/ProcessId=[0-9]{2,6}/i", $run, $pid);
	foreach ($cmd[0] as $key => $value) {
		$bol = explode("-", $value);
		if ($bol[0] == $id) {
			$expid = explode("=",$pid[0][$key]);
			return $expid[1];
		}
	}
}
function yayin_baslat_2($arg){
	$cmd = '"(Start-Process c:/users/knyr/desktop/bin/ffmpeg.exe -ArgumentList \''.$arg.'\' -passthru -NoNewWindow).ID | out-file C:\users\knyr\desktop\nginx\html\pid.txt -Encoding ASCII"';
	$out = shell_exec(HIDE_CMD.' powershell '.$cmd);
	$pid_path = "C:/users/knyr/desktop/nginx/html/pid.txt";
	unlink("pid.txt");
	while (file_exists($pid_path) == false) {
	    # Pid.txt dosyasının oluşmasını bekliyoruz
	};
	sleep(1);
	if(file_exists($pid_path) == true){
	    $pid_txt_oku = file_get_contents($pid_path);
	    return $pid_txt_oku;
	}
}
?>