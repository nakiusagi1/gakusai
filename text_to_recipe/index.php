<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // セッションがまだ開始されていなければ、セッションを開始します。
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>食材からレシピ提案</title>
  <meta charset="utf-8">
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script type="text/javascript" src="js/chatapi.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

  <header>
    <h1>食材からレシピ提案</h1>
  </header>

  <section>
    <form autocomplete="off">
      <label for="message">使いたい食材を入力してね。どのようなレシピが良いか指定もできるよ！</label><br>
      <input type="text" id="message" name="message" placeholder="例：豚肉となすを使ったさっぱりしたレシピ" value="<?php
    if (isset($_SESSION['numbers'])) {
        foreach ($_SESSION['numbers'] as $number => $count) {
            if($number == 1) {
              echo "にんじんが $count 個。";
            }
            if($number == 2) {
              echo "なすが $count 個。";
            }
            if($number == 3) {
              echo "玉ねぎが $count 個。";
            }
            if($number == 0) {
              echo "キャベツが $count 個。";
            }
        }
        // 結果を表示したら、その情報をセッションから削除します。
        unset($_SESSION['numbers']);
    }
    ?>" required>
      <input type="submit" value="レシピを作る" onclick="showLoadingAnimation()"><br>
      <a href="php/reset.php">レシピをリセット</a>
    </form>

    <a href="../image_upload_2/index.php">画像から食材検出</a>

    <div id="loading">
    <img src="img/loading.gif" alt="Loading..." /> 回答を考えています..
    </div>

    <div id="chat-history"></div>
  </section>

</body>
</html>
