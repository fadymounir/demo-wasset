<?php

session_start();
if (!isset($_SESSION['USER_DETAILS'])) {
    header("Location: ../../index.php");
}
include '../../config.php';
$_SESSION['PAGE']      = isset($_SESSION['PAGE']) ? 2 : 2;
$_SESSION['KIND_PAGE'] = isset($_SESSION['KIND_PAGE']) ? 2 : 2;

if (!isset($_SESSION["LIMIT_ORDERS"])) {
    $_SESSION["LIMIT_ORDERS"] = "100";
}
// echo $_SESSION['CLOSE_WINDOWS'];
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
    <input class="open_message_notifcation" value="<?= $_GET['order_id']; ?>" type="hidden"/>


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
                                    <button type="button" style="width: 124px;" class="btn btn-cust-success add_new_template make_event">
                                        <i class="fa fa-plus" aria-hidden="true"></i>اضافة قالب جديد
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

                <div class="col-md-12" style="padding: 0px;">
                    <div class="box box-primary" style="border-radius: 5px;    margin: 0 !important;">
                        <div class="box-body" style="padding: 0; height: 100%;">
                            <div class="direct-chat-messages" style="height: 100%; padding: 0; width: 100%;">
                                <table class="table table-bordered table-striped all_orders" style="font-size: 18px">
                                    <thead>
                                    <tr>
                                        <th>نص القالب</th>
                                        <th>الموظف</th>
                                        <th>اجراءات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php

                                    $addition = " WHERE whatsapp_templete.emp_id ";
                                    if ($_SESSION['is_admin'] != 0) {
                                        $addition .= " in( " . $_SESSION['user_id'] . ")";
                                    }
                                    else {
                                        $addition .= " in ( 0 ," . $_SESSION['user_id'] . ")";
                                    }

                                    $sql = "SELECT
                                                    * 
                                                FROM whatsapp_templete 
                                                    left JOIN users on users.u_id=whatsapp_templete.emp_id 
                                                " . $addition . "
                                                ORDER BY id DESC";
                                    $sql = mysqli_query($result, $sql);
                                    while ($row = mysqli_fetch_array($sql)) { ?>
                                        <tr id="<?php echo $row['id']; ?>">
                                            <td style="font-size:15px"><?= $row['content'] ?></td>
                                            <td style="font-size:15px">
                                                <?php if ($row['emp_id'] == 0) echo "الادارة"; else $row['user_name']; ?>
                                            </td>
                                            <td style="font-size:15px">
                                                <a data-id="<?php echo $row['id'] ?>" class="btn btn-danger delete_item">حذف</a>
                                                <a data-content="<?php echo $row['content'] ?>" data-id="<?php echo $row['id'] ?>" class="btn btn-success update_item">تعديل</a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
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


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">قالب الواتساب</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info" style="font-weight:bold; font-size:18px; background-color: #525657">
                    <p> # ==> تعبر عن اسم صاحب الطلب </p>
                    <p> $ ==> تعبر عن  رقم الطلب </p>
                </div>
                <form id="modalForm">
                    <div class="form-group">
                        <label dir="rtl" for="inputField">
                            محتوي القالب:
                        </label>
                        <input type="hidden" id="item_id">
                        <input type="hidden" id="action_type">
                        <textarea name="template" id="template" cols="30" rows="10" dir="rtl"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                <button type="button" class="btn btn-primary" id="saveButton">حفظ</button>
            </div>
        </div>
    </div>
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

<script>
    $(".all_orders").fancyTable({
        pagination: true,
        paginationClass: "btn btn-light",
        paginationClassActive: "active",
        pagClosest: 5,
        searchable: true,
        perPage: 10,
        globalSearch: false,
        rowDisplayStyle: 'block',
        limit: 5,
        inputPlaceholder: "بحث...",
    });


    $('body').on('click', '.delete_item', function () {

        let id = $(this).data('id');
        Swal.fire({
            title: 'حذف القالب',
            text: "هل انت متاكد من حذف القالب",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'حذف',
            cancelButtonText: 'الغاء'
        }).then((result) => {
            if (result.isConfirmed) {

                let dataString = 'action=deleteWhatsAppTemplate&value=' + id;
                $.ajax({
                    type: "post",
                    url: '../action.php',
                    data: dataString,
                    catch: false,
                    success: function (html) {
                        $('.loading_all').css('display', 'none');
                        $('.loading_page').css('display', 'none');
                        $('#' + id).hide();
                        Swal.fire(
                            'حذف!',
                            'تم حذف القالب بنجاح',
                            'success'
                        );
                    }
                });


            }
        });


    });
    $('body').on('click', '.update_item', function () {

        let id      = $(this).data('id');
        let content = $(this).data('content');
        $('#item_id').val(id);
        $('#template').val(content);
        $('#action_type').val('update');
        $('#exampleModal').modal();

    });

    $('body').on('click', '.add_new_template', function () {
        $('#template').val('');
        $('#action_type').val('create');
        $('#exampleModal').modal();
    });

    $('body').on('click', '#saveButton', function () {
        let item_id     = $('#item_id').val();
        let template    = $('#template').val();
        let action_type = $('#action_type').val();
        if (action_type == 'update') {
            let dataString = 'action=updateWhatsAppTemplate&value=' + item_id + "&content=" + template;
            $.ajax({
                type: "post",
                url: '../action.php',
                data: dataString,
                catch: false,
                success: function (html) {
                    Swal.fire(
                        'تم!',
                        'تم تعديل القالب  بنجاح',
                        'success'
                    );
                }
            });
        }
        else {
            let dataString = 'action=createWhatsAppTemplate&value=' + template;
            $.ajax({
                type: "post",
                url: '../action.php',
                data: dataString,
                catch: false,
                success: function (html) {
                    Swal.fire(
                        'تم!',
                        'تم اضافة الطلب بنجاح',
                        'success'
                    );
                }
            });
        }
        $('#exampleModal').modal('hide');
        location.reload();
    });


</script>

<!-- Your Custom Script -->

<script src="https://cdn.jsdelivr.net/npm/lodash@4.17.21/lodash.min.js"></script>
<script type="text/javascript" src="<?= DIR_ASSETS ?>js/events.js"></script>

</body>

</html>