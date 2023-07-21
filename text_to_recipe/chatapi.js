$(document).ready(function() {
	
	// アクセス時にチャットを読み込む
	$.ajax({
	    url: "./php/get-history.php",
	    type: "GET",
	    dataType: "html",
	    success: function(data) {
	        $("#chat-history").html(data);
	    },
	    error: function(jqXHR, textStatus, errorThrown) {
	        console.log(textStatus, errorThrown);
	    }
	});

	// 以降1秒おきにチャットを読み込む
    setInterval(function() {
        $.get("./php/get-history.php", function(data) {
            $("#chat-history").html(data);
        });
    }, 1000);

    // フォームが送信されたときの処理
    $("form").submit(function(event) {
        event.preventDefault(); // フォームの通常の動作をキャンセル

        // Ajaxでchatapi.phpにフォームデータを送信
        $.ajax({
            url: "./php/chatapi.php",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
            	hideLoadingAnimation();
            	
                // フォームの入力内容を取得
                var message = $("#message").val();

                // フォームをクリア
                $("#message").val("");

                // サーバーからのレスポンスを表示
                $("#output").html(response);

                // チャット履歴を更新
                var history = "" + message + "|" + response.trim();
                $.post("./php/save.php", {data: history}); // サーバーに履歴を保存
            }
        });
    });
});
// ローディングアニメーションの表示・非表示
function showLoadingAnimation() {
	var loading = document.getElementById("loading");
	loading.style.display = "block";
}
function hideLoadingAnimation() {
	var loading = document.getElementById("loading");
	loading.style.display = "none";
}