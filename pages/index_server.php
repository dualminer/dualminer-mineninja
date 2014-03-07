<?php 
		$host = $_POST["host"];
		$fp=fopen("/etc/hostname",'w');
		if($fp) {
			fwrite($fp,$host);
		}
		fclose($fp);
		echo 'save success';
?>
