<?php
session_start();
if (!isset($_SESSION['USER_DETAILS'])) {
    header("Location: ../../index.php");
}
include '../../config.php';

$_SESSION['PAGE'] = 1;
$_SESSION['PAGE'] = isset($_SESSION['PAGE']) ? $_SESSION['PAGE'] : 1;
echo $_SESSION['CLOSE_WINDOWS'];

$kind_emp = (int)$_SESSION['USER_DETAILS']['kind'];


$customer_orders = '';
$search_alarm    = '';
$kind_emp        = (int)$_SESSION['USER_DETAILS']['kind'];
$user_id         = $_SESSION['USER_DETAILS']['u_id'];
if ($kind_emp != 10 && $kind_emp != 0) {
    $customer_orders = " AND `orders`.`emp_id` = '$user_id' ";

}

$search_alarm = " AND `table_alarm`.`emp_id` = '$user_id' ";
$stmt_alarm   = $con->prepare("SELECT `order_id` from `table_alarm`  inner join orders on orders.id=table_alarm.order_id  WHERE    1=1  $search_alarm ");
$stmt_alarm->execute();
$count_alarm = $stmt_alarm->rowCount();

$query_alarm = "SELECT order_id FROM table_alarm WHERE  1=1 ";
$sql_alarm   = mysqli_query($result, $query_alarm);
$order_ids   = [];

$number_orders   = 0;
$fovrite_orders  = 0;
$motabaa_orders  = 0;
$no_call_orders  = 0;
$new_orders      = 0;
$upload_order    = 0;
$prossess_orders = 0;
$finish_orders   = 0;
$qu1             = "SELECT * FROM orders WHERE 1=1 $customer_orders";
$sql             = mysqli_query($result, $qu1);
while ($row_orders = mysqli_fetch_array($sql)) {
    $number_orders = $number_orders + 1;

    if ((int)$row_orders['favorite'] == 1) {
        $fovrite_orders = $fovrite_orders + 1;
    }

    if ((int)$row_orders['motabaa'] == 1) {
        $motabaa_orders = $motabaa_orders + 1;
    }

    if ((int)$row_orders['status_order'] == 5) {
        $no_call_orders = $no_call_orders + 1;
    }


    if ($row_orders['status_order'] == 1) {
        $new_orders = $new_orders + 1;
    }

    if ((int)$row_orders['upload_order'] == 1) {
        $upload_order = $upload_order + 1;
    }

    if ((int)$row_orders['status_order'] == 3) {
        $prossess_orders = $prossess_orders + 1;
    }

    if ((int)$row_orders['status_order'] == 4) {
        $finish_orders = $finish_orders + 1;
    }

}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (array_key_exists('send_problem', $_POST)) {
        $title_problem    = $_POST['title_problem'];
        $posation_problem = $_POST['posation_problem'];
        $msg              = $_POST['msg'];
        $user_id1         = $_SESSION['USER_DETAILS']['u_id'];
        $user_name1       = $_SESSION['USER_DETAILS']['user_name'];
        $today            = date("Y - F - j  , g:i a");

        if (($title_problem != null) && ($posation_problem != null) && ($msg != null)) {
            include "connectToDB.php";
            $stmt = $con->prepare("INSERT INTO problems (`user_id`, `user_sender_name`, `user_respt_id`, `msg`,`title_problem`, `posation_problem`,`solve_it` ,`isview`,`time_send`) VALUES (?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($_SESSION['USER_DETAILS']['kind'], $_SESSION['USER_DETAILS']['user_name'], 1, $msg, $title_problem, $posation_problem, 1, 1, $today));
            if ($stmt) {
                $send_problem = '<h2 style="text-align: center;padding-right: 10px;padding: 0px;margin: 0px;font-size: large;font-stretch: normal; color: #34a91f;" >تم إرسال المشكلة سوف يتم التواصل معك في وقت قصير</h2>';

            }
            else {
                $send_problem = '<h2 style="text-align: center;padding-right: 10px;padding: 0px;margin: 0px;font-size: large;font-stretch: normal; color: #f51c1c;"
												>لم تتم عملية إرسال المشكلة , تأكد من إتصالك في الأنترنت</h2>';
            }
        }
        else {
            $send_problem = '<h2 style="text-align: center;padding-right: 10px;padding: 0px;margin: 0px;font-size: large;font-stretch: normal; color: #f51c1c;" >عزيزي الكريم من فضلك قم بتعبية جميع الحقول</h2>';
        }

    }
    else {

    }
}


