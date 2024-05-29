<?php
include "config.php";
$nonav = '';
$error = "";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (array_key_exists('sign_in', $_POST)) {
        // testfun();
    }
    else {
        $email                      = $_POST['user_name'];
        $pass                       = $_POST['pass'];
        $_SESSION['input_username'] = $_POST['user_name'];

        $stmt = $con->prepare("SELECT * from users where user_name = ? and passrword = ? ");
        $stmt->execute(array($email, $pass));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $get = $stmt->fetch();
            if ((int)$get['u_proplems'] == 1) {
                $_SESSION['USER_DETAILS']        = $get;
                $_SESSION['loggedin']            = 1;
                $today                           = date('Y-m-d H:i:s');
                $user_id                         = (int)$get['u_id'];
                $_SESSION['user_color']          = $get['user_color'];
                $_SESSION['user_id']             = $user_id;
                $_SESSION['is_admin']            = $get['kind'];
                $_SESSION['sidebar_color']       = $get['sidebar_color'];
                $_SESSION['navbar_color']        = $get['navbar_color'];
                $_SESSION['sidebar_text_color']  = $get['sidebar_text_color'];
                $_SESSION['home_boxes']          = $get['home_boxes'];
                $_SESSION['sidebar_hover_color'] = $get['sidebar_hover_color'];

                $select_query = $con->prepare("SELECT * FROM login_details WHERE emp_id = ? ORDER BY id DESC LIMIT 1");
                $select_query->execute(array($user_id));
                $count_login = $select_query->rowCount();
                if ($count_login > 0) {
                    $get_login        = $stmt->fetch();
                    $user_login_value = $get_login['user_login'];
                    if ($user_login_value == 1) {
                        $_SESSION['login_details_id'] = $get_login['id'];
                        $_SESSION['user_id']          = $user_id;
                        header("Location: " . URL_DASHBORARD);
                    }
                    elseif ($user_login_value == 0) {
                        $_SESSION['last_activity'] = time();
                        $sub_query                 = "INSERT INTO login_details (`emp_id`,`login_at`,`last_activity`) VALUES (" . $user_id . ",'" . $today . "','" . $today . "') ";
                        $statement                 = $con->prepare($sub_query);
                        $statement->execute();
                        $_SESSION['login_details_id'] = $con->lastInsertId();
                        $_SESSION['user_id']          = $user_id;
                        header("Location: " . URL_DASHBORARD);
                    }
                    else {
                        $_SESSION['last_activity'] = time();
                        $sub_query                 = "INSERT INTO login_details (`emp_id`,`login_at`) VALUES (" . $user_id . ",'" . $today . "') ";
                        $statement                 = $con->prepare($sub_query);
                        $statement->execute();
                        $_SESSION['login_details_id'] = $con->lastInsertId();
                        $_SESSION['user_id']          = $user_id;
                        header("Location: " . URL_DASHBORARD);
                    }

                }
                else {

                }


                $_SESSION['last_activity'] = time();
                $sub_query                 = "INSERT INTO login_details (`emp_id`,`login_at`) VALUES (" . $user_id . ",'" . $today . "') ";
                $statement                 = $con->prepare($sub_query);
                $statement->execute();
                $_SESSION['login_details_id'] = $con->lastInsertId();
                $_SESSION['user_id']          = $user_id;
                header("Location: " . URL_DASHBORARD);
            }
            else {
                $error = "تم إيقاف الحساب الخاص بك من قبل الإدارة";
            }
        }
        else {
            $error = "كلمة السر أو البريد الإلكتروني الخاص بك غير صحيح";
        }
    }
}

?>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> تسجيل الدخول</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/iCheck/square/blue.css">


    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition login-page">
<div class="login-box" style="direction: rtl;">
    <div class="login-logo">
        <a href=""><b>تسجيل الدخول</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="login-box-body">

        <svg class="logo" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="300" height="150" style="transform: scale(1.3);" viewBox="0 0 640 480" xml:space="preserve">
        <g transform="matrix(3.31 0 0 3.31 320.4 240.4)">
            <circle style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(61,71,133); fill-rule: nonzero; opacity: 1;" cx="0" cy="0" r="40"></circle>
        </g>
            <g transform="matrix(0.98 0 0 0.98 268.7 213.7)">
                <circle style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" cx="0" cy="0" r="40"></circle>
            </g>
            <g transform="matrix(1.01 0 0 1.01 362.9 210.9)">
                <circle style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" cx="0" cy="0" r="40"></circle>
            </g>
            <g transform="matrix(0.92 0 0 0.92 318.5 286.5)">
                <circle style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" cx="0" cy="0" r="40"></circle>
            </g>
            <g transform="matrix(0.16 -0.12 0.49 0.66 290.57 243.57)">
                <polygon style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" points="-50,-50 -50,50 50,50 50,-50 "></polygon>
            </g>
            <g transform="matrix(0.16 0.1 -0.44 0.69 342.03 248.34)">
                <polygon style="stroke: rgb(0,0,0); stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" vector-effect="non-scaling-stroke" points="-50,-50 -50,50 50,50 50,-50 "></polygon>
            </g>
      </svg>
        <p class="login-box-msg">قم بتسجيل الدخول الى النظام</p>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group has-feedback">
                <input type="text" value="<?php echo isset($_SESSION['input_username']) ? $_SESSION['input_username'] : ""; ?>" name="user_name" class="form-control" placeholder="إسم المستخدم">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" value="" name="pass" class="form-control" placeholder="كلمة السر">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">

                <div>
                    <button type="sign_in" class="btn btn-primary btn-block btn-flat login">تسجيل الدخول</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <label style=" color:red; wight:100%; text-align: center;"> <?php echo $error ?> </label>

    </div>
    <!-- /.login-box-body -->
</div>
<!-- /.login-box -->

<!-- jQuery 3 -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?= DIR_ASSETS ?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?= DIR_ASSETS ?>plugins/iCheck/icheck.min.js"></script>
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });


    });
</script>
</body>

</html>