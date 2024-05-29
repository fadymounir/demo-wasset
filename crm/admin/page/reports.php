<?php
session_start();
if(!isset($_SESSION['USER_DETAILS'])){
    header("Location: ../../index.php");
}

include '../../config.php';
$_SESSION['PAGE'] = isset($_SESSION['PAGE']) ?  16 :  16;
$_SESSION['KIND_PAGE'] = isset($_SESSION['KIND_PAGE']) ?  16 :  16;

if (!isset($_SESSION["LIMIT_ORDERS"])) {
    $_SESSION["LIMIT_ORDERS"] = "100";
}
?>

<!--<!DOCTYPE html>-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>لوحة تحكم</title>
    <!-- Tell the browser to be responsive to screen width -->
    <link href="<?= DIR_ASSETS ?>plugins/photoviewer/photoviewer.min.css" rel="stylesheet" />
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
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/multi-select/jquery.multi-select.css">
    <!-- Date Picker -->

    <!-- filepond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/qunit/2.20.0/qunit.css" integrity="sha512-ekXyquDUShlSFCoQrSRXH6IdH8nzrnzs7+KpQTczB2bjNXUPP8ii9FpmZo2vPNuh7Y4c6H7jwxKe3ntmIZLquQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/daterange/jquery-daterange-picker.css" />

</head>


<?php
if ($_SESSION['changesidebar'] == "1") {
    echo '<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">';
} else {
    echo '<body class="hold-transition skin-blue sidebar-mini">';
}
?>

