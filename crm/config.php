<?php
    session_start();
    date_default_timezone_set('Asia/Riyadh');
    // define('inactive_duration', 5);

    $base_url='http://localhost/';
    $_SESSION['inactive_duration'] = 2400; // in socends
    $_SESSION['CLOSE_WINDOWS'] = false;
    $base_path="/website/";
    // ini_set('session.cache_limiter','public');
    // HTTP
    define('WEP_SITE', $base_url);
    define('IMG_USERS', $base_url.'assets/dist/img/avatar_no_user.png');
    define('HTTP_SERVER', $base_url.'');
    // HTTPS
    define('HTTPS_SERVER', $base_url.'');

    // DIR
    define('DIR_ASSETS', $base_url.'crm/assets/');

    define('URL_DASHBORARD', $base_url.'crm/admin/page/dashboard.php');
    define('URL_ALL_CUSTOMERS', $base_url.'crm/admin/page/all_customer.php');
    define('URL_NEW_CUSTOMERS', $base_url.'crm/admin/page/new_customers.php');
    define('URL_CUSTOMERSـIN_USE', $base_url.'crm/admin/page/prossess_orders.php');
    define('URL_CUSTOMERSـNO_CALL', $base_url.'crm/admin/page/no_call_customers.php');
    define('URL_CUSTOMERSـMOTABAA', $base_url.'crm/admin/page/motabaa_customers.php');
    define('URL_CUSTOMERSـFOVRITE', $base_url.'crm/admin/page/fovrite_customers.php');
    define('URL_CUSTOMERSـNOTIFICATION', $base_url.'crm/admin/page/notification_customers.php');
    define('URL_REPORTS', $base_url.'crm/admin/page/reports.php');
    define('URL_SETTINGS', $base_url.'crm/admin/page/settings.php');
    define('URL_ACCOUNTS', $base_url.'crm/admin/page/accounts.php');
    define('URL_MARKETING', $base_url.'crm/admin/page/marketing.php');

    define('URL_LOGOUT', $base_url.'crm/admin/logout.php');


    define('URL_PROCESS_UPLOAD_ORDERS', $base_url.'crm/admin/page/process_upload_orders.php');
    define('URL_CANCEL_UPLOAD_ORDERS', $base_url.'crm/admin/page/cancel_upload_orders.php');
    define('URL_FINISH_UPLOAD_ORDERS', $base_url.'crm/admin/page/finish_upload_orders.php');




    define('URL_ALL_USERS', $base_url.'crm/admin/page/dashboard.php');

    $_SESSION['changesidebar'] = 0;

    // DB
    define('DB_DRIVER', 'mysqli');
    define('DB_HOSTNAME', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'Password123#@!');
    define('DB_DATABASE', 'alwasset');
    define('DB_PREFIX', '');


    $host ="localhost";
    $uname = "root";
    $pwd = 'Password123#@!';
    $db_name = "alwasset";
    $result = mysqli_connect($host,$uname,$pwd) or die("Could not connect to database." .mysqli_error($result));
    mysqli_select_db($result,$db_name) or die("Could not select the databse." .mysqli_error($result));
    mysqli_query($result,"SET NAMES utf8mb4");

    $dsn='mysql:host=localhost;dbname='.$db_name;
    $user=$uname;
    $pass=$pwd;
    $option =array(PDO::MYSQL_ATTR_INIT_COMMAND =>  'SET NAMES utf8mb4',);
    try{
        $con=new PDO($dsn, $user , $pass, $option);
        //$_SESSION['con']=$con;
        // $con ->setAttrebiute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    }catch(PDOException $e){
        echo 'faild to conncet' . $e->getMessage();
    }