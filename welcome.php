<?php
// Initialize the session
session_start();
 

 // echo $_SESSION["count_shukkin"];
//$hour = date('H:m:s');
//echo $hour;



// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
?>
 
<?php
require_once "config.php";
$db= $link;
$tableName="after";
$columns= ['id', 'id_user','day','shour','smin', 'ehour','emin','biko'];
$fetchData = fetch_data($db, $tableName, $columns);
function fetch_data($db, $tableName, $columns){
 if(empty($db)){
  $msg= "Database connection error";
 }elseif (empty($columns) || !is_array($columns)) {
  $msg="columns Name must be defined in an indexed array";
 }elseif(empty($tableName)){
   $msg= "Table Name is empty";
}else{
$columnName = implode(", ", $columns);
$query = "SELECT ".$columnName." FROM $tableName"." ORDER BY id DESC";
$result = $db->query($query);
if($result== true){ 
 if ($result->num_rows > 0) {
    $row= mysqli_fetch_all($result, MYSQLI_ASSOC);
    $msg= $row;
 } else {
    $msg= "No Data Found"; 
 }
}else{
  $msg= mysqli_error($db);
}
}
return $msg;
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; text-align: center; }

table, th, td {
  border:1px solid black;
}

    </style>
</head>
<body>


<?php
//jumpstart2011@yahoo.co.jp
 $to='kokujpfukuoka@gmail.com';
 $subject='　確認メールです。　';
 $message="2202505 クオック!\n\n 。\n\n宜しくお願い致します。";
 $headers="From:kokujp0505@gmail.com\r\nReply-To: jumpstart2011@yahoo.com";
 $mail_sent=mail($to,$subject,$message,$headers);

  if($mail_sent==true)
  {
    echo "Mail Sent";
  }
  else
  {
    echo "Mail failed";
  }

if(isset($_POST['submit']) && !empty($_POST['submit'])) {


 $chuqin = trim($_POST["chuqin"]);
$_SESSION["chuqin"] = $chuqin; 


// if(isset($_POST['submit'])){

// //count
// }$s = 'chuqin';
// $yes = 0;
// foreach ($_POST as $p => $n) {
//  if (strpos($p, $s) !=== false && $n==='Yes') $yes ++; 
// }

    echo date("Y年m月d日");
date_default_timezone_set('Asia/Tokyo');
echo date("H時i分");

echo "<br>";
// echo date("H");
$weekday = array( '日曜日' , '月曜日' , '火曜日' , '水曜日' , '木曜日' , '金曜日' , '土曜日' ) ;
 
    // 日本語で曜日を出力する
    echo $weekday[ date('w') ] ;
    echo "<br>";

echo "登録済み：" ;
echo $_SESSION["chuqin"];
echo "<br>";

if ($_SESSION["chuqin"]=="出勤") {
   
//shukkin creatable to input data

// table, th, td {
//   border:1px solid black;
// }
// </style>
// <body>

// <h2>A basic HTML table</h2>

// <table style="width:100%">
//   <tr>
   
//     <th>出勤／退勤</th>
//     <th>時間表示</th>
//   </tr>
//   <tr>
   
//     <td>echo $_SESSION["chuqin"];</td>
//     <td>Germany</td>
//   </tr>

// </table>




//end shukkin data list


// Include config file
require_once "config.php";

 $sql = "INSERT INTO after (id_user, day,shour,smin) VALUES (?, ?, ?, ?)";
         //Tham số trong bảng có thể thay đổi thứ tự, tuy nhiên dữ liệu tương ứng.
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_id_user, $param_day,$param_shour,$param_smin);
            
            // Set parameters đặt thông số
            $param_id_user = htmlspecialchars($_SESSION["username"]);
            $param_day =date('j');
            date("Y年m月d日");
            // 
            $param_shour=date("H");
            $param_smin=date("i");
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // // Redirect to login page
                // header("location: login.php");
                echo "Excute oke.";
            } else{
                echo "エラーが発生します.";
            }

            // Close statement
            mysqli_stmt_close($stmt);



}


}
else
 echo "not shukkin";





}

// echo date("Y年m月d日");
// date_default_timezone_set('Asia/Tokyo');
// echo date("H時i分");
// echo "<br>";
// $weekday = array( '日曜日' , '月曜日' , '火曜日' , '水曜日' , '木曜日' , '金曜日' , '土曜日' ) ;
 
//     // 日本語で曜日を出力する
//     echo $weekday[ date('w') ] ;
//     echo "<br>";

// echo "登録済み：" ;
// echo $_SESSION["chuqin"];
// echo "<br>";



?>

<form method="post">
    


    <h1 class="my-5">こんにちは, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>.ようこそ会員ページへ.</h1>
    <p>
        <a href="reset-password.php" class="btn btn-warning">パスワードリセット</a>
        <a href="logout.php" class="btn btn-danger ml-3">ログアウト</a>
        <div class="form-group">

            <h2>出勤<input type="radio" name="chuqin" value="出勤">
            退勤  <input type="radio" name="chuqin" value="退勤"></h2><br>

            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="submit" name="submit">

            </div>


            </div>
    </p>



<table class="table table-bordered">
       <thead><tr><th>S.N</th>
         <th>ID</th>
         <th>ID User</th>
         <th>Day</th>
         <th>Shour</th>
         <th>Smin</th>
         <th>ehour</th>
         <th>emin</th>
    </thead>
    <tbody>
  <?php
      if(is_array($fetchData)){      
      $sn=1;
      foreach($fetchData as $data){
    ?>
      <tr>
      <td><?php echo $sn; ?></td>
      <td><?php echo $data['id']??''; ?></td>
      <td><?php echo $data['id_user']??''; ?></td>
      <td><?php echo $data['day']??''; ?></td>
      <td><?php echo $data['shour']??''; ?></td>
      <td><?php echo $data['smin']??''; ?></td>
      <td><?php echo $data['ehour']??''; ?></td>
      <td><?php echo $data['emin']??''; ?></td>  
     </tr>
     <?php
      $sn++;}}else{ ?>
      <tr>
        <td colspan="8">
    <?php echo $fetchData; ?>
  </td>
    <tr>
    <?php
    }?>
    </tbody>
     </table>

<h2>--------</h2>
    </form>
</body>


</html>