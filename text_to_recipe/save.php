<?php

	// チャット記録

	// POSTをdata.txtに書き込む
	if ($_SERVER["REQUEST_METHOD"] == "POST") {

		$data = $_POST["data"];

		$file = fopen("../data/data.txt", "a");
		fwrite($file, $data . "\n");
		fclose($file);

	}

?>