// 	get_old_customer();


function get_old_customer()
{
    $host    = "localhost";
    $uname   = "u175676054_user_teast";
    $pwd     = '~9Guey&~?vb';
    $db_name = "u175676054_teast";
    $result = mysqli_connect($host, $uname, $pwd) or die("Could not connect to database.-" . mysqli_error($result));
    mysqli_select_db($result, $db_name) or die("Could not select the database. =" . mysqli_error($result));
    mysqli_query($result, "SET NAMES utf8mb4");

    $dsn    = 'mysql:host=localhost;dbname=u175676054_teast';
    $user   = 'u175676054_user_teast';
    $pass   = '~9Guey&~?vb';
    $option = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',);
    try {
        $con = new PDO($dsn, $user, $pass, $option);
    }
    catch (PDOException $e) {
        echo 'Failed to connect =' . $e->getMessage();
    }

    $qu1 = "SELECT * FROM orders ORDER BY data_add DESC";

    $sql   = mysqli_query($result, $qu1);
    $index = 0;

    $dsn1        = 'mysql:host=localhost;dbname=u175676054_admins';
    $user1       = 'u175676054_admins';
    $pass1       = '&s9MB*I[q5J';
    $option1     = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',);
    $connection1 = new PDO($dsn1, $user1, $pass1, $option1);
    $no_update   = 0;

    $stmt_insert = "INSERT INTO orders (`id`, `name_customer`, `phone_number`, `msg`, `emp_id`, `emp_name`, `disc_order`, `stars`, `status_order`, `from_web`, `from_whatsapp`, `deleted`, `data_update`, `data_add`, `order_note`) VALUES";
    while ($row = mysqli_fetch_array($sql)) {
        if ($no_update == 0) {
            $order_id      = (int)$row['id'];
            $name_customer = (string)$row['name_customer'];
            $phone_number  = (string)$row['phone_number'];
            $customer_msg  = (string)$row['msg'];
            $emp_id        = (string)$row['emp_id'];
            $disc_order    = (string)$row['disc_order'];
            $stars         = (string)$row['stars'];
            $status_order  = (string)$row['status_order'];
            $from_web      = (string)$row['from_web'];
            $deleted       = (string)$row['deleted'];
            $from_whatsapp = (string)$row['from_whatsapp'];
            $data_update   = (string)$row['data_update'];
            $data_add      = (string)$row['data_add'];
            $order_note    = (string)$row['order_note'];
            $emp_name      = (string)$row['emp_name'];

            // print_r($row['order_note']);
            $stmt_insert = $connection1->prepare("INSERT INTO orders (`id`, `name_customer`, `phone_number`, `msg`, `emp_id`, `emp_name`, `disc_order`, `stars`, `status_order`, `from_web`, `from_whatsapp`, `deleted`, `data_update`, `data_add`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt_insert->execute(array($order_id, $name_customer, $phone_number, $customer_msg, $emp_id, $emp_name, $disc_order, $stars, $status_order, $from_web, $from_whatsapp, $deleted, $data_update, $data_add));

            if ($stmt_insert) {
                // Check the affected row count
                $affectedRows = $stmt_insert->rowCount();

                if ($affectedRows > 0) {
                    // Insertion was successful and rows were affected
                    print_r($row['id']); // or perform any other action upon successful insertion
                }
                else {
                    // Insertion was successful but no rows were affected
                    echo "No rows were affected for row with ID: " . $row['id'];
                    $no_update = 1;
                }
            }
            else {
                // Insertion failed
                echo "Insertion failed for row with ID: " . $row['id'];
                // You can handle the failure scenario here
            }
        }
    }
}


?>
<!--<!DOCTYPE html>-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>لوحة تحكم</title>
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

    <link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/filter/css/excel-bootstrap-table-filter-style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/css/skins/_all-skins.min.css">
    <!-- Morris chart -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/morris.js/morris.css">
    <!-- jvectormap -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/jvectormap/jquery-jvectormap.css">
    <!-- Date Picker -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- Daterange picker -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.20/jquery.datetimepicker.css">

    <link rel="stylesheet" href="<?= DIR_ASSETS ?>bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">

</head>


<?php
if ($_SESSION['changesidebar'] == "1") {
    echo '<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">';
}
else {
    echo '<body class="hold-transition skin-blue sidebar-mini">';
}
?>

<div class="wrapper">


    <?php include '../header.php'; ?>
    <?php include '../sidebar.php'; ?>


    <div class="content-wrapper">

        <section class="content-header">
            <h1>
                الصفحة الرئيسية
                <small>لوحة التحكم</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="home_admin.php?data=1"><i class="fa fa-dashboard"></i> الأدارة</a></li>
                <li class="active">الصفحة الرئيسية</li>
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $number_orders ?></h3>

                            <p>عدد العملاء</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="<?= URL_ALL_CUSTOMERS ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $prossess_orders ?></h3>
                            <p>عملاء قيد التنفيذ</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                        <a href="<?= URL_CUSTOMERSـIN_USE ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $no_call_orders ?></h3>
                            <p>عملاء لم يتم الرد</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-phone"></i>
                        </div>
                        <a href="<?= URL_CUSTOMERSـNO_CALL ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $motabaa_orders ?></h3>
                            <p>عملاء المتابعة اليومية</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-files-o"></i>
                        </div>
                        <a href="<?= URL_CUSTOMERSـMOTABAA ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $fovrite_orders ?></h3>
                            <p>العملاء المميزين</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-star"></i>
                        </div>
                        <a href="<?= URL_CUSTOMERSـFOVRITE ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>
                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3> <?= $count_alarm ?> </h3>
                            <p>عملاء التذكير</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-bell-o"></i>
                        </div>
                        <a href="<?= URL_CUSTOMERSـNOTIFICATION ?>" class="small-box-footer changepage animate__animated animate__jackInTheBox" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>

                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <!---------------------------------------------------------- ./col ----------------------------------------------------->

                <!---------------------------------------------------------- ./col ----------------------------------------------------->
                <div class="col-lg-3 col-xs-6">
                    <div class="small-box bg-navy animate__animated animate__jackInTheBox">
                        <div class="inner" style="text-align:center;">
                            <h3><?= $new_orders ?></h3>
                            <p>العملاء الجدد</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-users" aria-hidden="true"></i>
                        </div>
                        <a href="<?= URL_NEW_CUSTOMERS ?>" class="small-box-footer changepage" id="1">
                            <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
                    </div>
                </div>

                <?php
                if ($kind_emp == 10 || $kind_emp == 0) {
                    $stmt_count = $con->prepare("SELECT * from users");
                    $stmt_count->execute();
                    $num_users = $stmt_count->rowCount();

                    echo '
							<div class="col-lg-3 col-xs-6"> 
								<div class="small-box bg-navy animate__animated animate__jackInTheBox">
								<div class="inner" style="text-align:center;">
									<h3>' . $num_users . '</h3> 
									<p>عدد المستخدمين</p>
								</div>
								<div class="icon">
									<i class="fa fa-user" aria-hidden="true"></i>
								</div>
								<a href="' . URL_ACCOUNTS . '"  class="small-box-footer changepage" id="2"> <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
								</div>
							</div>
						';


                    $hand    = 0;
                    $website = 0;
                    $tima    = 0;
                    $rafa    = 0;
                    $qu22    = "SELECT from_web FROM orders";
                    $sql22   = mysqli_query($result, $qu22);
                    while ($row = mysqli_fetch_array($sql22)) {
                        $web = $row["from_web"];
                        if ($web == 1) {
                            $website = $website + 1;
                        }
                        else if ($web == 2) {
                            $tima = $tima + 1;
                        }
                        else if ($web == 3) {
                            $rafa = $rafa + 1;
                        }
                        else if ($web == 4) {
                            $hand = $hand + 1;
                        }
                    }

                    echo '
							
							<div class="col-lg-3 col-xs-6"> 
								<div class="small-box bg-navy animate__animated animate__jackInTheBox">
									<div class="inner" style="text-align:center;">
										<h3>' . $hand . '</h3> 
										<p>عملاء إدخال يدوي</p>
									</div>
									<div class="icon">
										<i class="fa fa-globe"></i>
									</div>
									<a href="' . URL_ALL_CUSTOMERS . '" class="small-box-footer changepage" id="1"> <i class="fa fa-arrow-circle-left"></i> المزيد من المعلومات</a>
								</div>
							</div>  
						
						';

                }


                ?>
                <!-- #endregion -->
            </div>

            <div class="row">

                <section class="col-lg-7 connectedSortable " style="display:none;">
                    <div class="box box-primary" style="border-radius: 10px;">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <h3 class="box-title">قائمة المهام الخاصة</h3>
                            </div>

                        </div>
                        <div class="box-body" id="emportent_li">
                            <?php
                            $use_id1        = $_SESSION['USER_DETAILS']['u_id'];
                            $qu_department  = "SELECT * FROM emportants where user_id=$use_id1";
                            $sql_department = mysqli_query($result, $qu_department);
                            $num_dep        = 0;
                            echo ' <ul class="todo-list"> ';
                            $id = "";
                            while ($row = mysqli_fetch_array($sql_department)) {
                                $num_dep = $num_dep + 1;
                                $id      = $row["id"];
                                echo ' <li style="text-align: right;" class="main-emportent animate__animated animate__fadeInUp">
        											<div class="tools" style="float: left;">
        												<a id="' . $id . '" data-value="2" class="editeDepartment"><i class="fa fa-edit"></i></a>
        
        												<a id="' . $id . '" style="color: #dd4b39;" class="delete_emportent"><i class="fa fa-trash-o"></i></a>
        											</div>
        											<span class="handle" style="float: right;">
        												<i class="fa fa-ellipsis-v"></i>
        												<i class="fa fa-ellipsis-v"></i>
        											</span>
        											<span class="text emportent-text">' . $row["emportant"] . '</span>
        									  	</li> ';

                            }
                            echo '</ul>';
                            if ($num_dep == 0) {
                                echo '<li>حالية لا توجد مهام </li>';
                            }
                            ?>
                        </div>

                        <div class="box-footer clearfix no-border">
                            <button type="submit" name="add_department" class="btn btn-default1 pull-right addnotes">
                                إضافة مهمة <i class="fa fa-plus"></i></button>
                        </div>

                        <a name="bottomOfPage"></a>
                    </div>
                </section>

                <?php
                if ($kind_emp == 10 || $kind_emp == 0) {

                    echo '
						<section class="col-lg-12 connectedSortable">
				    
					<div class="box box-primary">
						<div class="box-header" style="text-align: center;">
							<i class="fa fa-calendar" style="float: left;"></i> 
							<h3 class="box-title" style="direction: rtl;" title="الإعلانات الظاهرة على المستخدمين">إعدادات الموقع (SEO)</h3>
						</div>
						
					
					
						<div class="box-footer text-black">
							<div class="row"> 
								<div class="box-body">';
                    $use_id1        = $_SESSION['USER_DETAILS']['u_id'];
                    $qu_department  = "SELECT * FROM news ";
                    $sql_department = mysqli_query($result, $qu_department);
                    $num_dep        = 0;
                    echo ' <ul class="todo-list">';
                    $id = "";
                    while ($row = mysqli_fetch_array($sql_department)) {
                        $num_dep = $num_dep + 1;
                        $id      = $row["id"];
                        echo '<p class="title" style="direction: rtl;">' . $row["image"] . '</p>
											         <li style="text-align: right;" class="main-emportent"> 
        												<div class="tools" style="float: left;">
        													<a id="' . $id . '" title="' . $row["image"] . '" data-value="2" class="editeNews"><i class="fa fa-edit"></i></a>  
        												</div>
        												<span class="handle" style="float: right;">
        													<i class="fa fa-ellipsis-v"></i>
        													<i class="fa fa-ellipsis-v"></i>
        												</span>
        												<span class="text news_content">' . $row["text"] . '</span>
        											 </li> ';
                    }
                    echo '</ul>';
                    if ($num_dep == 0) {
                        echo '<li style="text-align: center; font-weight: bold; color: burlywood;">حالية لا توجد إعلان </li>';
                    }
                    echo '
								</div> 
							</div>
							<!-- /.row -->
						</div>
					</div>
					<!-- /.box -->


				</section>
						';
                }
                ?>

            </div>
            <!-- /.row (main row) -->

        </section>


    </div>


    <?php include('../footer.php'); ?>

</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.0.0/jquery.min.js" type="text/javascript"></script>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>


<!-- Sparkline -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?= DIR_ASSETS ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?= DIR_ASSETS ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?= DIR_ASSETS ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>


<script src="<?= DIR_ASSETS ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<script src="<?= DIR_ASSETS ?>bower_components/fastclick/lib/fastclick.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/adminlte.min.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/demo.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/paging.js"></script>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" aria-hidden="true"></script>
<script src="<?= DIR_ASSETS ?>dist/filter/js/excel-bootstrap-table-filter-bundle.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/jquery.mask.js"></script>


<script src="<?= DIR_ASSETS ?>dist/js/orders.js" type="text/javascript"></script>
<script src="<?= DIR_ASSETS ?>dist/js/main_admin.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker.css">
<link rel="stylesheet" type="text/css" href="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker-theme.css">
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/dashboard.js"></script>

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/events.js"></script>


</body>
</html>
