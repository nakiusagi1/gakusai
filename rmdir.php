<?php
// 再帰的にディレクトリを削除する関数
function remove_directory($dir) {
    $files = array_diff(scandir($dir), array('.','..'));
    foreach ($files as $file) {
        // ファイルかディレクトリによって処理を分ける
        if (is_dir("$dir/$file")) {
            // ディレクトリなら再度同じ関数を呼び出す
            remove_directory("$dir/$file");
        } else {
            // ファイルなら削除
            unlink("$dir/$file");
            echo "ファイル:" . $dir . "/" . $file . "を削除n";
        }
    }
    // 指定したディレクトリを削除
    echo "ディレクトリ:" . $dir . "を削除n";
    return rmdir($dir);
}
?>