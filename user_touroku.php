<?php
// $hour = date('H:m:s');
// echo $hour;
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "ユーザーネーム記入してください.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "ユーザーネーム入力可能 letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM touroku WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "このユーザーネーム既に登録されてます.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "多分インタネットエラーです。後からやり直ししてください.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "パスワード入力してください.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    $fullname = trim($_POST["fullname"]);
    $hobby = trim($_POST["hobby"]);

    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO touroku (user_id,name,password,phone) VALUES (?, ?, ?, ?)";
         //Tham số trong bảng có thể thay đổi thứ tự, tuy nhiên dữ liệu tương ứng.
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss",$param_username,$fullname,$param_password,$hobby);
            
            // Set parameters đặt thông số
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "登録完了しました.";

            } else{
                echo "エラーが発生します.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($link);
}


/* Attempt MySQL server connection. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
//$mysqli = new mysqli("localhost", "root", "", "zenki2022");
 
// Check connection
//if($mysqli === false){
 //   die("ERROR: Could not connect. " . $mysqli->connect_error);
//}
 
// Attempt insert query execution
//$sql = "INSERT INTO users (username,password, fullname,hobby) VALUES ('Peter1', 'Parker', 'peterparker@mail.com', 'peterparker@mail.com')";
//if($mysqli->query($sql) === true){
//    echo "Records inserted successfully.";
//} else{
//    echo "ERROR: Could not able to execute $sql. " . $mysqli->error;
//}
 
// Close connection
//$mysqli->close();

?>
 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>新規登録フォーム</h2>
        <p>アカウント作成のためすべての項目に記入してください.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>User ID</label>
                 <input type="text" name="username" onfocus="this.value=''" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                
            </div>  
            <div class="form-group">
                <label>ユーザーネーム</label>
                               <input type="text" id="fullname" onfocus="this.value=''"class="form-control" name="fullname" >

            </div>   



            <div class="form-group">
                <label>Phone</label>
                <input type="text" id="hobby" class="form-control" name="hobby" >
                
            </div>    



             

            <div class="form-group">
                <label>パスワード</label>
                <input type="password" name="password" onfocus="this.value=''" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>パスワード確認</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="登録">
                <input type="reset" class="btn btn-secondary ml-2" value="リセット">
                
            </div>
        </form>
    </div>    
</body>
</html>