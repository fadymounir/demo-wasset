<footer class="main-footer" style="text-align: center;">
    <!--<strong>حقوق الطبع &copy; 2022 <a href=""></a></strong>  -->
</footer>
<div class="control-sidebar-bg"></div>

<div class="main_edite_order">
    <div class="edite_order_customer">
        <div class="main-loading">
            <svg version="1.1" id="L1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
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
        <div class="set_edit_order">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">الموظف</label>
                    <input type="email" class="form-control" id="cusom_emp_name" readonly placeholder="اسم الموظف">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">ملاحظات العميل</label>
                    <input type="email" class="form-control" id="cusom_note" readonly placeholder="ملاحظات العيمل">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">رقم الجوال</label>
                    <input type="phone" class="form-control" id="cusom_phone" readonly placeholder="رقم جوال العميل">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">إسم العميل</label>
                    <input type="email" class="form-control" id="cusom_name" placeholder="اسم العميل">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">عميل وتس اب </label>
                    <input type="email" class="form-control" id="cusom_whatsapp" readonly placeholder="هل العميل وتس اب ">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">المصدر</label>
                    <input type="email" class="form-control" id="cusom_source" readonly placeholder="مصدر العميل">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">تقييم الطلب</label>
                    <select id="cusom_starts" class="form-control">
                        <option selected>إختر</option>
                        <option value="ضعيف"></option>
                        <option value="جيد"></option>
                        <option value="ممتاز"></option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="cusom_statues">حالة الطلب</label>
                    <select id="inputState" class="form-control">
                        <option selected>إختر</option>
                        <option value="">ملغي</option>
                        <option value="">قيد التنفيذ</option>
                        <option value="">منتهي</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputEmail4">رقم الطلب</label>
                    <input type="email" class="form-control" id="cusom_number" readonly placeholder="رقم الطلب">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">تاريخ الادخال</label>
                    <input type="email" class="form-control" id="cusom_date_add" readonly placeholder="تاريخ ادخال الطلب">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">تاريخ المتابعة</label>
                    <input type="email" class="form-control" id="cusom_date_re" readonly placeholder="تاريخ متابعة الطلب">
                </div>
                <div class="form-group col-md-3">
                    <label for="inputEmail4">إزالة الطلب من طرف الموظف</label>
                    <input type="email" class="form-control" id="cusom_delete" readonly placeholder="هل تم ازالة الطلب من طرف الموظف">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="inputEmail4">وصف الطلب</label>
                    <textarea class="form-control" id="cusom_description" rows="10"></textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <div class="file_title">
                        <label for="inputEmail4">الملفات الخاصة بالعميل</label>
                        <p>سيتم العمل عليها مستقبلاً</p>
                    </div>
                    <div class="customer_file_img">
                        <div class="fileimg">
                            <img src="<?= DIR_ASSETS ?>dist/img/blank-image.svg"/>
                        </div>
                        <div class="fileimg">
                            <img src="<?= DIR_ASSETS ?>dist/img/blank-image.svg"/>
                        </div>

                        <div class="fileimg">
                            <p>
                                <i class="fa fa-plus" aria-hidden="true"></i>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a id="1049" type="button" class="btn btn-danger cloase_edite_form"><i class="fa fa-close" aria-hidden="true"></i></a>

        <button id="5310" type="button" class="btn btn-edit add_new_alarm set_order_alarm_id" style="background-color: #ffd000 !important;position: absolute;top:5px;left:50px">
            <i class="fa fa-bell-o" aria-hidden="true"></i>
        </button>

        <button style="position:absolute;top:5px;left:100px" id="5310" type="button" class="btn btn-def add_to_fovreite add_to_fovreite_profile" is_true="1">
            <i class="fa fa-heart" aria-hidden="true"></i>
        </button>

        <button style="position:absolute; top:5px; left: 150px" id="5310" type="button" class="btn btn-def add_to_motabaa motabaa-button add_to_motabaa_profile" is_true="1">
            <i class="fa fa fa-files-o" aria-hidden="true"></i>
        </button>


        <div id="success"></div>
        <div class="form-row bot_but">
            <button type="button" class="btn btn-primary save-order-datialse"><i class="fa fa-pencil-square-o"></i> حفظ
                التعديلات
            </button>
        </div>
    </div>
