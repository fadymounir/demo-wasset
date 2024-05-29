<?php
   session_start(); 
    if(!isset($_SESSION['USER_DETAILS'])){
        header("Location: ../../index.php");
    }
    include '../../config.php';
    $_SESSION['PAGE'] = 1;
    $_SESSION['PAGE'] = isset($_SESSION['PAGE']) ? 17 : 17;
    
    $kind_emp = (int)$_SESSION['USER_DETAILS']['kind'];
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
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
} else {
    echo '<body class="hold-transition skin-blue sidebar-mini">';
}
?>

<div class="wrapper">



    <?php include '../header.php';  ?>
    <?php include '../sidebar.php';  ?>


    <div class="content-wrapper">

        <div style="min-height: 498.573px;">
            <section class="content-header">
                <h4 style="text-align: right; font-weight: bold; color: cadetblue;">
                    روابط التسويق
                </h4>
                <button class="button add_new_marketing button_loading">
                    <i class="fa fa-plus"></i>
                    إضافة رابط تسويق
                </button>
            </section>

            <style>
                .button_loading {
                    background-color:#246468;
                    position: relative;
                    height: 50px;
                    width: 200px;
                    background-image: none;
                    border: none;
                    outline: none;
                    color: white;
                    font-size: 15px;
                    letter-spacing: 1px;
                    cursor: pointer;
                    border-radius: 5px;
                    transition: all ease-out 0.5s;
                }
                .table_marketing{
                    background-color: white;  
                }
                .delete_marketing{
                    position: relative;
                    height: 40px;
                    width: 40px;
                    padding: 0;
                    color:red;
                }
                .delete_marketing .spinner{
                    width: 21px;
                    height: 21px;
                    border-top: 4px solid #f80606;
                }
                .button_loading:hover {
                    transform: scale(1.1);
                }

                .button_loading .active {
                    transition-delay: 1s;
                    width: 10px;
                }

                .button_loading.btn_loading {
                    border-radius: 50px;
                    width: 50px;
                    font-size: 0px;
                }

                .spinner {
                    display: block;
                    width: 34px;
                    height: 34px;
                    position: absolute;
                    top: 8px;
                    margin: 0 auto;
                    left: 0;
                    right: 0;
                    background: transparent;
                    box-sizing: border-box;
                    border-top: 4px solid white;
                    border-left: 4px solid transparent;
                    border-right: 4px solid transparent;
                    border-bottom: 4px solid transparent;
                    border-radius: 100%;
                    animation-delay: 0.5s;
                    animation: spin 0.6s ease-out infinite;
                    transition: all ease 0.5s;
                }

                @keyframes spin {
                    100% {
                        transform: rotate(360deg);
                    }
                }

                .skin-blue .content-header {
                    display: flex;
                    align-items: center;
                    justify-content: space-between;
                }

                /* .add_new_marketing {
                    height: 40px;
                    padding: 2px 17px;
                    background-color: #246468;
                    border: none;
                    border-radius: 5px;
                    color: white;
                } */

                .add_new_marketing:hover {
                    background-color: #c59018;
                }

                .input_name {
                    height: 30px;
                    min-width: 150px;
                    text-align: center;
                    border: none;
                    background-color: transparent;
                }

                .select_name {
                    height: 30px;
                    min-width: 117px;
                    border: none;
                    background-color: transparent;
                    text-align: center;
                }

                .table_marketing {
                    overflow: hidden;
                    border-radius: 4px;
                }
                .copy_url {
                    display: flex;
                    flex-direction: row-reverse;
                    align-items: center;
                }
                .copy_url .btn_copy_url{
                    width: 30px;
                    height: 30px;
                    background-color: #00000075;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    border-radius: 50px;
                    cursor: pointer;
                    color: white;
                    margin-right: 10px;
                }
            </style>
            <section class="col-lg-12">
                <table class="table table-striped table_marketing">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الاسم لدى الإدارة</th>
                            <th>الاسم لدى الموضف</th>
                            <th>عرض لدى الموظف</th>
                            <th>عرض المحتوى</th>
                            <th>رمز التتبع</th>
                            <th>رابط التسويق</th>
                            <th>عدد العملاء</th>
                            <th>عدد الزيارات</th>
                            <th>عدد الزيارات المتكررة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="all_marketings">



                    </tbody>
                </table>
            </section>



        </div>




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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/jquery.mask.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/main_admin.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>


<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/events.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/marketing.js"></script>



</body>

</html>