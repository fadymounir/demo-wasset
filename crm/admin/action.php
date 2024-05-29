<?php

include "../config.php";
header("Access-Control-Allow-Origin:" . $base_url);
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

session_start();

$action = $_POST['action'];
$value  = $_POST['value'];
$value1 = $_POST['value1'];

date_default_timezone_set("Asia/Riyadh");

// if(!isset($_SESSION['USER_DETAILS'])){
// 	return '';
// }
// if(!isset($_SESSION['USER_DETAILS']['kind'])){
// 	return '';
// }


if ($action == "delete_employye") {
    $sql = "DELETE FROM users WHERE u_id =$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "UpdateLoginSession") {
    if (isset($_SESSION['USER_DETAILS'])) {
        if (isset($_SESSION['last_activity']) && ((int)time() - (int)$_SESSION['last_activity'] > $_SESSION['inactive_duration'])) {
            echo "0";
            unset($_SESSION['USER_DETAILS']);
            $_SESSION = array();
            session_destroy();
        }
        else if (!isset($_SESSION['USER_DETAILS']) || empty($_SESSION['USER_DETAILS'])) {
            echo "0";
            unset($_SESSION['USER_DETAILS']);
            $_SESSION = array();
            session_destroy();
        }
        else {
            $_SESSION['last_activity'] = time();
            echo "1";
        }
        $today            = date('Y-m-d H:i:s');
        $lastInsertedId   = (int)$_SESSION['login_details_id'];
        $update_query     = "UPDATE login_details SET last_activity = ? WHERE id = ?";
        $update_statement = $con->prepare($update_query);
        $update_statement->execute([$today, $lastInsertedId]);

        return;

    }
    else {
        echo "0";
    }


}
else if ($action == "DeleteMarketings") {

    $id   = $value;
    $code = $value1;

    $stmt = $con->prepare("SELECT * FROM `orders` WHERE `from_web` = ? ");
    $stmt->execute(array($code));
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo '22222';
    }
    else {
        $sql = "DELETE FROM `table_source` WHERE `id` = $value";
        if ($con->query($sql)) {
            echo '11111';
        }
        else {
            echo '00000';
        }
    }

}
else if ($action == "new_visitings") {

    $marketing_code = $value;
    $replay         = (int)$value1;
    if ($replay == 1) {
        $sql = "UPDATE `table_source` SET `visitors` = `visitors` + 1 , `replay_visitors` = `replay_visitors` + 1 WHERE `code` = '$marketing_code' ";
        $con->query($sql);
    }
    else {
        $sql = "UPDATE `table_source` SET `replay_visitors` = `replay_visitors` + 1 WHERE `code` = '$marketing_code' ";
        $con->query($sql);
    }

}
else if ($action == "GetAllMarketings") {

    $query = "SELECT * FROM `table_source` ORDER BY `id` DESC";
    $sql   = mysqli_query($result, $query);
    while ($row = mysqli_fetch_array($sql)) {
        $show_page = (int)$row['show_page'];
        $can_show  = (int)$row['can_show'];
        echo '
			<tr marketing_id="' . $row['id'] . '">
				<td>' . $row['id'] . '</td>
				<td><input class="input_name change_marketing" type_int="string" column="name" value="' . $row['name'] . '" type="text" placeholder="أدخل الاسم لدى الإدارة"></td>
				<td><input class="input_name change_marketing" type_int="string" column="emp_name" value="' . $row['emp_name'] . '" type="text" placeholder="أدخل الاسم لدى الموظف"></td>
				<td>
					<select class="select_name change_marketing" column="can_show" type_int="int" >
						<option value="1" ';
        if ($can_show == 1) {
            echo " selected";
        }
        echo '>نعم</option>
						<option value="0" ';
        if ($can_show == 0) {
            echo " selected";
        }
        echo '>لا</option>
					</select>
				</td>
				<td> 
					<select class="select_name change_marketing" column="show_page" type_int="int">
						<option value="1" ';
        if ($show_page == 1) {
            echo " selected";
        }
        echo '>صفحة 1</option>
						<option value="2" ';
        if ($show_page == 2) {
            echo " selected";
        }
        echo '>صفحة 2</option>
						<option value="3" ';
        if ($show_page == 3) {
            echo " selected";
        }
        echo '>صفحة 3</option> 
					</select>
				</td>
				<td><input class="input_name change_marketing mask_input_code" type_int="string"   column="code" value="' . $row['code'] . '" type="text" placeholder="رمز التتبع"></td>
				<td>
					<div class="copy_url">
						<a class="btn_copy_url" url="' . WEP_SITE . 'code/' . $row['code'] . '/' . $show_page . '">
							<i class="fa fa-copy"></i>
						</a>
						<p>' . WEP_SITE . 'code/' . $row['code'] . '/' . $show_page . '</p>
					</div> 
				</td>
				<td>';
        $stmt = $con->prepare("SELECT * FROM `orders` WHERE from_web = ? ");
        $stmt->execute(array($row['code']));
        $count = $stmt->rowCount();
        echo '<p>' . $count . '</p>';
        echo '
				</td>
				<td>
					<p>' . $row['visitors'] . '</p>
				</td>
				<td>
					<p>' . $row['replay_visitors'] . '</p>
				</td>
				<td>
					<div class="mar_buttons">
						<button class="btn delete_marketing" mr_id="' . $row['id'] . '" marketing_id = "' . $row['code'] . '">
							<i class="fa fa-trash-o"></i>
						</button> 
					</div>
				</td>
			</tr>
		';
    }


}
else if ($action == "AddMarketing") {

    // sdaf
    $code  = generateRandomString(10);
    $today = date('Y-m-d H:i:s');

    $stmt = $con->prepare("INSERT INTO table_source (`code`, `date_create`,`date_update`) VALUES (?,?,?)");
    $stmt->execute(array($code, $today, $today));
    if ($stmt) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "UpdateMarketing") {
    $today        = date('Y-m-d H:i:s');
    $id           = (int)$_POST['value'];
    $column       = $_POST['value1'];
    $source_value = $_POST['value2'];
    $type         = $_POST['value3'];

    $sql = "";
    if ($type === "string") {
        $sql = "UPDATE `table_source` SET `$column` = '$source_value', `date_update` = '$today'  WHERE id = $id";
    }
    else {
        $sql = "UPDATE `table_source` SET `$column` = $source_value , `date_update` = '$today' WHERE id = $id";
    }

    if ($column == "code") {

        $count_source = 0;
        $sql_source   = "SELECT * FROM `table_source` WHERE `table_source`.`id` != $id ORDER BY id  ";
        $query_source = mysqli_query($result, $sql_source);
        while ($row_source = mysqli_fetch_array($query_source)) {
            if ($row_source['code'] === $source_value) {
                $count_source = $count_source + 1;
            }
        }
        if ($count_source > 0) {
            echo "22222";
        }
        else {
            if ($con->query("UPDATE `orders` SET `from_web` = '$source_value' WHERE `orders`.`from_web` = '$source_value' ")) {
                if ($con->query($sql)) {
                    echo '11111';
                }
                else {
                    echo '00000';
                }
            }

        }

    }
    else {

        if ($con->query($sql)) {
            echo '11111+' . $column;
            if ($column === "code") {
                // $sql_orders = "UPDATE `orders
            }
        }
        else {
            echo '00000';
        }
    }


}
else if ($action == "CHECK_SEESION") {
    if (isset($_SESSION['USER_DETAILS'])) {
        echo 1;
    }
    else {
        echo 0;
    }

}
else if ($action == "CloseWindows") {

    if (isset($_SESSION['USER_DETAILS'])) {
        session_write_close();
        $_SESSION['CLOSE_WINDOWS'] = true;
        if (isset($_SESSION['login_details_id'])) {
            $login_details_id = (int)$_SESSION['login_details_id'];
            $sql              = "UPDATE login_details SET last_activity = '$last_activity' WHERE id = $login_details_id";
            $con->query($sql);
        }

    }
    else {
        echo 0;
    }


}
else if ($action == "LogOutUser") {

    $last_activity    = date('Y-m-d H:i:s');
    $login_details_id = (int)$_SESSION['login_details_id'];
    $user_login       = 0;
    $sql              = "UPDATE login_details SET user_login = $user_login WHERE id = $login_details_id";
    $con->query($sql);
    unset($_SESSION['USER_DETAILS']);
    $_SESSION = array();
    session_destroy();
    echo '0';

}
else if ($action == "adduser") {

    $u_name       = $_POST['u_name'];
    $u_job        = $_POST['u_job'];
    $email        = $_POST['email'];
    $u_compony    = (int)$_POST['kind'];
    $phone_number = $_POST['phone_number'];
    $user_name    = $_POST['user_name'];
    $pass         = $_POST['passrword'];
    $pass2        = $_POST['passrword1'];

    $user_photo = "assets/img/placeholder.jpg";

    $stmt1 = $con->prepare("SELECT * FROM users WHERE email = ?");
    $stmt1->execute(array($email));
    $count1 = $stmt1->rowCount();

    $stmt2 = $con->prepare("SELECT * FROM users WHERE user_name = ?");
    $stmt2->execute(array($user_name));
    $count2 = $stmt2->rowCount();
    if ($count1 > 0) {
        echo 'البريد الألكتروني مستخدم من قبل , قم بتغيرة الى بريد اخر';
    }
    else if ($count2 > 0) {
        echo 'الرجاء ادخال إسم مستخدم أخر';
    }
    else {
        if ($pass2 != $pass) {
            echo " كلمة المرور غير متطابقتان , الرجاء التأكد من تأكيد كتابة كلمة المرور ";
        }
        else {
            if (empty($_POST['u_name']) && empty($_POST['u_job']) && empty($_POST['kind']) && empty($_POST['phone_number']) && empty($_POST['email']) && empty($_POST['user_name']) && empty($_POST['passrword']) && empty($_POST['passrword1'])) {
                echo " قم بتعبية الحقول كاملة  ";
            }
            else {
                $num_order = "";
                $query     = "SELECT * FROM users WHERE kind = '2' AND u_compony != 0   ORDER BY num_order ASC LIMIT 1";
                $sql       = mysqli_query($result, $query);
                while ($row = mysqli_fetch_array($sql)) {
                    $num_order = (int)$row["num_order"];
                }
                if ($num_order > 1) {
                    $num_order = $num_order - 1;
                }
                $num_order = (string)$num_order;
                $today     = date("Y - F - j  , g:i a");
                $stmt      = $con->prepare("INSERT INTO users (`u_name`, `user_name`,`num_order`, `email`, `phone_number` ,`kind`,`u_job`, `u_chat`, `u_proplems`, `u_solation`, `u_computer`, `passrword`, `img`, `update_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
                $stmt->execute(array($u_name, $user_name, $num_order, $email, $phone_number, $u_compony, $u_job, 0, 0, 0, 0, $pass2, 1, $today));
                if ($stmt) {
                    echo '111111';
                }
                else {
                    echo '00000';
                }
            }
        }
    }
}
else if ($action == "delet_account") {
    $sql = "DELETE FROM users WHERE u_id =$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "update_u_whatsapp") {
    $sql = "UPDATE users SET can_get_whatsapp=$value1 WHERE u_id=$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "change_u_cumpany") {
    $u_compony = (int)$value1;
    $sql       = "UPDATE users SET u_compony = $u_compony WHERE u_id=$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "update_u_stop") {
    $sql = "UPDATE users SET u_proplems=$value1 WHERE u_id=$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "add_employ_order") {
    $name_customer = $_POST['value'];
    $emp_phone     = $_POST['value1'];
    $msg           = "لا توجد رسالة";
    $disc_order    = $_POST['note'];
    // $emp_id = str_replace(" ", "", $_SESSION['USER_DETAILS']['u_id']);
    $emp_name     = $_SESSION['USER_DETAILS']['u_name'];
    $from_web     = $_POST['source'];
    $emp_id       = str_replace(" ", "", $_POST['emp_id']);
    $date_update  = "2050-10-25 07:54:46";
    $stars        = "1";
    $status_order = "1";
    $no           = "1";
    $deleted      = "0";
    $today        = date('Y-m-d H:i:s');

    $stmt_phone = $con->prepare("SELECT * from orders where phone_number = ? ");
    $stmt_phone->execute(array($emp_phone));
    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get         = $stmt_phone->fetch();
        $emp_phone11 = $get['phone_number'];
        $emp_name11  = $get['emp_name'];
        $cus_name11  = $get['name_customer'];
        $msg1        = "إن رقم الجوال ( ";
        $msg2        = ") مسجل لدى الموظف/ـه ( ";
        $msg3        = ")";
        $msg4        = "بإسم العميل (";
        $msg         = $msg1 . $emp_phone11 . $msg2 . $emp_name11 . $msg3 . $msg4 . $cus_name11 . $msg3;
        echo $msg;
    }
    else {
        if ($emp_id == "") {
            echo $emp_id;
            echo "يرجى تسجيل الدخول من جديد على النظام للتحقق من هوية الدخول !";
        }
        else {
            $stmt = $con->prepare("INSERT INTO orders (`name_customer`,`phone_number`,`msg`,`emp_id`,`emp_name`,`disc_order`,`stars`,`status_order`,`no`,`from_web`,`deleted`,`data_add`,`data_update`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->execute(array($name_customer, $emp_phone, $msg, $emp_id, $emp_name, $disc_order, $stars, $status_order, $no, $from_web, $deleted, $today, $date_update));
            if ($stmt) {
                echo '11111';
            }
            else {
                echo "00000";
            }
        }
    }
}
else if ($action == "SaveUserImage") {
    $fileTmpName = $_FILES['userImage']['tmp_name'];
    $user_id     = (int)$_POST['value'];

    // Enable error reporting for better debugging
    ini_set('display_errors', 'On');
    error_reporting(E_ALL);

    if ($_FILES['userImage']['error'] === UPLOAD_ERR_OK) {
        // Open the file using fopen with 'rb' mode to read binary data
        $fileHandler = fopen($fileTmpName, 'rb');

        if ($fileHandler !== false) {

            $thumbed = base64_encode(fread($fileHandler, filesize($fileTmpName)));
            // fclose($fileHandler);

            if ($thumbed !== false) {

                $sql  = "UPDATE `users` SET `img` = :thumbed WHERE `u_id` = :user_id";
                $stmt = $con->prepare($sql);
                $stmt->bindParam(':thumbed', $thumbed);
                $stmt->bindParam(':user_id', $user_id);
                if ($stmt->execute()) {
                    echo 'Update successful.';

                    if ((int)$_SESSION['USER_DETAILS']['u_id'] == $user_id) {
                        $_SESSION['USER_DETAILS']['img'] = $thumbed;
                    }
                }
                else {
                    print_r($stmt->errorInfo());
                    echo 'Update failed.';
                }
            }
            else {
                echo 'Error reading the file content.';
            }
        }
        else {
            echo 'Failed to open the file.';
        }
    }
    else {
        echo 'File upload error: ' . $_FILES['userImage']['error'];
    }


}
else if ($action == "UpdateUserSetting") {
    $user_id    = $value;
    $is_checked = $value1 === 'true' ? 1 : 0;
    $type_event = $_POST['value2'];
    $scr        = '';

    if ($type_event == 'enable_account') {
        $scr = " `u_proplems` = '$is_checked' ";
    }
    else if ($type_event == 'enable_whatsapp') {
        $scr = " `can_get_whatsapp` = '$is_checked' ";
    }
    else if ($type_event == 'enable_recive_order') {
        $scr = " `u_compony` = '$is_checked' ";
    }
    else {
        return false;
    }
    if ($scr != '') {
        $sql_update = "UPDATE `users` SET $scr WHERE `users`.`u_id` = $user_id;";
        if ($con->query($sql_update)) {
            echo "11111";
        }
        else {
            echo "00000";
        }
    }

}
else if ($action == "GETDETALESDILOGE") {
    $emp_id      = (int)$value;
    $type_diloag = $value1;
    $start_date  = date($_POST['value2']);
    $end_date    = date($_POST['value3']);
    $html        = '';

    if ($type_diloag == "show_times") {
        $html           .= '
			<div class="main_time">
				<table class="table">
					<thead>
						<tr>
							<th scope="col">#</th>
							<th scope="col">تاريخ الدخول</th>
							<th scope="col">تاريخ أخر تفاعل</th> 
						</tr>
					</thead> 
					<tbody>';
        $sql_all_time   = "SELECT * FROM `login_details` WHERE `login_details`.`emp_id` = $emp_id AND `login_details`.`login_at` BETWEEN '$start_date' AND '$end_date' ORDER BY id DESC ;";
        $query_all_time = mysqli_query($result, $sql_all_time);
        $index          = 1;
        while ($row_time = mysqli_fetch_array($query_all_time)) {
            $last_activity   = '';
            $login_at        = new DateTime($row_time['login_at']);
            $login_formatted = str_replace(['AM', 'PM'], ['صباحًا', 'مساءً'], $login_at->format('Y-m-d h:i:s A'));


            if ($row_time['last_activity'] == "") {
                $last_activity = 'لا يوجد تسجيل لأخر تفاعل';
            }
            else {
                $activate_at   = new DateTime($row_time['last_activity']);
                $last_activity = str_replace(['AM', 'PM'], ['صباحًا', 'مساءً'], $activate_at->format('Y-m-d h:i:s A'));
            }

            $html  .= '
							<tr>
								<th scope="row">' . $index . '</th>
								<td style="direction: ltr;">' . $login_formatted . '</td>
								<td style="direction: ltr;">' . $last_activity . '</td> 
							</tr>	
						';
            $index = $index + 1;
        }
        $html .= '</tbody>
				</table>
				</div> 
			';
    }
    else if ($type_diloag == "show_history") {


        $html         .= '
		<div class="main_time">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th>
						<th scope="col">نوع الحدث</th>
						<th scope="col">القيمة القديمة</th> 
						<th scope="col">القيمة الجديده</th> 
						<th scope="col">تاريخ الحدث</th>  
					</tr>
				</thead> 
				<tbody>';
        $index_orders = 0;
        $sql_orders   = "SELECT * FROM `orders` WHERE `orders`.`emp_id` = '$emp_id'  ORDER BY `id` ASC";
        $query_orders = mysqli_query($result, $sql_orders);
        while ($row_order = mysqli_fetch_array($query_orders)) {

            $order_id = (int)$row_order['id'];

            $sql_history   = "SELECT * FROM `table_order_history` WHERE `table_order_history`.`order_id` = '$order_id' AND `table_order_history`.`date_add` BETWEEN '$start_date' AND '$end_date' ORDER BY `id` DESC";
            $query_history = mysqli_query($result, $sql_history);
            while ($row_history = mysqli_fetch_array($query_history)) {
                $index_orders += 1;
                $html         .= '
							<tr>
								<th scope="row">' . $index_orders . '</th>
								<td>';

                $type_update = $row_history['type_update'];

                if ($type_update == "UPDATE_ADD_ALARM_ORDER") {
                    // Code for UPDATE_ADD_ALARM_ORDER
                    $html .= "تحديث في التذكير";
                }
                else if ($type_update == "UPDATE_ESTEMARA_ORDER") {
                    // Code for UPDATE_ESTEMARA_ORDER
                    $html .= "تحديث في ملف العميل";
                }
                else if ($type_update == "UPDATE_DELETE_ORDER") {
                    // Code for UPDATE_DELETE_ORDER
                    $html .= "تم إزالة عميل";
                }
                else if ($type_update == "UPDATE_STATUSE") {
                    // Code for UPDATE_STATUSE
                    $html .= "تحديث في حالة العميل";
                }
                else if ($type_update == "UPDATE_STARS") {
                    // Code for UPDATE_STARS
                    $html .= "تحديث امكانية خدمة العميل";
                }
                else if ($type_update == "UPDATE_POSSIBLE") {
                    // Code for UPDATE_POSSIBLE
                    $html .= "تحديث توقع الموظف للعميل";
                }
                else if ($type_update == "UPDATE_NOTE_POSSIBLE") {
                    // Code for UPDATE_NOTE_POSSIBLE
                    $html .= "تحديث ملاحظات توقع العميل";
                }
                else if ($type_update == "UPDATE_SOURCE") {
                    // Code for UPDATE_SOURCE
                    $html .= "تحديث مصدر العميل";
                }
                else if ($type_update == "UPDATE_MOVE_ORDERS") {
                    // Code for UPDATE_SOURCE
                    $html .= "تحويل عميل بين موظفين";
                }
                else if ($type_update == "UPDATE_STAGE_ORDER") {
                    // Code for UPDATE_STAGE_ORDER
                    $html .= "تحديث في مراحل الطلب";
                }
                else if ($type_update == "UPDATE_NOTE_ORDER") {
                    // Code for UPDATE_NOTE_ORDER
                    $html .= "تحديث ملاحظات الموظف";
                }
                else if ($type_update == "UPDATE_FOVRITE_ORDER") {
                    // Code for UPDATE_FOVRITE_ORDER
                    $html .= "تحديث تفضيل العميل";
                }
                else if ($type_update == "UPDATE_MOTABAA_ORDER") {
                    // Code for UPDATE_MOTABAA_ORDER
                    $html .= "تحديث زر متابعة العميل";
                }
                else {
                    $html .= "تحديث عن العميل";
                }

                // Continue with the rest of your code

                $html .= '</td> 
								<td>';

                $old_value = $row_history['old_value'];

                if ($type_update == "UPDATE_ADD_ALARM_ORDER") {
                    // Code for UPDATE_ADD_ALARM_ORDER
                    $html .= $old_value;
                }
                else if ($type_update == "UPDATE_ESTEMARA_ORDER") {
                    // Code for UPDATE_ESTEMARA_ORDER
                    $html .= $old_value;
                }
                else if ($type_update == "UPDATE_DELETE_ORDER") {
                    // Code for UPDATE_DELETE_ORDER
                    $html .= $old_value;
                }
                else if ($type_update == "UPDATE_STATUSE") {
                    // Code for UPDATE_STATUSE
                    $stmt1 = $con->prepare("SELECT * FROM `table_status` WHERE `table_status`.`id` = ? ");
                    $stmt1->execute(array((int)$old_value));
                    $count1 = $stmt1->rowCount();
                    if ($count1 > 0) {
                        $get1 = $stmt1->fetch();
                        $html .= $get1['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_STARS") {
                    // Code for UPDATE_STARS
                    $stmt2 = $con->prepare("SELECT * FROM `table_stars` WHERE `table_stars`.`id` = ? ");
                    $stmt2->execute(array((int)$old_value));
                    $count2 = $stmt2->rowCount();
                    if ($count2 > 0) {
                        $get2 = $stmt2->fetch();
                        $html .= $get2['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_POSSIBLE") {
                    $stmt3 = $con->prepare("SELECT * FROM `table_serve_customer` WHERE `table_serve_customer`.`id` = ? ");
                    $stmt3->execute(array((int)$old_value));
                    $count3 = $stmt3->rowCount();
                    if ($count3 > 0) {
                        $get3 = $stmt3->fetch();
                        $html .= $get3['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_NOTE_POSSIBLE") {
                    // Code for UPDATE_NOTE_POSSIBLE
                    $html .= $old_value;
                }
                else if ($type_update == "UPDATE_SOURCE") {
                    $stmt4 = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
                    $stmt4->execute(array($old_value));
                    $count4 = $stmt4->rowCount();
                    if ($count4 > 0) {
                        $get4 = $stmt4->fetch();
                        $html .= $get4['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_STAGE_ORDER") {
                    // Code for UPDATE_STAGE_ORDER
                    $stmt5 = $con->prepare("SELECT * FROM `table_stage` WHERE `table_stage`.`id` = ? ");
                    $stmt5->execute(array((int)$old_value));
                    $count5 = $stmt5->rowCount();
                    if ($count5 > 0) {
                        $get4 = $stmt5->fetch();
                        $html .= $get5['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_NOTE_ORDER") {
                    // Code for UPDATE_NOTE_ORDER
                    $html .= $old_value;
                }
                else if ($type_update == "UPDATE_FOVRITE_ORDER") {
                    // Code for UPDATE_FOVRITE_ORDER
                    if ((int)$old_value == 1) {
                        $html .= 'تم الإضافة لصفة التفضيل';
                    }
                    else {
                        $html .= 'تم الإزالة من صفحة التذكير';
                    }

                }
                else if ($type_update == "UPDATE_MOTABAA_ORDER") {
                    if ((int)$old_value == 1) {
                        $html .= 'تم الإضافة لصفة المتابعة';
                    }
                    else {
                        $html .= 'تم الإزالة من صفحة المتابعة';
                    }
                }
                else {
                    $html .= $old_value;
                }

                // Continue with the rest of your code

                $html .= '</td> 
								<td>';

                $new_value = $row_history['new_value'];

                if ($type_update == "UPDATE_ADD_ALARM_ORDER") {
                    // Code for UPDATE_ADD_ALARM_ORDER
                    $html .= $new_value;
                }
                else if ($type_update == "UPDATE_ESTEMARA_ORDER") {
                    // Code for UPDATE_ESTEMARA_ORDER
                    $html .= $new_value;
                }
                else if ($type_update == "UPDATE_DELETE_ORDER") {
                    // Code for UPDATE_DELETE_ORDER
                    $html .= $new_value;
                }
                else if ($type_update == "UPDATE_STATUSE") {
                    // Code for UPDATE_STATUSE
                    $stmt1 = $con->prepare("SELECT * FROM `table_status` WHERE `table_status`.`id` = ? ");
                    $stmt1->execute(array((int)$new_value));
                    $count1 = $stmt1->rowCount();
                    if ($count1 > 0) {
                        $get1 = $stmt1->fetch();
                        $html .= $get1['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_STARS") {
                    // Code for UPDATE_STARS
                    $stmt2 = $con->prepare("SELECT * FROM `table_stars` WHERE `table_stars`.`id` = ? ");
                    $stmt2->execute(array((int)$new_value));
                    $count2 = $stmt2->rowCount();
                    if ($count2 > 0) {
                        $get2 = $stmt2->fetch();
                        $html .= $get2['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_POSSIBLE") {
                    $stmt3 = $con->prepare("SELECT * FROM `table_serve_customer` WHERE `table_serve_customer`.`id` = ? ");
                    $stmt3->execute(array((int)$new_value));
                    $count3 = $stmt3->rowCount();
                    if ($count3 > 0) {
                        $get3 = $stmt3->fetch();
                        $html .= $get3['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_NOTE_POSSIBLE") {
                    // Code for UPDATE_NOTE_POSSIBLE
                    $html .= $new_value;
                }
                else if ($type_update == "UPDATE_SOURCE") {
                    $stmt4 = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
                    $stmt4->execute(array($new_value));
                    $count4 = $stmt4->rowCount();
                    if ($count4 > 0) {
                        $get4 = $stmt4->fetch();
                        $html .= $get4['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_STAGE_ORDER") {
                    // Code for UPDATE_STAGE_ORDER
                    $stmt5 = $con->prepare("SELECT * FROM `table_stage` WHERE `table_stage`.`id` = ? ");
                    $stmt5->execute(array((int)$new_value));
                    $count5 = $stmt5->rowCount();
                    if ($count5 > 0) {
                        $get4 = $stmt5->fetch();
                        $html .= $get5['name'];
                    }
                    else {
                        $html .= 'غير معروف';
                    }
                }
                else if ($type_update == "UPDATE_NOTE_ORDER") {
                    // Code for UPDATE_NOTE_ORDER
                    $html .= $new_value;
                }
                else if ($type_update == "UPDATE_FOVRITE_ORDER") {
                    // Code for UPDATE_FOVRITE_ORDER
                    if ((int)$new_value == 1) {
                        $html .= 'تم الإضافة لصفة التفضيل';
                    }
                    else {
                        $html .= 'تم الإزالة من صفحة التذكير';
                    }

                }
                else if ($type_update == "UPDATE_MOTABAA_ORDER") {
                    if ((int)$new_value == 1) {
                        $html .= 'تم الإضافة لصفة المتابعة';
                    }
                    else {
                        $html .= 'تم الإزالة من صفحة المتابعة';
                    }
                }
                else {
                    $html .= $new_value;
                }

                // Continue with the rest of your code

                $html .= '</td>  
								<td>' . $row_history['date_add'] . '</td>  
							</tr>
						';
            }

        }


        $html .= '</tbody>
		</table>
		</div> ';
    }
    else if ($type_diloag == "show_events") {
        $html            .= '
		<div class="main_time">
			<table class="table">
				<thead>
					<tr>
						<th scope="col">#</th> 
						<th scope="col">معلومات الحدث</th> 
						<th scope="col">تاريخ الحدث</th>  
					</tr>
				</thead> 
				<tbody>';
        $sql_all_event   = "SELECT * FROM `table_events` WHERE `table_events`.`emp_id` = $emp_id AND `table_events`.`date_create` BETWEEN '$start_date' AND '$end_date'  ORDER BY id DESC ;";
        $query_all_event = mysqli_query($result, $sql_all_event);
        $index           = 1;
        while ($row_event = mysqli_fetch_array($query_all_event)) {
            $html  .= '
						<tr>
							<th scope="row">' . $index . '</th> 
							<td>' . $row_event['text'] . '</td> 
							<td>' . $row_event['date_create'] . '</td> 
						</tr>	
					';
            $index = $index + 1;
        }
        $html .= '</tbody>
		</table>
		</div> ';
    }
    echo $html;
}
else if ($action == "UpdateUserAccount") {

    $value       = $_POST['value'];
    $user_id     = $_POST['value1'];
    $empName     = $_POST['empName'];
    $userName    = $_POST['userName'];
    $email       = $_POST['email'];
    $password    = $_POST['password'];
    $kindAccount = (int)$_POST['kindAccount'];
    $phoneNumber = $_POST['phoneNumber'];
    $update_at   = date('Y-m-d H:i:s');

    $stmt_phone = $con->prepare("SELECT * FROM `users` WHERE `users`.`u_id` = ? ");
    $stmt_phone->execute(array((int)$user_id));
    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get   = $stmt_phone->fetch();
        $sql   = "UPDATE `users` SET `kind` = '$kindAccount', `u_name` = '$empName', `user_name` = '$userName', `email` = '$email', `phone_number` = '$phoneNumber', `passrword`= '$password', `update_at` = '$update_at' WHERE `users`.`u_id` = $user_id;";
        $error = $con->query($sql);
        if ($con->query($sql)) {
            echo '11111';
        }
        else {
            echo '00000';
        }
    }
    else {
        echo '22222';
    }


}
else if ($action == "GETUSERFORM") {
    $user_id    = (int)$value;
    $html       = '';
    $stmt_phone = $con->prepare("SELECT * FROM `users` WHERE `users`.`u_id` = ? ");
    $stmt_phone->execute(array((int)$user_id));
    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get  = $stmt_phone->fetch();
        $html .= '
			<input type="hidden" class="user_id" value="' . $get['u_id'] . '"/>
			<div class="form-group">
				<label for="exampleInputEmail1">اسم الحساب</label>
				<input type="text" value="' . $get['u_name'] . '" class="form-control emp_name" placeholder="أدخل إسم الحساب">
				<small class="form-text text-muted"></small>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">اسم المستخدم</label>
				<input type="email" class="form-control username"  value="' . $get['user_name'] . '"  placeholder="إسم المستخدم">
				<small class="form-text text-muted"></small>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">رقم الجوال</label>
				<input type="email" class="form-control phone_number"  value="' . $get['phone_number'] . '"  placeholder="05123456789">
				<small class="form-text text-muted"></small>
			</div>
			
			<div class="form-group">
				<label for="exampleInputEmail1">البريد الإلكتروني</label>
				<input type="email" class="form-control email"  value="' . $get['email'] . '"  aria-describedby="emailHelp" placeholder="Enter email">
				<small class="form-text text-muted"></small>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">كلمة المرور</label>
				<input type="email" class="form-control password"  value="' . $get['passrword'] . '"  aria-describedby="emailHelp" placeholder="Enter email">
				<small class="form-text text-muted"></small>
			</div>
			<div class="form-group">
				<label for="exampleInputEmail1">نوع الحساب</label>
				<select class="form-control kind_account">
					<option value="0"';
        if ((int)$get['kind'] == 0) {
            $html .= ' selected';
        }
        $html .= '>مدير</option>
					<option value="2" ';
        if ((int)$get['kind'] == 2) {
            $html .= ' selected';
        }
        $html .= '>موظف</option>
				</select> 
				<small class="form-text text-muted"></small>
			</div>
		';
    }
    else {
        $html .= 'لا توجد بيانات';
    }
    echo $html;

}
else if ($action == "AddUserAccount") {

    $value       = $_POST['value'];
    $user_id     = $_POST['value1'];
    $empName     = $_POST['empName'];
    $userName    = $_POST['userName'];
    $email       = $_POST['email'];
    $password    = $_POST['password'];
    $kindAccount = (int)$_POST['kindAccount'];
    $phoneNumber = $_POST['phoneNumber'];
    $today       = date('Y-m-d H:i:s');
    $num_order   = 0;

    $stmt = $con->prepare("INSERT INTO users (`u_name`, `user_name`,`num_order`, `email`, `phone_number` ,`kind`, `u_chat`, `u_proplems`, `u_solation`, `u_computer`, `passrword`, `update_at`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    $stmt->execute(array($empName, $userName, $num_order, $email, $phoneNumber, $kindAccount, 0, 0, 0, 0, $password, $today));
    if ($stmt) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "GetUsersDetals") {
    $start_date = date($value);
    $end_date   = date($value1);
    $html       = '';

    $sql_all_user   = "SELECT * FROM `users`";
    $query_all_user = mysqli_query($result, $sql_all_user);
    while ($row_all_users = mysqli_fetch_array($query_all_user)) {
        $emp_id = $row_all_users['u_id'];

        $sql_all_time   = "SELECT * FROM login_details WHERE login_details.emp_id = $emp_id AND login_details.login_at BETWEEN '$start_date' AND '$end_date' ORDER BY `id` ASC ;";
        $query_all_time = mysqli_query($result, $sql_all_time);
        $is_login       = 0;

        $total_minutes = 0;
        $minutes       = 0;

        while ($row_time = mysqli_fetch_array($query_all_time)) {
            $is_login      = (int)$row_time['user_login'];
            $last_activity = $row_time['last_activity'];
            $minutes       = 0;

            if ($last_activity != '') {
                $given_date   = new DateTime($last_activity);
                $current_date = new DateTime();
                $interval     = $current_date->diff($given_date);

                // Calculate the total number of minutes in the difference
                $minutes = ($interval->days * 24 * 60) + ($interval->h * 60) + $interval->i;

                $date_start    = new DateTime($row_time['login_at']);
                $date_end      = new DateTime($row_time['last_activity']);
                $all_interval  = $date_start->diff($date_end);
                $total_minutes += ($all_interval->days * 24 * 60) + ($all_interval->h * 60) + $all_interval->i;

            }
            else {
                $minutes = 10;
            }

        }

        // Check if the total time elapsed since last activity is greater than 1 minute
        if ($minutes > 40) {
            $is_login = 0;
        }

        $result_history = getOrderHistoryCount($con, $result, $emp_id, $start_date, $end_date);

        $divClass = ''; // Initialize variable to store the div class
        if ($is_login == 1) {
            $divClass = 'login_in';
        }
        else {
            $divClass = 'login_off';
        }

        $img = '';
        if ($row_all_users['img'] != '1') {
            $img = 'data:image/jpeg;base64,' . trim($row_all_users['img'], "'");
        }
        else {
            $img = IMG_USERS;
        }

        $html .= '
			<div class="user_card" user_id = "' . $emp_id . '">
				<div class="banner">
					<input type="hidden" class="user_id" value="' . $row_all_users['u_id'] . '"/>
					<input type="file" class="fileInput" style="display: none;">
					<div class="main_image">
						<img class="changeImageUsers" src="' . $img . '"/>
						<div class="' . $divClass . '"></div>
					</div>
				</div>
				<div class="menu">
					<div class="opener deleteemployee" id =' . $emp_id . '>
						<i class="fa fa-trash-o"></i>
					</div>
				</div>
				<h2 class="name">' . $row_all_users["u_name"] . '</h2>';
        $html .= '<div class="main_jop">';
        if ($row_all_users["kind"] == "0") {
            $html .= '<h5 class="card_admin">مدير</h5>';
        }
        else if ($row_all_users["kind"] == "2") {
            $html .= '<h5 class="card_employee">موظف</h5>';
        }
        $html .= '</div>';
        $html .= '<div class="main_title">
					<div class="title">' . $row_all_users['user_name'] . '</div>
					<div style="width:10px;"></div>
					<div class="title">' . $row_all_users['phone_number'] . '</div>
				</div>
				

				<div class="seeting_users">

				<div class="checkbox-wrapper" user_id="' . $row_all_users['u_id'] . '">
					<span>الحساب</span>
					<input class="change_checkbox_user" type_event="enable_account" id="_checkbox1-' . $row_all_users['u_id'] . '" type="checkbox"';
        if ($row_all_users['u_proplems'] === "1") {
            $html .= ' checked="true"';
        }
        $html .= '>
					<label for="_checkbox1-' . $row_all_users['u_id'] . '">
						<div class="tick_mark"></div>
					</label>
				</div>
				
				<div class="checkbox-wrapper"  user_id="' . $row_all_users['u_id'] . '">
					<span>الواتس اب</span>
					<input class="change_checkbox_user" type_event="enable_whatsapp" id="_checkbox2-' . $row_all_users['u_id'] . '" type="checkbox" ';
        if ($row_all_users['can_get_whatsapp'] === "1") {
            $html .= ' checked="true"';
        }
        $html .= '>
					<label for="_checkbox2-' . $row_all_users['u_id'] . '">
						<div class="tick_mark"></div>
					</label>
				</div>
				
				<div class="checkbox-wrapper"  user_id="' . $row_all_users['u_id'] . '">
					<span>تسجيل</span>
					<input class="change_checkbox_user" type_event="enable_recive_order" id="_checkbox3-' . $row_all_users['u_id'] . '" type="checkbox" ';
        if ($row_all_users['u_compony'] === "1") {
            $html .= ' checked="true"';
        }
        $html    .= '>
					<label for="_checkbox3-' . $row_all_users['u_id'] . '">
						<div class="tick_mark"></div>
					</label>
				</div>
				

				</div>

				<div class="actions">
					<div class="follow-info">

						<h2>	
							<a class="show_diloge_details" title="جميع الأحداث على النظام" type_diloage="show_events" data-toggle="modal" data-target="#show_diloge_details">
								<span>';
        $html    .= getEventsCount($con, $row_all_users["u_id"], $start_date, $end_date);
        $html    .= '
								</span>
								<small>إجمالي الأحداث</small>
							</a>
						</h2>

						<h2>
							<a class="show_diloge_details" title="جميع هيستري الطلبات" type_diloage="show_history" data-toggle="modal" data-target="#show_diloge_details"><span>';
        $html    .= $result_history["number_history"];
        $html    .= '</span><small>اجمالي هيستري الطلبات</small></a>
						</h2>

						<h2 time="' . $total_minutes . '">
							<a class="show_diloge_details" title="ساعات العمل بناءً على تسجيلات الدخول" type_diloage="show_times" data-toggle="modal" data-target="#show_diloge_details"><span>';
        $hours   = floor($total_minutes / 60);
        $minutes = $total_minutes % 60;
        $html    .= '' . $hours . ':' . $minutes;
        $html    .= '</span>
							<small>عدد ساعات العمل</small></a>
						</h2>

						<h2>
							<a href="#"><span>';
        $html    .= $result_history["num_orders"];
        $html    .= '</span><small>عدد الطلبات</small></a>
						</h2>

					</div>
					<div class="follow-btn">
						<button class="edit_user_dateails" user_id ="' . $emp_id . '" data-toggle="modal" data-target="#show_edit_details">تعديل البيانات</button>
					</div>
				</div>
			</div>
		';
    }

    echo $html;
    exit();

}
else if ($action == "GetUsers") {
    $qu1   = "SELECT * FROM users ORDER BY kind ASC";
    $sql   = mysqli_query($result, $qu1);
    $index = 1;
    while ($row = mysqli_fetch_array($sql)) {
        echo '<tr>';
        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $index . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $row["u_name"] . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $row["email"] . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $row["phone_number"] . '</p></td>';

        if ($row["kind"] == "0") {
            echo '<td id="' . $row["u_id"] . '"  class="mailbox-name" style="color:green;font-weight: bolder;font-size: 20px;">
<p style="background-color: rgb(217 83 79); padding: 5px; color: white; border-radius: 10px;">مدير</p>
</td>';
        }
        else if ($row["kind"] == "1") {
            echo '<td id="' . $row["u_id"] . '"  class="mailbox-name" style="color:#80003 ;">
<p style=" background-color: #4f5cd95e; padding: 5px; color: white; border-radius: 10px;">مسوق</p>
</td>';
        }
        else if ($row["kind"] == "2") {
            echo '<td id="' . $row["u_id"] . '"  class="mailbox-name" style="color: green;font-weight: bolder;font-size: 20px;">
<p style="background-color: rgb(6 6 6);; padding: 5px; color: white; border-radius: 10px;">موظف</p>
</td>';
        }

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $row["user_name"] . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>' . $row["passrword"] . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name" style="direction: ltr;"><p>' . $row["update_at"] . '</p></td>';

        echo '<td id="' . $row["u_id"] . '" class="mailbox-name"><p>';
        if ($row["u_id"] == "10") {
            echo 'الإدارة العليا';
        }
        else if ($row["kind"] == "2") {
            $stmt = $con->prepare("SELECT * from `orders` where emp_id = ? ");
            $stmt->execute(array($row["u_id"]));
            echo $stmt->rowCount();
        }
        else {
            echo 'الإدارة';
        }
        echo '</p></td>';

        echo '<td>' . $row["num_order"] . '</td> 

		<td>' . $row["u_whatsapp"] . '</td>';

        if ($row["u_id"] == "10") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة العليا</p>';
            echo '</td>';
        }
        else if ($row["kind"] == "0") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة</p>';
            echo '</td>';
        }
        else {
            if ($row["can_get_whatsapp"] == "1") {
                echo '<td  class="mailbox-name">';
                echo '<button id="' . $row["u_id"] . '" type="0" style="min-width: 77px;max-width: 77px;" type="button" class="btn btn-success update_u_whatsapp">يستقبل</button>';
                echo '</td>';
            }
            else {
                echo '<td  class="mailbox-name">';
                echo '<button id="' . $row["u_id"] . '" type="1" style="min-width: 77px;max-width: 77px;" type="button" class="btn btn-error update_u_whatsapp">لا يستقبل</button>';
                echo '</td>';
            }
        }

        if ($row["u_id"] == "10") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة العليا</p>';
            echo '</td>';
        }
        else if ($row["kind"] == "0") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة</p>';
            echo '</td>';
        }
        else {
            if ((int)$row["u_compony"] === 1) {
                echo '<td  class="mailbox-name">';
                echo '<button id="' . $row["u_id"] . '" type="0" style="min-width: 77px;max-width: 77px;" type="button" class="btn btn-success update_u_compony">يستقبل</button>';
                echo '</td>';
            }
            else {
                echo '<td  class="mailbox-name">';
                echo '<button id="' . $row["u_id"] . '" type="1" style="min-width: 77px;max-width: 77px;" type="button" class="btn btn-error update_u_compony">لا يستقبل</button>';
                echo '</td>';
            }
        }

        if ($row["u_id"] == "10") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة العليا</p>';
            echo '</td>';
        }
        else {
            if ($row["u_proplems"] == "1") {
                echo '<td  class="mailbox-name">';
                echo '<button class="btn btn-success update_u_stop" id="' . $row["u_id"] . '" type="0" style="min-width: 77px;max-width: 77px;" type="button" >شغال</button>';
                echo '</td>';
            }
            else {
                echo '<td  class="mailbox-name">';
                echo '<button class="btn btn-error update_u_stop" id="' . $row["u_id"] . '" type="1" style="min-width: 77px;max-width: 77px;" type="button" >موقف</button>';
                echo '</td>';
            }
        }


        echo '<td  class="mailbox-name">';
        echo '<button id="' . $row["u_id"] . '" type="button" class="btn  btn-edit editeemployee"><i class="fa fa-edit" aria-hidden="true"></i></button>';
        echo '</td>';

        if ($row["u_id"] == "10") {
            echo '<td  class="mailbox-name">';
            echo '<p>الإدارة العليا</p>';
            echo '</td>';
        }
        else {
            echo '<td  class="mailbox-name">';
            echo '<button id="' . $row["u_id"] . '" type="button" class="btn btn-danger deleteemployee"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
            echo '</td>';
        }

        echo '</tr> ';
        $index = $index + 1;
    }
}
else if ($action == "savedatapage") {

    $con->query("update users set users.user_color='" . $_POST['user_color'] . "' where users.u_id=" . $_SESSION['user_id']);
    $con->query("update users set users.sidebar_text_color='" . $_POST['sidebar_text_color'] . "' where users.u_id=" . $_SESSION['user_id']);
    $con->query("update users set users.navbar_color='" . $_POST['navbar_color'] . "' where users.u_id=" . $_SESSION['user_id']);
    $con->query("update users set users.sidebar_color='" . $_POST['sidebar_color'] . "' where users.u_id=" . $_SESSION['user_id']);
    $con->query("update users set users.home_boxes='" . $_POST['home_boxes'] . "' where users.u_id=" . $_SESSION['user_id']);
    $con->query("update users set users.sidebar_hover_color='" . $_POST['sidebar_hover_color'] . "' where users.u_id=" . $_SESSION['user_id']);
    $_SESSION['user_color']          = $_POST['user_color'];
    $_SESSION['sidebar_text_color']  = $_POST['sidebar_text_color'];
    $_SESSION['navbar_color']        = $_POST['navbar_color'];
    $_SESSION['sidebar_color']       = $_POST['sidebar_color'];
    $_SESSION['home_boxes']          = $_POST['home_boxes'];
    $_SESSION['sidebar_hover_color'] = $_POST['sidebar_hover_color'];

    if (empty($value)) {
        echo '11111';
        die();
    }

    $sql = "UPDATE `page` SET $value WHERE `page`.`id` = 1;";
    // echo $sql;
    $error = $con->query($sql);
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "getEmployyes") {

    $qu_movment  = 'SELECT * FROM orders  WHERE emp_id=' . $value . ' AND deleted !=1 ORDER BY data_add DESC';
    $sql_movment = mysqli_query($result, $qu_movment);
    $index       = 0;

    while ($row = mysqli_fetch_array($sql_movment)) {
        $index++;
        echo '
		        <div class="empllay_detals" value_emplloy="' . $row["id"] . '">
                    <label class="checkbox path">
                        <input type="checkbox" class="checkbox">
                        <svg viewBox="0 0 21 21">
                            <path d="M5,10.75 L8.5,14.25 L19.4,2.3 C18.8333333,1.43333333 18.0333333,1 17,1 L4,1 C2.35,1 1,2.35 1,4 L1,17 C1,18.65 2.35,20 4,20 L17,20 C18.65,20 20,18.65 20,17 L20,7.99769186"></path>
                        </svg>
                    </label>
                    <p class="name">' . $row["name_customer"] . '</p>';

        if ($row["stars"] == "1") {
            echo '<p class="p-text starts1">غير مقيم 🤔</p>';
        }
        if ($row["stars"] == "2") {
            echo '<p class="p-text starts2">ضعيف ☹️</p>';
        }
        if ($row["stars"] == "3") {
            echo '<p class="p-text starts3">جيد 🙂</p>';
        }
        if ($row["stars"] == "4") {
            echo '<p class="p-text starts4">ممتاز 🤩</p>';
        }

        if ($row["order_stage"] == "0") {
            echo '<p class="stages order_stages0">غير محدد</p>';
        }
        if ($row["order_stage"] == "1") {
            echo '<p class="stages order_stages1">موافقة مبدئية</p>';
        }
        if ($row["order_stage"] == "2") {
            echo '<p class="stages order_stages2">رفع الأوراق</p>';
        }
        if ($row["order_stage"] == "3") {
            echo '<p class="stages order_stages3">تقيم</p>';
        }
        if ($row["order_stage"] == "4") {
            echo '<p class="stages order_stages4">سداد</p>';
        }
        if ($row["order_stage"] == "5") {
            echo '<p class="stages order_stages5">موافقة نهائية</p>';
        }
        if ($row["order_stage"] == "6") {
            echo '<p class="stages order_stages6">محصل</p>';
        }

        echo '
					<p class="phone">
                        <i class="fa fa-phone"></i> ' . $row["phone_number"] . '
                    </p> 
                </div>
		    ';
    }

    if ($index == 0) {
        echo '
		    <div style="width: 100%; height: 300px; display: flex;align-items: center; justify-content: center;  font-weight: bold;">
		      <p style="font-size: 20px;">لا يوجد طلبات (عملاء) لهذا الموظف</p>
		    </div>
		    ';
    }
}
else if ($action == "ADD_NEW_ALARM") {
    $today      = date('Y-m-d H:i:s');
    $order_id   = $_POST['value'];
    $alarm_date = $_POST['value1'];
    $alarm_note = $_POST['value2'];
    $user_id    = $_SESSION['USER_DETAILS']['u_id'];

    $newValue = "تم إضافة تذكير للعميل تاريخ (" . $alarm_date . ") ذات ملاحظات  (" . $alarm_note . ")";
    add_new_history($order_id, $newValue, 'UPDATE_ADD_ALARM_ORDER');

    $stmt = $con->prepare("INSERT INTO table_alarm (`emp_id`,`alarm_date`,`order_id`,`note`,`date_add`) VALUES (?,?,?,?,?)");
    $stmt->execute(array($user_id, $alarm_date, $order_id, $alarm_note, $today));
    if ($stmt) {
        echo "1";
    }
    else {
        echo "2";
    }

}
else if ($action == "DELETE_ALARM") {
    if (isset($_SESSION['USER_DETAILS']['u_id'])) {
        $user_id = $_SESSION['USER_DETAILS']['u_id'];
        $sql     = "DELETE FROM `table_alarm` WHERE `table_alarm`.`order_id` =$value AND `table_alarm`.`emp_id` =$user_id ";
        $con->query($sql);
        $sql = "DELETE FROM `table_alarm` WHERE `table_alarm`.`id` =$value AND `table_alarm`.`emp_id` =$user_id ";
        if ($con->query($sql)) {
            echo "11111";
        }
        else {
            echo "00000";
        }
    }
    else {
        echo "22222";
    }
}
else if ($action == "GET_ALARM_NOW") {
    if (isset($_SESSION['USER_DETAILS']['u_id'])) {
        $user_id         = $_SESSION['USER_DETAILS']['u_id'];
        $currentDateTime = date('Y-m-d H:i');
        $alarms          = array();

        $query = "SELECT * FROM `table_alarm` WHERE `table_alarm`.`emp_id` = $user_id AND DATE_FORMAT(`alarm_date`, '%Y-%m-%d %H:%i') <= STR_TO_DATE('$currentDateTime', '%Y-%m-%d %H:%i') ORDER BY id ASC";
        $sql   = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($sql)) {
            $stmt_phone = $con->prepare("SELECT * from orders where id = ? ");
            $stmt_phone->execute(array((int)$row['order_id']));
            $count = $stmt_phone->rowCount();
            if ($count > 0) {
                $get       = $stmt_phone->fetch();
                $alarmData = array(
                    "id"       => $row['id'],
                    "date_now" => $currentDateTime,
                    "html"     => '
						<div class="dialoge_alarm alarm' . $row['id'] . '" alarm_id = "' . $row['id'] . '">
							<div class="alarm_header">
								<p>تـــــــــــذكـــــــــــيـــــــــــر</p>
							</div>
							<div class="alarm_body">
								<img src="' . DIR_ASSETS . 'dist/img/alarm.gif">
								<p class="alarm_notes">
									' . $row['alarm_date'] . '
								</p>
								<p class="alarm_notes">
									' . $row['note'] . '
								</p>
								<div class="customer_details">
									<p style="font-size: 15px;">
										<span class="title">اسم العميل:</span>
										<span class="description">' . $get['name_customer'] . '</span>
									</p>
									<p style="font-size: 15px;">
										<span class="title">رقم الجوال:</span>
										<span class="description">' . $get['phone_number'] . '</span>
									</p>
								</div>
							</div>
							<div class="alarm_footer">
								<a href="https://wa.me/+966' . ltrim($get['phone_number'], '0') . '" target="_blank" class="btn-alarm" style="background-color: #00a65a;">
									<i class="fa fa-whatsapp"></i>
								</a>
								<a class="btn-alarm alarm_show_tabs" id=' . $get['id'] . ' style="background-color: #337ab7;">
									<i class="fa fa-edit"></i>
								</a>
								<a class="btn-alarm change_notification" id="2899" style="background-color: #f39c12;">
									<i class="fa fa-clock-o" aria-hidden="true"></i>
								</a>
								<a class="btn-alarm delete_alarm" style="background-color: #dd4b39;">
									<i class="fa fa-close"></i>
								</a>
							</div>
						</div>
					',
                );
            }
            array_push($alarms, $alarmData);
        }

        // Encode the array as JSON
        echo json_encode($alarms);
    }
    else {
        // Handle the case when the user is not authenticated
        echo json_encode(array("error" => "User not authenticated"));
    }
}
else if ($action == "UPDATE_DATE_ALARM") {

    $alarm_id   = (int)$value;
    $stmt_alarm = $con->prepare("SELECT * from `table_alarm` where `table_alarm`.`id` = ? ");
    $stmt_alarm->execute(array($alarm_id));
    $count = $stmt_alarm->rowCount();
    if ($count > 0) {
        $get             = $stmt_alarm->fetch();
        $currentDatetime = new DateTime();
        $currentDatetime->add(new DateInterval('PT10M'));
        $modifiedDatetimeString = $currentDatetime->format('Y-m-d H:i');

        $sql_update = "UPDATE `table_alarm` SET `table_alarm`.`alarm_date` = '$modifiedDatetimeString' WHERE `table_alarm`.`id` = $alarm_id;";
        // echo $sql_update;
        if ($con->query($sql_update)) {
            echo "11111";
        }
        else {
            echo '00000';
        }
    }
}
else if ($action == "SAVE_NEW_ELTIZAM") {

    $order_id       = $_POST['value'];
    $cardValuesJSON = $_POST['value1'];

    $cardValues = json_decode($cardValuesJSON, true);
    if (!empty($cardValues)) {
        $sql = "DELETE FROM `table_eltzam` WHERE `table_eltzam`.`order_id` =$order_id";
        if ($con->query($sql)) {
            $stmt_eltzam = $con->prepare("INSERT INTO table_eltzam (`order_id`, `kind_eltezam`, `cast`, `total_eltizam`, `note`, `date_add`) VALUES (?, ?, ?, ?, ?, NOW())");
            foreach ($cardValues as $cardData) {
                $order_id      = $_POST['value'];
                $kind_eltezam  = $cardData['jehaht_eltizam'];
                $cast          = $cardData['cast'];
                $total_eltizam = $cardData['total_eltizam'];
                $note          = $cardData['note'];

                $stmt_eltzam->execute(array($order_id, $kind_eltezam, $cast, $total_eltizam, $note));
            }
        }
    }
}
else if ($action == "editeorderdetailse") {
    $cusom_number         = (int)$_POST['value'];
    $cusom_name           = $_POST['value1'];
    $cusom_starts         = $_POST['value2'];
    $cusom_statues        = $_POST['value3'];
    $cusom_description    = $_POST['value4'];
    $number_owner         = $_POST['value5'];
    $kind_aqar            = $_POST['value6'];
    $city                 = $_POST['value7'];
    $jop                  = $_POST['value8'];
    $salary               = $_POST['value9'];
    $resource_obligations = $_POST['value10'];
    $obligations          = $_POST['value11'];
    $data_birth           = $_POST['value12'];
    $powered              = $_POST['value13'];
    $bank                 = $_POST['value14'];
    $name_owner           = $_POST['value15'];
    $order_notes          = $_POST['value16'];

    $hiring_date                  = $_POST['hiring_date'];
    $military_rank                = $_POST['military_rank'];
    $net_salary                   = $_POST['net_salary'];
    $gross_salary                 = $_POST['gross_salary'];
    $support_premium              = $_POST['support_premium'];
    $remain_money                 = $_POST['remain_money'];
    $state_value                  = $_POST['state_value'];
    $mortgage_lenders_id          = $_POST['mortgage_lenders_id'];
    $construction_completion_rate = $_POST['construction_completion_rate'];
    $state_age                    = $_POST['state_age'];
    $years_left_repay             = $_POST['years_left_repay'];
    $job_title                    = $_POST['job_title'];


    $today             = date('Y-m-d H:i:s');
    $discription_event = 'تسجيل تحديث بيانات الطلب للعميل ' . $cusom_name;
    $stmt_event        = $con->prepare("INSERT INTO site_events (`description`,`data_add`,`line`) VALUES (?,?,?)");
    $stmt_event->execute(array($discription_event, $today, '558'));

    add_new_history($cusom_number, $discription_event, 'UPDATE_ESTEMARA_ORDER');

    $sql_update = "UPDATE `orders` SET  `hiring_date`='$hiring_date', `military_rank`='$military_rank', `net_salary`='$net_salary', `gross_salary`='$gross_salary', `support_premium`='$support_premium', `remain_money`='$remain_money', `state_value`='$state_value', `mortgage_lenders_id`='$mortgage_lenders_id', `construction_completion_rate`='$construction_completion_rate', `state_age`='$state_age', `years_left_repay`='$years_left_repay', `job_title`='$job_title',    `status_order` = '$cusom_statues',`stars` = '$cusom_starts',`order_notes` = '$order_notes',`name_customer` = '$cusom_name',`disc_order` = '$cusom_description',`number_owner` = '$number_owner',`name_owner` = '$name_owner',`kind_aqar` = '$kind_aqar',`city` = '$city',`jop` = '$jop',`salary` = '$salary',`resource_obligations` = '$resource_obligations',`obligations` = '$obligations',`data_birth` = '$data_birth',`powered` = '$powered',`bank` = '$bank',`data_update` = '$today' WHERE `orders`.`id` = $cusom_number;";
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo '00000';
    }

}
else if ($action == "editeustomerdetailse") {

    $cusom_name     = $_POST['value'];
    $cusom_phone    = $_POST['value1'];
    $cusom_email    = $_POST['value2'];
    $cusom_username = $_POST['value3'];
    $cusom_password = $_POST['value4'];
    $cusom_id       = (int)$_POST['value5'];

    $today             = date('Y-m-d H:i:s');
    $discription_event = 'تسجيل تحديث على بيانات الموظف ' . $cusom_name;
    $stmt_event        = $con->prepare("INSERT INTO site_events (`description`,`data_add`,`line`) VALUES (?,?,?)");
    $stmt_event->execute(array($discription_event, $today, '558'));

    $sql_update = "UPDATE `users` SET `u_name` = '$cusom_name',`phone_number` = '$cusom_phone',`email` = '$cusom_email',`user_name` = '$cusom_username',`passrword` = '$cusom_password' WHERE `users`.`u_id` = $cusom_id;";
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo '00000';
    }
}
else if ($action == "DeleteMessages") {

    $message_id          = $value;
    $stmt_delete_message = "DELETE FROM `department` WHERE `department`.`id` = $message_id  ";
    $result              = $con->query($stmt_delete_message);

}
else if ($action == "GetMessages") {

    $user_id  = (int)$_SESSION['USER_DETAILS']['u_id'];
    $html     = '';
    $can_show = 0;

    $html .= '<li class="header" style="direction:rtl;text-align: center; border:none !important;">الرسائل</li>';

    $query = "SELECT 
                                department.date_add,
                                orders.emp_name,
                                orders.id as  order_id,
                                orders.name_customer
                            from `department`
                                inner join orders on orders.id = department.order_id
                                inner join users on users.u_id = department.emp_id
                                WHERE `department`.`can_show` != $can_show  AND `department`.`emp_id` = $user_id ORDER BY department.date_add DESC ;";


    $result_department = mysqli_query($result, $query);
    $de_index          = 0;
    while ($row = mysqli_fetch_array($result_department)) {
        $de_index = $de_index + 1;
        $html     .= '
			<li class="header informationadmin" style="direction:rtl;text-align: center;" message_id="' . $row["order_id"] . '">
				<p onclick=window.location.href="/crm/admin/page/all_customer?order_id=' . $row['order_id'] . '" >
                        <a href="/crm/admin/page/all_customer?order_id=' . $row['order_id'] . '">  رقم الطلب : ' . $row['order_id'] . ' </a>  <br>
                        <span>  الموظف : ' . $row['emp_name'] . ' </span>  <br>
                        <span>  العميل : ' . $row['name_customer'] . ' </span>       <br>       
				        <span style="background-color:#d2b964; padding:5px">  تاريخ الرسالة' . $row['date_add'] . '</span>
				</p>
				<i id="' . $row["id"] . '" class="fa fa-close deletedepartment"></i>
			</li>
		';
    }
    if ($de_index == 0) {
        $html .= '
			<li class="no_message_chate">
				<i class="fa fa-weixin" aria-hidden="true"></i>
				<p>لا توجد رسائل</p>
			</li>
		';
    }
    $html .= ' <li class="footer"><a href="#">انقر على الرسالة للذهاب إلى المصدر</a></li>';


    echo $html;

}
else if ($action == "getDeatilsUsers") {
    $stmt_phone = $con->prepare("SELECT * from users where u_id = ? ");
    $stmt_phone->execute(array($value));
    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get = $stmt_phone->fetch();
        echo ' 
        <div class="row">
            <input value="' . $get['u_id'] . '" id="custom_id" style="display:none" />
            <div class="form-group col-md-3">
				<label for="inputEmail4">إسم الموظف</label>
				<input type="text" class="form-control" value="' . $get['u_name'] . '" id="cusom_name" placeholder="اسم الموظف">
            </div> 
            <div class="form-group col-md-3">
				<label for="inputEmail4">رقم الجوال</label>
				<input type="number" class="form-control" value="' . $get['phone_number'] . '" id="cusom_phone" placeholder="رقم الجوال">
            </div> 
            <div class="form-group col-md-3">
				<label for="inputEmail4">البريد الإلكتروني</label>
				<input type="email" class="form-control" value="' . $get['email'] . '" id="cusom_email" placeholder="البريد الإلكتروني">
            </div>
            <div class="form-group col-md-3">
				<label for="inputEmail4">اسم المستخدم</label>
				<input type="text" class="form-control" value="' . $get['user_name'] . '" id="cusom_username"  placeholder="اسم المستخدم">
            </div> 
        </div>  
        <div class="row">  
            <div class="form-group col-md-3">
				<label for="inputEmail4">كلمة المرور</label>
				<input type="text" class="form-control" value="' . $get['passrword'] . '" id="cusom_password" placeholder="كلمة المرور">
            </div>    
        </div>  ';
    }
}
else if ($action == "change_accept_order") {
    $order_id  = $_POST['value'];
    $accept_id = $_POST['value1'];
    $accept    = 2;
    $upload    = 1;

    $sql_update_order = "UPDATE `order_msg` SET `have_accept` = '$accept' WHERE `order_msg`.`id` = $accept_id;";
    if ($con->query($sql_update_order)) {
        echo "11";
        $sql_update_accept = "UPDATE `orders` SET `upload_order` = '$upload' WHERE `orders`.`id` = $order_id;";
        if ($con->query($sql_update_accept)) {
            echo "111";
        }
        else {
            echo '00000';
        }
    }
    else {
        echo '00000';
    }
}
else if ($action == "cancel_accept_order") {
    $order_id  = $_POST['value'];
    $accept_id = $_POST['value1'];
    $accept    = 3;
    $upload    = 0;

    $sql_update_order = "UPDATE `order_msg` SET `have_accept` = '$accept' WHERE `order_msg`.`id` = $accept_id;";
    if ($con->query($sql_update_order)) {
        echo "11";
        $sql_update_accept = "UPDATE `orders` SET `upload_order` = '$upload' WHERE `orders`.`id` = $order_id;";
        if ($con->query($sql_update_accept)) {
            echo "111";
        }
        else {
            echo '00000';
        }
    }
    else {
        echo '00000';
    }
}
else if ($action == "change_rejection_order") {
    $order_id  = $_POST['value'];
    $accept_id = $_POST['value1'];
    $accept    = 4;
    $upload    = 0;

    $sql_update_order = "UPDATE `order_msg` SET `have_accept` = '$accept' WHERE `order_msg`.`id` = $accept_id;";
    if ($con->query($sql_update_order)) {
        echo "11";
        $sql_update_accept = "UPDATE `orders` SET `upload_order` = '$upload' WHERE `orders`.`id` = $order_id;";
        if ($con->query($sql_update_accept)) {
            echo "111";
        }
        else {
            echo '00000';
        }
    }
    else {
        echo '00000';
    }
}
else if ($action == "getDeatilsOrder") {
    $table_source     = array();
    $table_evaluation = array();
    $table_status     = array();
    $table_kind_aqar  = array();
    $table_banks      = array();
    $table_banks_v2      = array();
    $table_citys      = array();
    $table_eltizam    = array();

    $query1 = "SELECT * FROM `table_source` ORDER BY id ASC";
    $sql1   = mysqli_query($result, $query1);
    while ($rows1 = mysqli_fetch_array($sql1)) {
        $table_source[] = $rows1;
    }

    $query2 = "SELECT * FROM `table_evaluation` ORDER BY id ASC";
    $sql2   = mysqli_query($result, $query2);
    while ($rows2 = mysqli_fetch_array($sql2)) {
        $table_evaluation[] = $rows2;
    }

    $query3 = "SELECT * FROM `table_status` ORDER BY id ASC";
    $sql3   = mysqli_query($result, $query3);
    while ($rows3 = mysqli_fetch_array($sql3)) {
        $table_status[] = $rows3;
    }

    $query4 = "SELECT * FROM `table_kind_aqar` ORDER BY id ASC";
    $sql4   = mysqli_query($result, $query4);
    while ($rows4 = mysqli_fetch_array($sql4)) {
        $table_kind_aqar[] = $rows4;
    }

    $query5 = "SELECT * FROM `table_banks` ORDER BY id ASC";
    $sql5   = mysqli_query($result, $query5);
    while ($rows5 = mysqli_fetch_array($sql5)) {
        $table_banks[] = $rows5;
    }


    $query5 = "SELECT * FROM `table_banks` ORDER BY id ASC";
    $sql5   = mysqli_query($result, $query5);
    while ($rows5 = mysqli_fetch_array($sql5)) {
        $table_banks_v2[] = $rows5;
    }

    $query6 = "SELECT * FROM `city` ORDER BY id ASC";
    $sql6   = mysqli_query($result, $query6);
    while ($rows6 = mysqli_fetch_array($sql6)) {
        $table_citys[] = $rows6;
    }

    $query7 = "SELECT * FROM `table_jehah` ORDER BY id ASC";
    $sql7   = mysqli_query($result, $query7);
    while ($rows7 = mysqli_fetch_array($sql7)) {
        $table_eltizam[] = $rows7;
    }


    $html_eltizam = '';
    $query8       = "SELECT * FROM `table_eltzam`  WHERE `table_eltzam`.`order_id` = $value ORDER BY id ASC";
    $sql8         = mysqli_query($result, $query8);
    while ($rows8 = mysqli_fetch_array($sql8)) {
        $html_eltizam .= '
			<div class="card main_eltizam"> 
				<div class="col-md-12"> 
				<input type="text" class="form-control kind_jehah" value="' . $rows8['kind_eltezam'] . '" placeholder="جهة الإلتزام">
				</div>

				<div class="col-md-12"> 
					<input type="number" class="form-control cast" value="' . $rows8['cast'] . '" placeholder="أدخل القسط">
				</div> 

				<div class="col-md-12"> 
					<input type="number" class="form-control total_eltizam" value="' . $rows8['total_eltizam'] . '" placeholder="ادخل اجمالي الإلتزامات">
				</div> 

				<div class="col-md-12"> 
					<textarea type="text" class="form-control note" placeholder="ملاحظات">' . $rows8['note'] . '</textarea>
				</div>  
				<div class="col-md-12" style="display: flex;"> 
					<button type="button" class="btn btn-error delete-eltizam"><i class="fa fa-pencil-square-o"></i>إزالة</button>
				</div>

			</div>
		';
    }

    $html_new = '
		<div class="card" style="display:none"> 
			<div class="col-md-12"> 
				<input type="text" class="form-control kind_jehah" value="" placeholder="جهة الإلتزام">
			</div>

			<div class="col-md-12"> 
				<input type="number" class="form-control cast" value="" placeholder="أدخل القسط">
			</div> 

			<div class="col-md-12"> 
				<input type="number" class="form-control total_eltizam" value="" placeholder="ادخل اجمالي الإلتزامات">
			</div> 

			<div class="col-md-12"> 
				<textarea type="text" class="form-control note" placeholder="ملاحظات"></textarea>
			</div>  
			<div class="col-md-12" style="display: flex;"> 
				<button type="button" class="btn btn-error delete-eltizam"><i class="fa fa-pencil-square-o"></i>إزالة</button>
			</div> 
		</div>
	';


    $stmt_phone = $con->prepare("SELECT * from orders where id = ? ");
    $stmt_phone->execute(array($value));
    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get = $stmt_phone->fetch();

        $stmt1 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
        $stmt1->execute(array($get["emp_id"]));
        $get1 = $stmt1->fetch();

        $today = date('Y-m-d H:i:s');
        $date1 = strtotime($get["data_update"]);
        $date2 = strtotime($today);
        $diff  = abs($date2 - $date1);

        $id        = 1;
        $stmt_time = $con->prepare("SELECT `text` FROM `news` WHERE `news`.`id` = ? ");
        $stmt_time->execute(array($id));
        $get_time      = $stmt_time->fetch();
        $time_update   = (int)($diff / 3600);
        $time_database = (int)$get_time['text'];

        $time_update = (int)($diff / 3600);


        $stmt_status = $con->prepare("SELECT * from `table_status` where `table_status`.`id` = ? ");
        $stmt_status->execute(array($get['status_order']));
        $get_status = $stmt_status->fetch();


        echo '
        <div class="card">
			<input  type="hidden"  style="display:none" id="order_id" value="' . $get['id'] . '"/>
			<div class="card-header p-2">
				<ul class="nav nav-pills">
					<li class="nav-item active"><a class="nav-link" href="#activity" data-toggle="tab">بيانات الطلب <i class="fa fa-pencil-square-o"></i></a></li> 
					<li class="nav-item"><a class="nav-link order_discussing" href="#upload_order" data-toggle="tab">مناقشة الطلب <i class="fa fa-clock-o"></i></a></li> 
					<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">ملفات العميل<i class="fa fa-folder-open"></i></a></li>
					
				</ul>
			</div>
			
			<div class="card-body">
				<div class="tab-content"> 
					<div class="active tab-pane" id="activity"> 

						<div class="row">

							<div class="form-group col-md-4">
								<label for="inputEmail4">الموظف</label>
								<input style="border: none;box-shadow: none;cursor: no-drop;" type="text" class="form-control" value="' . $get1['u_name'] . '" id="cusom_emp_name" value="" readonly placeholder="اسم الموظف">
							</div> 

							<div class="form-group col-md-4">
								<label for="inputEmail4">ملاحظات العميل</label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . $get['msg'] . '" id="cusom_note" readonly placeholder="ملاحظات العيمل">
							</div> 
							
							<div class="form-group col-md-4">
								<label for="inputEmail4">رقم الجوال</label>
								<input type="phone" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . $get['phone_number'] . '" id="cusom_phone"readonly  placeholder="رقم جوال العميل">
								<a class="chate_whats_app whatsapp_send" data-name="' . $get1['u_name'] . '" data-order="' . $get['id'] . '"  data-phone="' . $get['phone_number'] . '" href="#" >
								<i class="fa fa-whatsapp"></i>
								</a>
							</div> 

							<!-- <div class="form-group col-md-3" style="display: none">
								<label for="inputEmail4">عميل وتس اب </label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . ($get['name_customer'] == "1" ? 'نعم' : 'لا') . '" id="cusom_whatsapp" readonly placeholder="هل العميل وتس اب ">
							</div> 
							
							--> 
							
						</div> 

						<div class="row">
 
						<!--	<div class="form-group col-md-3">
								<label for="inputEmail4">المصدر</label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;"  class="form-control" value="';

        $stmt_source = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
        $stmt_source->execute(array($get["from_web"]));
        $get_source = $stmt_source->fetch();
        if ($kind_emp == 10 || $kind_emp == 0) {
            echo $get_source['name'];
        }
        else {
            echo $get_source['emp_name'];
        }


        echo '" id="cusom_source" readonly placeholder="مصدر العميل">
							</div> -->

							<div class="form-group col-md-4">
								<label for="inputEmail4">رقم الطلب</label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . $get['id'] . '" id="cusom_number" readonly placeholder="رقم الطلب">
							</div> 

							<div class="form-group col-md-4">
								<label for="inputEmail4">تاريخ الادخال</label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . $get['data_add'] . '" id="cusom_date_add" readonly placeholder="تاريخ ادخال الطلب">
							</div> 

							<div class="form-group col-md-4">
								<label for="inputEmail4">تاريخ اخر متابعة</label>
								<input type="text" style="border: none;box-shadow: none;cursor: no-drop;" class="form-control" value="' . know_date($get['data_update'], $time_update, $time_database) . '" id="cusom_date_re" readonly placeholder="تاريخ متابعة الطلب">
							</div>  
							
						</div> 
 
							
						<div class="row">

							<div class="form-group col-md-4">
								<label for="cusom_starts">حالة الطلب</label>
							    <p  id="' . $get['id'] . '" class="show_statuse_dialog reqtangular p-text show_statuse" style="min-height:40px;cursor:pointer;background-color:' . $get_status['color'] . ';">' . $get_status['name'] . '</p>
							</div> ';
        $stmt_stars = $con->prepare("SELECT * from `table_stars` where `table_stars`.`id` = ? ");
        $stmt_stars->execute(array($get['stars']));
        $get_stars = $stmt_stars->fetch();

        $stmt_serve = $con->prepare("SELECT * from `table_serve_customer` where `table_serve_customer`.`id` = ? ");
        $stmt_serve->execute(array($get['serve_customer']));
        $get_serve = $stmt_serve->fetch();

        echo '        <div class="form-group col-md-4">
                                <label for="cusom_starts">تقييم الطلب</label>
                                    <div class="main_td" style="width:100%">
                                          <p 
                                              title="' . $get['statuse_note'] . '"
                                              id="' . $get["id"] . '" 
                                              stars="' . $get['stars'] . '" 
                                              serve_customer="' . $get['serve_customer'] . '" 
                                              statuse_note="' . $get['statuse_note'] . '" 
                                              class="mailbox-name show_stars_diloage" data-toggle="modal" data-target="#show_statuse_dialoge">
                                                <span class="main_p_1_service main_p_1" style="display:flex;justify-content:center;align-items:center;font-size:18px;text-align:center;height:50px; width:50%; background-color:' . $get_serve['color'] . ';" > ' . $get_serve['name'] . ' </span>
                                                <span class="main_p_2_service main_p_2" style="display:flex;justify-content:center;align-items:center;font-size:18px;text-align:center;height:50px; width:50%; background-color:' . $get_stars['color'] . ';" > ' . $get_stars['table_name'] . '</span> 
                                          </p>
                                    </div>
                            </div> 


						 <!--	<div class="form-group col-md-3">
								<label for="cusom_statues">تقييم</label>
								<select id="cusom_statues" class="form-control">';
        foreach ($table_status as $status) {
            $selected = ((int)$get['status_order'] == (int)$status['id']) ? 'selected' : '';
            echo '<option value="' . $status['id'] . '" ' . $selected . '>' . $status['name'] . '</option>';
        }
        echo '
								</select>
							</div> 
                        -->
							<div class="form-group col-md-4">
								<label for="inputEmail4">إسم العميل</label>
								<input type="text" class="form-control" value="' . $get['name_customer'] . '" id="cusom_name" placeholder="اسم العميل">
							</div>  
							
							<div class="form-group col-md-4">
								<label for="inputEmail4">اسم المالك</label>
								<input  type="text" class="form-control"   id="name_owner" value="' . $get['name_owner'] . '" placeholder="اسم المالك">
							</div>
							
						</div> 

						<div class="row">

							<div class="form-group col-md-3">
								<label for="inputEmail4">رقم جوال المالك</label>
								<input  type="text" class="form-control" id="number_owner" value="' . $get['number_owner'] . '" placeholder="رقم جوال المالك">
							</div> 
							
							<div class="form-group col-md-3">
								<label for="cusom_starts">نوع العقار</label>
								<select id="kind_aqar" class="form-control">';
        foreach ($table_kind_aqar as $kind_aqar) {
            $selected = ((int)$get['kind_aqar'] == (int)$kind_aqar['id']) ? 'selected' : '';
            echo '<option value="' . $kind_aqar['id'] . '" ' . $selected . '>' . $kind_aqar['name'] . '</option>';
        }
        echo '
								</select>
							</div> 
							
							<div class="form-group col-md-3">
								<label for="cusom_starts">مدينة العقار</label>
									<select id="city" class="form-control">';
        foreach ($table_citys as $citys) {
            $selected = ((int)$get['status_order'] == (int)$citys['id']) ? 'selected' : '';
            echo '<option value="' . $citys['id'] . '" ' . $selected . '>' . $citys['name'] . '</option>';
        }
        echo '
								</select>
							</div>
							
							<div class="form-group col-md-3">
								<label for="inputEmail4">الوظيفة</label>
								<input  type="text" class="form-control"id="jop" value="' . $get['jop'] . '" placeholder="وظيفة العميل">
							</div>
							
						</div>
							
						<div class="row">  
							<div class="form-group col-md-3">
								<label for="inputEmail4">الراتب</label>
								<input   type="text" class="form-control" id="salary" value="' . $get['salary'] . '" placeholder="راتب العميل">
							</div>
								
							<div class="form-group col-md-3">
								<label for="inputEmail4">تاريخ الميلاد</label>
								<input   type="date" class="form-control"  id="data_birth" value="' . $get['data_birth'] . '" placeholder="تاريخ ميلاد العميل">
							</div>
				
							
							<div class="form-group col-md-3">
								<label for="cusom_starts">هل العميل مدعوم</label>
								<select class="form-control">
								<option value="0"';
        if ($get['powered'] == "") {
            echo 'selected';
        }
        echo '>اختر</option>
															<option value="1"';
        if ($get['powered'] == "1") {
            echo 'selected';
        }
        echo '>نعم</option>
															<option value="2"';
        if ($get['powered'] == "2") {
            echo 'selected';
        }
        echo '>لا</option> 
								</select>
							</div>
							
							<div class="form-group col-md-3">
								<label for="cusom_starts">البنك</label>
								<select id="bank" class="form-control bank_customer">';
        foreach ($table_banks as $banks) {
            if ($banks['can_show'] == 0){
                continue;
            }
            $selected = ((int)$get['bank'] == (int)$banks['id']) ? 'selected' : '';
            echo '<option value="' . $banks['id'] . '" ' . $selected . '>' . $banks['name'] . '</option>';
        }
        echo ' 
								</select>
							</div>
								
						</div>  
						
						
						<div class="row">
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">تعديل مسمى الوظيفة إلى جهة العمل </label>
                                <input type="text" class="form-control" id="job_title" value="' . $get['job_title'] . '" placeholder="تعديل مسمى الوظيفة إلى جهة العمل ">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">كم متبقي سنة لسداد القرض العقاري</label>
                                <input type="number" class="form-control" id="years_left_repay" value="' . $get['years_left_repay'] . '" placeholder="كم متبقي سنة لسداد القرض العقاري">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">عمر العقار</label>
                                <input type="number" class="form-control" id="state_age" value="' . $get['state_age'] . '" placeholder="عمر العقار">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">نسبة إكمال البناء </label>
                                <input type="number" class="form-control" id="construction_completion_rate" value="' . $get['construction_completion_rate'] . '" placeholder="نسبة إكمال البناء ">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">جهة الرهن</label>
                                <select id="mortgage_lenders_id" class="form-control"> ';
                                    foreach ($table_banks_v2 as $bank){
                                        $selected='';
                                        if ($get['mortgage_lenders_id'] == $bank['id']){
                                            $selected='selected';
                                        }
                                        echo '<option '.$selected.' value="'.$bank['id'].'" >'.$bank['name'].'</option>';
                                    }
                              echo '  </select>
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">قيمة العقار حاليا</label>
                                <input type="number" class="form-control" id="state_value" value="' . $get['state_value'] . '" placeholder="قيمة العقار حاليا">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">المبلغ المتبقي لسداد للعقار</label>
                                <input type="number" class="form-control" id="remain_money" value="' . $get['remain_money'] . '" placeholder="المبلغ المتبقي لسداد للعقار">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">قسط الدعم</label>
                                <input type="number" class="form-control" id="support_premium" value="' . $get['gross_salary'] . '" placeholder="قسط الدعم">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">الراتب الأساسي</label>
                                <input type="number" class="form-control" id="gross_salary" value="' . $get['gross_salary'] . '" placeholder="الراتب الأساسي">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">الراتب الصافي </label>
                                <input type="number" class="form-control" id="net_salary" value="' . $get['net_salary'] . '" placeholder="الراتب الصافي ">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">الرتبه العسكريه</label>
                                <input type="text" class="form-control" id="military_rank" value="' . $get['military_rank'] . '" placeholder="الرتبه العسكريه">
                            </div>
                            <div class="form-group col-md-3">
                                <label for="inputEmail4">تاريخ التعيين</label>
                                <input type="date" class="form-control" id="hiring_date" value="' . $get['hiring_date'] . '" placeholder="تاريخ التعيين">
                            </div>
                        </div>
						
						

						<div class="eltzams"> 
							<div class="card">
								<div class="add_new_eltizam">
									<i class="fa fa-plus"></i>
									<p>إضافة إلتزام</p>';
        echo $html_new;
        echo '
								</div>

							</div>
						';
        echo $html_eltizam;
        echo ' 
						</div>
						
						<div class="row">
							<div class="form-group col-md-12">
								<label for="inputEmail4">ملاحظات الموظف  <span style="width: 30px;height: 30px cursor:pointer" id="' . $value . '" class="show_details_logs fa fa-info btn btn-edit"></span> </label>
								<textarea class="form-control" placeholder="أدخل اي ملاحظات للطلب" disabled id="cusom_description" rows"10">' . ($get['disc_order'] == "لا توجد ملاحظات" ? '' : $get['disc_order']) . '</textarea>
							</div>  
						</div> 
						
					</div>  

					<div class="tab-pane" id="upload_order">
						<div class="row">
							<div class="form-group col-12 col-md-8 col-sm-12" style="Padding:0px !important"> 
								<div class="paper">
									<div class="paper-content">
										<textarea id="order_notes" autofocus>
												' . $get["order_notes"] . '
										</textarea>
									</div>
								</div>
							</div>
							<div class="form-group col-12 col-md-4 col-sm-12 main_contenct_msg">
								<div class="row main_send_msg_order animate__animated animate__zoomIn"> 
									
									<div class="col-md-12">
										<label for="inputEmail4">محتوى الرسالة</label>
										<textarea class="form-control" placeholder="أدخل اي ملاحظات" id="msg_description" rows"10"></textarea>
									</div>
									
									<div class="col-md-12" ';
        $d1 = 1;
        $d2 = 2;

        $stmt_upload1 = $con->prepare("SELECT * from order_msg where order_id = ? AND have_accept = ? ");
        $stmt_upload1->execute(array($get["id"], $d1));
        $count1 = $stmt_upload1->rowCount();

        $stmt_upload2 = $con->prepare("SELECT * from order_msg where order_id = ? AND have_accept = ? ");
        $stmt_upload2->execute(array($get["id"], $d2));
        $count2 = $stmt_upload2->rowCount();

        if ($get['upload_order'] != "0") {
            echo 'style="display:none;"';
            echo 'data="1"';
        }
        else if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
            echo 'style="display:none;"';
            echo 'data="2"';
        }
        else {
            if ($count1 > 0) {
                echo 'style="display:none;"';
                echo 'data="4"';
            }
            else if ($count2 > 0) {
                echo 'style="display:none;"';
                echo 'data="5"';
            }
        }
        echo '>
																											
										<input type="checkbox" class="form-check-input" id="order_accept">
										<label class="form-check-label" for="exampleCheck1">طلب قبول رفع الطلب</label>
									</div>  

									<div class="form-group col-md-12"> 
										<a href="#" class="btn btn-primary btn-sm send_msg_order" order_id="' . $get['id'] . '" emp_name="';

        $stmt_emp_name = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
        $stmt_emp_name->execute(array($get["emp_id"]));
        $get_name = $stmt_emp_name->fetch();
        echo $get_name['u_name'];
        echo '">إرسال <i class="fa fa-send"></i></a>
																		</div> 
																	</div>

											<div class="timeline timeline-inverse" id="timelinehtml">';
        $qu1    = 'SELECT * FROM `order_msg`  WHERE order_id=' . $get['id'] . ' ORDER BY id DESC';
        $sql    = mysqli_query($result, $qu1);
        $data   = "";
        $animat = 0.5;
        while ($row = mysqli_fetch_array($sql)) {
            $animat = $animat + 2;
            if ($animat == 5) {
                $animat = 0.5;
            }
            if ($data != $row["data_update"]) {
                echo '
														<div class="time-label animate__animated animate__bounceInUp animate__delay-0.' . $animat . 's">
															<span class="bg-danger">' . $row["data_update"] . '</span>
														</div>
													';
                $data = $row["data_update"];
            }

            echo '
											<div class="animate__animated animate__bounceInUp animate__delay-' . $animat . 's">
											
											<div class="timeline-item">
												<span class="time"><i class="fa fa-clock"></i>' . $row["time"] . '</span> 
												<h3 class="timeline-header"> 
													<i class="fa fa-envelope bg-primary animate__animated animate__pulse animate__infinite"></i> 
													<a href="#">' . $row["emp_name"] . '</a> 
												</h3> 
												<p style="font-size: 20px; padding: 13px;">' . $row["msg"] . '</p>
												';
            if ($row['have_accept'] == "1") {
                if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
                    echo '
															<div class="timeline-footer">
																<a href="#" accept_id="' . $row["id"] . '" order_id="' . $get['id'] . '" class="btn btn-success btn-sm btn_accept_order">قبول رفع الطلب</a> 
																<a href="#" accept_id="' . $row["id"] . '" order_id="' . $get['id'] . '" class="btn btn-danger btn-sm btn_rejection_order">رفض رفع الطلب</a> 
															</div>
														';
                }
                else {
                    echo '
															<div class="timeline-footer">
																<a href="#" class="btn btn-primary btn-sm">جاري مراجعة الطلب للموافقة</a> 
															</div>
														';
                }
            }
            else if ($row['have_accept'] == "2") {
                if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
                    echo '
															<div class="timeline-footer">
																<a href="#" class="btn btn-success btn-sm disaple_btn">تمت الموافقة على رفع الطلب</a> 
																<a href="#" accept_id="' . $row["id"] . '" accept_order_id="' . $get['id'] . '" class="btn btn-danger btn-sm cancel_accept_order">إلغاء رفع الطلب</a> 
															</div>
														';
                }
                else {
                    echo '
															<div class="timeline-footer">
																<a href="#" class="btn btn-success btn-sm">تمت الموافقة على رفع الطلب</a> 
															</div>
														';
                }
            }
            else if ($row['have_accept'] == "3") {
                echo '
														<div class="timeline-footer">  
															<a href="#" class="btn btn-danger btn-sm">تم استعادة رفع الطلب</a> 
														</div>
													';
            }
            else if ($row['have_accept'] == "4") {
                if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
                    echo '
															<div class="timeline-footer">  
																<a href="#" class="btn btn-danger btn-sm">تم رفض الطلب من طرفكم</a> 
															</div>
														';
                }
                else {
                    echo '
															<div class="timeline-footer">  
																<a href="#" class="btn btn-danger btn-sm">تم رفض الطلب من طرف الإدارة</a> 
															</div>
														';
                }
            }
            echo '
												</div>
											</div>
										';
        }


        echo ' 
													<div> 
														<i class="fa fa-clock-o bg-gray" aria-hidden="true"></i>
													</div>
												</div> 

											</div>  
										</div>
									</div>
					
						
					<div class="tab-pane" id="settings">
					
						<div class="main_file_history">
							<div class="file_history">

								<div class="file_header_history">
									<p>سجل الملفات</p>
									<a class="close_file_dilaoge">
										<i class="fa fa-close"></i>
									</a>   
								</div>

								<div class="all_file_history">';

        $num_file_history = 0;
        $order_id_history = $get['id'];
        $query_history    = "SELECT * FROM `table_file_history` WHERE `table_file_history`.`order_id` = $order_id_history  ORDER BY id ASC";
        $sql_history      = mysqli_query($result, $query_history);
        while ($row_history = mysqli_fetch_array($sql_history)) {
            $num_file_history = $num_file_history + 1;

            $stmt3 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
            $stmt3->execute(array($get["emp_id"]));
            $get3     = $stmt3->fetch();
            $get_name = $get3['u_name'];
            echo '
											<div class="main_update">
												<p class="index_update">' . $num_file_history . '</p>
												<div class="hidder_update">
													<div class="h_cercel">
														<i class="fa fa-user"></i>
														<p>' . $get_name . '</p>
													</div>
													<p class="date_update">' . $row_history['date_add'] . '</p>
												</div>
												<div class="body_update">
													<p>' . $row_history['description'] . '</p>
												</div>
											</div>
										';
        }
        if ($num_file_history == 0) {
            echo '
											<div class="no_update">
												<i class="fa fa-eye-slash" aria-hidden="true"></i>
												<p>لا توجد سجلات</p>
											</div>
										';
        }

        echo '
					 			</div>
					 		</div>
						</div> 

						<div class="row">
							<div class="form-group col-md-12">
								<div class="file_title"> 
									<input type="file" class="input_tab_files" name="filepond"/>
									<a class="show_file_history">
										<i class="fa fa-clock-o" aria-hidden="true"></i>
									</a>
								</div>
								<div class="customer_file_img"> 
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
									</div>
									<div class="fileimg">
										<img src="../../assets/dist/img/blank-image.svg"/>                    
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
					
				</div> 
			</div> 
		</div>';
    }
}
else if ($action == "SaveFilesOrders") {

    $order_id    = $value;
    $data        = $value1;
    $json_string = json_encode($data, JSON_PRETTY_PRINT);
    $manage      = json_decode($json_string, true);
    $data        = json_decode($manage);

    if (count($data) > 0) {

        $sql_string        = "('" . $order_id . "', '" . $data[0] . "', '" . $data[1] . "', '" . $data[2] . "', '" . $data[3] . "', '" . $data[4] . "','1')";
        $stmt_insert_phone = "INSERT INTO `order_files` (`order_id`, `file_path`, `file_type`, `file_size`, `file_name`, `folder_path`,`kind`) VALUES $sql_string ;";
        $result_insert     = $con->query($stmt_insert_phone);
        if ($result_insert) {
            echo "11111";
            $today       = date('Y-m-d H:i:s');
            $description = ' تم إضافة ملف حجم ( ' . $data[2] . ') نوع الملف (' . $data[1] . ') إسم الملف (' . $data[3] . ')';
            $user_id     = $user_id = $_SESSION['USER_DETAILS']['u_id'];;
            $stmt_insert_history = "INSERT INTO `table_file_history` (`order_id`, `how_update`, `description`, `date_add`) VALUES (" . $order_id . ", " . $user_id . ", '" . $description . "', '" . $today . "') ;";
            $con->query($stmt_insert_history);
        }
        else {
            echo $result_insert;
        }
    }
}
else if ($action == "getAllFilesOrders") {
    $order_id = $value;
    if (!isset($order_id)) {
        echo "";
        return false;
    }

    $sql_files   = "SELECT * FROM `order_files` WHERE `order_files`.`order_id` = $order_id AND `order_files`.`kind`= '1'  ORDER BY id ASC";
    $query_files = mysqli_query($result, $sql_files);
    $num_files   = 0;
    echo '
	<div class="jFiler jFiler-theme-dragdropbox">
		<div class="jFiler-items jFiler-row">
		<ul class="jFiler-items-list jFiler-items-grid all-files-orders">';
    $index = 0;
    while ($row_files = mysqli_fetch_array($query_files)) {
        $num_files = $num_files + 1;
        $path      = realpath($row_files['folder_path']);
        $file_name = $row_files['file_name'] . $row_files['file_type'];
        $file_size = (int)$row_files['file_size'];
        echo '
					<li class="jFiler-item" data-jfiler-index="3" style="">						
					<div class="jFiler-item-container">	
						<div class="delete_loading">
							<div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
						</div>						
						<div class="jFiler-item-inner">								
						<div class="jFiler-item-thumb">									
							<div class="jFiler-item-status"></div>									
							<div class="jFiler-item-thumb-overlay">										
							<div class="jFiler-item-info">											
								<div class="jFiler-item-list">												
								<span class="jFiler-item-title">
									<b title="' . $file_name . '">' . $file_name . '</b>
								</span>												
								<span class="jFiler-item-others">';
        if ($file_size < 1024) {
            echo "{$file_size} bytes";
        }
        else if ($file_size < 1048576) {
            $size_kb = round($file_size / 1024);
            echo "{$size_kb} KB";
        }
        else {
            $size_mb = round($file_size / 1048576, 1);
            echo "{$size_mb} MB";
        }

        echo '</span>		
								<span>' . $row_files['date_add'] . '</span>											
								</div>										
							</div>									
							</div>									
							<div class="jFiler-item-thumb-image">';
        if (($row_files['file_type'] === "jpeg") || ($row_files['file_type'] === "jpg") || ($row_files['file_type'] === "gif") || ($row_files['file_type'] === "png") || ($row_files['file_type'] === "apng") || ($row_files['file_type'] === "svg") || ($row_files['file_type'] === "bmp") || ($row_files['file_type'] === "ico") || ($row_files['file_type'] === "bmp ico") || ($row_files['file_type'] === "png ico")) {
            echo '
								<a data-gallery="photoviewer" index="' . $index . '" data-title="' . $row_files['file_name'] . '" href="' . $row_files['file_path'] . '" data-group="b">
									<img draggable="false" src="' . $row_files['file_path'] . '" alt=""> 
								</a> 
								';
            $index = $index + 1;
        }
        else {
            echo ' <a data-gallery="pdfviewer" href="' . $row_files['file_path'] . '" data-group="a"" class="view_pdf">
									<span class="jFiler-icon-file f-file f-file-ext-' . $row_files['file_type'] . '" style="background-color: rgb(242, 60, 15);">.' . $row_files['file_type'] . '</span>
								</a>';
        }
        echo '
							</div>								
						</div>								
						<div class="jFiler-item-assets jFiler-row">									
							<ul class="list-inline pull-right">										
							<li>
								<div class="jFiler-jProgressBar" style="display: none;">
								<div class="bar"></div>
								</div>
								<div class="jFiler-item-others text-error" style="">
								<input type="text" value="' . $row_files['file_name'] . '" class="change_file_name" file="' . $row_files['id'] . '" order="' . $row_files['order_id'] . '">
								</div>
							</li>
							</ul>									
							<ul class="list-inline pull-left">										
							<li>
							<a class="icon-jfi-trash jFiler-item-trash-action delete_file_order" folder="' . $row_files['folder_path'] . '" file="' . $row_files['id'] . '" order="' . $row_files['order_id'] . '"></a>
							</li>									
							</ul>								
						</div>							
						</div>					
					</div>					
					</li>';
    }
    echo ' 
		</ul>
	</div>
</div>
';

    if ($num_files == 0) {
        echo '
	<div class="no-files">
		<span>حالياً لا توجد ملفات لهذا العميل</span>
	</div>
	';
    }
}
else if ($action == "DeleteFileOrders") {

    $file_id  = $value;
    $order_id = $value1;
    $dir      = $_POST['value2'];

    if (($file_id === "") || ($order_id === "") || ($dir === "")) {
        echo "no Data";
        return;
    }

    // echo $dir;
    $kind = 1;

    $stmt_delete_phone = "DELETE FROM `order_files` WHERE `order_files`.`order_id` ='$order_id' AND `order_files`.`kind` = '$kind' AND `order_files`.`id` = $file_id ";
    $result            = $con->query($stmt_delete_phone);
    if ($result) {
        $path = realpath($dir);
        deleteDirectory($path);
        echo "11111";
        $today       = date('Y-m-d H:i:s');
        $description = ' تم إزالة أحد الملفات رقم الملف (' . $file_id . ')';
        $user_id     = $user_id = $_SESSION['USER_DETAILS']['u_id'];;
        $stmt_insert_history = "INSERT INTO `table_file_history` (`order_id`, `how_update`, `description`, `date_add`) VALUES (" . $order_id . ", " . $user_id . ", '" . $description . "', '" . $today . "') ;";
        $con->query($stmt_insert_history);
    }
    else {
        print_r($result);
    }

    return;
}
else if ($action == "ChangeFileNameOrders") {
    $file_id   = $value;
    $order_id  = $value1;
    $file_name = $_POST['value2'];

    $stmt_file = $con->prepare("SELECT `file_name` FROM `order_files` WHERE `order_files`.id = ? ");
    $stmt_file->execute(array($file_id));
    $get_file      = $stmt_file->fetch();
    $old_name_file = $get_file['file_name'];

    $sql_update_file = "UPDATE `order_files` SET `file_name` = '$file_name' WHERE `order_files`.`id`= $file_id AND `order_files`.`order_id` = $order_id AND `order_files`.`kind` = '1' ";
    $result          = $con->query($sql_update_file);
    if ($result) {
        echo "11111";
        $today       = date('Y-m-d H:i:s');
        $description = ' تم تغير إسم أحد الملفات من (' . $old_name_file . ') إلى (' . $file_name . ') رقم الملف (' . $file_id . ')';
        $user_id     = $user_id = $_SESSION['USER_DETAILS']['u_id'];;
        $stmt_insert_history = "INSERT INTO `table_file_history` (`order_id`, `how_update`, `description`, `date_add`) VALUES (" . $order_id . ", " . $user_id . ", '" . $description . "', '" . $today . "') ;";
        $con->query($stmt_insert_history);
    }
    else {
        print_r($result);
        echo "error_update";
    }
}
else if ($action == "refrch_msg") {
    $order_id = $_POST['value'];
    $qu1      = 'SELECT * FROM `order_msg`  WHERE order_id=' . $order_id . ' ORDER BY id DESC';
    $data     = "";
    $sql      = mysqli_query($result, $qu1);
    while ($row = mysqli_fetch_array($sql)) {

        if ($data != $row["data_update"]) {
            echo '
        			 <div class="time-label">
                        <span class="bg-danger">' . $row["data_update"] . '</span>
                    </div>';
            $data = $row["data_update"];
        }

        echo '
            <div>
                <i class="fa fa-envelope bg-primary"></i> 
                <div class="timeline-item">
                    <span class="time"><i class="fa fa-clock"></i>' . $row["time"] . '</span> 
                    <h3 class="timeline-header">
                      <a href="#">' . $row["emp_name"] . '</a> 
                    </h3>  
					<p style="font-size: 20px; padding: 13px;">' . $row["msg"] . '</p>
                    ';
        if ($row['have_accept'] == "1") {
            if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
                echo '
                             <div class="timeline-footer">
                                <a href="#" accept_id="' . $row["id"] . '" order_id="' . $order_id . '" class="btn btn-success btn-sm btn_accept_order">قبول رفع الطلب</a> 
                                <a href="#" accept_id="' . $row["id"] . '" order_id="' . $order_id . '" class="btn btn-danger btn-sm">رفض رفع الطلب</a> 
                            </div>
                            ';
            }
            else {
                echo '
                             <div class="timeline-footer">
                                <a href="#" class="btn btn-primary btn-sm">جاري مراجعة الطلب للموافقة</a> 
                            </div>
                            ';
            }
        }
        else if ($row['have_accept'] == "2") {
            if (($_SESSION['USER_DETAILS']['kind'] == "10") or ($_SESSION['USER_DETAILS']['kind'] == "0")) {
                echo '
                             <div class="timeline-footer">
                                <a href="#" class="btn btn-success btn-sm">تمت الموافقة على رفع الطلب</a> 
                                <a href="#" accept_id="' . $row["id"] . '" accept_order_id="' . $order_id . '" class="btn btn-danger btn-sm cancel_accept_order">إلغاء رفع الطلب</a> 
                            </div>
                            ';
            }
            else {
                echo '
                             <div class="timeline-footer">
                                <a href="#" class="btn btn-success btn-sm">تمت الموافقة على رفع الطلب</a> 
                            </div>
                            ';
            }
        }
        else if ($row['have_accept'] == "3") {
            echo '
                             <div class="timeline-footer">  
                                <a href="#" class="btn btn-danger btn-sm">تم استعادة رفع الطلب</a> 
                            </div>
                            ';
        }
        else if ($row['have_accept'] == "4") {
            echo '
                             <div class="timeline-footer">  
                                <a href="#" class="btn btn-danger btn-sm">تم رفض الطلب</a> 
                            </div>
                            ';
        }
        echo '
                </div>
            </div>';
    }


    echo '  
    ';
}
else if ($action == "AddCity") {
    $city_name = $_POST['value'];
    $stats_id  = "1";

    $stmt = $con->prepare("INSERT INTO `city` (`name`,`stats_id`) VALUES (?,?)");
    $stmt->execute(array($city_name, $stats_id));
    if ($stmt) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "save_city") {
    $id         = $_POST['value'];
    $name       = $_POST['value1'];
    $sql_update = "UPDATE `city` SET `name` = '$id' WHERE `city`.`id` = $name;";
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo "00000";
    }
}
else if ($action == "deletecity") {
    $sql = "DELETE FROM `city` WHERE `city`.`id` =$value";
    if ($con->query($sql)) {
        echo "11111";
    }
    else {
        echo "00000";
    }
}
else if ($action == "getcitys") {

    $query = "SELECT * FROM `city`  ORDER BY `city`.`id` ASC";
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
    echo '
		<div class="form-group has-feedback box-city">
	    	<button id="sighn" type="button" class="btn btn-success btn-block btn-flat add_city"> <i class="fa fa-plus" aria-hidden="true"></i> إضافة مدينة</button>
    	</div> 
	';
}
else if ($action == "changeMarketingText") {

    $news_id   = (int)$value;
    $news_text = $value1;

    $sql_update = "UPDATE `news` SET `text` = '$news_text' WHERE `news`.`id` = $news_id;";
    if ($con->query($sql_update)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "getemploynumber") {

    $num_order        = 0;
    $num_whatsapp     = 0;
    $name_customer    = "عميل وتس أب";
    $from_web         = $_POST['value1'];
    $customer_phone   = $_POST['value'];
    $msg              = "لا توجد رسالة";
    $disc_order       = "لا توجد ملاحظات";
    $emp_id           = "0";
    $emp_name         = "";
    $stars            = "1";
    $status_order     = "1";
    $no               = "1";
    $deleted          = "0";
    $today            = date('Y-m-d H:i:s');
    $today1           = "3022-01-26 08:57:20";
    $num_order_true   = 0;
    $emp_phone_number = 0;

    $stmt_phone = $con->prepare("SELECT emp_id from orders where phone_number = ? ");
    $stmt_phone->execute(array($customer_phone));

    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $count = $stmt_phone->rowCount();
    if ($count > 0) {
        $get         = $stmt_phone->fetch();
        $employye_id = (int)$get['emp_id'];
        $query       = "SELECT * FROM users WHERE u_id = $employye_id";
        $sql         = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($sql)) {

            die($row["phone_number"]);

            $emp_name = $row["u_name"];
            echo $row["phone_number"];
        }
    }
    else {


        $kind             = 2;
        $can_get_whatsapp = 1;
        $query            = "SELECT * FROM `users` WHERE `kind` = $kind  AND `can_get_whatsapp` = $can_get_whatsapp AND u_whatsapp =  ( SELECT MIN(u_whatsapp) FROM users WHERE kind = $kind  AND can_get_whatsapp = $can_get_whatsapp ) LIMIT 1;";
        $sql              = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($sql)) {
            $emp_id           = (int)$row["u_id"];
            $emp_name         = $row["u_name"];
            $num_whatsapp     = (int)$row["u_whatsapp"];
            $emp_phone_number = $row["phone_number"];
        }

        $stmt = $con->prepare("INSERT INTO orders (`name_customer`,`phone_number`,`msg`,`emp_id`,`emp_name`,`disc_order`,`stars`,`status_order`,`no`,`from_whatsapp`,`from_web`,`deleted`,`data_update`,`data_add`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($name_customer, $customer_phone, $msg, (string)$emp_id, $emp_name, $disc_order, $stars, $status_order, $no, "1", $from_web, $deleted, $today1, $today));
        if ($stmt) {
            $numwah     = (string)$num_whatsapp + 1;
            $sql_update = "UPDATE `users` SET `u_whatsapp` = `u_whatsapp` + 1 WHERE `users`.`u_id` = $emp_id;";
            if ($con->query($sql_update)) {
                echo $emp_phone_number;
            }
            else {
                echo '00000';
            }
        }
        else {
            echo "22222";
        }
    }
}
else if ($action == "SendAdminMesage") {

    $today           = date('Y-m-d');
    $time            = date('H:i');
    $order_id        = $_POST['value'];
    $title           = $_POST['value1'];
    $msg_description = $_POST['value2'];
    $order_accept    = $_POST['value3'] === "true" ? "1" : "0";
    $emp_name        = $_SESSION['USER_DETAILS']['u_name'];

    $stmt = $con->prepare("INSERT INTO `order_msg` (`order_id`,`emp_name`,`title`,`msg`,`have_accept`,`time`,`data_update`) VALUES (?,?,?,?,?,?,?)");
    $stmt->execute(array($order_id, $emp_name, $title, $msg_description, $order_accept, $time, $today));
    if ($stmt) {
        add_msg_to_chate($order_id);
        echo "11111";
    }
    else {
        echo "00000";
    }
}
else if ($action == "savechangeorder") {
    $name_emp = "";
    $from     = $_POST['value3'];
    $to       = $_POST['value4'];
    $temp1    = explode(',', $_POST['value2']);


    $stmt = $con->prepare("SELECT * from `orders` where emp_id = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $stmt1 = $con->prepare("SELECT `u_name` from `users` where u_id = ? ");
        $stmt1->execute(array($value));
        $get              = $stmt1->fetch();
        $name_emp         = $get['u_name'];
        $success_movement = 0;
        $error_movement   = 0;
        $today            = date('Y-m-d');
        $info             = 'طلب محول من الموظف/ـة ' . $from . ' إلى الموظف/ـة ' . $to . ' في تاريخ ' . $today;
        $datachange       = '0';
        $datachange1      = '1';
        $discription      = "";
        foreach ($temp1 as $ids) {
            $sql = " UPDATE `orders` SET `emp_id` = '$value1' , `emp_name`='$name_emp', `movement`='$info', `data_add`='$today', `stars`='$datachange1', `order_stage`='$datachange', `status_order`='$datachange1', `disc_order`='$discription' WHERE `orders`.`emp_id` = '$value' AND `orders`.`id` = '$ids';";
            if ($con->query($sql)) {
                $success_movement++;
            }
            else {
                $error_movement++;
            }
        }
        echo ' نجح تحويل ' . $success_movement . ' عميل وفشل تحويل ' . $error_movement . ' عميل';
    }
    else {
        echo "أكتشف النظام أن العميل لا يوجد لديه طلبات";
    }
}
else if ($action == "delete_order_admin") {
    $is_admin = (int)$_SESSION['USER_DETAILS']['kind'];
    if ($is_admin == 10 || $is_admin == 0) {
        $sql = "DELETE FROM orders WHERE id =$value";
        if ($con->query($sql)) {
            echo '11111';
        }
        else {
            echo '00000';
        }
    }
    else {
        $delete_it = 1;
        add_new_history($value, 0, 'UPDATE_DELETE_ORDER');
        $sql = "UPDATE orders SET deleted=$delete_it WHERE id = $value";
        if ($con->query($sql)) {
            echo '11111';
        }
        else {
            echo '00000';
        }

    }
}
else if ($action == "changepassword") {
    $oldpassword = $value;
    $newpassword = $value1;
    $newpassword = $_POST['value2'];
    $value2      = $_POST['value2'];
    if (($value == null) || ($value1 == null) || ($value2 == null)) {
        echo '4';
        return;
    }
    $stmt = $con->prepare("SELECT passrword from users where passrword = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        if ($value1 == $value2) {
            $uid = $_SESSION['USER_DETAILS']['u_id'];
            $sql = "UPDATE users SET passrword=$value2 WHERE u_id=$uid";
            if ($con->query($sql)) {
                echo '3';
            }
            else {
                echo '2';
            }
        }
        else {
            echo '1';
        }
    }
    else {
        echo '0';
    }
}
else if ($action == "changepage") {
    $_SESSION['num_page'] = $value;
}
else if ($action == "make_order_zero") {
    $sql = "UPDATE `users` SET `num_order_true` = 0, `u_whatsapp` = 0, `num_order` = 0 WHERE `users`.`kind` = '2';";

    if ($con->query($sql)) {
        echo '11111'; // If the query was successful, output '11111'
    }
    else {
        echo '00000'; // If there was an error with the query, output '00000'
    }
}
else if ($action == "make_whatsapp_order_zero") {
    $sql = "UPDATE `users` SET `u_whatsapp` = '0' WHERE `users`.`kind` = '2';";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "make_order_true_zero") {
    $sql = "UPDATE `users` SET `num_order` = '0' WHERE `users`.`kind` = '2';";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "add_order_rafa") {

    $num_order      = 0;
    $name_customer  = $_POST['value1'];
    $from_web       = $_POST['value'];
    $emp_phone      = $_POST['cus_phone'];
    $msg            = $_POST['cus_note'];
    $disc_order     = "لا توجد ملاحظات";
    $emp_id         = "0";
    $emp_name       = "";
    $stars          = "1";
    $status_order   = "1";
    $no             = "1";
    $deleted        = "0";
    $today          = date('Y-m-d H:i:s');
    $today1         = "3022-01-26 08:57:20";
    $num_order_true = 0;
    $stmt           = $con->prepare("SELECT name_customer from orders where phone_number = ? ");
    $stmt->execute(array($emp_phone));
    $count = $stmt->rowCount();
    if (!($count > 0)) {
        $query = "SELECT * FROM `users` WHERE `kind` = '2' AND `u_compony` != 0 AND `num_order` = ( SELECT MIN(num_order) FROM `users` WHERE `kind` = '2' AND `u_compony` != 0 ) LIMIT 1 ;";
        $sql   = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($sql)) {
            $emp_id         = (int)$row["u_id"];
            $emp_name       = $row["u_name"];
            $num_order      = (int)$row["num_order"];
            $num_order_true = (int)$row["num_order_true"];
        }

        $stmt = $con->prepare("INSERT INTO orders (`name_customer`,`phone_number`,`msg`,`emp_id`,`emp_name`,`disc_order`,`stars`,`status_order`,`no`,`from_web`,`deleted`,`data_update`,`data_add`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($name_customer, $emp_phone, $msg, (string)$emp_id, $emp_name, $disc_order, $stars, $status_order, $no, $from_web, $deleted, $today1, $today));
        if ($stmt) {
            $num1       = (string)$num_order + 1;
            $num2       = (string)$num_order_true + 1;
            $sql_update = "UPDATE `users` SET `num_order` = '$num1', `num_order_true` = '$num2' WHERE `users`.`u_id` = $emp_id;";
            if ($con->query($sql_update)) {
                echo '11111';
            }
            else {
                echo '00000';
            }
        }
        else {
            echo "00000";
        }
    }
    else {
        echo "22222";
    }
}
else if ($action == "update_user_problems") {
    $use_id2      = $_SESSION['USER_DETAILS']['u_id'];
    $qu2          = "SELECT * FROM problems where user_id=" . $use_id2 . ' ORDER BY solve_it';
    $sql2         = mysqli_query($result, $qu2);
    $num_problems = 0;
    $index_id     = 1;
    echo '  <table class="table table-hover" >';
    while ($row = mysqli_fetch_array($sql2)) {
        $num_problems = $num_problems + 1;
        if ($num_problems == 1) {
            echo ' <tr>
							<th style="text-align: right;">رقم البلاغ</th>
							<th style="text-align: right;">رمز الإقفال </th>
							<th style="text-align: right;">عنوان البلاغ</th>
							<th style="text-align: right;">تاريخ الإرسال</th>
							<th style="text-align: right;">حالات البلاغ</th>
							<th style="text-align: right;">التفاصيل</th>
							<th style="text-align: center;">إجراء</th>
						</tr>';
        }

        echo '<tr> 	
				<td>' . $index_id . '</td>
				<td >' . $row["num_pro"] . '</td>
				<td>' . $row["title_problem"] . '</td>';
        echo '<td>';
        $today = date('Y-m-d H:i:s');
        $date1 = strtotime($row["time_send"]);
        $date2 = strtotime($today);

        $diff   = abs($date2 - $date1);
        $years  = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));

        $days = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));

        $hours = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));

        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);

        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24
            - $hours * 60 * 60 - $minutes * 60));

        if ($years != 0) {
            if ($years == 1) {
                echo " قبل سنة ";
            }
            else if ($years == 2) {
                echo " قبل سنتين";
            }
            else {
                if ($years < 11) {
                    echo "قبل " . $years . " سنين ";
                }
                else {
                    echo "قبل " . $years . " سنة ";
                }
            }
            $days    = 0;
            $hours   = 0;
            $minutes = 0;
            $seconds = 0;
        }

        if ($months != 0) {
            if ($years != 0) {

                if ($months == 1) {
                    echo " و شهر ";
                }
                else if ($months == 2) {
                    echo " و شهرين ";
                }
                else {
                    if ($months < 11) {
                        echo " و " . $months . " أشهر ";
                    }
                    else {
                        echo " و " . $months . " شهر ";
                    }
                }
            }
            else {
                if ($months == 1) {
                    echo " قبل شهر ";
                }
                else if ($months == 2) {
                    echo " قبل شهرين";
                }
                else {
                    if ($months < 11) {
                        echo "قبل " . $months . " أشهر ";
                    }
                    else {
                        echo " قبل " . $months . " شهر ";
                    }
                }
            }
            $hours   = 0;
            $minutes = 0;
            $seconds = 0;
        }

        if ($days != 0) {
            if ($months != 0) {

                if ($days == 1) {
                    echo " و يوم ";
                }
                else if ($days == 2) {
                    echo " و يومان ";
                }
                else {
                    if ($days < 11) {
                        echo " و " . $days . " أيام ";
                    }
                    else {
                        echo " و " . $days . " يوم ";
                    }
                }
            }
            else {
                if ($days == 1) {
                    echo " قبل يوم ";
                }
                else if ($days == 2) {
                    echo " قبل يومان ";
                }
                else {
                    if ($days < 11) {
                        echo " قبل " . $days . " أيام ";
                    }
                    else {
                        echo " قبل " . $days . " يوم ";
                    }
                }
            }
            $minutes = 0;
            $seconds = 0;
        }

        if ($hours > 0) {
            if ($days != 0) {

                if ($hours == 1) {
                    echo " و ساعة ";
                }
                else if ($hours == 2) {
                    echo " و ساعتين ";
                }
                else {
                    if ($hours < 11) {
                        echo " و " . $hours . " ساعات ";
                    }
                    else {
                        echo " و " . $hours . " ساعة ";
                    }
                }
            }
            else {
                if ($hours == 1) {
                    echo " قبل ساعة ";
                }
                else if ($hours == 2) {
                    echo " قبل ساعتين";
                }
                else {
                    if ($hours < 11) {
                        echo "قبل " . $hours . " ساعات ";
                    }
                    else {
                        echo "قبل " . $hours . " ساعة ";
                    }
                }
            }
            $seconds = 0;
        }

        if ($minutes > 0) {
            if ($hours != 0) {

                if ($minutes == 1) {
                    echo " و دقيقة  ";
                }
                else if ($minutes == 2) {
                    echo " و دقيقتان ";
                }
                else {
                    if ($minutes < 11) {
                        echo " و " . $minutes . " دقائق ";
                    }
                    else {
                        echo " و " . $minutes . " دقيقة ";
                    }
                }
            }
            else {
                if ($minutes == 1) {
                    echo " قبل دقيقة ";
                }
                else if ($minutes == 2) {
                    echo " قبل دقيقتان";
                }
                else {
                    if ($minutes < 11) {
                        echo "قبل " . $minutes . " دقائق";
                    }
                    else {
                        echo "قبل " . $minutes . " دقيقة ";
                    }
                }
            }
        }

        if ($seconds > 0) {
            if ($minutes != 0) {

                if ($seconds == 1) {
                    echo " و ثانية  ";
                }
                else if ($seconds == 2) {
                    echo " و ثانيتان ";
                }
                else {
                    if ($seconds < 11) {
                        echo " و " . $seconds . " ثواني ";
                    }
                    else {
                        echo " و " . $seconds . " ثانية ";
                    }
                }
            }
            else {
                if ($seconds == 1) {
                    echo " قبل ثانية ";
                }
                else if ($seconds == 2) {
                    echo " قبل ثانيتان";
                }
                else {
                    if ($seconds < 11) {
                        echo "قبل " . $seconds . " ثواني ";
                    }
                    else {
                        echo "قبل " . $seconds . " ثانية ";
                    }
                }
            }
        }


        echo '</td>';
        if ($row["solve_it"] == 3) {
            echo ' <td><span class="label label-success">تم الإقفال</span></td>';
        }
        else if ($row["solve_it"] == 2) {
            echo ' <td><span class="label label-primary">قيد المعالجة</span></td>';
        }
        else if ($row["solve_it"] == 1) {
            echo '<td><span class="label label-warning">تم التسليم </span></td>';
        }
        else {
            echo ' <td><span class="label label-danger">جاهز للتسليم</span></td>';
        }
        echo '<td>' . $row["msg"] . '</td>';
        if ($row["isview"] == 0) {
            echo '<td  style="text-align: center; font-weight: bold;"><a href="" id="' . $row["id"] . '" onclick="return SendNumCode(this.id);" style="min-width: 77px;max-width: 77px;"> إرسال رمز الإقفال </a></td>';
        }
        else {
            echo '<td style="text-align: center; color: forestgreen;font-weight: bold;">تم الإرسال</td>';
        }

        echo '</tr>';
        $index_id = $index_id + 1;
    }

    if ($num_problems == 0) {
        echo '<b margin-bottom:10px;>لا توجد بلاغات مشكلات مرسلة </b>';
    }
    echo '</table>';
}
else if ($action == "delet_emportant") {
    $sql = "DELETE FROM emportants WHERE id =$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "changeStatuse") {
    $today        = date('Y-m-d H:i:s');
    $status_order = $value1;
    add_new_history($value, $status_order, "UPDATE_STATUSE");

    $sql = "UPDATE orders SET status_order='$status_order',data_update='$today' WHERE id=$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "changeStars") {
    $today = date('Y-m-d H:i:s');

    $order_id      = isset($_POST['value']) ? $_POST['value'] : 0;
    $starsValue    = isset($_POST['value1']) ? $_POST['value1'] : 1;
    $serviceValue  = isset($_POST['value2']) ? $_POST['value2'] : 1;
    $textareaValue = isset($_POST['value3']) ? $_POST['value3'] : '';

    add_new_history($order_id, $starsValue, 'UPDATE_STARS');
    add_new_history($order_id, $serviceValue, 'UPDATE_POSSIBLE');
    add_new_history($order_id, $textareaValue, 'UPDATE_NOTE_POSSIBLE');

    $sql = "UPDATE orders SET stars='$starsValue', serve_customer='$serviceValue', statuse_note='$textareaValue',data_update='$today' WHERE id = $value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "changeSource") {
    $today = date('Y-m-d H:i:s');

    $order_id = isset($_POST['value']) ? $_POST['value'] : 0;
    $code_id  = isset($_POST['value1']) ? $_POST['value1'] : 0;

    add_new_history($order_id, $code_id, 'UPDATE_SOURCE');

    $sql = "UPDATE orders SET from_web='$code_id', data_update='$today' WHERE id = $order_id";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "changestages") {
    $today = date('Y-m-d H:i:s');
    add_new_history($id, $value1, 'UPDATE_STAGE_ORDER');

    $sql = "UPDATE orders SET order_stage='$value1',data_update='$today' WHERE id=$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "GetHistoryOrder") {

    $html  = "";
    $query = "SELECT * FROM `table_order_history` WHERE `order_id` = $value ORDER BY `id` DESC";
    $sql   = mysqli_query($result, $query);
    $index = 0;
    while ($row = mysqli_fetch_array($sql)) {
        $index = $index + 1;

        $stmt_user = $con->prepare("SELECT `u_name` from `users` WHERE `users`.`u_id` = ? ");
        $stmt_user->execute(array((int)$row['how_update']));
        $get_value = $stmt_user->fetch();
        $user_name = $get_value['u_name'];

        $description = "";
        $new_value   = $row['new_value'];
        $old_value   = $row['old_value'];

        if ($row['type_update'] == "UPDATE_STATUSE") {
            $stmt1 = $con->prepare("SELECT `name` from `table_status` WHERE `table_status`.`id` = ? ");
            $stmt1->execute(array($old_value));
            $get1            = $stmt1->fetch();
            $text_old_value1 = $get1['name'];

            $stmt2 = $con->prepare("SELECT `name` from `table_status` WHERE `table_status`.`id` = ? ");
            $stmt2->execute(array($new_value));
            $get2            = $stmt2->fetch();
            $text_old_value2 = $get2['name'];

            $description = "تم تغير حالة العميل من ( " . $text_old_value1 . ") إلى (" . $text_old_value2 . ").";
        }
        else if ($row['type_update'] == "UPDATE_STARS") {
            $stmt1 = $con->prepare("SELECT `name` from `table_stars` WHERE `table_stars`.`id` = ? ");
            $stmt1->execute(array($old_value));
            $get1            = $stmt1->fetch();
            $text_old_value1 = $get1['name'];

            $stmt2 = $con->prepare("SELECT `name` from `table_stars` WHERE `table_stars`.`id` = ? ");
            $stmt2->execute(array($new_value));
            $get2            = $stmt2->fetch();
            $text_old_value2 = $get2['name'];

            $description = "تم تغير تقييم العميل من ( " . $text_old_value1 . ") إلى (" . $text_old_value2 . ").";
        }
        else if ($row['type_update'] == "UPDATE_POSSIBLE") {
            $stmt1 = $con->prepare("SELECT `name` from `table_serve_customer` WHERE `table_serve_customer`.`id` = ? ");
            $stmt1->execute(array($old_value));
            $get1            = $stmt1->fetch();
            $text_old_value1 = $get1['name'];

            $stmt2 = $con->prepare("SELECT `name` from `table_serve_customer` WHERE `table_serve_customer`.`id` = ? ");
            $stmt2->execute(array($new_value));
            $get2            = $stmt2->fetch();
            $text_old_value2 = $get2['name'];

            $description = "تم تغير إمكانية العميل من ( " . $text_old_value1 . ") إلى (" . $text_old_value2 . ").";
        }
        else if ($row['type_update'] == "UPDATE_NOTE_POSSIBLE") {
            $description = "تم تغير ملاحظات إمكانية العميل من ( " . $old_value . ") إلى (" . $new_value . ").";
        }
        else if ($row['type_update'] == "UPDATE_SOURCE") {
            $stmt1 = $con->prepare("SELECT `name` from `table_source` WHERE `table_source`.`code` = ? ");
            $stmt1->execute(array($old_value));
            $count1 = $stmt1->rowCount();
            if ($count1 > 0) {
                $get1            = $stmt1->fetch();
                $text_old_value1 = $get1['name'];
            }
            else {
                $text_old_value1 = "الموقع الإلكتروني";
            }


            $stmt2 = $con->prepare("SELECT `name` from `table_source` WHERE `table_source`.`code` = ? ");
            $stmt2->execute(array($new_value));
            $count2 = $stmt2->rowCount();
            if ($count2 > 0) {
                $get2            = $stmt2->fetch();
                $text_old_value2 = $get2['name'];
            }
            else {
                $text_old_value2 = "الموقع الإلكتروني";
            }
            $description = "تم تغير مصدر العميل من ( " . $text_old_value1 . ") إلى (" . $text_old_value2 . ").";

        }
        else if ($row['type_update'] == "UPDATE_MOVE_ORDERS") {

            $stmt1 = $con->prepare("SELECT `u_name` from `users` WHERE `users`.`u_id` = ? ");
            $stmt1->execute(array((int)$old_value));
            $count1 = $stmt1->rowCount();
            if ($count1 > 0) {
                $get1            = $stmt1->fetch();
                $text_old_value1 = $get1['u_name'];
            }
            else {
                $text_old_value1 = "غير معروف";
            }

            $stmt2 = $con->prepare("SELECT `u_name` from `users` WHERE `users`.`u_id` = ? ");
            $stmt2->execute(array((int)$new_value));
            $count2 = $stmt2->rowCount();
            if ($count2 > 0) {
                $get2            = $stmt2->fetch();
                $text_old_value2 = $get2['u_name'];
            }
            else {
                $text_old_value2 = "غير معروف";
            }

            $description = "تم تحويل العميل من الموظف ( " . $text_old_value1 . ") إلى الموظف (" . $text_old_value2 . ").";

        }
        else if ($row['type_update'] == "UPDATE_NOTE_ORDER") {
            $description = "تم تغير ملاحظات العميل من ( " . $old_value . ") إلى (" . $new_value . ").";
        }
        else if ($row['type_update'] == "UPDATE_FOVRITE_ORDER") {
            $description = "تم تغير تمييز العميل من ( " . ((int)$old_value == 0 ? " غير مميز" : " مميز ") . ") إلى (" . ((int)$new_value == 0 ? " غير مميز" : " مميز ") . ").";
        }
        else if ($row['type_update'] == "UPDATE_MOTABAA_ORDER") {
            $description = "تم تغير متابعة العميل من ( " . ((int)$old_value == 0 ? " غير متابعة" : " متابعة ") . ") إلى (" . ((int)$new_value == 0 ? " غير متابعة" : " متابعة ") . ").";
        }
        else if ($row['type_update'] == "UPDATE_DELETE_ORDER") {
            $description = "تم إزالة العميل من طرف الموظف.";
        }
        else if ($row['type_update'] == "UPDATE_ADD_ALARM_ORDER") {
            $description = $new_value;
        }
        else if ($row['type_update'] == "UPDATE_ESTEMARA_ORDER") {
            $description = $new_value;
        }
        else if ($row['type_update'] == "UPDATE_STAGE_ORDER") {
            $stmt1 = $con->prepare("SELECT `name` from `table_stage` WHERE `table_stage`.`id` = ? ");
            $stmt1->execute(array($old_value));
            $get1            = $stmt1->fetch();
            $text_old_value1 = $get1['name'];

            $stmt2 = $con->prepare("SELECT `name` from `table_stage` WHERE `table_stage`.`id` = ? ");
            $stmt2->execute(array($new_value));
            $get2            = $stmt2->fetch();
            $text_old_value2 = $get2['name'];

            $description = "تم تغير مرحلة الطلب للعميل من ( " . $text_old_value1 . ") إلى (" . $text_old_value2 . ").";
        }
        $html .= '
            <div class="main_update">
                <p class="index_update">' . $index . '</p>
                <div class="hidder_update">
                    <div class="h_cercel">
                        <i class="fa fa-user"></i>
                        <p>' . $user_name . '</p>
                    </div>
                    <p class="date_update">' . $row['date_add'] . '</p>
                </div>
                <div class="body_update">
                    <p>' . $description . '</p>
                </div>
            </div>
        ';
    }
    if ($index == 0) {
        $html .= '
			<div class="no_update">
				<i class="fa fa-eye-slash" aria-hidden="true"></i>
				<p>لا توجد سجلات للطلب</p>
			</div>
		';
    }
    echo $html;
}
else if ($action == "changenote") {
    $today = date('Y-m-d H:i:s');
    add_new_history($value, $value1, 'UPDATE_NOTE_ORDER');

    $sql = "UPDATE orders SET disc_order='$value1',data_update='$today' WHERE id=$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }

}
else if ($action == "edite_emportant") {

    $sql = "UPDATE emportants SET emportant='$value1' WHERE id=$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "edite_emportant") {

    $sql = "UPDATE emportants SET emportant='$value1' WHERE id=$value";
    if ($con->query($sql)) {
        echo 'تم التعديل على القسم';
    }
    else {
        echo 'لم يتم التعديل على القسم';
    }
}
else if ($action == "EditeNews") {

    $sql = "UPDATE news SET text='$value1' WHERE id=$value";
    if ($con->query($sql)) {
        echo '11111';
    }
    else {
        echo '00000';
    }
}
else if ($action == "AddDepartment") {
    $stmt = $con->prepare("INSERT INTO department (`new_name`,`old_name`) VALUES (?,?)");
    $stmt->execute(array($value1, $value1));
    if ($stmt) {
        echo '1';
    }
    else {
        echo "2";
    }
}
else if ($action == "AddEmortant") {
    $stmt = $con->prepare("INSERT INTO emportants (`user_id`,`emportant`) VALUES (?,?)");
    $stmt->execute(array($_SESSION['USER_DETAILS']['u_id'], $value1));
    if ($stmt) {
        $use_id1        = $_SESSION['USER_DETAILS']['u_id'];
        $qu_department  = "SELECT * FROM emportants where user_id=$use_id1";
        $sql_department = mysqli_query($result, $qu_department);
        $num_dep        = 0;
        echo ' <ul class="todo-list"> ';
        $id = "";
        while ($row = mysqli_fetch_array($sql_department)) {
            $num_dep = $num_dep + 1;
            $id      = $row["id"];
            echo ' <li style="text-align: right;" class="main-emportent">
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
    }
    else {
        echo '0';
    }
}
else if ($action == "Enter_code") {
    /*$code=substr($value, 0, 4);
	$length = strlen($value);
	$id=substr($value, 4, $length); */
    $stmt = $con->prepare("SELECT num_pro from problems where id = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $get  = $stmt->fetch();
        $code = $get['num_pro'];
        if ($code == $value1) {
            echo "1";
            $stmt_statuse = $con->prepare("UPDATE problems SET solve_it=3 WHERE id=$value");
            $stmt_statuse->execute();
        }
        else {
            echo "2";
        }
    }
    else {
    }
}
else if ($action == "GetAllDetals") {
    //	$ComputerDeatailse="";


    $stmt = $con->prepare("SELECT * from problems where id = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        $get = $stmt->fetch();

        if ($get['solve_it'] == 1) {
            $stmt_statuse = $con->prepare("UPDATE problems SET solve_it=2 WHERE id=?");
            $stmt_statuse->execute(array($value));
        }

        $stmt12 = $con->prepare("SELECT * from computer_de where user_id = ? ");
        $stmt12->execute(array($get['user_id']));
        $get12 = $stmt12->fetch();
        $code  = $get['num_pro'];
        echo '<li class="item"> 
                  <div class="product-info">
                    <a  class="product-title">إسم المرسل 
                    <span class="product-description">
                        ' . $get['user_sender_name'] . '
                    </span>
                  </div>
                </li>
				  <li class="item"> 
				  <div class="product-info">
					<a  class="product-title">عنوان البلاغ
					<span class="product-description">
						  ' . $get['title_problem'] . '
					</span>
                  </div>
                </li>
				  <li class="item"> 
                  <div class="product-info">
                    <a   class="product-title">التفاصيل
                    <span class="product-description" style="white-space: pre-line;">
                         ' . $get['msg'] . '
                    </span>
                  </div>
                </li>
				<li class="item"> 
                  <div class="product-info">
                    <a   class="product-title">تفاصيل النظام
                    <span class="product-description" style="white-space: pre-line;">
                         ' . $get12['system'] . '
                    </span>
                  </div>
                </li> ';
    }
    else {
    }
}
else if ($action == "setDetals") {
    $today = date('Y-m-d H:i:s');
    $stmt  = $con->prepare("INSERT INTO computer_de (`user_id`,`system`,`ip`,`data_update`) VALUES (?,?,?,?)");
    $stmt->execute(array($_SESSION['USER_DETAILS']['u_id'], $_SESSION['all_Details'], $value, $today));
}
else if ($action == "ChangePassword") {
    $value2 = $_POST['value2'];
    if (($value == null) || ($value1 == null) || ($value2 == null)) {
        echo '4';
        return;
    }
    $stmt = $con->prepare("SELECT passrword from users where passrword = ? ");
    $stmt->execute(array($value));
    $count = $stmt->rowCount();
    if ($count > 0) {
        if ($value1 == $value2) {
            $uid = $_SESSION['USER_DETAILS']['u_id'];
            $sql = "UPDATE users SET passrword=$value2 WHERE u_id=$uid";
            if ($con->query($sql)) {
                echo '3';
            }
            else {
                echo '2';
            }
        }
        else {
            echo '1';
        }
    }
    else {
        echo '0';
    }
}
else if ($action == "DetailsComputer") {
    $_SESSION['all_Details'] = $value1;
}
else if ($action == "changesidebar") {
    $_SESSION['changesidebar'] = $value;
}
else if ($action == "SendNumCode") {
    $sql = "UPDATE problems SET isview=1 WHERE id=$value";
    if ($con->query($sql)) {
        echo '1';
    }
    else {
        echo '0';
    }
}
else if ($action == "SendEvent") {

    $user_id     = $_SESSION['USER_DETAILS']['u_id'];
    $json_string = json_encode($value, JSON_PRETTY_PRINT);
    $manage      = json_decode($json_string, true);
    $data        = json_decode($manage);
    $today       = date('Y-m-d H:i:s');
    // json_data.push(eventType);
    // json_data.push(whereClick);
    // json_data.push(text);
    // (int)$data[0]
    $stmt = $con->prepare("INSERT INTO table_events (`emp_id`, `type_event`, `where_event`, `text`, `date_create`) VALUES (?,?,?,?,?)");
    $stmt->execute(array($user_id, $data[0], $data[1], $data[2], $today));


}
else if ($action == "AddExelOrders") {

    $kind_account = $_POST['value1'];
    $json_string  = json_encode($value, JSON_PRETTY_PRINT);
    $manage       = json_decode($json_string, true);
    $data         = json_decode($manage);


    if ($data != null) {
        $phone_number = '0' . $data[1];
        $stmt         = $con->prepare("SELECT `id` from `orders` where `orders`.`phone_number` = ? ");
        $stmt->execute(array($phone_number));
        $count = $stmt->rowCount();
        if ($count < 1) {
            add_new_orders($data[0], $kind_account, $phone_number, $data[2]);
        }

    }


}
else if ($action == "CheckPhoneNumber") {

    $phone_number = $value;

    $stmt = $con->prepare("SELECT `id` from `orders` where `orders`.`phone_number` = ? ");
    $stmt->execute(array($phone_number));
    $count = $stmt->rowCount();
    if ($count > 0) {
        echo "1";
    }
    else {
        echo "0";
    }


}
else if ($action == "MoverOrder") {
    $order_id = $value;
    $user_id  = $value1;

    add_new_history($order_id, $user_id, "UPDATE_MOVE_ORDERS");

    $stmt = $con->prepare("UPDATE orders SET emp_id = :newEmpId WHERE id = :orderID");
    $stmt->bindParam(':newEmpId', $user_id, PDO::PARAM_INT);
    $stmt->bindParam(':orderID', $order_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "11111";
    }
    else {
        echo "00000";
    }


}
else if ($action == "UpdateRowCustomer") {

    $kind_emp = (int)$_SESSION['USER_DETAILS']['kind'];
    $user_id  = $_SESSION['USER_DETAILS']['u_id'];
    $order_id = (int)$_POST['value'];
    $html     = "";
    $index    = 0;
    $stmt1    = $con->prepare("SELECT * from `orders` where `orders`.`id` = ? ");
    $stmt1->execute(array($order_id));
    $count_users = $stmt1->rowCount();
    if ($count_users > 0) {
        $row     = $stmt1->fetch();
        $index   = $index + 1;
        $today   = date('Y-m-d H:i:s');
        $date1   = strtotime($row["data_update"]);
        $date2   = strtotime($today);
        $diff    = abs($date2 - $date1);
        $years   = floor($diff / (365 * 60 * 60 * 24));
        $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));


        $id        = 9;
        $stmt_time = $con->prepare("SELECT `text` from `news` where `news`.`id` = ? ");
        $stmt_time->execute(array($id));
        $get_time      = $stmt_time->fetch();
        $time_update   = (int)($diff / 3600);
        $time_database = (int)$get_time['text'];

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name number_order_sort" style="background-color: #222d32; color: white;">';
        if ($row["movement"] != "0") {
            $html .= ' <i class="fa fa-info" data-toggle="tooltip" title="' . $row["movement"] . '" data-placement="bottom"  data-original-title="' . $row["movement"] . '" aria-hidden="true" style="cursor: help;font-size: 20px;color: #c7c02c;"></i>';
        }

        $html .= '<p>' . $index . '</p>
			</td>';

        $html .= '<td><p>' . $row["id"] . '</p></td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>' . $row["name_customer"] . '</p></td>';

        $html .= '<td  id="' . $row["id"] . '" class="mailbox-name td_customer_number"><p>' . $row["phone_number"] .
            '</p><a data-order="' . $row['id'] . '" data-name="' . $row['name_customer'] . '" data-phone="' . $row['phone_number'] . '" href="#" class="whatsapp_send">
							<i class="fa fa-whatsapp" aria-hidden="true"></i>
						</a>
					</td>';
        $html .= '<td id="' . $row["id"] . '" class="mailbox-name" style="cursor:pointer;">
				<p class="p-text">';
        if ($row["msg"] == "") {
            $html .= 'لا توجد ملاحظات';
        }
        else {
            $html .= $row["msg"];
        }
        $html .= '</p>
			</td>';
        $html .= '<td id="' . $row["id"] . '" class="mailbox-name change_note" style="cursor:pointer; margin-top:50%; margin-right:10px;margin-bottom:5px;"><p class="p-text reqtangular source-css" data-toggle="tooltip" data-placement="bottom" title="' . $row["disc_order"] . '">';
        if ($row["disc_order"] == "") {
            $html .= 'لا يوجد وصف';
        }
        else {
            if (strlen($row["disc_order"]) > 30) {
                $vall = mb_substr($row["disc_order"], 0, 30);
                $html .= $vall . "ـــ.....";
            }
            else {
                $html .= $row["disc_order"];
            }
        }
        $html .= '</p>
			</td>';
        if ($kind_emp == 10 || $kind_emp == 0) {
            $html  .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';
            $stmt1 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
            $stmt1->execute(array($row["emp_id"]));
            $count_users = $stmt1->rowCount();

            if ($count_users > 0) {
                $get  = $stmt1->fetch();
                $html .= $get['u_name'];
            }
            else {
                $html .= 'غير معروف';
            }
            $html .= ' </p> </td>';
        }


        $stmt_status = $con->prepare("SELECT * from `table_status` where `table_status`.`id` = ? ");
        $stmt_status->execute(array($row['status_order']));
        $get_status = $stmt_status->fetch();

        $html .= '
				<td id="' . $row["id"] . '" class="mailbox-name show_statuse" style="cursor:pointer;">
					<p class="reqtangular p-text" style="background-color:' . $get_status['color'] . ';">' . $get_status['name'] . '</p>
				</td>
			';


        $stmt_stars = $con->prepare("SELECT * from `table_stars` where `table_stars`.`id` = ? ");
        $stmt_stars->execute(array($row['stars']));
        $get_stars = $stmt_stars->fetch();

        $stmt_serve = $con->prepare("SELECT * from `table_serve_customer` where `table_serve_customer`.`id` = ? ");
        $stmt_serve->execute(array($row['serve_customer']));
        $get_serve = $stmt_serve->fetch();

        $html .= '
			<td title="' . $row['statuse_note'] . '" id="' . $row["id"] . '" stars="' . $row['stars'] . '" serve_customer="' . $row['serve_customer'] . '" statuse_note="' . $row['statuse_note'] . '" class="mailbox-name show_stars_diloage" data-toggle="modal" data-target="#show_statuse_dialoge">
				<div class="main_td">
					<p class="main_p_1"  style="background-color:' . $get_serve['color'] . ';"> </p>
					<p class="main_p_2"  style="background-color:' . $get_stars['color'] . ';"> </p> 
					<span class="main_span_1">' . $get_stars['table_name'] . '</span>
					<span class="main_span_2">' . $get_serve['name'] . '</span>
				</div>
			</td>
		';

        $html        .= '<td id="' . $row["id"] . '" class="mailbox-name">';
        $stmt_source = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
        $stmt_source->execute(array($row["from_web"]));
        $source_count = $stmt_source->rowCount();
        if ($source_count > 0) {
            $get_source = $stmt_source->fetch();
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['id'] . '" code="' . $row['from_web'] . '">' . $get_source['name'] . '</p>';
            }
            else {
                $html .= $get_source['emp_name'];
            }
        }
        else {
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['id'] . '" code="0">الموقع الإلكتروني</p>';
            }
            else {
                $html .= 'تسويق';
            }

        }

        $html .= '</td>';


        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';
        if ($row["from_whatsapp"] == "1") {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';


        $html .= '<td id="' . $row["id"] . '" class="mailbox-name">';
        if ($row["deleted"] == 1) {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';

        $html .= know_date($row['data_update'], $time_update, $time_database);

        $html .= '</p></td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name data_add"><p>';
        $date = new DateTime($row["data_add"]);
        $html .= date_format($date, 'Y-m-d');

        $html .= '</p></td>';


        $html .= '<td style="font-size: 15px;color:#000;">' . $row['date_add'] . '</td>';

        if (!$row['date_add'] == '') {
            $html .= '<td><a data-id="' . $row['id'] . '" class="btn btn-edit delete_alarm_tr" style="background-color:red !important; height:35px  !important;"><i style="color: white" class="fa fa-close"></i></a></td>';
        }
        else {
            $html .= '<td></td>';
        }


        $html .= '<td  class="mailbox-name">';
        $html .= '<div class="btn-group"> ';

        $buttonFavorite = 'btn btn-def add_to_fovreite';
        if ($row['favorite'] == 1) {
            $buttonFavorite .= ' favorite-button';
        }

        $buttonMotabaa = 'btn btn-def add_to_motabaa';
        if ($row['motabaa'] == 1) {
            $buttonMotabaa .= ' motabaa-button';
        }

        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-danger delete_order"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit add_new_alarm" style="background-color: #ffd000 !important;"><i class="fa fa-bell-o" aria-hidden="true"></i></button>';
        $html .= '<button data-favourite="' . $row['favorite'] . '" data-motabaa="' . $row['motabaa'] . '"  id="' . $row["id"] . '" type="button" class="btn btn-edit edite_order_main"><i class="fa fa-edit" aria-hidden="true"></i></button>';

        $html .= '<button id="' . $row["id"] . '" type="button" class="' . $buttonFavorite . '" is_true="' . $row['favorite'] . '">';
        $html .= '<i class="fa fa-heart" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button id="' . $row["id"] . '" type="button" class="' . $buttonMotabaa . '" is_true="' . $row['motabaa'] . '">';
        $html .= '<i class="fa fa fa-files-o" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit show_history"  class="btn btn-primary" data-toggle="modal" data-target="#show_history">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
			</button>';

        if ($kind_emp == 10 || $kind_emp == 0) {
            $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit show_move_customer"  class="btn btn-primary" data-toggle="modal" data-target="#asing_order_employee" style="color: white !important; background-color: #2ae2b2c7 !important;
			">
				<i class="fa fa-reply" aria-hidden="true"></i>
			</button>';
        }

        $html .= '</div></td>';

    }
    else {
        $html = '';
    }

    echo $html;

}
else if ($action == "UpdateRowUploadCustomer") {

    $kind_emp = (int)$_SESSION['USER_DETAILS']['kind'];
    $user_id  = $_SESSION['USER_DETAILS']['u_id'];
    $order_id = (int)$_POST['value'];
    $html     = "";
    $index    = 0;
    $stmt1    = $con->prepare("SELECT * from `orders` where `orders`.`id` = ? ");
    $stmt1->execute(array($order_id));
    $count_users = $stmt1->rowCount();
    if ($count_users > 0) {
        $row     = $stmt1->fetch();
        $index   = $index + 1;
        $today   = date('Y-m-d H:i:s');
        $date1   = strtotime($row["data_update"]);
        $date2   = strtotime($today);
        $diff    = abs($date2 - $date1);
        $years   = floor($diff / (365 * 60 * 60 * 24));
        $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));


        $id        = 9;
        $stmt_time = $con->prepare("SELECT `text` from `news` where `news`.`id` = ? ");
        $stmt_time->execute(array($id));
        $get_time      = $stmt_time->fetch();
        $time_update   = (int)($diff / 3600);
        $time_database = (int)$get_time['text'];

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name number_order_sort" style="background-color: #222d32; color: white;">';
        if ($row["movement"] != "0") {
            $html .= ' <i class="fa fa-info" data-toggle="tooltip" title="' . $row["movement"] . '" data-placement="bottom"  data-original-title="' . $row["movement"] . '" aria-hidden="true" style="cursor: help;font-size: 20px;color: #c7c02c;"></i>';
        }

        $html .= '<p>' . $index . '</p>
			</td>';

        $html .= '<td><p>' . $row["id"] . '</p></td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>' . $row["name_customer"] . '</p></td>';

        $html .= '<td  id="' . $row["id"] . '" class="mailbox-name td_customer_number"><p>' . $row["phone_number"] .
            '</p><a data-order="' . $row['id'] . '" data-name="' . $row['name_customer'] . '" data-phone="' . $row['phone_number'] . '" href="#" class="whatsapp_send">
							<i class="fa fa-whatsapp" aria-hidden="true"></i>
						</a>
					</td>';
        $html .= '<td id="' . $row["id"] . '" class="mailbox-name" style="cursor:pointer;">
				<p class="p-text">';
        if ($row["msg"] == "") {
            $html .= 'لا توجد ملاحظات';
        }
        else {
            $html .= $row["msg"];
        }
        $html .= '</p>
			</td>';
        $html .= '<td id="' . $row["id"] . '" class="mailbox-name change_note" style="cursor:pointer; margin-top:50%; margin-right:10px;margin-bottom:5px;"><p class="p-text" data-toggle="tooltip" data-placement="bottom" title="' . $row["disc_order"] . '">';
        if ($row["disc_order"] == "") {
            $html .= 'لا يوجد وصف';
        }
        else {
            if (strlen($row["disc_order"]) > 30) {
                $vall = mb_substr($row["disc_order"], 0, 30);
                $html .= $vall . "ـــ.....";
            }
            else {
                $html .= $row["disc_order"];
            }
        }
        $html .= '</p>
			</td>';
        if ($kind_emp == 10 || $kind_emp == 0) {
            $html  .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';
            $stmt1 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
            $stmt1->execute(array($row["emp_id"]));
            $count_users = $stmt1->rowCount();

            if ($count_users > 0) {
                $get  = $stmt1->fetch();
                $html .= $get['u_name'];
            }
            else {
                $html .= 'غير معروف';
            }
            $html .= ' </p> </td>';
        }


        $stmt_status = $con->prepare("SELECT * from `table_status` where `table_status`.`id` = ? ");
        $stmt_status->execute(array($row['status_order']));
        $get_status = $stmt_status->fetch();

        $html .= '
				<td id="' . $row["id"] . '" class="mailbox-name show_statuse" style="cursor:pointer;">
					<p class="reqtangular p-text" style="background-color:' . $get_status['color'] . ';">' . $get_status['name'] . '</p>
				</td>
			';


        $stmt_stars = $con->prepare("SELECT * from `table_stars` where `table_stars`.`id` = ? ");
        $stmt_stars->execute(array($row['stars']));
        $get_stars = $stmt_stars->fetch();

        $stmt_serve = $con->prepare("SELECT * from `table_serve_customer` where `table_serve_customer`.`id` = ? ");
        $stmt_serve->execute(array($row['serve_customer']));
        $get_serve = $stmt_serve->fetch();

        $html .= '
				<td title="' . $row['statuse_note'] . '" id="' . $row["id"] . '" stars="' . $row['stars'] . '" serve_customer="' . $row['serve_customer'] . '" statuse_note="' . $row['statuse_note'] . '" class="mailbox-name show_stars_diloage" data-toggle="modal" data-target="#show_statuse_dialoge">
					<div class="main_td">
						<p class="main_p_1"  style="background-color:' . $get_serve['color'] . ';"> </p>
						<p class="main_p_2"  style="background-color:' . $get_stars['color'] . ';"> </p> 
						<span class="main_span_1">' . $get_stars['table_name'] . '</span>
						<span class="main_span_2">' . $get_serve['name'] . '</span>
					</div>
				</td>
			';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name">';

        $stmt_source = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
        $stmt_source->execute(array($row["from_web"]));
        $source_count = $stmt_source->rowCount();
        if ($source_count > 0) {
            $get_source = $stmt_source->fetch();
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['id'] . '" code="' . $row['from_web'] . '">' . $get_source['name'] . '</p>';
            }
            else {
                $html .= $get_source['emp_name'];
            }
        }
        else {
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['id'] . '" code="0">الموقع الإلكتروني</p>';
            }
            else {
                $html .= 'تسويق';
            }

        }

        $html .= '</td>';


        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';
        if ($row["from_whatsapp"] == "1") {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';


        $html .= '<td id="' . $row["id"] . '" class="mailbox-name">';
        if ($row["deleted"] == 1) {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name"><p>';

        $html .= know_date($row['data_update'], $time_update, $time_database);

        $html .= '</p></td>';

        $html .= '<td id="' . $row["id"] . '" class="mailbox-name data_add"><p>';
        $date = new DateTime($row["data_add"]);
        $html .= date_format($date, 'Y-m-d');

        $html .= '</p></td>';


        $html .= '<td  class="mailbox-name">';
        $html .= '<div class="btn-group"> ';

        $buttonFavorite = 'btn btn-def add_to_fovreite';
        if ($row['favorite'] == 1) {
            $buttonFavorite .= ' favorite-button';
        }

        $buttonMotabaa = 'btn btn-def add_to_motabaa';
        if ($row['motabaa'] == 1) {
            $buttonMotabaa .= ' motabaa-button';
        }

        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-danger delete_order"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit add_new_alarm" style="background-color: #ffd000 !important;"><i class="fa fa-bell-o" aria-hidden="true"></i></button>';
        $html .= '<button  data-favourite="' . $row['favorite'] . '" data-motabaa="' . $row['motabaa'] . '" id="' . $row["id"] . '" type="button" class="btn btn-edit edite_order_main"><i class="fa fa-edit" aria-hidden="true"></i></button>';

        $html .= '<button id="' . $row["id"] . '" type="button" class="' . $buttonFavorite . '" is_true="' . $row['favorite'] . '">';
        $html .= '<i class="fa fa-heart" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button id="' . $row["id"] . '" type="button" class="' . $buttonMotabaa . '" is_true="' . $row['motabaa'] . '">';
        $html .= '<i class="fa fa fa-files-o" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit show_history"  class="btn btn-primary" data-toggle="modal" data-target="#show_history">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
			</button>';

        if ($kind_emp == 10 || $kind_emp == 0) {
            $html .= '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit show_move_customer"  class="btn btn-primary" data-toggle="modal" data-target="#asing_order_employee" style="color: white !important; background-color: #2ae2b2c7 !important;
			">
				<i class="fa fa-reply" aria-hidden="true"></i>
			</button>';
        }

        $html .= '</div></td>';

    }
    else {
        $html = '';
    }

    echo $html;

}
else if ($action == "GetProblems") {


    if (!isset($_SESSION['USER_DETAILS']['kind'])) {
        return 'انتهت الجلسة يرجى تسجيل الدخول من جديد';
    }
    if (!isset($_SESSION['USER_DETAILS'])) {
        return 'انتهت الجلسة يرجى تسجيل الدخول من جديد';
    }
    $kind_emp    = (int)$_SESSION['USER_DETAILS']['kind'];
    $user_id     = $_SESSION['USER_DETAILS']['u_id'];
    $json_string = json_encode($value, JSON_PRETTY_PRINT);
    $manage      = json_decode($json_string, true);
    $data        = json_decode($manage);
    $upload      = (int)$_POST['value2'];
    $html        = '';

    $html .= '
	<thead style="position: sticky;top: 0;z-index: 9; position: sticky;top: 0z-index: 9;">
		<tr>
			<th class="number_th no-sort" style="vertical-align: middle;">رقم</th>
			<th class="number_th no-sort" style="vertical-align: middle;">رقم المعاملة</th>
			<th class="no-sort" style="vertical-align: middle;">اسم العميل</th>
			<th class="no-sort" style="vertical-align: middle;">رقم الجوال</th> 
			<th class="hidefillter no-sort" style="vertical-align: middle;" >ملاحظات العميل</th>
			<th class="hidefillter no-sort" style="vertical-align: middle;">ملاحظات الموظف</th> 
			';

    if ($kind_emp == 10 || $kind_emp == 0) {
        $html .= '<th class="no-sort" style="vertical-align: middle;">الموظف</th>';
    }

    $html .= '
			<th class="no-sort" style="vertical-align: middle;">حالة الطلب</th> 
			<th class="no-sort" style="vertical-align: middle;">تقيم الطلب</th>
			<th class="no-sort" style="vertical-align: middle;">المصدر</th> ';


    if ($upload == 1 && $kind_emp == 0) {
        $html .= '<th class="no-sort" style="vertical-align: middle;">مراحل الطلب</th>';
    }

    $alarm_note_tr = '';
    if ($data[0] == 8) {
        $alarm_note_tr = '<th class="no-sort" style="vertical-align: middle;">محتوى التذكير</th>';
    }
    $html .= '
			
			<th class="no-sort" style="vertical-align: middle;">وتس أب</th> 
			<th class="no-sort" style="vertical-align: middle;">تم الحذف</th> 
			<th class="no-sort" style="vertical-align: middle;">تاريخ اخر متابعة</th> 
			<th class="no-sort" style="vertical-align: middle;">تاريخ تسجيل العمل</th> 
			' . $alarm_note_tr . '
			<th class="no-sort" style="vertical-align: middle;">تاريخ التذكير</th> 
			<th class="no-sort" style="vertical-align: middle;">اغلاق التذكير</th> 
			<th class="no-sort" style="vertical-align: middle;" class="hidefillter">الإجراءات</th>
		</tr>
	</thead>
	<tbody class="total_orders_filter"> ';

    $qu1 = "";

    $search_row = '';
    if ((int)$data[0] == 7) {
        $search_row = " AND `orders`.`favorite` = 1 ";
    }
    else if ((int)$data[0] == 6) {
        $search_row = " AND `orders`.`motabaa` = 1 ";
    }
    else if ((int)$data[0] == 3) {
        $search_row = " AND `orders`.`status_order` = '1' ";
    }
    else if ((int)$data[0] == 5) {
        $search_row = " AND `orders`.`status_order` = '5' ";
    }
    else if ((int)$data[0] == 4) {
        $search_row = " AND `orders`.`status_order` = '3' ";
    }
    else if ((int)$data[0] == 8) {
        $query_alarm = "SELECT order_id FROM table_alarm WHERE  `table_alarm`.`emp_id` = $user_id ";


        if ($_POST['date_alarm_from'] != "") {
            $query_alarm .= " And table_alarm.date_add >='" . $_POST['date_alarm_from'] . "'";
        }

        if ($_POST['date_alarm_to'] != "") {
            $query_alarm .= " And table_alarm.date_add <='" . $_POST['date_alarm_to'] . "'";
        }

        $sql_alarm = mysqli_query($result, $query_alarm);
        $order_ids = [];
        while ($row_alarm = mysqli_fetch_array($sql_alarm)) {
            $order_ids[] = $row_alarm['order_id'];
        }
        if (count($order_ids) > 0) {
            $search_row = " AND `orders`.`id` IN (" . implode(',', $order_ids) . ") ";
        }
        else {
            $search_row = " AND `orders`.`id` IN (0) ";
        }
    }
    else if ((int)$data[0] == 9) {
        $search_row = " AND `orders`.`upload_order` = '1' AND `orders`.`status_order` = '3' ";
    }
    else if ((int)$data[0] == 10) {
        $search_row = " AND `orders`.`upload_order` = '1' AND `orders`.`status_order` = '2' ";
    }
    else if ((int)$data[0] == 11) {
        $search_row = " AND `orders`.`upload_order` = '1' AND `orders`.`status_order` = '4' ";
    }


    $_SESSION["LIMIT_ORDERS"] = $data[1];
    $search_limit             = '';
    $limit                    = $_SESSION["LIMIT_ORDERS"];
    if ($limit != '' && $limit != "all") {
        $search_limit = " LIMIT $limit";
    }


    $customer_name = $data[2];
    $search_name   = '';
    if ($customer_name != '') {
        $search_name = " AND `orders`.`name_customer` LIKE '%$customer_name%'";
    }

    $customer_phone = $data[3];
    $search_phone   = '';
    if ($customer_phone != '') {
        $search_phone = " AND `orders`.`phone_number` LIKE '%$customer_phone%'";
    }

    $start_date  = $data[4];
    $end_date    = $data[5];
    $search_date = '';
    if (!empty($start_date) && !empty($end_date)) {
        $search_date = " AND `orders`.`data_add` BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
    }

    $number_order        = $data[6];
    $search_number_order = '';
    if ($number_order != '') {
        $search_number_order = " AND `orders`.`id` = $number_order ";
    }

    $filter_stars = isset($data[7]) ? $data[7] : null;
    $search_stars = '';
    if ($filter_stars !== null && !empty($filter_stars)) {
        $valuesForINStars = "'" . implode("', '", $filter_stars) . "'";
        $search_stars     = " AND `orders`.`stars` IN ($valuesForINStars) ";
    }

    $filter_posible = isset($data[8]) ? $data[8] : null;
    $search_posible = '';
    if ($filter_posible !== null && !empty($filter_posible)) {
        $valuesForINPosible = "'" . implode("', '", $filter_posible) . "'";
        $search_posible     = " AND `orders`.`serve_customer` IN ($valuesForINPosible) ";
    }


    $filter_statuse        = isset($data[9]) ? $data[9] : null;
    $fillter_search_status = '';
    if ($filter_statuse !== null && !empty($filter_statuse)) {
        $valuesForINStatuse    = "'" . implode("', '", $filter_statuse) . "'";
        $fillter_search_status = " AND `orders`.`status_order` IN ($valuesForINStatuse) ";
    }

    $filter_users = isset($data[10]) ? $data[10] : null;
    $search_users = '';
    if ($filter_users !== null && !empty($filter_users) && ($kind_emp == 10 || $kind_emp == 0)) {
        $valuesForINusers = "'" . implode("', '", $filter_users) . "'";
        $search_users     = " AND `orders`.`emp_id` IN ($valuesForINusers) ";
    }

    $filter_source = isset($data[11]) ? $data[11] : null;
    $search_source = '';
    if ($filter_source !== null && !empty($filter_source)) {
        $valuesForSource = "'" . implode("', '", $filter_source) . "'";
        $search_source   = " AND `orders`.`from_web` IN ($valuesForSource) ";
    }

    $search_customer_orders = '';
    if ($kind_emp != 10 && $kind_emp != 0) {
        $search_customer_orders = " AND `orders`.`emp_id` = '$user_id' ";
    }


    foreach ($data as $key => $item) {

        if ($key == 0 || $key == 1) {
            continue;
        }

        if ($item == '') {
            continue;
        }

        if (is_null($item)) {
            continue;
        }

        if (empty($item)) {
            continue;
        }

        $search_limit = "";
        break;
    }


    if ($data[0] == 8) {
        $date = "";
        if ($data[12] != '') {
            $date = "table_alarm.alarm_date like '%" . $data[12] . "%' and";
        }
        $query_orders = "SELECT *,orders.id as order_id,
                             table_alarm.alarm_date as date_add,
                             table_alarm.note as alarm_note,
                             table_alarm.id as alarm_id
                    FROM orders  
                         left join table_alarm on  table_alarm.order_id= orders.id
                         WHERE " . $date;

    }
    else {
        $query_orders = "SELECT
                            orders.*,
                            orders.id AS order_id,
                            (SELECT alarm_date FROM table_alarm WHERE table_alarm.order_id = orders.id ORDER BY alarm_date DESC LIMIT 1) AS date_add
                        FROM
                            orders where";
    }

    $query_orders .= " 1=1 $search_number_order $search_name $search_phone $fillter_search_status $search_date $search_stars $search_posible $search_users $search_source $search_customer_orders $search_row  ORDER BY data_add DESC$search_limit";

    // echo $query_orders;
    $sql_orders = mysqli_query($result, $query_orders);
    $index      = 0;

    while ($row = mysqli_fetch_array($sql_orders)) {

        $index   = $index + 1;
        $today   = date('Y-m-d H:i:s');
        $date1   = strtotime($row["data_update"]);
        $date2   = strtotime($today);
        $diff    = abs($date2 - $date1);
        $years   = floor($diff / (365 * 60 * 60 * 24));
        $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));


        $id        = 9;
        $stmt_time = $con->prepare("SELECT `text` from `news` where `news`.`id` = ? ");
        $stmt_time->execute(array($id));
        $get_time      = $stmt_time->fetch();
        $time_update   = (int)($diff / 3600);
        $time_database = (int)$get_time['text'];
        if ($time_update < $time_database) {
            $html .= '<tr class="main_tr_' . $row["order_id"] . '" style="background-color: ' . $_SESSION['user_color'] . ';">';
        }
        else {
            $html .= '<tr class="main_tr_' . $row["order_id"] . '">';
        }

        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name number_order_sort" style="background-color: #222d32; color: white;">';
        if ($row["movement"] != "0") {
            $html .= ' <i class="fa fa-info" data-toggle="tooltip" title="' . $row["movement"] . '" data-placement="bottom"  data-original-title="' . $row["movement"] . '" aria-hidden="true" style="cursor: help;font-size: 20px;color: #c7c02c;"></i>';
        }

        $html .= '<p>' . $index . '</p>
			</td>';

        $html .= '<td><p>' . $row["order_id"] . '</p></td>';

        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name"><p>' . $row["name_customer"] . '</p></td>';

        $html .= '<td  id="' . $row["order_id"] . '" class="mailbox-name td_customer_number"><p>' . $row["phone_number"] .
            '</p><a data-name="' . $row['name_customer'] . '" data-order="' . $row['order_id'] . '" data-phone="' . $row['phone_number'] . '" href="#" class="whatsapp_send" >
							<i class="fa fa-whatsapp" aria-hidden="true"></i>
						</a>
					</td>';
        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name" style="cursor:pointer;">
				<p class="p-text">';
        if ($row["msg"] == "") {
            $html .= 'لا توجد ملاحظات';
        }
        else {
            $html .= $row["msg"];
        }
        $html .= '</p>
			</td>';
        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name change_note" style="cursor:pointer; margin-top:30%; margin-right:10px;margin-bottom:5px;"><p class="p-text  reqtangular source-css" data-toggle="tooltip" data-placement="bottom" title="' . $row["disc_order"] . '">';
        if ($row["disc_order"] == "") {
            $html .= 'لا يوجد وصف';
        }
        else {
            if (strlen($row["disc_order"]) > 30) {
                $vall = mb_substr($row["disc_order"], 0, 30);
                $html .= $vall . "ـــ.....";
            }
            else {
                $html .= $row["disc_order"];
            }
        }
        $html .= '</p>
			</td>';
        if ($kind_emp == 10 || $kind_emp == 0) {
            $html  .= '<td id="' . $row["order_id"] . '" class="mailbox-name"><p>';
            $stmt1 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
            $stmt1->execute(array($row["emp_id"]));
            $count_users = $stmt1->rowCount();

            if ($count_users > 0) {
                $get  = $stmt1->fetch();
                $html .= $get['u_name'];
            }
            else {
                $html .= 'غير معروف';
            }
            $html .= ' </p> </td>';
        }


        $stmt_status = $con->prepare("SELECT * from `table_status` where `table_status`.`id` = ? ");
        $stmt_status->execute(array($row['status_order']));
        $get_status = $stmt_status->fetch();

        $html .= '
			<td id="' . $row["order_id"] . '" class="mailbox-name show_statuse" style="cursor:pointer;">
				<p class="reqtangular p-text" style="background-color:' . $get_status['color'] . ';">' . $get_status['name'] . '</p>
			</td>
		';


        $stmt_stars = $con->prepare("SELECT * from `table_stars` where `table_stars`.`id` = ? ");
        $stmt_stars->execute(array($row['stars']));
        $get_stars = $stmt_stars->fetch();

        $stmt_serve = $con->prepare("SELECT * from `table_serve_customer` where `table_serve_customer`.`id` = ? ");
        $stmt_serve->execute(array($row['serve_customer']));
        $get_serve = $stmt_serve->fetch();

        $html .= '
			<td title="' . $row['statuse_note'] . '" id="' . $row["order_id"] . '" stars="' . $row['stars'] . '" serve_customer="' . $row['serve_customer'] . '" statuse_note="' . $row['statuse_note'] . '" class="mailbox-name show_stars_diloage" data-toggle="modal" data-target="#show_statuse_dialoge">
				<div class="main_td">
					<p class="main_p_1"  style="background-color:' . $get_serve['color'] . ';"> </p>
					<p class="main_p_2"  style="background-color:' . $get_stars['color'] . ';"> </p> 
					<span class="main_span_1">' . $get_stars['table_name'] . '</span>
					<span class="main_span_2">' . $get_serve['name'] . '</span>
				</div>
			</td>
		';

        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name">';

        $stmt_source = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
        $stmt_source->execute(array($row["from_web"]));
        $source_count = $stmt_source->rowCount();
        if ($source_count > 0) {
            $get_source = $stmt_source->fetch();
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['order_id'] . '" code="' . $row['from_web'] . '">' . $get_source['name'] . '</p>';
            }
            else {
                $html .= $get_source['emp_name'];
            }
        }
        else {
            if ($kind_emp == 10 || $kind_emp == 0) {
                $html .= '<p class="reqtangular source-css show_source" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['order_id'] . '" code="0">الموقع الإلكتروني</p>';
            }
            else {
                $html .= 'تسويق';
            }

        }


        $html .= '</td>';

        if ($upload == 1 && $kind_emp == 0) {
            $html       .= '<td id="' . $row["order_id"] . '" class="mailbox-name order_stages" style="cursor:pointer;">';
            $stmt_stage = $con->prepare("SELECT * from `table_stage` where `table_stage`.`id` = ? ");
            if ((int)$row['order_stage'] == 0) {
                $html .= '<p class="reqtangular p-text order_stages' . $row['order_stage'] . '">غير محدد</p>';
            }
            else {
                $stmt_stage->execute(array($row['order_stage']));
                $get_stage = $stmt_stage->fetch();
                $html      .= '<p class="reqtangular p-text order_stages' . $row['order_stage'] . '">' . $get_stage['name'] . '</p>';
            }

            $html .= '</td>';
        }


        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name"><p>';
        if ($row["from_whatsapp"] == "1") {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';


        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name">';
        if ($row["deleted"] == 1) {
            $html .= 'نعم';
        }
        else {
            $html .= 'لا';
        }
        $html .= '</td>';

        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name"><p>';

        $html .= know_date($row['data_update'], $time_update, $time_database);

        $html .= '</p></td>';

        $html .= '<td id="' . $row["order_id"] . '" class="mailbox-name data_add"><p>';
        $date = new DateTime($row["data_add"]);
        $html .= date_format($date, 'Y-m-d');

        $html .= '</p></td>';

        $alarm_note_data = $row['alarm_note'];
        if ($alarm_note_data == '') {
            $alarm_note_data = 'لا يوجد محتوي';
        }

        if ($data[0] == 8) {
            $html .= '<td 
                            id="' . $row['alarm_id'] . '" 
                            data-order="' . $row['order_id'] . '"
                            data-note="' . $alarm_note_data . '" 
                            class="mailbox-name  change_alarm_note"
                            style="cursor:pointer; margin-top:30%; margin-right:3px;margin-bottom:5px;">
                <p class="p-text reqtangular source-css" data-toggle="tooltip" data-placement="bottom" title="' . $alarm_note_data . '"> ' . $alarm_note_data . ' </p>
			</td>';
        }


        $html .= '<td style="font-size: 15px;color:#000;">' . $row['date_add'] . '</td>';

        if (!$row['date_add'] == '') {
            $html .= '<td><a data-id="' . $row['order_id'] . '" class="btn btn-edit delete_alarm_tr" style="background-color:red !important; height:35px  !important;"><i style="color: white" class="fa fa-close"></i></a></td>';
        }
        else {
            $html .= '<td></td>';
        }


        $html .= '<td  class="mailbox-name">';
        $html .= '<div class="btn-group"> ';

        $buttonFavorite = 'btn btn-def add_to_fovreite';
        if ($row['favorite'] == 1) {
            $buttonFavorite .= ' favorite-button';
        }

        $buttonMotabaa = 'btn btn-def add_to_motabaa';
        if ($row['motabaa'] == 1) {
            $buttonMotabaa .= ' motabaa-button';
        }

        $html .= '<button  id="' . $row["order_id"] . '" type="button" class="btn btn-danger delete_order"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        $html .= '<button  id="' . $row["order_id"] . '" type="button" class="btn btn-edit add_new_alarm" style="background-color: #ffd000 !important;"><i class="fa fa-bell-o" aria-hidden="true"></i></button>';
        $html .= '<button data-favourite="' . $row['favorite'] . '" data-motabaa="' . $row['motabaa'] . '"  id="' . $row["order_id"] . '" type="button" class="btn btn-edit edite_order_main"><i class="fa fa-edit" aria-hidden="true"></i></button>';

        $html .= '<button id="' . $row["order_id"] . '" type="button" class="' . $buttonFavorite . '" is_true="' . $row['favorite'] . '">';
        $html .= '<i class="fa fa-heart" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button id="' . $row["order_id"] . '" type="button" class="' . $buttonMotabaa . '" is_true="' . $row['motabaa'] . '">';
        $html .= '<i class="fa fa fa-files-o" aria-hidden="true"></i>';
        $html .= '</button>';

        $html .= '<button  id="' . $row["order_id"] . '" type="button" class="btn btn-edit show_history"  class="btn btn-primary" data-toggle="modal" data-target="#show_history">
				<i class="fa fa-clock-o" aria-hidden="true"></i>
			</button>';

        if ($kind_emp == 10 || $kind_emp == 0) {
            $html .= '<button  id="' . $row["order_id"] . '" type="button" class="btn btn-edit show_move_customer"  class="btn btn-primary" data-toggle="modal" data-target="#asing_order_employee" style="color: white !important; background-color: #2ae2b2c7 !important;
			">
				<i class="fa fa-reply" aria-hidden="true"></i>
			</button>';
        }

        $html .= '</div> </td>';

        $html .= '</tr> ';
    }
    if ($index == 0) {
        echo '
			<div class="no_row">
				<i class="fa fa-eye-slash animate__animated animate__bounceIn" aria-hidden="true"></i>
				<p class="animate__animated animate__bounceIn">لا توجد بيانات</p>
			</div>
		';
    }

    $html .= '</tbody>';


    echo $html;
}
else if ($action == "GetReports") {
    $kind_emp    = (int)$_SESSION['USER_DETAILS']['kind'];
    $user_id     = $_SESSION['USER_DETAILS']['u_id'];
    $json_string = json_encode($value, JSON_PRETTY_PRINT);
    $manage      = json_decode($json_string, true);
    $data        = json_decode($manage);
    $html        = '';

    $number_orders = 0;
    $index_users   = 0;


    $filter_users = isset($data[2]) ? $data[2] : null;
    if ($filter_users !== null && !empty($filter_users)) {
        $all_users    = implode(",", $filter_users);
        $search_users = " AND `users`.`u_id` IN ($all_users) ";

        $query_users = "SELECT * FROM users WHERE 1=1   $search_users  ORDER BY u_id ";
        $sql_users   = mysqli_query($result, $query_users);
        while ($row_users = mysqli_fetch_array($sql_users)) {
            $index_users   += 1;
            $emp_name      = $row_users['u_name'];
            $number_orders = 0;
            $emp_id        = $row_users['u_id'];

            $start_date  = $data[0];
            $end_date    = $data[1];
            $search_date = '';
            if (!empty($start_date) && !empty($end_date)) {
                $search_date = " AND `orders`.`data_add` BETWEEN '$start_date 00:00:00' AND '$end_date 23:59:59'";
            }

            $stmt_count_orders = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id $search_date");
            $stmt_count_orders->execute();
            $number_orders = $stmt_count_orders->rowCount();

            $html .= '
				<div class="emp_card">
			';

            $img = '';
            if ($row_users['img'] != '1') {
                $img = 'data:image/jpeg;base64,' . trim($row_users['img'], "'");
            }
            else {
                $img = IMG_USERS;
            }
            $html .= '
				<div class="c_header">
					<div>
					<img src="' . $img . '" class="img-circle" alt="User Image">
						<p class="c_description">' . $emp_name . '</p>
					</div>
					<div class="c_emp_details">
						<strong class="c_description total_num">' . $number_orders . '</strong>
						<p class="c_title">إجمالي الطلبات:</p>
					</div>
				</div>
			';


            $filter_source = isset($data[3]) ? $data[3] : null;
            $search_source = '';
            if ($filter_source !== null && !empty($filter_source)) {

                $html         .= ' 
					<div class="start_line">
						<p>المصادر</p> 
					</div>
					<div class="c_body">
				';
                $query_source = "SELECT * FROM table_source  ORDER BY id ";
                $sql_source   = mysqli_query($result, $query_source);
                while ($row_source = mysqli_fetch_array($sql_source)) {
                    $value_3 = $row_source['code'];
                    if (in_array($value_3, $filter_source)) {
                        $stmt_source = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id  AND `orders`.`from_web`= '$value_3' $search_date ");
                        $stmt_source->execute();
                        $count_source = $stmt_source->rowCount();

                        $html .= ' 
							<div class="c_num_card"> 
								<strong>' . $count_source . '</strong>
								<p>' . $row_source['name'] . '</p>
							</div>
						';
                    }
                }
                $html .= '  
					</div> 
				';
            }

            $filter_stars = isset($data[4]) ? $data[4] : null;
            $search_stars = '';
            if ($filter_stars !== null && !empty($filter_stars)) {

                $html        .= ' 
					<div class="start_line">
						<p>تقييم الطلب</p> 
					</div>
					<div class="c_body">
				';
                $query_stars = "SELECT * FROM table_stars  ORDER BY id ";
                $sql_stars   = mysqli_query($result, $query_stars);
                while ($row_stars = mysqli_fetch_array($sql_stars)) {
                    $value_4 = $row_stars['id'];
                    if (in_array($value_4, $filter_stars)) {
                        $stmt_stars = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id $search_date AND `orders`.`stars`= $value_4 ");
                        $stmt_stars->execute();
                        $count_stars = $stmt_stars->rowCount();

                        $html .= ' 
							<div class="c_num_card" style="background-color:' . $row_stars["color"] . ';"> 
								<strong>' . $count_stars . '</strong>
								<p>' . $row_stars['name'] . '</p>
							</div>
						';
                    }
                }
                $html .= '  
					</div> 
				';
            }

            $filter_move = isset($data[5]) ? $data[5] : null;
            $search_move = '';
            if ($filter_move !== null && !empty($filter_move)) {

                $html       .= ' 
					<div class="start_line">
						<p>عملاء محولين</p> 
					</div>
					<div class="c_body">
				';
                $query_move = "SELECT * FROM table_move_order  ORDER BY id ";
                $sql_move   = mysqli_query($result, $query_move);
                while ($row_move = mysqli_fetch_array($sql_move)) {
                    $value_5 = $row_move['id'];
                    if (in_array($value_5, $filter_move)) {
                        $stmt_move = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id $search_date AND `orders`.`num_move`= $value_5 ");
                        $stmt_move->execute();
                        $count_move = $stmt_move->rowCount();

                        $html .= ' 
							<div class="c_num_card"> 
								<strong>' . $count_move . '</strong>
								<p>' . $row_move['name'] . '</p>
							</div>
						';
                    }
                }
                $html .= '  
					</div> 
				';
            }

            $filter_status = isset($data[6]) ? $data[6] : null;
            $search_status = '';
            if ($filter_status !== null && !empty($filter_status)) {

                $html         .= ' 
					<div class="start_line">
						<p>حالة الطلب</p> 
					</div>
					<div class="c_body">
				';
                $query_status = "SELECT * FROM table_status  ORDER BY id ";
                $sql_status   = mysqli_query($result, $query_status);
                while ($row_status = mysqli_fetch_array($sql_status)) {
                    $value_7 = $row_status['id'];
                    if (in_array($value_7, $filter_status)) {
                        $stmt_status = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id $search_date AND `orders`.`status_order`= $value_7 ");
                        $stmt_status->execute();
                        $count_status = $stmt_status->rowCount();

                        $html .= ' 
							<div class="c_num_card" style="background-color:' . $row_status['color'] . ';"> 
								<strong>' . $count_status . '</strong>
								<p>' . $row_status['name'] . '</p>
							</div>
						';
                    }
                }
                $html .= '  
					</div> 
				';
            }

            $filter_serve = isset($data[7]) ? $data[7] : null;
            $search_serve = '';
            if ($filter_serve !== null && !empty($filter_serve)) {

                $html        .= ' 
					<div class="start_line">
						<p>إمكانية الطلب</p> 
					</div>
					<div class="c_body">
				';
                $query_serve = "SELECT * FROM table_serve_customer  ORDER BY id ";
                $sql_serve   = mysqli_query($result, $query_serve);
                while ($row_serve = mysqli_fetch_array($sql_serve)) {
                    $value_7 = $row_serve['id'];
                    if (in_array($value_7, $filter_serve)) {
                        $stmt_serve = $con->prepare("SELECT * FROM `orders` WHERE `orders`.`emp_id`= $emp_id $search_date AND `orders`.`stars`= $value_7 ");
                        $stmt_serve->execute();
                        $count_serve = $stmt_serve->rowCount();

                        $html .= ' 
							<div class="c_num_card"  style="background-color:' . $row_serve['color'] . ';"> 
								<strong>' . $count_serve . '</strong>
								<p>' . $row_serve['name'] . '</p>
							</div>
						';
                    }
                }
                $html .= '  
					</div> 
				';
            }


            $html .= '  
				</div>
			';
        }
    }


    if ($index_users == 0) {
        $html .= '
			<div class="no_row">
				<i class="fa fa-eye-slash animate__animated animate__bounceIn" aria-hidden="true"></i>
				<p class="animate__animated animate__bounceIn">لا توجد بيانات</p>
			</div>
		';
    }


    echo $html;
}
else if ($action == "UpdateFovrite") {

    $newFavoriteValue = ($value1 == 0) ? 1 : 0;
    $id               = $value;
    add_new_history($id, $newFavoriteValue, 'UPDATE_FOVRITE_ORDER');
    // Use a prepared statement to avoid SQL injection
    $stmt = $con->prepare("UPDATE orders SET favorite = :newFavoriteValue WHERE id = :orderID");
    $stmt->bindParam(':newFavoriteValue', $newFavoriteValue, PDO::PARAM_INT);
    $stmt->bindParam(':orderID', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo "11111";
    }
    else {
        echo "00000";
    }

}
else if ($action == "UpdateMotabaa") {
    $newFavoriteValue = ($value1 == 0) ? 1 : 0;
    $id               = $value;
    add_new_history($id, $newFavoriteValue, 'UPDATE_MOTABAA_ORDER');
    // Use a prepared statement to avoid SQL injection
    $stmt = $con->prepare("UPDATE orders SET motabaa = :newFavoriteValue WHERE id = :orderID");
    $stmt->bindParam(':newFavoriteValue', $newFavoriteValue, PDO::PARAM_INT);
    $stmt->bindParam(':orderID', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "11111";
    }
    else {
        echo "00000";
    }

}
else if ($action == "GetOrderUpoload") {
    echo '
    <thead style="position: sticky;top: 0;z-index: 9; position: sticky;top: 0z-index: 9;">
     	<tr>
    		<th class="number_th no-sort" style="vertical-align: middle;">رقم</th>
    		<th class="no-sort" style="vertical-align: middle;">اسم العميل</th>
    		<th class="no-sort" style="vertical-align: middle;">رقم الجوال</th> 
    		<th class="hidefillter no-sort" style="vertical-align: middle;" >ملاحظات العميل</th>
    		<th class="hidefillter no-sort" style="vertical-align: middle;">ملاحظات الموظف</th> 
    		<th class="no-sort" style="vertical-align: middle;">الموظف</th>  
    		<th class="no-sort" style="vertical-align: middle;">حالة الطلب</th> 
    		<th class="no-sort" style="vertical-align: middle;">تقيم الطلب</th>
    		<th class="no-sort" style="vertical-align: middle;">مراحل الطلب</th>
    		<th class="no-sort" style="vertical-align: middle;">المصدر</th> 
    		<th class="no-sort" style="vertical-align: middle;">وتس أب</th> 
    		<th class="no-sort" style="vertical-align: middle;">تم الحذف</th> 
    		<th class="no-sort" style="vertical-align: middle;">تاريخ اخر متابعة</th> 
    		<th class="no-sort" style="vertical-align: middle;">تاريخ تسجيل العمل</th> 
    		<th class="no-sort" style="vertical-align: middle;">تسجيل الملاحظات</th> 
    		<th class="no-sort" style="vertical-align: middle;" class="hidefillter">الإجراءات</th>
		</tr>
	</thead>
	<tbody class="total_orders_filter_upload"> ';
    $qu1 = "";
    $qu1 = "SELECT orders.id as order_id,* FROM orders WHERE upload_order = 1 ORDER BY id DESC";

    $sql   = mysqli_query($result, $qu1);
    $index = 0;

    while ($row = mysqli_fetch_array($sql)) {
        $index   = $index + 1;
        $today   = date('Y-m-d H:i:s');
        $date1   = strtotime($row["data_update"]);
        $date2   = strtotime($today);
        $diff    = abs($date2 - $date1);
        $years   = floor($diff / (365 * 60 * 60 * 24));
        $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
        $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
        $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
        $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60));

        $id        = 9;
        $stmt_time = $con->prepare("SELECT `text` from `news` where `news`.`id` = ? ");
        $stmt_time->execute(array($id));
        $get_time      = $stmt_time->fetch();
        $time_update   = (int)($diff / 3600);
        $time_database = (int)$get_time['text'];
        if ($time_update < $time_database) {
            echo '<tr style="background-color: ' . $_SESSION['user_color'] . ';">';
        }
        else {
            echo '<tr>';
        }
        echo '<td id="' . $row["id"] . '" class="mailbox-name number_order_sort"><p>' . $index . '</p></td>';
        echo '<td id="' . $row["id"] . '" class="mailbox-name"><p>' . $row["name_customer"] . '</p></td>';

        echo '<td  id="' . $row["id"] . '" class="mailbox-name td_customer_number"><p>' . $row["phone_number"] .
            '</p><a data-order="' . $row['id'] . '" data-name="' . $row['name_customer'] . '" data-phone="' . $row['phone_number'] . '" href="#"  class="whatsapp_send">
								<i class="fa fa-whatsapp" aria-hidden="true"></i>
							</a>
						</td>';
        echo '<td id="' . $row["id"] . '" class="mailbox-name" style="cursor:pointer;">
				    <p class="p-text">';
        if ($row["msg"] == "") {
            echo 'لا توجد ملاحظات';
        }
        else {
            echo $row["msg"];
        }
        echo '</p>
				</td>';
        echo '<td id="' . $row["order_id"] . '" class="mailbox-name change_note reqtangular source-css" style="cursor:pointer; margin-top:50%; margin-right:10px;margin-bottom:5px;"><p class="p-text" data-toggle="tooltip" data-placement="bottom" title="' . $row["disc_order"] . '">';
        if ($row["disc_order"] == "") {
            echo 'لا يوجد وصف';
        }
        else {
            if (strlen($row["disc_order"]) > 30) {
                $vall = mb_substr($row["disc_order"], 0, 30);
                echo $vall . "ـــ.....";
            }
            else {
                echo $row["disc_order"];
            }
        }
        echo '</p>
				</td>';
        echo '<td id="' . $row["id"] . '" class="mailbox-name"><p>';

        $stmt1 = $con->prepare("SELECT `u_name` from `users` where `users`.`u_id` = ? ");
        $stmt1->execute(array($row["emp_id"]));
        $get = $stmt1->fetch();
        echo $get['u_name'];

        echo '</P></td>';

        $stmt2 = $con->prepare("SELECT * from `table_status` where `table_status`.`id` = ? ");
        $stmt2->execute(array($row["status_order"]));
        $get2 = $stmt2->fetch();
        echo $get['u_name'];

        echo '<td id="' . $row["id"] . '" class="mailbox-name show_status" >';
        echo '<p class="p-text" style="border-radius: 10px; background-color: ' . $get2['color'] . '; padding: 5px;">' . $get2['name'] . '</p>';
        echo '  
				</td>';
        echo '<td id="' . $row["id"] . '" class="mailbox-name show_starts" style="cursor:pointer;">';
        if ($row["stars"] == "1") {
            echo '<p class="p-text starts1">غير مقيم 🤔</p>';
        }
        if ($row["stars"] == "2") {
            echo '<p class="p-text starts2">ضعيف ☹️</p>';
        }
        if ($row["stars"] == "3") {
            echo '<p class="p-text starts3">جيد 🙂</p>';
        }
        if ($row["stars"] == "4") {
            echo '<p class="p-text starts4">ممتاز 🤩</p>';
        }
        echo '  
				</td>';

        echo '  
				</td>';


        echo '<td id="' . $row["id"] . '" class="mailbox-name">';
        $stmt_source = $con->prepare("SELECT * FROM `table_source` WHERE `table_source`.`code` = ? ");
        $stmt_source->execute(array($row["from_web"]));
        $get_source = $stmt_source->fetch();
        if ($kind_emp == 10 || $kind_emp == 0) {
            echo '<p class="reqtangular source-css show_source" kind_emp="' . $kind_emp . '" data-toggle="modal" data-target="#show_source_dialoge" order_id="' . $row['id'] . '" code="' . $row['from_web'] . '">' . $get_source['name'] . '</p>';
        }
        else {
            echo $get_source['emp_name'];
        }

        echo '</td>';


        echo '<td id="' . $row["id"] . '" class="mailbox-name"><p>';
        if ($row["from_whatsapp"] == "1") {
            echo 'نعم';
        }
        else {
            echo 'لا';
        }
        echo '</td>';


        echo '<td id="' . $row["id"] . '" class="mailbox-name">';
        if ($row["deleted"] == 1) {
            echo 'نعم';
        }
        else {
            echo 'لا';
        }
        echo '</td>';

        echo '<td id="' . $row["id"] . '" class="mailbox-name"><p>';

        echo know_date($row['data_update'], $time_update, $time_database);

        echo '</p></td>';

        echo '<td id="' . $row["id"] . '" class="mailbox-name data_add"><p>';
        $date = new DateTime($row["data_add"]);
        echo date_format($date, 'Y-m-d');

        echo '</p></td>';


        echo '<td  class="mailbox-name">';
        echo '<div class="btn-group"> ';

        echo '<button  id="' . $row["id"] . '" type="button" class="btn btn-danger delete_order"><i class="fa fa-trash-o" aria-hidden="true"></i></button>';
        echo '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit add_new_alarm" style="background-color: #ffd000 !important;"><i class="fa fa-bell-o" aria-hidden="true"></i></button>';
        echo '<button  id="' . $row["id"] . '" type="button" class="btn btn-edit edite_order_main"><i class="fa fa-edit" aria-hidden="true"></i></button>';

        echo '</div> </td>';

        echo '</tr> ';
    }

    echo '</tbody>';
}
else if ($action == "listDetailsLogs") {

    $hmtl = "";
    $sql  = "SELECT * FROM table_order_history 
            inner join users on users.u_id = table_order_history.how_update
         WHERE order_id = " . $value . " and type_update='UPDATE_NOTE_ORDER' order by id ASC";
    $sql  = mysqli_query($result, $sql);
    while ($row = mysqli_fetch_array($sql)) {
        $html .= "<tr><td> <h5 style='text-align: left'> " . $row['date_add'] . " </h5>  <h5 style='text-align:right'>" . $row['u_name'] . "</h5>  <p style='font-weight: 700;'>" . $row['new_value'] . " </p> </td></tr>";
    }

    echo $html;
}
else if ($action == "change_alarm_note") {
    $alarm_id   = $value1;
    $sql_update = "UPDATE `table_alarm` SET table_alarm.note = '$value' WHERE `table_alarm`.`id` = $alarm_id;";
    // echo $sql_update;
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo '00000';
    }
}
else if ($action == "listWhatsappTemplate") {

    $sql  = "SELECT * FROM `whatsapp_templete` WHERE emp_id in(0," . $_SESSION['USER_DETAILS']['u_id'] . ")";
    $html = "";
    $sql  = mysqli_query($result, $sql);
    while ($row = mysqli_fetch_array($sql)) {

        $content = $row['content'];
        $content = str_replace('$', $_POST['order_id'], $content);
        $content = str_replace('#', $_POST['customer_name'], $content);

        $html = $html . "
            <div class='row'>
                 <div class='col-md-3'>
                      <a href='#' class='go-whatsapp btn btn-primary btn-block'>ارسال</a>                
                </div>
                <div class='col-md-9'>
                   <input type='text' value='" . $content . "' class='templete form-control' style='height:41px'>
                </div>
            </div>      
            <hr>
        ";
    }
    echo $html;
}
else if ($action == 'deleteWhatsAppTemplate') {

    $alarm_id   = $value;
    $sql_update = "DELETE from whatsapp_templete WHERE whatsapp_templete.id=$alarm_id";
    // echo $sql_update;
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo '00000';
    }

}
else if ($action == "updateWhatsAppTemplate") {
    $sql_update = "UPDATE `whatsapp_templete` SET content='" . $_POST["content"] . "' WHERE id=" . $_POST['value'];
    // echo $sql_update;
    if ($con->query($sql_update)) {
        echo "11111";
    }
    else {
        echo '00000';
    }
}
else if ($action == "createWhatsAppTemplate") {

    $emp_id = 0;
    if ($_SESSION['is_admin'] != 0) {
        $emp_id = $_SESSION['user_id'];
    }
    $sql_insert = "INSERT INTO `whatsapp_templete`(`content`, `emp_id`) VALUES ('" . $_POST['value'] . "',$emp_id)";
    $con->query($sql_insert);
}
else {
}


