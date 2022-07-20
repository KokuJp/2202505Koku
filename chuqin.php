<?php
echo date("Y年m月d日");
date_default_timezone_set('Asia/Tokyo');
echo date("H時i分");
echo "<br>";
$weekday = array( '日曜日' , '月曜日' , '火曜日' , '水曜日' , '木曜日' , '金曜日' , '土曜日' ) ;
 
	// 日本語で曜日を出力する
	echo $weekday[ date('w') ] ;
    echo "<br>";

echo "登録済み：" ;
echo $_POST["chuqin"];
echo "<br>";

?>