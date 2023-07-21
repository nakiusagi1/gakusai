<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // セッションがまだ開始されていなければ、セッションを開始します。
}

// 画像がアップロードされたかどうかをチェック
if(isset($_FILES['image'])){
    include 'detect.php';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>画像から食材検出</title>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="js/loading.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

    <header>
        <h1>食材からレシピ提案</h1>
    </header>

    <section>
        <form action="index.php" method="post" enctype="multipart/form-data">
            食材の写った画像をアップロードしてください<br><br>
            <input type="file" name="image" accept="image/*">
            <input type="submit" value="アップロード" onclick="showLoadingAnimation()">
        </form>

        <div id="loading">
        <img src="img/loading.gif" alt="Loading..." /> 食材を認識しています..
        </div>
    </section>
    
</body>
</html>
