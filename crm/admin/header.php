<header class="main-header">
    <!-- Logo -->
    <a href="home_admin.php?data=0" class="logo">
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg" style="color: #f0c1a8;">
        <b style="color: #c59019;font-size: 15px;">الوسيط العقارية</b>
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">النافذة المنبثقة</span>
        </a>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-envelope-o"></i>
                        <span class="label label-success all_meesages_nofite"></span>
                    </a>
                    <ul class="dropdown-menu all_meessages_chat">

                    </ul>
                </li>
                <li>
                <li>
                    <a class="font-plus" data-toggle="tooltip" data-placement="bottom" title="زيادة حجم الخط"><i class="fa fa-plus" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a class="font-minus" data-toggle="tooltip" data-placement="bottom" title="تصغير حجم الخط"><i class="fa fa-minus" aria-hidden="true"></i></a>
                </li>
                <li>
                    <a class="gofs" data-toggle="tooltip" data-placement="bottom" title="ملئ الشاشة"><i class="fa fa-arrows-alt" aria-hidden="true"></i></a>
                </li>
                </li>

                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">

                        <?php
                        $img = '';
                        if ($_SESSION['USER_DETAILS']['img'] != '1') {
                            $img = 'data:image/jpeg;base64,' . trim($_SESSION['USER_DETAILS']['img'], "'");
                        }
                        else {
                            $img = IMG_USERS;
                        }
                        echo '<img src="' . $img . '" class="user-image customer_user_img" alt="User Image" style="float: right; margin-left: 10px;">';

                        ?>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php
                            $img = '';
                            if ($_SESSION['USER_DETAILS']['img'] != '1') {
                                $img = 'data:image/jpeg;base64,' . trim($_SESSION['USER_DETAILS']['img'], "'");
                            }
                            else {
                                $img = IMG_USERS;
                            }
                            echo ' <img src="' . $img . '" class="img-circle customer_user_img" alt="User Image">';

                            ?>

                            <p>
                                <?= $_SESSION['USER_DETAILS']['u_name'] ?>
                                <small> <?= $_SESSION['USER_DETAILS']['u_job'] ?></small>
                            </p>
                        </li>
                        <li class="user-footer">
                            <div class="exit_user">
                                <a class="btn btn-default btn-flat w-100">خروج </a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </nav>

</header>


<style>
    .skin-blue .main-header .navbar,
    .skin-blue .main-header .logo {
        background-color: <?php echo $_SESSION['navbar_color']?> !important;
    }

    .main-sidebar {
        background-color: <?php echo $_SESSION['sidebar_color']?> !important;
    }

    .custom_sidebar_label {
        color: <?php echo $_SESSION['sidebar_text_color']?> !important;
        font-weight: 700;
    }

    .bg-navy {
        background-color: <?php echo $_SESSION['home_boxes']?> !important;
    }

    .skin-blue .sidebar-menu > li:hover > a {
        background: <?php echo $_SESSION['sidebar_hover_color']?> !important;
    }

    .skin-blue .sidebar-menu > li.active > a {
        background: <?php echo $_SESSION['sidebar_hover_color']?> !important;
    }

</style>