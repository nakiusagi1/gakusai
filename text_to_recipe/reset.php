<?php
	
	// ログリセット

	$file = fopen("../data/data.txt", "w");
	fwrite($file, "");
	fclose($file);

	header("Location:../");
	exit;

?>