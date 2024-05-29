<?php

session_start();
if (!isset($_SESSION['USER_DETAILS'])) {
    header("Location: ../../index.php");
}
include '../../config.php';
$_SESSION['PAGE']      = isset($_SESSION['PAGE']) ? 8 : 8;
$_SESSION['KIND_PAGE'] = isset($_SESSION['KIND_PAGE']) ? 8 : 8;

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
    <link href="<?= DIR_ASSETS ?>plugins/photoviewer/photoviewer.min.css" rel="stylesheet"/>
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
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/multi-select/jquery.multi-select.css">
    <!-- Date Picker -->

    <!-- filepond -->
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/qunit/2.20.0/qunit.css" integrity="sha512-ekXyquDUShlSFCoQrSRXH6IdH8nzrnzs7+KpQTczB2bjNXUPP8ii9FpmZo2vPNuh7Y4c6H7jwxKe3ntmIZLquQ==" crossorigin="anonymous" referrerpolicy="no-referrer"/>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdn.rawgit.com/mervick/emojionearea/master/dist/emojionearea.min.css">

    <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lalezar&family=Noto+Kufi+Arabic:wght@100;200;300;400;500;600;700;800;900&family=Tajawal:wght@200;300;400;500;700;800;900&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/daterange/jquery-daterange-picker.css"/>

</head>

<style>
    .custom-textarea {
        width: 300px !important; /* specify the width */
        height: 200px !important; /* specify the height */
    }
</style>
<?php
if ($_SESSION['changesidebar'] == "1") {
    echo '<body class="hold-transition skin-blue sidebar-mini sidebar-collapse">';
}
else {
    echo '<body class="hold-transition skin-blue sidebar-mini">';
}
?>

