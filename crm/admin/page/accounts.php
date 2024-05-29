<?php
session_start();
if(!isset($_SESSION['USER_DETAILS'])){
    header("Location: ../../index.php");
}
include '../../config.php';
$_SESSION['PAGE'] = 14;
$_SESSION['PAGE'] = isset($_SESSION['PAGE']) ? $_SESSION['PAGE'] : 14;


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
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>css/account.css">

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
    
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>plugins/native-toast/jquery.toast.css">
    <link rel="stylesheet" href="<?= DIR_ASSETS ?>css/account.css">


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

        <section class="content-header">
            <section class="content" style="padding-bottom: 0;">
                <div class="row">
                    <div class="box box-primary" style="border-radius: 8px; margin-top: 5px !important;">
                        <div style="margin-bottom: 5px; min-height: 90vh;">
                            <div class="mailbox-controls" style="padding: 5px 20px;">
                                <input class="daterange_users" type="text"/>
                                <div class="mailbox-actions">
                                    <a href="<?=URL_ACCOUNTS?>" style="width: 145px;" class="btn btn-default  btn-customer update_users"><i class="fa fa-refresh"></i> تحديث الصفحة</a>
                                    <button type="button" style="width: 124px;" class="btn btn-default refrch_store_order btn-customer make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر ضبط الطلبات" to><i class="fa fa-trash-o"></i>ضبط الطلبات</button>
                                    <button type="button" style="width: 124px;" class="btn btn-default btn-customer changeuserorder make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر تحويل الطلبات " data-bs-toggle="modal" data-bs-target="#changeuserorder"><i class="fa fa-exchange"></i>تحويل الطلبات</button>
                                    <button type="button" style="width: 124px;" class="btn btn-default btn-customer make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر إضافة مستخدم" data-toggle="modal" data-target="#add_new_user"><i class="fa fa-plus"></i>إضافة مستخدم</button>
                                    <button type="button" style="width: 140px;" class="btn btn-default btn-customer btn_upload_exel make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر إستيراد عملاء" data-toggle="modal" data-target="#upload_exel_customers"><i class="fa fa-upload"></i>استيراد عملاء exel</button>
                                </div>
                            </div>
                            <div class="all_users">
                                <div class="lds-roller">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section class="content" style="display:none;">
                <div class="row">
                    <div class="col-md-6">
                      
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title">تقرير نسبة اعمالي</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="areaChart" style="height:250px"></canvas>
                                </div>
                            </div> 
                        </div> 
 
                        <div class="box box-danger">
                            <div class="box-header with-border" style="text-align:center;">
                                <h3 class="box-title">تقرير الطلبات</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <canvas id="pieChart" style="height:250px"></canvas>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col (LEFT) -->
                    <div class="col-md-6">
                        <!-- LINE CHART -->
                        <div class="box box-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">نسبة الطلبات </h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="lineChart" style="height:250px"></canvas>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                        <!-- BAR CHART -->
                        <div class="box box-success">
                            <div class="box-header with-border">
                                <h3 class="box-title">نسبة الأعمال</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="chart">
                                    <canvas id="barChart" style="height:230px"></canvas>
                                </div>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                    </div>
                    <!-- /.col (RIGHT) -->
                </div>
                <!-- /.row -->

            </section>

            <div class="main_edite_cust">
                <div class="edite_cust_customer">
                    <div class="main-loading" style="display: none;">
                        <svg version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                            <!--<circle fill="none" stroke="#fff" stroke-width="6" stroke-miterlimit="15" stroke-dasharray="14.2472,14.2472" cx="50" cy="50" r="47">-->
                            <!--  <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="360 50 50" repeatCount="indefinite"></animateTransform>-->
                            <!--  </circle>-->
                            <!--<circle fill="none" stroke="#fff" stroke-width="1" stroke-miterlimit="10" stroke-dasharray="10,10" cx="50" cy="50" r="39">-->
                            <!--    <animateTransform attributeName="transform" attributeType="XML" type="rotate" dur="5s" from="0 50 50" to="-360 50 50" repeatCount="indefinite"></animateTransform>-->
                            <!--</circle>-->
                            <g fill="#fff">
                                <rect x="30" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.1"></animateTransform>
                                </rect>
                                <rect x="40" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.2"></animateTransform>
                                </rect>
                                <rect x="50" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.3"></animateTransform>
                                </rect>
                                <rect x="60" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.4"></animateTransform>
                                </rect>
                                <rect x="70" y="35" width="5" height="30">
                                    <animateTransform attributeName="transform" dur="1s" type="translate" values="0 5 ; 0 -5; 0 5" repeatCount="indefinite" begin="0.5"></animateTransform>
                                </rect>
                            </g>
                        </svg>
                    </div>
                    <div id="success"></div>
                    <div id="set_edit_cust">
                        <div id="success"></div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">إسم الموظف</label>
                                <input style="border: none;box-shadow: none;cursor: no-drop;" type="text" class="form-control" value="" id="cusom_name" readonly="" placeholder="اسم الموظف">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">رقم الجوال</label>
                                <input type="phone" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="" id="cusom_phone" readonly="" placeholder="رقم الجوال">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">البريد الإلكتروني</label>
                                <input type="phone" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="" id="cusom_email" readonly="" placeholder="البريد الإلكتروني">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">اسم المستخدم</label>
                                <input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="" id="cusom_username" readonly="" placeholder="اسم المستخدم">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-12">
                                <label for="inputEmail4">كلمة المرور</label>
                                <input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="" id="cusom_password" readonly="" placeholder="كلمة المرور">
                            </div>
                        </div>
                    </div>
                    <div class="form-row" style="padding: 0 15px;">
                        <button type="button" class="btn btn-primary save-user-datialse">حفظ التعديلات</button>
                        <button type="button" class="btn btn-primary cloase_edite_cust" style="float: left;">إخفاء النافذه</button>
                    </div>
                </div>
            </div>
            <!-- ./wrapper -->



        </section>
    </div>
    
    <div class="modal fade" id="show_diloge_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" style="width:100%;" data-dismiss="modal">إخفاء</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade show_edit_details" id="show_edit_details" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل بيانات المستخدم</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl;">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_update_user" data-dismiss="modal">إخفاء</button>
                <button type="button" class="btn btn-success save_employee_data">حفظ البيانات</button>
            </div>
            </div>
        </div>
    </div>


    <div class="modal fade add_new_user" id="add_new_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إضافة مستخدم جديد</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="direction: rtl;"> 
                <div class="form-group">
                    <label for="exampleInputEmail1">اسم الحساب</label>
                    <input type="text" class="form-control emp_name" placeholder="أدخل إسم الحساب">
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">اسم المستخدم</label>
                    <input type="email" class="form-control username" placeholder="إسم المستخدم">
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">رقم الجوال</label>
                    <input type="email" class="form-control phone_number" placeholder="05123456789">
                    <small class="form-text text-muted"></small>
                </div>
                
                <div class="form-group">
                    <label for="exampleInputEmail1">البريد الإلكتروني</label>
                    <input type="email" class="form-control email"  aria-describedby="emailHelp" placeholder="Enter email">
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">كلمة المرور</label>
                    <input type="email" class="form-control password" aria-describedby="emailHelp" placeholder="Enter email">
                    <small class="form-text text-muted"></small>
                </div>
                <div class="form-group">
                    <label for="exampleInputEmail1">نوع الحساب</label>
                    <select class="form-control kind_account">
                        <option value="0" selected="">مدير</option>
                        <option value="2">موظف</option>
                    </select> 
                    <small class="form-text text-muted"></small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary close_add_users" data-dismiss="modal">إخفاء</button>
                <button type="button" class="btn btn-success add_employee_data">حفظ البيانات</button>
            </div>
            </div>
        </div>
    </div>

    <div class="modal fade upload_exel_customers" id="upload_exel_customers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">إستيراد عملاء من ملف أكسل</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <a class="download_exel_file" href="<?= DIR_ASSETS ?>files/exel_customers.xlsx" type="button">
                    <i class="fa fa-download"></i>
                </a>
            </div>
            <div class="modal-body" style="direction: rtl;"> 
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">رفعل الملف</label>
                            <input type="file" class="form-control exel_file" placeholder="اختر الملف">
                            <small class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1">أختر المصدر</label>
                            <select class="form-control kind_account_exel"> 
                                <option value="10101010101" selected>إختر</option>
                                <?php
                                    $qu_source = "SELECT * FROM `table_source` ";
                                    $sql_source = mysqli_query($result, $qu_source);
                                    while ($row_source = mysqli_fetch_array($sql_source)) {
                                        echo '<option value="' . $row_source["code"] . '">' . $row_source["name"] . '</option>';
                                    }
                                ?>
                            </select> 
                            <small class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="">
                        <div class="main_progressbar">
                            <div class="progressBar" style="margin-bottom: 10px;">
                                <p> تحقق من رقم الجوال </p>
                                <div id="progressBar">0%</div> 
                            </div>
                        </div>
                    </div>

                </div>

                <div class="excelTable">
                <table class="table">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">اسم العميل</th>
                        <th scope="col">رقم الجوال</th>
                        <th scope="col">رسالة العميل</th>
                        <th scope="col" style="width: 100px;">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="excelTable">
                        
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">إخفاء</button>
                <button type="button" class="btn btn-success save_exel_data make_event"  type_event="click" where_click="all_orders" type_text="الضعط على زر تأكيد إضافة عملاء">إضافة البيانات</button>
            </div>
            </div>
        </div>
    </div>

    <?php include('../footer.php'); ?>

