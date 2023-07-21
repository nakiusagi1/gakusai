<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();  // セッションがまだ開始されていなければ、セッションを開始します。
}

include 'rmdir.php';

// 画像がアップロードされたかどうかをチェック
if(isset($_FILES['image'])){
    // 画像を一時フォルダに保存
    $uploaded_image = $_FILES['image']['tmp_name'];
    $destination = "uploads/" . $_FILES['image']['name'];
    move_uploaded_file($uploaded_image, $destination);

    // YOLOv5で画像を処理
    $command = "activate base && python ../yolov5/detect.py --save-txt --project results/ --weights ../yolov5/with_chi_cabbage_best.pt --source " . $destination;
    exec($command);

    // ファイル名を指定します。
    // 元のファイル名を設定します。
    $original_filename = $_FILES['image']['name'];

    // pathinfoを使ってファイルの拡張子を除いた名前を取得します。
    $filename_without_extension = pathinfo($original_filename, PATHINFO_FILENAME);

    // .txtを追加して新しいファイル名を作成します。
    $file = $filename_without_extension . '.txt';

    // ファイルを一行ずつ読み込みます。
    $lines = file("results/exp/labels/" . $file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    // 数を格納する配列を初期化します。
    $numbers = [];

    // 各行の最初の数を抽出し、配列に保存します。
    foreach ($lines as $line) {
        $parts = explode(' ', $line);
        $firstNumber = $parts[0];
        
        // 数が既に配列に存在する場合は、そのカウントを増やします。
        // そうでない場合は、新たに配列に追加します。
        if (array_key_exists($firstNumber, $numbers)) {
            $numbers[$firstNumber]++;
        } else {
            $numbers[$firstNumber] = 1;
        }
    }

    $_SESSION['numbers'] = $numbers;  // セッション変数に保存します。

    // expディレクトリを削除
    remove_directory('results/exp');
    ?>
    <!-- loadingアニメーションを隠す -->
    <script src="js/loading.js"></script>
    <script>hideLoadingAnimation();</script>
    <?php
} else {
    echo "画像がアップロードされていません。";
}

header("Location: ../text_to_recipe/index.php"); // 処理が完了したらindex.phpにリダイレクトします。
exit; // これ以上の処理を停止します。
?>