<div class="wrapper">
    <input class="kind_customer" value="<?= $_SESSION['KIND_PAGE'] ?>" type="hidden"/>
    <input class="kind_employee" value="<?= $_SESSION['USER_DETAILS']['kind'] ?>" type="hidden"/>


    <?php include '../header.php'; ?>
    <?php include '../sidebar.php'; ?>


    <div class="content-wrapper">


        <section class="content" style="direction:rtl; padding: 0px;">
            <div class="row">

                <div class="col-md-12" style="padding: 0px;">
                    <div class="box-body" style="padding: 0px;">
                        <div class="box box-primary main-box" style="margin: 0px !important; border-radius: 0;">
                            <form style="margin-bottom: 5px;">
                                <div class="mailbox-controls">

                                    <button type="button" style="width: 124px;" class="btn btn-default refrch_orders make_event" type_event="click" where_click="all_orders" type_text="النقر على زر التحديث">
                                        <i class="fa fa-refresh"></i> تحديث
                                    </button>
                                    <button type="button" style="width: 124px;" class="btn btn-warning show_filter_main make_event" type_event="click" where_click="all_orders" type_text="النقر على زر الفلترة">
                                        <i class="fa fa-filter" aria-hidden="true"></i> فلترة
                                    </button>

                                    <input class="alarm_date_time date_time_with_filter" type="datetime-local" value="now">
                                    <button type="button" style="width: 124px;" class="btn btn-warning  make_event refrch_orders" type_event="click" where_click="all_orders" type_text="النقر على زر الفلترة">
                                        <i class="fa fa-filter" aria-hidden="true"></i>ابحث
                                    </button>

                                    <button type="button" style="width: 124px;" class="btn btn-primary  make_event show_all_orders">
                                        <i class="fa fa-filter" aria-hidden="true"></i>اظهار الكل
                                    </button>


                                </div>
                            </form>
                            <div class="header_table_1">
                                <p class="number_orders">0 إجمالي الطلبات</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 0px;">
                    <div class="box box-primary" style="border-radius: 5px;    margin: 0 !important;">
                        <div class="box-body" style="padding: 0; height: 100%;">
                            <div class="direct-chat-messages" style="height: 100%; padding: 0; width: 100%;">
                                <table class="table table-bordered table-striped all_orders">
                                    <thead style="position: sticky;top: 0;z-index: 9; position: sticky;top: 0;z-index: 9;">
                                    <tr>
                                        <th class="number_th no-sort" style="vertical-align: middle;">رقم</th>
                                        <th class="no-sort" style="vertical-align: middle;">اسم العميل</th>
                                        <th class="no-sort" style="vertical-align: middle;">رقم الجوال</th>
                                        <th class="hidefillter no-sort" style="vertical-align: middle;">ملاحظات العميل
                                        </th>
                                        <th class="hidefillter no-sort" style="vertical-align: middle;">ملاحظات الموظف
                                        </th>
                                        <th class="no-sort" style="vertical-align: middle;">الموظف</th>
                                        <th class="no-sort" style="vertical-align: middle;">حالة الطلب</th>
                                        <th class="no-sort" style="vertical-align: middle;">تقيم الطلب</th>
                                        <th class="no-sort" style="vertical-align: middle;">المصدر</th>
                                        <th class="no-sort" style="vertical-align: middle;">وتس أب</th>
                                        <th class="no-sort" style="vertical-align: middle;">تم الحذف</th>
                                        <th class="no-sort" style="vertical-align: middle;">تاريخ المتابعة</th>
                                        <th class="no-sort" style="vertical-align: middle;">تاريخ تسجيل</th>
                                        <th class="no-sort" style="vertical-align: middle;" class="hidefillter">
                                            الإجراءات
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody class="total_orders_filter"></tbody>
                                    </tbody>


                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.col -->

                <div class="col-md-3" style="display:none">
                    <a class="btn btn-primary btn-block margin-bottom" style="font-weight: bold;font-size: larger; margin-bottom: 20px;">تقارير</a>

                    <div class="box box-solid box collapsed-box">
                        <div class="box-header with-border" style="text-align: center;">
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <h3 class="box-title">البلاغات</h3>
                        </div>
                        <div class="box-body no-padding">
                            <form>
                                <ul class="nav nav-pills nav-stacked" style="padding-right: 0px;padding-left: 0px;">
                                    <li>
                                        <a id="0" onclick="return GetProblems(this.id);" href="#"><i class="fa fa-inbox"></i>
                                            الكل
                                            <span class="label label-primary pull-left"><?php echo $num_proplems; ?></span></a>
                                    </li>
                                    <li>
                                        <a id="1" onclick="return GetProblems(this.id);" href="#"><i class="fa fa-envelope-o"></i>
                                            الجديد</a></li>
                                    <li>
                                        <a id="2" onclick="return GetProblems(this.id);" href="#"><i class="fa fa-clock-o"></i>قيد
                                            المعالجة</a></li>
                                    <li>
                                        <a id="3" onclick="return GetProblems(this.id);" href="#"><i class="fa fa-lock"></i>تم
                                            الإقفال</a></li>

                                </ul>
                            </form>
                        </div>

                    </div>
                    <div class="box box-primary" style="direction: rtl; margin-top: 0px;">
                        <div class="box-header with-border" style="text-align: center;">
                            <h3 class="box-title">كامل التفاصيل </h3>

                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="box-body">
                            <ul id="return_data" class="products-list product-list-in-box">
                                <!--		هنا تطبع التفاصيل كاملة من الأكشن		 -->
                            </ul>

                        </div>
                        <!-- /.box-body -->
                        <div class="box-footer text-center">
                            <div class="img-push">
                                <input type="text" class="form-control input-sm" placeholder="إدخل نص الرسالة الى مرسل البلاغ">
                            </div>
                        </div>
                        <!-- /.box-footer -->
                    </div>

                    <div class="box box-primary">
                        <div class="box-header">
                            <i class="ion ion-clipboard"></i>
                            <div class="box-tools">
                                <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                                    <i class="fa fa-minus"></i>
                                </button>
                                <h3 class="box-title">الأقسام</h3>
                            </div>

                        </div>

                        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
                            <div class="box-body">
                                <?php
                                $use_id1        = $_SESSION['USER_DETAILS']['u_id'];
                                $qu_department  = "SELECT * FROM department";
                                $sql_department = mysqli_query($result, $qu_department);
                                $num_dep        = 0;
                                echo ' <ul class="todo-list"><form>';
                                $id = "";
                                while ($row = mysqli_fetch_array($sql_department)) {
                                    $num_dep = $num_dep + 1;
                                    $id      = $row["id"];
                                    echo ' <li> 
										<div class="tools" style="float: left;"> 
										<a href="" id="' . $id . '" data-value="2" onclick="return editeDepartment(this.id);" type="submit"  ><i class="fa fa-edit"></i></a>
										
										<a  href="" id="' . $id . '"  onclick="return DeleteDepartment(this.id);" type="submit"   style="color: #dd4b39;"><i class="fa fa-trash-o"></i></a>
									  </div>
									  <span class="handle">
											<i class="fa fa-ellipsis-v"></i>
											<i class="fa fa-ellipsis-v"></i>
									  </span>  
									  <span  class="text">' . $row["new_name"] . '</span> 
										</li> ';
                                }
                                echo '</form></ul>';
                                if ($num_dep == 0) {
                                    echo '<li>حالية لا توجد أقسام </li>';
                                }
                                ?>
                            </div>

                            <div class="box-footer clearfix no-border">
                                <button type="submit" onclick="return AddDepartment();" name="add_department" class="btn btn-default pull-right">
                                    إضافة قسم <i class="fa fa-plus"></i></button>
                            </div>


                        </form>
                        <a name="bottomOfPage"></a>
                    </div>

                </div>
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
<script src="<?= DIR_ASSETS ?>js/all_customers.js"></script>

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/events.js"></script>


<script>
    var now               = new Date();
    var formattedDateTime = now.getFullYear() + '-' +
        ('0' + (now.getMonth() + 1)).slice(-2) + '-' +
        ('0' + now.getDate()).slice(-2) + 'T' +
        ('0' + now.getHours()).slice(-2) + ':' +
        ('0' + now.getMinutes()).slice(-2);
    $('.date_time_with_filter').val(formattedDateTime);


    $('.show_all_orders').on('click', function () {
        $('.date_time_with_filter').val('');
        $('.refrch_orders').click();
    });


</script>


</body>

</html>