function know_date($date, $time_update, $time_database)
{
    $today   = date('Y-m-d H:i:s');
    $html    = '';
    $date1   = strtotime($date);
    $date2   = strtotime($today);
    $diff    = abs($date2 - $date1);
    $years   = floor($diff / (365 * 60 * 60 * 24));
    $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    $minutes = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
    $seconds = floor($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minutes * 60);

    if ($years > 50) {
        $html .= 'لا توجد اي متابعة';
    }
    else {
        if ($time_update > $time_database) {
            $html .= "أنتهت فترة المتابعة";
        }
        else {
            if ($years != 0) {
                $year_text = ($years == 1) ? " سنة " : ($years == 2 ? " سنتين" : (($years < 11) ? " " . $years . " سنين " : " " . $years . " سنة "));
                $html      .= "قبل" . $year_text;
                $days      = 0;
                $hours     = 0;
                $minutes   = 0;
                $seconds   = 0;
            }
            else if ($months != 0) {
                $month_text = ($months == 1) ? " شهر " : ($months == 2 ? " شهرين" : (($months < 11) ? " " . $months . " أشهر " : " " . $months . " شهر "));
                $year_text  = ($years != 0) ? " و " : " قبل ";
                $html       .= $year_text . $month_text;
                $hours      = 0;
                $minutes    = 0;
                $seconds    = 0;
            }
            else if ($days != 0) {
                $day_text   = ($days == 1) ? " يوم " : ($days == 2 ? " يومان" : (($days < 11) ? " " . $days . " أيام " : " " . $days . " يوم "));
                $month_text = ($months != 0) ? " و " : " قبل ";
                $html       .= $month_text . $day_text;
                $minutes    = 0;
                $seconds    = 0;
            }
            else if ($hours > 0) {
                $hour_text = ($hours == 1) ? " ساعة " : ($hours == 2 ? " ساعتين" : (($hours < 11) ? " " . $hours . " ساعات " : " " . $hours . " ساعة "));
                $day_text  = ($days != 0) ? " و " : " قبل ";
                $html      .= $day_text . $hour_text;
                $seconds   = 0;
            }
            else if ($minutes > 0) {
                $minute_text = ($minutes == 1) ? " دقيقة " : ($minutes == 2 ? " دقيقتان" : (($minutes < 11) ? " " . $minutes . " دقائق " : " " . $minutes . " دقيقة "));
                $hour_text   = ($hours != 0) ? " و " : " قبل ";
                $html        .= $hour_text . $minute_text;
            }
            else if ($seconds > 0) {
                $second_text = ($seconds == 1) ? " ثانية " : ($seconds == 2 ? " ثانيتان" : (($seconds < 11) ? " " . $seconds . " ثواني " : " " . $seconds . " ثانية "));
                $minute_text = ($minutes != 0) ? " و " : " قبل ";
                $html        .= $minute_text . $second_text;
            }
        }
    }

    return $html;
}