</div>

<div id="changeuserordermodel" class="modal" style="padding:0px; overflow: hidden;">
    <!-- Modal content -->
    <div class="modal-content" style="width: 100%; height: 100%; border-radius: 0; overflow: scroll; padding-bottom: 20px; position: initial;">
        <span class="closemodel" style="z-index: 9999999;">&times;</span>

        <span class="main_movment_title">تحويل طلبات العملاء</span>
        <div class="main_movement">
            <p class="pragraphext">من</p>
            <select name="kind" class="form-control name1" style="width: 100%;">
                <option value="0" selected="selected">إختر</option>
                <?php
                $qu_user = "SELECT * FROM `users` WHERE `users`.`kind`=2";
                $sql_user = mysqli_query($result, $qu_user);
                while ($rows = mysqli_fetch_array($sql_user)) {
                    echo '<option value="' . $rows["u_id"] . '">' . $rows["u_name"] . '</option>';
                }
                ?>
            </select>
            <p class="pragraphext">إلى</p>
            <select name="kind" class="form-control name2" style="width: 100%;">
                <option value="1" selected="selected">إختر</option>
                <?php
                $qu_user = "SELECT * FROM `users` WHERE `users`.`kind`=2";
                $sql_user = mysqli_query($result, $qu_user);
                while ($rows = mysqli_fetch_array($sql_user)) {
                    echo '<option value="' . $rows["u_id"] . '">' . $rows["u_name"] . '</option>';
                }
                ?>
            </select>

        </div>

        <p class="model_error" style="display:none;"></p>
        <p class="model_normal" style="display:none;"></p>
        <p class="model_successful" style="display:none;"></p>

        <div class="main_emplloyes_move">
            <div class="emplay_loadding">
                <i class="fa fa-spinner fa-spin"></i>
            </div>
            <div class="emplly_search">
                <input type="text" class="form__input" placeholder="أدخل (إسم العميل أو حالة التقيم أو حالة الطلب أو رقم الجوال  )">
            </div>
            <div class="header_details">
                <label class="checkbox path">
                    <input type="checkbox" class="checkbox">
                    <svg viewBox="0 0 21 21">
                        <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                    </svg>
                    <p>تحديد الكل</p>
                </label>
                <p class="name">إسم العميل</p>
                <p class="state">حالة الطلب</p>
                <p class="status">حالة العميل</p>
                <p class="phone">رقم الجوال</p>

            </div>
            <div class="main_emplay">


            </div>
            <div class="main_btn_send">
                <a class="btn_send_emplloy make_event"  type_event="click" where_click="all_orders" type_text="النقر على زر تأكيد تحويل عملاء">
                    <i class="fa fa-spinner fa-spin"></i>
                    <p class="move_count_emp">يرجى إختيار عميل واحد على الإقل</p>
                </a>
            </div>

        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>

<script src="<?= DIR_ASSETS ?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<script src="<?= DIR_ASSETS ?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<script src="<?= DIR_ASSETS ?>plugins/native-toast/jquery.toast.js"></script>

<script src="<?= DIR_ASSETS ?>bower_components/moment/min/moment.min.js"></script>
<script src="<?= DIR_ASSETS ?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="<?= DIR_ASSETS ?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="<?= DIR_ASSETS ?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<script src="<?= DIR_ASSETS ?>bower_components/fastclick/lib/fastclick.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/adminlte.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/demo.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/paging.js"></script>
<script src="https://cdn.jsdelivr.net/npm/emojionearea@3.4.2/dist/emojionearea.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= DIR_ASSETS ?>dist/filter/js/excel-bootstrap-table-filter-bundle.js"></script>

<script src="https://cdn.jsdelivr.net/npm/jquery.fancytable/dist/fancyTable.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
<script src="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.js"></script>
<script src="<?= DIR_ASSETS ?>dist/selectstyle/jquery.mask.js"></script>
<script src="<?= DIR_ASSETS ?>js/account.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/orders.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/main_admin.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/jquery.datetimepicker.full.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>


<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script src="<?= DIR_ASSETS ?>js/events.js"></script>



</body>

</html>