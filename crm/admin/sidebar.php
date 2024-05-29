
<aside class="main-sidebar"> 
    <section class="sidebar"> 
      <div class="user-panel">
        <input class="url_logout" type="hidden" value="<?=URL_LOGOUT?>"/>
        <div class="pull-right image">
          <input type="hidden" value="<?=$_SESSION['USER_DETAILS']['u_id']?>" class="customer_user_id"/>
          <?php 
            $img = '';
            if($_SESSION['USER_DETAILS']['img'] != '1'){
              $img = 'data:image/jpeg;base64,'.trim($_SESSION['USER_DETAILS']['img'], "'");
            }else{
              $img = IMG_USERS;
            }
            echo '<img src="'.$img.'" class="img-circle customer_user_img" alt="User Image">';
          
          ?> 
        </div>

        <div class="pull-right info">
          <p><?=$_SESSION['USER_DETAILS']['user_name'] ?></p> 
        </div>

      </div>
 
      <ul class="sidebar-menu" data-widget="tree">
  <li class="<?= $_SESSION['PAGE'] == 1 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على الصفحة الرئيسية">
    <a class="changepage" href="<?= URL_DASHBORARD ?>">
      <i class="fa fa-home"></i> <span class='custom_sidebar_label'>الصفحة الرئيسية</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 2 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة جميع العملاء">
    <a class="changepage" href="<?= URL_ALL_CUSTOMERS ?>">
      <i class="fa fa-list"></i>
      <span class='custom_sidebar_label'>جميع العملاء</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 3 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة العملاء الجديدة">
    <a class="changepage" href="<?= URL_NEW_CUSTOMERS ?>">
      <i class="fa fa-users" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>العملاء الجديدة</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 4 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة عملاء قيد التنفيذ">
    <a class="changepage" href="<?= URL_CUSTOMERSـIN_USE ?>">
      <i class="fa fa-users" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>العملاء قيد التنفيذ</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 5 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة عملاء لم يتم الرد">
    <a class="changepage" href="<?= URL_CUSTOMERSـNO_CALL ?>">
      <i class="fa fa-phone" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>العملاء لم يتم الرد</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 6 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة عملاء المتابعة">
    <a class="changepage" href="<?= URL_CUSTOMERSـMOTABAA ?>">
      <i class="fa fa-files-o"></i>
      <span class='custom_sidebar_label'>عملاء المتابعة</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 7 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة العملاء المميزين">
    <a class="changepage" href="<?= URL_CUSTOMERSـFOVRITE ?>">
      <i class="fa fa-star" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>عملاء مميزين</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 8 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة عملاء التذكير">
    <a class="changepage" href="<?= URL_CUSTOMERSـNOTIFICATION ?>">
      <i class="fa fa-bell-o" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>عملاء التذكير</span>
    </a>
  </li>

  <li class="<?= $_SERVER['PHP_SELF'] == 'all_messages' ? 'active' : '' ?>">
      <a class="changepage" href="/crm/admin/page/all_messages">
          <i class="fa fa-telegram" aria-hidden="true"></i>
          <span class='custom_sidebar_label'>كل الرسائل</span>
      </a>
  </li>


  <li class="<?= $_SERVER['PHP_SELF'] == 'whatsapp_templete' ? 'active' : '' ?>">
      <a class="changepage" href="/crm/admin/page/whatsapp_templete">
          <i class="fa fa-telegram" aria-hidden="true"></i>
          <span class='custom_sidebar_label'>قوالب الواتساب</span>
      </a>
  </li>


  <hr>
  <li class="<?= $_SESSION['PAGE'] == 9 ? 'active' : '' ?> make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة العملاء المرفوعة">
    <a class="changepage" href="<?=URL_PROCESS_UPLOAD_ORDERS?>">
      <i class="fa fa-file-text-o" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>الطلبات المرفوعه</span>
      <span style="font-size: 11px; color: #3c3c3c; position: absolute; bottom: 0; right: 13%;">(قيد التنفيذ)</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 10 ? 'active' : '' ?>">
    <a class="changepage" href="<?=URL_CANCEL_UPLOAD_ORDERS?>">
      <i class="fa fa-file-text-o" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>الطلبات المرفوعه</span>
      <span style="font-size: 11px; color: #3c3c3c; position: absolute; bottom: 0; right: 13%;">(ملغية)</span>
    </a>
  </li>

  <li class="<?= $_SESSION['PAGE'] == 11 ? 'active' : '' ?>">
    <a class="changepage" href="<?=URL_FINISH_UPLOAD_ORDERS?>">
      <i class="fa fa-file-text-o" aria-hidden="true"></i>
      <span class='custom_sidebar_label'>الطلبات المرفوعه</span>
      <span style="font-size: 11px; color: #3c3c3c; position: absolute; bottom: 0; right: 13%;">(منتهية)</span>
    </a>
  </li>
  <hr>
  <?php
    $kind_emp_side_bar = (int)$_SESSION['USER_DETAILS']['kind'];
    if ($kind_emp_side_bar == 10 || $kind_emp_side_bar == 0) { 
      echo '
      

      <li class="'.($_SESSION['PAGE'] == 17 ? 'active' : '' ).' make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة التسويق">
        <a class="changepage" href="'.URL_MARKETING.'">
          <i class="fa fa-bullhorn" aria-hidden="true"></i>
          <span class="custom_sidebar_label">التسويق</span>
        </a>
      </li>
      <li class="'.($_SESSION['PAGE'] == 14 ? 'active' : '' ).' make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة حسابات الموظفين">
        <a class="changepage" href="'.URL_ACCOUNTS.'">
          <i class="fa fa-user" aria-hidden="true"></i>
          <span class="custom_sidebar_label">حسابات الموظفين</span>
        </a>
      </li>
    
      <li class="'.($_SESSION['PAGE'] == 16 ? 'active' : '' ).' make_event"  type_event="click" where_click="all_orders" type_text="النقر على صفحة التقرير">
        <a class="changepage" href="'.URL_REPORTS.'">
          <i class="fa fa-bar-chart" aria-hidden="true"></i>
          <span class="custom_sidebar_label">التقارير</span>
        </a>
      </li>
      ';
    } 
  ?>
  
    <li class="'.($_SESSION['PAGE'] == 15 ? 'active' : '' ).'"> 
        <a class="changepage" href="/crm/admin/page/settings">
          <i class="fa fa-cog" aria-hidden="true"></i>
          <span class="custom_sidebar_label">اعدادات النظام</span>
        </a>
  </li>


</ul>
    </section>
    <!-- /.sidebar -->
  </aside>  