function deleteDirectory($dirPath)
{
    if (is_dir($dirPath)) {
        $objects = scandir($dirPath);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (filetype($dirPath . DIRECTORY_SEPARATOR . $object) == "dir") {
                    deleteDirectory($dirPath . DIRECTORY_SEPARATOR . $object);
                }
                else {
                    unlink($dirPath . DIRECTORY_SEPARATOR . $object);
                }
            }
        }
        reset($objects);
        rmdir($dirPath);
    }
}


function add_new_history($order_id, $new_value, $type_event)
{
    global $con;
    $user_id = $_SESSION['USER_DETAILS']['u_id'];
    $today   = date('Y-m-d H:i:s');

    if ($type_event === "UPDATE_STATUSE") {

        $stmt_old = $con->prepare("SELECT `status_order` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['status_order'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_STARS") {

        $stmt_old = $con->prepare("SELECT `stars` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['stars'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_POSSIBLE") {

        $stmt_old = $con->prepare("SELECT `serve_customer` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['serve_customer'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_NOTE_POSSIBLE") {

        $stmt_old = $con->prepare("SELECT `statuse_note` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['statuse_note'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_NOTE_ORDER") {
        $stmt_old = $con->prepare("SELECT `disc_order` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['disc_order'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_FOVRITE_ORDER") {
        $stmt_old = $con->prepare("SELECT `favorite` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['favorite'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_MOTABAA_ORDER") {
        $stmt_old = $con->prepare("SELECT `motabaa` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['motabaa'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_DELETE_ORDER") {
        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, 0, 1, $today));
    }
    else if ($type_event == "UPDATE_ADD_ALARM_ORDER") {
        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, 1, $today));
    }
    else if ($type_event == "UPDATE_ESTEMARA_ORDER") {
        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, 1, $today));
    }
    else if ($type_event == "UPDATE_STAGE_ORDER") {
        $stmt_old = $con->prepare("SELECT `order_stage` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['order_stage'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else if ($type_event == "UPDATE_SOURCE") {
        $stmt_old = $con->prepare("SELECT `from_web` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = $get_value['from_web'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));

    }
    else if ($type_event == "UPDATE_MOVE_ORDERS") {
        $stmt_old = $con->prepare("SELECT `emp_id` from `orders` WHERE `orders`.`id` = ? ");
        $stmt_old->execute(array($order_id));
        $get_value   = $stmt_old->fetch();
        $older_value = (int)$get_value['emp_id'];

        $stmt = $con->prepare("INSERT INTO table_order_history (`order_id`, `how_update`,`type_update`, `new_value`, `old_value` ,`date_add`) VALUES (?,?,?,?,?,?)");
        $stmt->execute(array($order_id, $user_id, $type_event, $new_value, $older_value, $today));
    }
    else {
    }
}


function getOrderHistoryCount($con, $result, $emp_id, $start_date, $end_date)
{
    $sql_all_orders   = "SELECT * FROM orders WHERE orders.emp_id = $emp_id;";
    $query_all_orders = mysqli_query($result, $sql_all_orders);
    $num_orders       = 0;
    $number_history   = 0;

    while ($row_order = mysqli_fetch_array($query_all_orders)) {
        $num_orders++;

        $stmt11 = $con->prepare("SELECT * FROM `table_order_history` 
                                WHERE order_id = ? AND date_add BETWEEN ? AND ?");
        $stmt11->execute(array($row_order["id"], $start_date, $end_date));
        $number_history += (int)$stmt11->rowCount();
    }

    return array('number_history' => $number_history, 'num_orders' => $num_orders);
}

function getEventsCount($con, $emp_id, $start_date, $end_date)
{
    $sql  = "SELECT * FROM `table_events` WHERE emp_id = ? AND date_create BETWEEN ? AND ?";
    $stmt = $con->prepare($sql);
    $stmt->execute(array($emp_id, $start_date, $end_date));
    $count = $stmt->rowCount();

    return $count;
}

function add_msg_to_chate($order_id)
{
    global $con, $result;
    $user_id   = $_SESSION['USER_DETAILS']['u_id'];
    $user_name = $_SESSION['USER_DETAILS']['u_name'];
    $today     = date('Y-m-d H:i:s');
    $can_show  = 1;

    $msg = "هناك رسالة في مناقشة الطلب الخاص بالمعاملة رقم (" . $order_id . ") من طرف الموظف (" . $user_name . ") يرجى النقر على الرسالة لعرض مناقشة الطلب";


    if ($user_id == 10 || $user_id == 0) {

        $stmt = $con->prepare("SELECT `emp_id` from `orders` where `orders`.`id` = ? ");
        $stmt->execute(array((int)$order_id));
        $count = $stmt->rowCount();
        if ($count > 0) {
            $get    = $stmt->fetch();
            $emp_id = $get['emp_id'];

            $stmt = $con->prepare("INSERT INTO `department` (`msg`,`can_show`,`order_id`,`emp_id`,`date_add`) VALUES (?,?,?,?,?)");
            $stmt->execute(array($msg, $can_show, $order_id, $emp_id, $today));
        }

    }
    else {

        $kind              = 0;
        $query             = "SELECT `u_id` from `users` WHERE `users`.`kind` = $kind ;";
        $result_department = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($result_department)) {
            $user_ids = (int)$row['u_id'];
            $stmt     = $con->prepare("INSERT INTO `department` (`msg`,`can_show`,`order_id`,`emp_id`,`date_add`) VALUES (?,?,?,?,?)");
            $stmt->execute(array($msg, $can_show, $order_id, $user_ids, $today));
        }
    }

}

function add_new_orders($name_customer, $from_web, $emp_phone, $msg)
{
    global $con, $result;

    $num_order      = 0;
    $disc_order     = "لا توجد ملاحظات";
    $emp_id         = "0";
    $emp_name       = "";
    $stars          = "1";
    $status_order   = "1";
    $no             = "1";
    $deleted        = "0";
    $today          = date('Y-m-d H:i:s');
    $today1         = "3022-01-26 08:57:20";
    $num_order_true = 0;
    $stmt           = $con->prepare("SELECT name_customer from orders where phone_number = ? ");
    $stmt->execute(array($emp_phone));
    $count = $stmt->rowCount();
    if (!($count > 0)) {
        $query = "SELECT * FROM `users` WHERE `kind` = '2' AND `u_compony` != 0 AND `num_order` = ( SELECT MIN(num_order) FROM `users` WHERE `kind` = '2' AND `u_compony` != 0 ) LIMIT 1 ;";
        $sql   = mysqli_query($result, $query);
        while ($row = mysqli_fetch_array($sql)) {
            $emp_id         = (int)$row["u_id"];
            $emp_name       = $row["u_name"];
            $num_order      = (int)$row["num_order"];
            $num_order_true = (int)$row["num_order_true"];
        }

        $stmt = $con->prepare("INSERT INTO orders (`name_customer`,`phone_number`,`msg`,`emp_id`,`emp_name`,`disc_order`,`stars`,`status_order`,`no`,`from_web`,`deleted`,`data_update`,`data_add`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)");
        $stmt->execute(array($name_customer, $emp_phone, $msg, (string)$emp_id, $emp_name, $disc_order, $stars, $status_order, $no, $from_web, $deleted, $today1, $today));
        if ($stmt) {
            $num1       = (string)$num_order + 1;
            $num2       = (string)$num_order_true + 1;
            $sql_update = "UPDATE `users` SET `num_order` = '$num1', `num_order_true` = '$num2' WHERE `users`.`u_id` = $emp_id;";
            if ($con->query($sql_update)) {
                echo '11111';
            }
            else {
                echo '00000';
            }
        }
        else {
            echo "00000";
        }
    }
    else {
        echo "22222";
    }
}

function generateRandomString($length)
{
    $characters   = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $randomString = str_shuffle($characters);

    return substr($randomString, 0, $length);
}
