<?php

	// ChatGPT APIレスポンス処理

	// API_KEYをセット
	define('API_KEY', 'sk-');

	// ----------------------------------------------------------------------------------------------

	// data.txtから履歴を取り出す
	$previous_messages = array();
	$file = fopen("../data/data.txt", "r");
	if ($file) {
	    while (($line = fgets($file)) !== false) {
	        $data = explode("|", $line);
	        $previous_messages[] = array(
	            array('role' => 'user', 'content' => $data[0]),
	            array('role' => 'assistant', 'content' => $data[1])
	        );
	    }
	    fclose($file);
	}
	
	// ChatGPT APIへのリクエスト構築
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "https://api.openai.com/v1/chat/completions");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
	curl_setopt($ch, CURLOPT_POST,1);
	curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: Bearer '. API_KEY));

	// ここにChatGPTに送信するオプションを設定
	$data = array('model' => 'gpt-3.5-turbo');

	$data["messages"] = array();
	
	// ここにAIのキャラクター設定を設定
    $data["messages"][] = array('role' => 'system', 'content' => "あなたは熟練したシェフです。読点で区切られた食材のリストを渡すので、その全部またはほとんどを使って、このリストに載っている以外のものを使わないレシピを教えてください。各レシピにはキャッチーなタイトル、完成までのおおよその時間、提供人数を付けてください。");
    
    // 履歴を登録
    foreach ($previous_messages as $message) {
    	$data["messages"][] = $message[0];
    	$data["messages"][] = $message[1];
    }
    
	// $_POST["message"]を処理
	$message = htmlspecialchars($_POST["message"], ENT_QUOTES);
	$data["messages"][] = array('role' => 'user', 'content' => $_POST["message"]);

	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
	
	$result = curl_exec($ch);
	$response = json_decode($result, true);
	curl_close($ch);

	// レスポンスを受け取り、回答のみ出力する
	$res = str_replace("\n","<br>",$response["choices"][0]["message"]["content"]);
	print $res;

?>
