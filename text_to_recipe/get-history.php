<?php
	
	// チャット履歴表示

	$history = array();
	$file = fopen("../data/data.txt", "r");
	if ($file) {
	    while (($line = fgets($file)) !== false) {
	        $data = explode("|", $line);
	        $history[] = array(
	            '<div class="question">Q: ' . $data[0] . '</div>',
	            '<div class="answer">A: ' . $data[1] . '</div>'
	        );
	    }
	    fclose($file);
	}

	// 配列の順序を新しい順にする。したくない場合はコメントアウト
	$history = array_reverse($history); 
	
	$output = "";
	foreach ($history as $item) {
	    $item = highlight_code_blocks($item);
	    $output .= implode("", $item)."<div class=\"spacer\"></div>";
	}

	echo $output;

	// コードが含まれる場合はタグ
	function highlight_code_blocks($string) {
	    return preg_replace_callback('/```([^`]*)```/s', function($matches) {
	        return '<pre><code>' . htmlentities(str_replace('<br>', "\n", $matches[1]), ENT_QUOTES) . '</code></pre>';
	    }, $string);
	}

?>