<div class="wrapper">
    <input class="kind_customer" value="<?= $_SESSION['KIND_PAGE'] ?>" type="hidden" />
    <input class="kind_employee" value="<?= $_SESSION['USER_DETAILS']['kind'] ?>" type="hidden" />


    <?php include '../header.php';  ?>
    <?php include '../sidebar.php';  ?>


    <div class="content-wrapper">


        <section class="content" style="direction:rtl; padding: 0px;">
            <div class="row">

                <div class="col-md-12" style="padding: 0px;">
                    <div class="box-body" style="padding: 0px;">
                        <div class="box box-primary main-box" style="margin: 0px !important; border-radius: 0; padding: 15px; padding-bottom: 0;">
                            <form style="margin-bottom: 5px; width:100%;">
                                <div class="row">

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">التاريخ</label>
                                        <input type="text" class="date_order_get input_search_filter" placeholder="حدد تاريخ">
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">الموظف المسؤول</label>
                                        <select id="categories_users" class="input_search_filter" name="categories_users" multiple>
                                            <?php
                                            $qu_users = "SELECT * FROM users WHERE `users`.`kind` = '2' ";
                                            $sql_users = mysqli_query($result, $qu_users);
                                            while ($row_users = mysqli_fetch_array($sql_users)) {
                                                echo '<option value="' . $row_users['u_id'] . '">' . $row_users['u_name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">المصدر</label>
                                        <select id="categories_source" class="input_search_filter" name="categories_source" multiple>
                                            <?php
                                            $qu_users = "SELECT * FROM table_source  ORDER BY `id` ";
                                            $sql_users = mysqli_query($result, $qu_users);
                                            while ($row_users = mysqli_fetch_array($sql_users)) {
                                                echo '<option value="' . $row_users['code'] . '">' . $row_users['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">توقع التنفيذ</label>
                                        <select id="categories_stars" class="input_search_filter" name="categories_stars" multiple>
                                            <?php
                                            $qu_stars = "SELECT * FROM table_stars WHERE `can_show` = 1 ";
                                            $sql_stars = mysqli_query($result, $qu_stars);
                                            while ($row_stars = mysqli_fetch_array($sql_stars)) {
                                                echo '<option value="' . $row_stars['id'] . '">' . $row_stars['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">عرض النتائج</label>
                                        <button type="button" style="width: 100%;" class="btn btn-default update_filter make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر تطبيق في صحفة التقارير"><i class="fa fa-filter"></i> تطبيق </button>
                                    </div>


                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">إمكانية الطلب</label>
                                        <select id="categories_posible" class="input_search_filter" name="categories_posible" multiple>
                                            <?php
                                            $qu_posible = "SELECT * FROM table_serve_customer WHERE `can_show` = 1 ";
                                            $sql_posible = mysqli_query($result, $qu_posible);
                                            while ($row_posible = mysqli_fetch_array($sql_posible)) {
                                                echo '<option value="' . $row_posible['id'] . '">' . $row_posible['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">حالة الطلب</label>
                                        <select id="categories_status" class="input_search_filter" name="categories_status" multiple>
                                            <?php
                                            $qu_status = "SELECT * FROM table_status WHERE `can_show` = 1 ";
                                            $sql_status = mysqli_query($result, $qu_status);
                                            while ($row_status = mysqli_fetch_array($sql_status)) {
                                                echo '<option value="' . $row_status['id'] . '">' . $row_status['name'] . '</option>';
                                            }
                                            ?>
                                        </select>
                                    </div>

                                    
                                    <div class="form-group col-12 col-sm-6 col-md-3">
                                        <label for="inputEmail4">هل تم التحويل</label>
                                        <select id="categories_move" class="input_search_filter" name="categories_move" multiple>
                                            <?php
                                                $qu_move = "SELECT * FROM table_move_order WHERE `can_show` = 1 ";
                                                $sql_move = mysqli_query($result, $qu_move);
                                                while ($row_move = mysqli_fetch_array($sql_move)) {
                                                    echo '<option value="' . $row_move['id'] . '">' . $row_move['name'] . '</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>

                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 0px;"> 
                    <div class="box box-primary" style="border-radius: 5px;margin: 0 !important;">
                        <div class="box-body" style="padding: 0; height: 100%;">
                            <div class="main_report">
                                <div class="no_row">
                                    <i class="fa fa-filter" aria-hidden="true"></i>
                                    <p>قم في تحديد التاريخ وإختيار الموظفين لعرض النتائج</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

            </div>

        </section>




    </div>


    <?php include('../footer.php'); ?>

</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>

<!-- Sparkline -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>



<!-- jQuery Knob Chart -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>

<!-- Date Range Picker -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/daterange/jquery-daterange-picker.js"></script>

<!-- FilePond -->
<script src="https://unpkg.com/filepond-polyfill/dist/filepond-polyfill.js"></script>
<script src="https://unpkg.com/filepond/dist/filepond.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-rename/dist/filepond-plugin-file-rename.js"></script>
<script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-resize/dist/filepond-plugin-image-resize.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-crop/dist/filepond-plugin-image-crop.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-exif-orientation/dist/filepond-plugin-image-exif-orientation.js"></script>
<script src="https://unpkg.com/filepond-plugin-image-transform/dist/filepond-plugin-image-transform.js"></script>

<!-- Slimscroll -->
<script src="<?= DIR_ASSETS ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>

<!-- Fastclick -->
<script src="<?= DIR_ASSETS ?>bower_components/fastclick/lib/fastclick.js"></script>

<!-- AdminLTE -->
<script src="<?= DIR_ASSETS ?>dist/js/adminlte.min.js"></script>

<!-- Demo -->
<script src="<?= DIR_ASSETS ?>dist/js/demo.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/paging.js"></script>

<!-- Emojione Area -->
<script src="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.js"></script>

<!-- jQuery Form -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9" aria-hidden="true"></script>

<!-- Excel Bootstrap Table Filter -->
<script src="<?= DIR_ASSETS ?>dist/filter/js/excel-bootstrap-table-filter-bundle.js"></script>

<!-- FancyTable -->
<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>

<!-- PhotoViewer -->
<script src="<?= DIR_ASSETS ?>plugins/photoviewer/photoviewer.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- SelectStyle -->
<script src="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.js"></script>
<script src="<?= DIR_ASSETS ?>dist/selectstyle/jquery.mask.js"></script>

<!-- multi-select -->
<script src="<?= DIR_ASSETS ?>plugins/multi-select/jquery.multi-select.js"></script>

<!-- Bootstrap -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

<!-- Your Custom Script -->
<script src="<?= DIR_ASSETS ?>js/reports.js"></script>

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?=DIR_ASSETS?>js/events.js"></script>


</body>

</html>