</div>


<div class="main_add_new_alarm">
    <div class="edite_order_customer">
        <input class="alarm_order_id" type="hidden" value="0"/>
        <a type="button" class="btn btn-danger cloase_alarm"><i class="fa fa-close" aria-hidden="true"></i></a>
        <div class="messages"></div>
        <div class="main_add_alarm">
            <p>إضافة تذكير جديد</p>
            <input class="alarm_date_time" type="datetime-local" value="2023-06-01T08:30"/>
            <textarea class="alarm_note" placeholder="ادخل نص التذكير"></textarea>
            <button type="button" class="btn btn-primary save-add-new-alarm">
                <i class="fa fa-plus"></i>
                إضافة التذكير
            </button>
        </div>

    </div>
</div>


<div class="modal fade asing_order_employee" id="asing_order_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">حدد الموظف الأخر</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" class="order_id" value="0"/>.
            </div>
            <div class="modal-body main_users_asign" style="direction: rtl;">
                <?php
                $query_users = "SELECT * FROM users WHERE 1=1  ORDER BY u_id ";
                $sql_users   = mysqli_query($result, $query_users);
                while ($row_users = mysqli_fetch_array($sql_users)) {
                    echo '
                        <div class="check_user_name" user_id="' . $row_users['u_id'] . '">
                            ' . $row_users['u_name'] . '
                        </div>
                    ';
                }
                ?>
            </div>
            <p class="show_error_not_check_user" style=" text-align: center; color: red; display:none;">يرجى إختيار موظف
                واحد.</p>
            <div class="modal-footer">
                <button type="button" class="btn btn-success save_asign_order" style="width:100%">حفظ البيانات</button>
            </div>
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="show_history" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    سجل التعديلات
                    <i class="fa fa-clock-o"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body all_update">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="show_new_customer" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    إدخال عميل جديد
                    <i class="fa fa-plus"></i>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group has-feedback">
                        <input id="emp_name" type="text" maxlength="30" class="form-control check_valdations" placeholder="إسم العميل">
                        <span class="input_icon glyphicon glyphicon-user form-control-feedback" style="font-size: 23px;"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <input id="emp_phone" type="text" maxlength="10" class="form-control check_valdations" placeholder="رقم الجوال">
                        <span class="input_icon glyphicon glyphicon-phone form-control-feedback" style="font-size: 23px;"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <select class="select_source">
                            <?php
                            $qu_source_in    = "SELECT * FROM table_source WHERE 1 = 1 ";
                            $sql_source_in   = mysqli_query($result, $qu_source_in);
                            $kind_emp_source = (int)$_SESSION['USER_DETAILS']['kind'];
                            while ($row_source_in = mysqli_fetch_array($sql_source_in)) {

                                if ($kind_emp_source == 10 || $kind_emp_source == 0) {
                                    echo '<option value="' . $row_source_in['code'] . '">' . $row_source_in['name'] . '</option>';
                                }
                                else {
                                    if (((int)$row_source_in['can_show']) == 1) {
                                        echo '<option value="' . $row_source_in['code'] . '">' . $row_source_in['emp_name'] . '</option>';
                                    }
                                }


                            }
                            ?>
                        </select>
                        <span class="input_icon glyphicon glyphicon-phone form-control-feedback" style="font-size: 23px;"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <select class="select_employee">
                            <?php
                            $kind_emp_users = (int)$_SESSION['USER_DETAILS']['kind'];
                            $user_id        = (int)$_SESSION['USER_DETAILS']['u_id'];
                            $user_name      = $_SESSION['USER_DETAILS']['u_name'];

                            if ($kind_emp_users == 10 || $kind_emp_users == 0) {
                                $query1 = "SELECT * FROM `users` WHERE 1=1";
                                $sql1   = mysqli_query($result, $query1);

                                if (!$sql1) {
                                    echo '<option value="' . $user_id . '">' . $user_name . '</option>';
                                }

                                while ($row1 = mysqli_fetch_array($sql1)) {
                                    echo '<option value="' . $row1['u_id'] . '">' . $row1['u_name'] . '</option>';
                                }
                            }
                            else {
                                echo '<option value="' . $user_id . '">' . $user_name . '</option>';
                            }
                            ?>

                        </select>
                        <span class="input_icon glyphicon glyphicon-phone form-control-feedback" style="font-size: 23px;"></span>
                    </div>

                    <div class="form-group has-feedback">
                        <textarea rows="1" cols="60" name="note" id="note" maxlength="200" type="text" class="form-control" placeholder="ادخل أي ملاحظات"></textarea>
                        <span class="input_icon glyphicon glyphicon-txt form-control-feedback" style="font-size: 23px;"></span>
                    </div>
                </form>
                <div class="model_error" style="display:none;"></div>
            </div>
            <div class="modal-footer" style="display: flex;">
                <button class="btn btn-success add_new_order w-100" type="button">حفظ</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade show_statuse_dialoge" id="show_statuse_dialoge" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" class="statuse_order_id" value="0"/>
            </div>
            <div class="modal-body">
                <div>
                    <div class="main_chose_statuse">
                        <div class="chose_statuse_just" style="background-color: #c4901838;">
                            <p>هل تتوقع العميل رح يخلص معك؟</p>
                            <div class="all_chose_statuse">
                                <?php
                                $qu_table_stars  = "SELECT * FROM table_stars WHERE `can_show` = 1 ";
                                $sql_table_stars = mysqli_query($result, $qu_table_stars);
                                while ($row_table_stars = mysqli_fetch_array($sql_table_stars)) {
                                    echo '
                                            <div class="checkbox-wrapper-16">
                                                <label class="checkbox-wrapper">
                                                    <input type="radio" name="status" class="checkbox-input" main_id = "' . $row_table_stars['id'] . '"/>
                                                    <span class="checkbox-tile"> 
                                                        <span class="checkbox-label">' . $row_table_stars['name'] . '</span>
                                                    </span>
                                                </label>
                                            </div>
                                        ';
                                }

                                ?>

                            </div>

                        </div>
                        <div class="chose_statuse_just" style="background-color: #00a65a2e;">
                            <p>هل يمكن خدمة العميل لدى الجهات التمويلية؟</p>
                            <div class="all_chose_serve_customer">
                                <?php
                                $qu_service  = "SELECT * FROM table_serve_customer WHERE `can_show` = 1 ";
                                $sql_service = mysqli_query($result, $qu_service);
                                while ($row_service = mysqli_fetch_array($sql_service)) {
                                    echo '
                                            <div class="checkbox-wrapper-16">
                                                <label class="checkbox-wrapper">
                                                    <input type="radio" name="service" class="checkbox-input" main_id = "' . $row_service['id'] . '"/>
                                                    <span class="checkbox-tile"> 
                                                        <span class="checkbox-label">' . $row_service['name'] . '</span>
                                                    </span>
                                                </label>
                                            </div>
                                        ';
                                }

                                ?>
                            </div>

                        </div>
                    </div>
                    <textarea class="note_statuse" placeholder="ملاحظات"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success w-100 save_statuse_service" data-dismiss="modal">
                    حفظ
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade show_source_dialoge" id="show_source_dialoge" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <input type="hidden" class="marketing_id" value="0"/>
            </div>
            <div class="modal-body">
                <div class="chose_statuse_just" style="border: none;">
                    <p>تغير مصدر الطلب</p>
                    <div class="all_source_customer">
                        <?php
                        $qu_source  = "SELECT * FROM table_source WHERE 1=1 ";
                        $sql_source = mysqli_query($result, $qu_source);
                        while ($row_source = mysqli_fetch_array($sql_source)) {
                            echo '
                                <div class="checkbox-wrapper-16">
                                    <label class="checkbox-wrapper">
                                        <input type="radio" name="source" class="checkbox-input" code_id = "' . $row_source['code'] . '"/>
                                        <span class="checkbox-tile"> 
                                            <span class="checkbox-label">' . $row_source['name'] . '</span>
                                        </span>
                                    </label>
                                </div>
                            ';
                        }

                        ?>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success w-100 save_source_customer" data-dismiss="modal">
                    تغير المصدر
                    <i class="fa fa-save"></i>
                </button>
            </div>
        </div>
    </div>
