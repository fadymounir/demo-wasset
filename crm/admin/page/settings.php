<?php
session_start();
if (!isset($_SESSION['USER_DETAILS'])) {
    header("Location: ../../index.php");
}
include '../../config.php';
$_SESSION['PAGE'] = 1;
$_SESSION['PAGE'] = isset($_SESSION['PAGE']) ? 15 : 15;
$kind_emp         = (int)$_SESSION['USER_DETAILS']['kind'];
?>

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


        <style>
            .col-lg-4 {
                margin-bottom: 10px !important;
            }

            .content-header {
                margin-bottom: 10px;
            }

            form {
                direction: rtl;
            }

            input,
            select {
                font-family: 'Tajawal';
                border-radius: 5px !important;
            }

            label,
            div {
                font-family: 'Tajawal';
            }

            .m-b-0 .col-lg-6 {
                padding: 0 0px !important;
            }

            .has-feedback .form-control {
                text-align: right;
            }
        </style>
        <div style="min-height: 498.573px;">
            <section class="content-header">
                <h1 style="text-align: right; font-weight: bold; color: cadetblue;">
                    تعديل على محتوى الموقع
                </h1>
            </section>
            <section class="content">


                <section class="col-lg-12">
                    <div class="box box-solid bg-green-gradient">
                        <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                            <i class="fa fa-calendar" style="float: left;"></i>
                            <h3 class="box-title" title="About Us">تعديل الالوان الخطوط</h3>
                        </div>
                        <div class="box-footer text-black">
                            <div class="row">
                                <form class="form" style="left: 0px; padding-left: 21px;">
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number"> اللون الظاهر بعد متابعة العميل</label>
                                            <input id="user_color" name="user_color" value="<?php if (isset($_SESSION['user_color'])) {
                                                echo $_SESSION['user_color'];
                                            }
                                            else {
                                                echo "#c59018";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number">لون الخلفية الخاصة بالشريط الجانبي</label>
                                            <input id="sidebar_color" name="sidebar_color" value="<?php if (isset($_SESSION['sidebar_color'])) {
                                                echo $_SESSION['sidebar_color'];
                                            }
                                            else {
                                                echo "#747474";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number"> لون الخلفية الخاصة بالشريط العلوي</label>
                                            <input id="navbar_color" name="navbar_color" value="<?php if (isset($_SESSION['navbar_color'])) {
                                                echo $_SESSION['navbar_color'];
                                            }
                                            else {
                                                echo "#747474";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number">لون الخط الخاص بالشريط الجانبي</label>
                                            <input id="sidebar_text_color" name="sidebar_text_color" value="<?php if (isset($_SESSION['sidebar_text_color'])) {
                                                echo $_SESSION['sidebar_text_color'];
                                            }
                                            else {
                                                echo "#ecf0f5";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number">لون الخلفية في التقارير في الصفحة الرئيسية </label>
                                            <input id="home_boxes" name="home_boxes" value="<?php if (isset($_SESSION['home_boxes'])) {
                                                echo $_SESSION['home_boxes'];
                                            }
                                            else {
                                                echo "#B39079";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group">
                                            <label for="phone_number">لون مؤشر الماوس في الشريط الجانبي</label>
                                            <input id="sidebar_hover_color" name="sidebar_hover_color" value="<?php if (isset($_SESSION['sidebar_hover_color'])) {
                                                echo $_SESSION['sidebar_hover_color'];
                                            }
                                            else {
                                                echo "#C39B50";
                                            } ?>" type="color" class="form-control">
                                        </div>
                                    </div>
                                    <p class="error_input" style="color:#f44336;text-align: center;"></p>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>


                <?php

                $kind_emp_side_bar = (int)$_SESSION['USER_DETAILS']['kind'];
                if ($kind_emp_side_bar == 10 || $kind_emp_side_bar == 0) {

                    $querypage = "SELECT * FROM `page` WHERE `page`.`id`=1;";
                    $sql       = mysqli_query($result, $querypage);
                    $index     = 1;

                    while ($row = mysqli_fetch_array($sql)) {

                        echo '<div class="row" id="valuess">  
            <!-------------- بيانات من نحن  ---------->
            <section class="col-lg-12">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                        <i class="fa fa-calendar" style="float: left;"></i>
                        <h3 class="box-title" title="About Us">من نحن</h3> 
                    </div> 
                    <div class="box-footer text-black">
                        <div class="row"> 
                            <form class="form"  style="left: 0px; padding-left: 21px;">
                                <div class="row">
                                    <div class="col-lg-3">
                                        <div class="form-group"> 
                                             <label for="phone_number">إضهار على الموقع</label>
                                            <select name="show_about_as" class="form-control select2" style="width: 100%;">
                                              <option ';
                        if ($row['show_about_as'] == "1") {
                            echo ' selected';
                        }
                        echo '  value="1" selected="selected">نعم</option>
                                              <option ';
                        if ($row['show_about_as'] == "0") {
                            echo ' selected';
                        }
                        echo '  value="0">لا</option> 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص من نحن</label>
                                            <input name="title_about_us" value="';
                        if ($row["title_about_us"] != "0") {
                            echo $row["title_about_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="النص الضاهر على الموق ( من نحن ) ">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div> 
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">رقم جوال</label>
                                            <input name="about_phone_num1" value="';
                        if ($row["about_phone_num1"] != "0") {
                            echo $row["about_phone_num1"];
                        }
                        echo '"  type="number" class="form-control" placeholder="966555555555">
                                            <i class="fa fa-phone form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">رقم جوال أخر</label>
                                            <input name="about_phone_num2" value="';
                        if ($row["about_phone_num2"] != "0") {
                            echo $row["about_phone_num2"];
                        }
                        echo '" type="number" class="form-control" placeholder="966555555555">
                                            <i class="fa fa-phone form-control-feedback"></i>
                                        </div> 
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">وصف عن الشركة </label>
                                            <textarea  name="about_us_dis" style="height: 119px;" rows="200" type="text" class="form-control" placeholder="وصف عن ما تقدمة الشركة">';
                        echo $row["about_us_dis"];
                        echo '</textarea>
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    
                                </div>  
                                <p class="error_input" style="color:#f44336;text-align: center;"></p>
                           </form>
                        </div>
                   </div>
                </div> 
            </section>
            
            <!-------------- اتصل بنا  ---------->
            <section class="col-lg-12">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                        <i class="fa fa-calendar" style="float: left;"></i>
                        <h3 class="box-title" title="About Us">اتصل بنا</h3> 
                    </div> 
                    <div class="box-footer text-black">
                        <div class="row"> 
                            <form class="form"  style="left: 0px; padding-left: 21px;">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <div class="form-group"> 
                                             <label for="phone_number">إضهار على الموقع</label>
                                            <select name="show_call_us" class="form-control select2" style="width: 100%;">
                                              <option ';
                        if ($row['show_call_us'] == "1") {
                            echo ' selected';
                        }
                        echo ' value="1" selected="selected">نعم</option>
                                                                        <option ';
                        if ($row['show_call_us'] == "0") {
                            echo ' selected';
                        }
                        echo ' value="0">لا</option> 
                                            </select>
                                         </div>
                                    </div>
                                    
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص اتصل بنا (تذييل )</label>
                                            <input name="txt_connect_us_footer" value="';
                        if ($row["txt_connect_us_footer"] != "0") {
                            echo $row["txt_connect_us_footer"];
                        }
                        echo '"  type="text" class="form-control" placeholder="النص الإفتراضي (إتصل بنا )">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">تصفح الفلل</label>
                                            <input name="title_villa" value="';
                        if ($row["title_villa"] != "0") {
                            echo $row["title_villa"];
                        }
                        echo '"  type="text" class="form-control" placeholder="نص تصفح الفلل">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص اوقات العمل </label>
                                            <input name="title_call_us" value="';
                        if ($row["title_call_us"] != "0") {
                            echo $row["title_call_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="إتصل بنا ( هو النص الإفتراضي ) ">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>    
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">وصف إتصل بنا</label>
                                            <input name="title1_call_us" value="';
                        if ($row["title1_call_us"] != "0") {
                            echo $row["title1_call_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="مثلاً : نحن دائما على استعداد لتزويدك بأعلى مستوى من الدعم. العلاقة بيننا وبين كل عميل مهمة للغاية بالنسبة لنا,">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div> 
                                    </div> 
                                     <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص البريد الإكتروني</label>
                                            <input name="txt_mail" value="';
                        if ($row["txt_mail"] != "0") {
                            echo $row["txt_mail"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الافتراضي(البريد الإلكتروني)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                         <div class="form-group has-feedback">
                                            <label for="phone_number">البريد الإكتروني</label>
                                            <input name="mail_call_us" value="';
                        if ($row["mail_call_us"] != "0") {
                            echo $row["mail_call_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="info@domain.com">
                                            <i class="fa fa-envelope form-control-feedback"></i>
                                        </div>  
                                    </div>
                                     <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص رقم التواصل </label>
                                            <input name="txt_num_moahad" value="';
                        if ($row["txt_num_moahad"] != "0") {
                            echo $row["txt_num_moahad"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الافتراضي(رقم التواصل)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                         <div class="form-group has-feedback">
                                            <label for="phone_number">رقم التواصل</label>
                                            <input name="cn_call_us" value="';
                        if ($row["cn_call_us"] != "0") {
                            echo $row["cn_call_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="966 92000000">
                                            <i class="fa fa-phone form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص العنوان</label>
                                            <input name="txt_num_connect" value="';
                        if ($row["txt_num_connect"] != "0") {
                            echo $row["txt_num_connect"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الافتراضي (العنوان)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    <div class="col-lg-4">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">العنوان</label>
                                            <input name="address_call_us" value="';
                        if ($row["address_call_us"] != "0") {
                            echo $row["address_call_us"];
                        }
                        echo '"  type="text" class="form-control" placeholder="المملكة العربية السعودية - الرياض - مقابل برج">
                                            <i class="fa fa-map form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    <div class="col-lg-12">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">خريطة جوجل (كود)</label>
                                            <textarea  name="google_map" style="height: 119px;" rows="200" type="text" class="form-control" placeholder="Code HTML From Google Earth">';
                        if ($row["google_map"] != "0") {
                            echo $row["google_map"];
                        }
                        echo ' </textarea>
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div> 
                                    </div>
                                </div>  
                                <p class="error_input" style="color:#f44336;text-align: center;"></p>
                           </form>
                        </div>
                   </div>
                </div> 
            </section>
            
            <!-------------- بيانات التوصال الإجتماعي ----->
            <section class="col-lg-12">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                        <i class="fa fa-calendar" style="float: left;"></i>
                        <h3 class="box-title" title="About Us">بيانات التواصل الإجتماعي</h3> 
                    </div>
                    <div class="box-body no-padding">
        
                    </div>
                    <div class="box-footer text-black">
                        <div class="row"> 
                            <form class="form"  style="left: 0px; padding-left: 21px;"> 
                              <div class="row"> 
                                  <div class="col-lg-3">
                                       <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب facebook</label>
                                    <input name="url_facebook" value="';
                        if ($row["url_facebook"] != "0") {
                            echo $row["url_facebook"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-facebook form-control-feedback"></i>
                                </div>  
                                  </div>
                                  <div class="col-lg-3">
                                       <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب twitter</label>
                                    <input name="url_twitter" value="';
                        if ($row["url_twitter"] != "0") {
                            echo $row["url_twitter"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-twitter form-control-feedback"></i>
                                </div>
                                  </div>
                                  <div class="col-lg-3">
                                  <div class="form-group has-feedback">
                                    <label for="phone_number">رابط snapchat</label>
                                    <input name="url_snapchat" value="';
                        if ($row["url_snapchat"] != "0") {
                            echo $row["url_snapchat"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                   <i class="fa fa-snapchat form-control-feedback"></i>
                                </div>
                                  </div>
                                  <div class="col-lg-3"> 
                                  <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب instagram</label>
                                    <input name="url_instagram" value="';
                        if ($row["url_instagram"] != "0") {
                            echo $row["url_instagram"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-instagram form-control-feedback"></i>
                                </div>
                                  </div>
                                  <div class="col-lg-3">
                                  <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب youtube</label>
                                    <input name="url_youtube" value="';
                        if ($row["url_youtube"] != "0") {
                            echo $row["url_youtube"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                   <i class="fa fa-youtube form-control-feedback"></i>
                                </div>  
                                  </div>
                                  <div class="col-lg-3">
                                  <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب linkedin</label>
                                    <input name="url_linkedin" value="';
                        if ($row["url_linkedin"] != "0") {
                            echo $row["url_linkedin"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-linkedin form-control-feedback"></i>
                                </div>  
                                  </div>
                                  <div class="col-lg-3">
                                
                                 <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب google</label>
                                    <input name="url_google" value="';
                        if ($row["url_google"] != "0") {
                            echo $row["url_google"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-google form-control-feedback"></i>
                                </div>
                                  </div>
                                  <div class="col-lg-3">
                                 <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب WhatsApp</label>
                                    <input name="url_whatsapp" value="';
                        if ($row["url_whatsapp"] != "0") {
                            echo $row["url_whatsapp"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-whatsapp form-control-feedback"></i>
                                </div>
                                  </div>
                                  <div class="col-lg-3">
                                 <div class="form-group has-feedback">
                                    <label for="phone_number">رابط حساب Telegram</label>
                                    <input name="url_telegram" value="';
                        if ($row["url_telegram"] != "0") {
                            echo $row["url_telegram"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                    <i class="fa fa-telegram form-control-feedback"></i>
                                </div>   
                                  </div>
                                  <div class="col-lg-3">
                                     <div class="form-group has-feedback">
                                        <label for="phone_number">رابط حساب Pinterest</label>
                                        <input name="url_pinterest" value="';
                        if ($row["url_pinterest"] != "0") {
                            echo $row["url_pinterest"];
                        }
                        echo '"  type="text" class="form-control" placeholder="https://example.com/users">
                                        <i class="fa fa-pinterest form-control-feedback"></i>
                                    </div>    
                                  </div> 
                              </div>  
                                <p class="error_input" style="color:#f44336;text-align: center;"></p>
                           </form>
                        </div>
                   </div>
                </div> 
            </section> 
            
             
             <!--------------   نبذه عنا  ---------->
             <section class="col-lg-12">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                        <i class="fa fa-calendar" style="float: left;"></i>
                        <h3 class="box-title" title="About Us">خدماتنا</h3> 
                    </div> 
                    <div class="box-footer text-black">
                        <div class="row">  
                            <form class="form"  style="left: 0px; padding-left: 21px;"> 
                                <div class="row"> 
                                     <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">عنوان خدماتنا</label>
                                            <input name="txt_nobtha_ana" value="';
                        if ($row["txt_nobtha_ana"] != "0") {
                            echo $row["txt_nobtha_ana"];
                        }
                        echo '"  type="text" class="form-control" placeholder="ادخل عنوان خدماتنا">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">وصف خدماتنا</label>
                                            <input name="comp_efficiency" value="';
                        if ($row["comp_efficiency"] != "0") {
                            echo $row["comp_efficiency"];
                        }
                        echo '"  id="u_name" type="text" class="form-control" placeholder="ادخل وصف خدماتنا">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">عنوان خدماتنا الرئيسي</label>
                                            <input name="comp_message" value="';
                        if ($row["comp_message"] != "0") {
                            echo $row["comp_message"];
                        }
                        echo '"  type="text" class="form-control" placeholder="العنوان في الهيدير">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>    
                                    </div> 
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group"> 
                                             <label for="phone_number">إضهار على الموقع</label>
                                            <select name="show_nobtha_ana" class="form-control select2" style="width: 100%;">
                                              <option ';
                        if ($row['show_nobtha_ana'] == "1") {
                            echo ' selected';
                        }
                        echo '  value="1" selected="selected">نعم</option>
                                              <option ';
                        if ($row['show_nobtha_ana'] == "0") {
                            echo ' selected';
                        }
                        echo '  value="0">لا</option> 
                                            </select>
                                         </div>
                                    </div> 
                                </div> 
                           </form> 
                            <div class="row m-b-0">
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num1" type="text" value="';
                        if ($row["u_num1"] != "0") {
                            echo $row["u_num1"];
                        }
                        echo '"  class="form-control" placeholder="رقم بيت">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name1" type="text" value="';
                        if ($row["u_name1"] != "0") {
                            echo $row["u_name1"];
                        }
                        echo '"  class="form-control" placeholder="نص بيت">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div>  
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num2" type="text" value="';
                        if ($row["u_num2"] != "0") {
                            echo $row["u_num2"];
                        }
                        echo '" class="form-control" placeholder="رقم موقع">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name2" type="text" value="';
                        if ($row["u_name2"] != "0") {
                            echo $row["u_name2"];
                        }
                        echo '" class="form-control" placeholder="نص موقع">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div>  
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num3" type="text" value="';
                        if ($row["u_num3"] != "0") {
                            echo $row["u_num3"];
                        }
                        echo '" class="form-control" placeholder="رقم مبلغ">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name3" type="text" value="';
                        if ($row["u_name3"] != "0") {
                            echo $row["u_name3"];
                        }
                        echo '" class="form-control" placeholder="نص مبلغ">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div>  
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num4" type="text" value="';
                        if ($row["u_num4"] != "0") {
                            echo $row["u_num4"];
                        }
                        echo '" class="form-control" placeholder="رقم كاس">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name4" type="text" value="';
                        if ($row["u_name4"] != "0") {
                            echo $row["u_name4"];
                        }
                        echo '" class="form-control" placeholder="نص كاس">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div> 
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num5" type="text" value="';
                        if ($row["u_num5"] != "0") {
                            echo $row["u_num5"];
                        }
                        echo '" class="form-control" placeholder="الرقم">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name5" type="text" value="';
                        if ($row["u_name5"] != "0") {
                            echo $row["u_name5"];
                        }
                        echo '" class="form-control" placeholder="النص">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div> 
                                <div class="col-lg-4 br">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_num6" type="text" value="';
                        if ($row["u_num6"] != "0") {
                            echo $row["u_num6"];
                        }
                        echo '" class="form-control" placeholder="الرقم">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group has-feedback"> 
                                                <input name="u_name6" type="text" value="';
                        if ($row["u_name6"] != "0") {
                            echo $row["u_name6"];
                        }
                        echo '" class="form-control" placeholder="النص">
                                                <i class="fa fa-font form-control-feedback"></i>
                                            </div>
                                        </div>
                                    </div>  
                                </div>  
                            </div> 
                            <p class="error_input" style="color:#f44336;text-align: center;"></p> 
                        </div>
                   </div>
                </div> 
            </section>
            
             <!--------------  نصوص الموقع   ---------->
             <section class="col-lg-12">
                <div class="box box-solid bg-green-gradient">
                    <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                        <i class="fa fa-calendar" style="float: left;"></i>
                        <h3 class="box-title" title="About Us">نصوص على الموقع</h3> 
                    </div> 
                    <div class="box-footer text-black">
                        <div class="row">  
                            <form class="form"  style="left: 0px; padding-left: 21px;"> 
                                <div class="row"> 
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">عنوان تقديم الطلب</label>
                                            <input name="title_send_order" value="';
                        if ($row["title_send_order"] != "0") {
                            echo $row["title_send_order"];
                        }
                        echo '"  type="text" class="form-control" placeholder="عنوان تقديم الطلب المودود اعلى حقول الإدخال">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                     <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">العنوان الأساسي</label>
                                            <input name="txt_name_comp" value="';
                        if ($row["txt_name_comp"] != "0") {
                            echo $row["txt_name_comp"];
                        }
                        echo '"  type="text" class="form-control" placeholder="ادخل اسم الشركة">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص حقل ادخال الاسم</label>
                                            <input name="customer_name" value="';
                        if ($row["customer_name"] != "0") {
                            echo $row["customer_name"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الإفتراضي (إسمك الكريم )">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص حقل محتوى رقم الجوال</label>
                                            <input name="customer_phone" value="';
                        if ($row["customer_phone"] != "0") {
                            echo $row["customer_phone"];
                        }
                        echo '"  type="text" class="form-control" placeholder="النص الإفتراضي(رقم الجوال)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص محتوى حقل ملاحظات العميل</label>
                                            <input name="customer_note" value="';
                        if ($row["customer_note"] != "0") {
                            echo $row["customer_note"];
                        }
                        echo '" type="text" class="form-control" placeholder="االنص الإفتراضي (اكتب لنا شيئاً)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص إرسال الطلب</label>
                                            <input name="txt_send_order" value="';
                        if ($row["txt_send_order"] != "0") {
                            echo $row["txt_send_order"];
                        }
                        echo '"  type="text" class="form-control" placeholder="النص الموجود على زر ارسال الطلب">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص خدماتنا</label>
                                            <input name="txt_our_service" value="';
                        if ($row["txt_our_service"] != "0") {
                            echo $row["txt_our_service"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الإفتراضي (خدماتنا)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                   
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص رقم الجوال</label>
                                            <input name="txt_phone_number" value="';
                        if ($row["txt_phone_number"] != "0") {
                            echo $row["txt_phone_number"];
                        }
                        echo '"  type="text" class="form-control" placeholder="الافتراضي(رقم الجوال)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">تم إرسال الطلب بنجاح</label>
                                            <input name="txt_send_successful" value="';
                        if ($row["txt_send_successful"] != "0") {
                            echo $row["txt_send_successful"];
                        }
                        echo '"  type="text" class="form-control" placeholder="عند نجح إرسال الطب">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">هناك طلب سابق على هذا الرقم</label>
                                            <input name="txt_thare_order" value="';
                        if ($row["txt_thare_order"] != "0") {
                            echo $row["txt_thare_order"];
                        }
                        echo '"  type="text" class="form-control" placeholder="عند تقديم طلب جديد بنفس الرقم">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">يرجى الإنتظار</label>
                                            <input name="txt_wite_send" value="';
                        if ($row["txt_wite_send"] != "0") {
                            echo $row["txt_wite_send"];
                        }
                        echo '"  type="text" class="form-control" placeholder="تتم عند إرسال الطلب">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div>
                                    <div class="col-lg-3">
                                        <div class="form-group has-feedback">
                                            <label for="phone_number">نص روابط مفيدة(تذييل)</label>
                                            <input name="txt_links" value="';
                        if ($row["txt_links"] != "0") {
                            echo $row["txt_links"];
                        }
                        echo '" type="text" class="form-control" placeholder="النص الإفتراضي (روابط مفيدة)">
                                            <i class="fa fa-font form-control-feedback"></i>
                                        </div>
                                    </div> 
                                </div> 
                           </form>   
                            <p class="error_input" style="color:#f44336;text-align: center;"></p> 
                        </div>
                   </div>
                </div> 
            </section>
        </div>';
                    }

                }
                ?>

                <button type="button" class="btn btn-primary btn-block btn-flat savepagedata">
                    <i class="fa fa-save" aria-hidden="true"></i>
                </button>

            </section>


            <?php $kind_emp_side_bar = (int)$_SESSION['USER_DETAILS']['kind'];
            if ($kind_emp_side_bar == 10 || $kind_emp_side_bar == 0) { ?>
                <section class="content main-citys" style="margin: 10px 0px; padding: 0px 5px;">
                    <div class="col-lg-12">
                        <div class="box box-solid bg-green-gradient">
                            <div class="box-header ui-sortable-handle" style="text-align: center; cursor: move;">
                                <i class="fa fa-calendar" style="float: left;"></i>
                                <h3 class="box-title" title="About Us">المدن</h3>
                            </div>
                            <div class="box-footer text-black">
                                <div class="row">
                                    <form class="form" style="left: 0px; padding-left: 21px;">
                                        <div class="row row-citys">
                                            <?php
                                            $query = "SELECT * FROM `city`";
                                            $sql   = mysqli_query($result, $query);
                                            while ($row = mysqli_fetch_array($sql)) {

                                                echo '
                                		<div class="form-group has-feedback box-city">
                                            <input value="' . $row["name"] . '" type="text" class="form-control" placeholder="إسم المدينة">
                                            <i class="fa fa-trash-o delete_city" id="' . $row["id"] . '"></i>
                                            <i class="fa fa-save save_city" id="' . $row["id"] . '"></i>
                                        </div> 
                            		';
                                            }
                                            echo '<div class="form-group has-feedback box-city">
                            	    <button id="sighn" type="button" class="btn btn-success btn-block btn-flat add_city"> <i class="fa fa-plus" aria-hidden="true"></i> إضافة مدينة</button>
                                </div> ';
                                            ?>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            <?php } ?>

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

<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<link rel="stylesheet" href="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.css">
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/selectstyle.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/selectstyle/jquery.mask.js"></script>

<script src="<?= DIR_ASSETS ?>dist/js/main_admin.js"></script>
<script src="<?= DIR_ASSETS ?>dist/js/jquery.datetimepicker.full.min.js" type="text/javascript"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker.css">
<link rel="stylesheet" type="text/css" href="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker-theme.css">
<script type="text/javascript" src="<?= DIR_ASSETS ?>dist/duDatepicker/duDatepicker.js"></script>

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/events.js"></script>


</body>

</html>