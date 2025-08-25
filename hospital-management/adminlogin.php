<?php
session_start();
error_reporting(0);
include("dbconnection.php");

$dt = date("Y-m-d");
$tim = date("H:i:s");

// Check if admin is already logged in
if(isset($_SESSION['adminid'])) {
    header("Location: adminaccount.php");
    exit;
}

$err = '';
if(isset($_POST['submit'])) {
    $loginid = mysqli_real_escape_string($con, $_POST['loginid']);
    $password = mysqli_real_escape_string($con, $_POST['password']);

    $sql = "SELECT * FROM admin WHERE loginid='$loginid' AND password='$password' AND status='Active'";
    $result = mysqli_query($con, $sql);

    if(mysqli_num_rows($result) == 1) {
        $rslogin = mysqli_fetch_assoc($result);
        $_SESSION['adminid'] = $rslogin['adminid'];
        header("Location: adminaccount.php");
        exit;
    } else {
        $err = "<div class='alert alert-danger'>
                    <strong>Oh!</strong> Invalid username or password.
                </div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<title>HMS - Admin Login</title>
<link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- Custom CSS -->
<link href="assets/css/main.css" rel="stylesheet">
<link href="assets/css/login.css" rel="stylesheet">
<!-- Swift Themes -->
<link href="assets/css/themes/all-themes.css" rel="stylesheet" />
</head>
<body class="theme-cyan login-page authentication">
<div class="container">
    <div id="err"><?php echo $err; ?></div>
    <div class="card-top"></div>
    <div class="card">
        <h1 class="title"><span>Hospital Management System</span>Login <span class="msg">Hello, Admin!</span></h1>
        <div class="col-md-12">
            <form method="post" action="" name="frmadminlogin" id="sign_in" onSubmit="return validateform()">
                <div class="input-group">
                    <span class="input-group-addon"><i class="zmdi zmdi-account"></i></span>
                    <div class="form-line">
                        <input type="text" name="loginid" id="loginid" class="form-control" placeholder="Username" />
                    </div>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="zmdi zmdi-lock"></i></span>
                    <div class="form-line">
                        <input type="password" name="password" id="password" class="form-control" placeholder="Password" />
                    </div>
                </div>
                <div>
                    <div class="">
                        <input type="checkbox" name="rememberme" id="rememberme" class="filled-in chk-col-pink">
                        <label for="rememberme">Remember Me</label>
                    </div>
                    <div class="text-center">
                        <input type="submit" name="submit" id="submit" value="Login" class="btn btn-raised waves-effect g-bg-cyan" />
                    </div>
                    <div class="text-center">
                        <a href="forgot-password.html">Forgot Password?</a>
                    </div>
                </div>
            </form>
        </div>
    </div>    
</div>
<div class="clear"></div>
<div class="theme-bg"></div>
</div>
</body>
</html>

<script type="application/javascript">
var alphanumericExp = /^[0-9a-zA-Z]+$/; // Variable to validate numbers and alphabets

function validateform() {
    if(document.frmadminlogin.loginid.value == "") {
        alert("Login ID should not be empty..");
        document.frmadminlogin.loginid.focus();
        return false;
    } else if(!document.frmadminlogin.loginid.value.match(alphanumericExp)) {
        alert("Login ID not valid..");
        document.frmadminlogin.loginid.focus();
        return false;
    } else if(document.frmadminlogin.password.value == "") {
        alert("Password should not be empty..");
        document.frmadminlogin.password.focus();
        return false;
    } else if(document.frmadminlogin.password.value.length < 8) {
        alert("Password length should be more than 8 characters...");
        document.frmadminlogin.password.focus();
        return false;
    }
}
</script>