</div>


<div class="show_filter">
    <div class="filter_header">
        <p>الفلترة بالمدخلات</p>
        <a class="close_filter">
            <i class="fa fa-close"></i>
        </a>
    </div>
    <div class="filter_body">
        <div class="row">

            <div class="form-group col-md-12">
                <label for="inputEmail4">رقم المعاملة</label>
                <input type="number" class="number_order input_search_filter" value="" placeholder="ادخل رقم المعاملة"/>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">اسم العميل</label>
                <input type="search" class="customer_name input_search_filter" value="" placeholder="ادخل اسم العميل"/>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">رقم الجوال</label>
                <input type="search" class="customer_phone_number input_search_filter" value="" placeholder="ادخل رقم جوال العميل"/>
            </div>


            <div class="form-group col-md-12">
                <label for="inputEmail4">حالة الطلب</label>
                <select id="categories_status" class="input_search_filter" name="categories_status" multiple>
                    <?php
                    $qu_statuse  = "SELECT * FROM table_status WHERE `can_show` = 1 ";
                    $sql_statuse = mysqli_query($result, $qu_statuse);
                    while ($row_status = mysqli_fetch_array($sql_statuse)) {
                        echo '<option value="' . $row_status['id'] . '">' . $row_status['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">توقع العميل من قبل الموظف</label>
                <select id="categories_stars" class="input_search_filter" name="categories_stars" multiple>
                    <?php
                    $qu_stars  = "SELECT * FROM table_stars WHERE `can_show` = 1 ";
                    $sql_stars = mysqli_query($result, $qu_stars);
                    while ($row_stars = mysqli_fetch_array($sql_stars)) {
                        echo '<option value="' . $row_stars['id'] . '">' . $row_stars['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <?php
            $kind_emp    = (int)$_SESSION['USER_DETAILS']['kind'];
            $html_select = '';
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html_select .= '
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">الموظف المسؤول</label>
                        <select id="categories_users" class="input_search_filter" name="categories_users" multiple> 
                            ';
                $qu_users    = "SELECT * FROM users WHERE `users`.`kind` = '2' ";
                $sql_users   = mysqli_query($result, $qu_users);
                while ($row_users = mysqli_fetch_array($sql_users)) {
                    $html_select .= '<option value="' . $row_users['u_id'] . '">' . $row_users['u_name'] . '</option>';
                }
                $html_select .= '
                        </select>
                    </div>
                ';
            }

            echo $html_select;

            ?>

            <?php
            $kind_emp           = (int)$_SESSION['USER_DETAILS']['kind'];
            $html_select_source .= '
                    <div class="form-group col-md-12">
                        <label for="inputEmail4">المصدر</label>
                        <select id="categories_source" class="input_search_filter" name="categories_source" multiple> 
                            ';
            $qu_source          = "SELECT * FROM table_source";
            $sql_source         = mysqli_query($result, $qu_source);
            while ($row_source = mysqli_fetch_array($sql_source)) {
                if ($kind_emp == 10 || $kind_emp == 0) {
                    $html_select_source .= '<option value="' . $row_source['code'] . '">' . $row_source['name'] . '</option>';
                }
                else {
                    if ((int)$row_source['can_show'] == 1) {
                        $html_select_source .= '<option value="' . $row_source['code'] . '">' . $row_source['emp_name'] . '</option>';
                    }

                }
            }
            $html_select_source .= '
                        </select>
                    </div>
                ';

            echo $html_select_source;

            ?>


            <div class="form-group col-md-12">
                <label for="inputEmail4">إمكانية خدمة العميل</label>
                <select id="categories_posible" class="input_search_filter" name="categories_posible" multiple>
                    <?php
                    $qu_posible  = "SELECT * FROM table_serve_customer WHERE `can_show` = 1 ";
                    $sql_posible = mysqli_query($result, $qu_posible);
                    while ($row_posible = mysqli_fetch_array($sql_posible)) {
                        echo '<option value="' . $row_posible['id'] . '">' . $row_posible['name'] . '</option>';
                    }
                    ?>
                </select>
            </div>


            <div class="form-group col-md-12">
                <label for="inputEmail4">عدد عرض العملاء</label>
                <input type="number" value="<?= $_SESSION["LIMIT_ORDERS"] ?>" class="number_order_select input_search_filter" placeholder="عدد الطلبات"/>
            </div>

            <div class="form-group col-md-12">
                <label for="inputEmail4">التاريخ</label>
                <input type="text" class="date_order_get input_search_filter" placeholder="حدد تاريخ">
            </div>

            <div class="form-group col-md-12" style="display: none">
                <label for="inputEmail4">تاريخ التذكير</label>
                <input type="text" class="date_order_alarm input_search_filter" placeholder="حدد تاريخ">
            </div>

        </div>

    </div>
    <div class="filter_footer">
        <div class="row">
            <div class="form-group col-md-12">
                <button type="button" class="btn btn-default update_filters w-100"><i class="fa fa-save"></i>تطبيق
                    الفلتر
                </button>
            </div>
            <div class="form-group col-md-12">
                <button type="button" class="btn btn-error clear_filters w-100"><i class="fa fa-trash"></i> إزالة الفلتر
                </button>
            </div>

        </div>


    </div>

</div>


<audio id="alarm_sounds">
    <source src="https://admin.alawtar.net/assets/sounds/notification.mp3" type="audio/mpeg">
</audio>


<div class="all_alarms">

</div>
<div class="loading_page">
    <div class="spinner">
        <div class="bar1"></div>
        <div class="bar2"></div>
        <div class="bar3"></div>
        <div class="bar4"></div>
        <div class="bar5"></div>
        <div class="bar6"></div>
        <div class="bar7"></div>
        <div class="bar8"></div>
        <div class="bar9"></div>
        <div class="bar10"></div>
        <div class="bar11"></div>
        <div class="bar12"></div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="show_order_details_logs" dir="rtl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title " id="exampleModalLabel" style="text-align:right">سجل الملاحظات</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <table class="table table-responsive">
                    <tbody id="show_order_details_logs_body_content"></tbody>
                </table>


                <div class="col-md-12 mb-5" style="margin-bottom: 20px">
                    <textarea name="new_note" id="new_note" cols="30" rows="5" class="form-control" dir="rtl" style="resize:none"></textarea>
                </div>

            </div>
            <div class="modal-footer" >
                <a href="#"  class="btn btn-secondary" data-dismiss="modal">اغلاق</a>
                <a href="#"  class="btn btn-primary add_new_note">اضافة ملاحظات جديدة</a>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="whatsapp_template" dir="rtl" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header" style="display:block">
                <h5 class="modal-title " id="exampleModalLabel" style="text-align:right display:block ">قوالب ارسال</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <input type="hidden" id="whatsapp_phone_number">
            <div class="modal-body">
                <div class="listWhatsappTemplate_content"></div>
            </div>
            <div class="modal-footer" >
                <a href="#"  class="btn btn-secondary" data-dismiss="modal" style="color:white;background-color: #3c8dbc ">اغلاق</a>
            </div>
        </div>
    </div>
</div>



<?php

        $sql_starts = mysqli_query($result, "SELECT * from `table_stars`");
        while ($row = mysqli_fetch_array($sql_starts)) {
?>              <p id="table_stars_<?php echo $row['id'];?>" data-name="<?php echo $row['name'];?>" data-table="<?php echo $row['table_name'];?>" data-color="<?php echo $row['color'];?>">  </p>
<?php   }

        $sql_orders = mysqli_query($result, "SELECT * from `table_serve_customer`");
        while ($row = mysqli_fetch_array($sql_orders)) {
?>

            <p id="serve_customer_<?php echo $row['id']; ?>" data-name="<?php echo $row['name'];?>" data-color="<?php echo $row['color'];?>"></p>
<?php   }


        $sql_status  = mysqli_query($result, "SELECT * from `table_status`");
        while ($row = mysqli_fetch_array($sql_status)) {   ?>
            <p id="table_status_<?php echo $row['id'];?>" data-name="<?php echo $row['name'];?>" data-color="<?php echo $row['color'];?>"></p>
<?php   } ?>










