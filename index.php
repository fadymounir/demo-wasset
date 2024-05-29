<?php



    session_start();
    date_default_timezone_set("Asia/Riyadh");
    include "crm/config.php";
    $code = isset($_GET['code']) ? $_GET['code'] : 0;
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $new_code = htmlspecialchars($code);
    $new_page = htmlspecialchars($page);

?>
<!DOCTYPE html>
<html lang="ar" style="direction: rtl;">

<head>
    <meta charset="utf-8">
    <title>شركة الوسيط العقارية</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta name="description" content="الحلول العقارية">
    <link rel="canonical" href="https://diyarr.com/">
    <meta property="og:site_name" content="الوسيط الخليج | وجهتك إلى عقار آمن">
    <meta property="og:url" content="https://demo.alwaseet.sa/">
    <meta property="og:title" content="الحلول العقارية">
    <meta property="og:type" content="website">
    <meta property="og:locale:alternate" content="en_GB">
    <meta property="article:publisher" content="https://m.facebook.com">
    <meta property="article:modified_time" content="2023-10-24T13:59:13+00:00">
    <meta name="twitter:site" content="@Diyarrsa">
    <meta property="og:locale" content="ar_AR">
    <!-- Favicon -->
    <link href="<?=WEP_SITE?>images/logo_fursan.png" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Inter:wght@700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="<?=WEP_SITE?>lib/animate/animate.min.css" rel="stylesheet">
    <link href="<?=WEP_SITE?>lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="<?=WEP_SITE?>css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="<?=WEP_SITE?>css/al-fursansaudi.css" rel="stylesheet">
</head>
    <body>

    <?php

        echo '
            <input class="marketing_code" type="hidden" value="'.$new_code.'"/>
            <input class="page" type="hidden" value="'.$new_page.'"/>
        ';

        if($new_page  == 1 || $new_page  == 0){

            $querypage="SELECT * FROM `page` WHERE `page`.`id`=1;";
            $sql = mysqli_query($result,$querypage);
            while($row = mysqli_fetch_array($sql))
            {

                echo '

                    <div class="container-xxl bg-white p-0">
                        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">جار التحميل...</span>
                            </div>
                        </div>

                        <div class="container-fluid nav-bar bg-transparent">
                            <nav class="navbar navbar-expand-lg bg-brimiry navbar-light py-0 px-4">
                                <a href="#" class="navbar-brand d-flex align-items-center text-center">
                                    <div class="icon p-2 me-2">
                                        <img class="img-fluid" id="" src="'.WEP_SITE.'images/logo_white.png" alt="Icon" style="height:140px">
                                    </div>
                                </a>
                                <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                                    <i class="fa fa-bars" aria-hidden="true"></i>
                                </button>
                                <div class="collapse navbar-collapse" id="navbarCollapse">
                                    <div class="navbar-nav ms-auto">
                                        <a href="#id_order" class="nav-item nav-link active">قدم طلبك</a>
                                        ';
                                        if($row["title_about_us"] != "0"){
                                            echo '<a href="#about_us" class="nav-item nav-link">'.$row["title_about_us"].'</a>';
                                        }else{
                                            echo '<a href="#about_us" class="nav-item nav-link">من نحن</a>';
                                        }

                                        if($row["txt_our_service"] != "0"){
                                            echo '<a href="#service" class="nav-item nav-link">'.$row["txt_our_service"].'</a>';
                                        }else{
                                            echo '<a href="#service" class="nav-item nav-link">خدماتنا</a>';
                                        }

                                        if($row['title_call_us'] != "0"){
                                            echo '<a href="#conect_us" class="nav-item nav-link">'.$row["title_call_us"].' </a> ';
                                        }else{
                                            echo '<a href="#conect_us" class="nav-item nav-link">تواصل معنا</a>';
                                        }
                                    echo'
                                    </div>
                                    <a href="tel:'.$row['cn_call_us'].'" class="btn btn-primary px-3 d-lg-flex">قدم طلبك</a>
                                </div>
                            </nav>
                        </div>

                        <div class="container-fluid header bg-white p-0">
                            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                                <div class="col-md-12 animated fadeIn">
                                    <div class="owl-carousel header-carousel">
                                        <div class="owl-carousel-item background-main">
                                            <img class="img-fluid" src="'.WEP_SITE.'images/logo_white.png" alt="a" style="width:0px">
                                            <div class="logo_main p-2">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/logo_white.png" id="logo_center_page" alt="Icon" style="width:100%; height:100%; filter: brightness(100);">
                                                <p class="logo-text">تحتاج حلول عقارية تمكنك من شراء منزلك بسهولة ؟</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid bg-primary mb-5 wow fadeIn" data-wow-delay="0.1s" style="padding: 35px;">
                            <div class="container">
                                <label class="title_order">قدم طلبك الان</label>
                                <p class="sub_title_order">قدّم طلب إستشارة أو إستفسار مجاناً فقط أرسل البيانات الأتية وسيتم الإتصال بك في أقرب وقت ممكن.</p>
                                <div class="row g-2" id="contactForm">
                                    <div id="success"></div>
                                    <div class="col-md-10" id="id_order">
                                        <div class="row g-2">
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control text-end customer_name" placeholder="محمد محمد محمد">
                                                    <label for="name">'; if($row['customer_name']!="0"){ echo $row['customer_name'];}else{ echo "إسمك بالكامل";} echo '</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control text-end custmer_phone" placeholder="0512345678">
                                                    <label for="name">'; if($row['customer_phone']!="0"){ echo $row['customer_phone'];}else{ echo "رقم الجوال";} echo'</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control text-end customer_msg" placeholder="ادخل إستفسارك">
                                                    <label for="name">'; if($row['customer_note']!="0"){ echo $row['customer_note'];} else{ echo "فضلاً إكتب لنا شي (إختياري)";} echo '</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary border-0 w-100 py-3 send-order"><p class="text_send">';
                                            if($row['txt_send_order']!="0"){ echo $row['txt_send_order'];}else{ echo "إرسال الطلب";} echo '</p>
                                            <div class="ld ldld bare em-1"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';


                        if($row['show_about_as']=="1"){
                            echo '
                        <div class="container-xxl py-5">
                            <div class="container">
                                <div class="row g-5 align-items-center" id="about_us">
                                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                        <div class="about-img position-relative overflow-hidden p-5 pe-0">
                                            <img class="img-fluid w-100" src="'.WEP_SITE.'images/about_us.jpg">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                        <h1 class="mb-4">'; if($row['title_about_us']!="0"){ echo $row['title_about_us'];}else{ echo "من نحن";} echo'</h1>
                                        <p class="mb-4"> '; if($row['about_us_dis']!="0"){ echo $row['about_us_dis'];}else{ echo "لا يوجد وصف";} echo'</p>
                                    ';
                                        if($row['show_nobtha_ana']=="1"){
                                            if($row["txt_nobtha_ana"]!="0"){
                                                echo '<p><i class="fa fa-check text-primary me-3"></i>'.$row["txt_nobtha_ana"].'</p>';
                                            }
                                            if($row["comp_efficiency"]!="0"){
                                                echo '<p><i class="fa fa-check text-primary me-3"></i>'.$row["comp_efficiency"].'</p>';
                                            }
                                            if($row["comp_message"]!="0"){
                                                echo '<p><i class="fa fa-check text-primary me-3"></i>'.$row["comp_message"].'</p>';
                                            }
                                            if($row["comp_our_vision"]!="0"){
                                                echo '<p><i class="fa fa-check text-primary me-3"></i>'.$row["comp_our_vision"].'</p>';
                                            }

                                    }
                                        echo '
                                    </div>
                                </div>
                            </div>
                        </div>';

                        }

                        echo '
                        <div class="container-xxl py-5" id="service">
                            <div class="container">
                                <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                                    <h1 class="mb-3">خدماتنا</h1>
                                    <p>نوفر لعملائنا مجموعة من الحلول العقارية الفريده و المبتكرة التي لن تجدها سوى في شركة ديار الخليج العقارية الأولى العقارية .</p>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-3 col-md-12 col-sm-12 wow fadeIn w-50" data-wow-delay="0.1s">
                                        <a class="cat-item d-block bg-lights text-center">
                                            <div class="p-4 category">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/assets.png" alt="Icon">
                                                </div>
                                                <h6>توفير العقارات</h6>
                                                <span>نقدم خدمة توفير العقار المناسب حسب السعر و الموقع من خلال فروعنا المنتشرة  في اكثر من منطقة في الممكلة العربية السعودية </span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 wow fadeIn w-50" data-wow-delay="0.3s">
                                        <a class="cat-item d-block bg-lights text-center">
                                            <div class="p-4 category">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/consultant.png" alt="Icon">
                                                </div>
                                                <h6>استشارات</h6>
                                                <span>لأنها اصعب واكبر عملية شراء يقوم بها الفرد في حياته و لأن كل مواطن سعودي يستحق امتلاك منزله الخاص ، نقدم لكم استشارات مجانية من خبرائنا المتميزين حتى يسهل عليك اتخاز القرار المناسب.</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 wow fadeIn w-50" data-wow-delay="0.5s">
                                        <a class="cat-item d-block bg-lights text-center">
                                            <div class="p-4 category">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/islam.png" style="transform: scale(1.5);" alt="Icon">
                                                </div>
                                                <h6>خدمات متوافقة مع الأحكام الاسلامية</h6>
                                                <span>نوفر لكم حلول الرهن العقاري والتمويل العقاري للقطاع الخاص والحكومي بالتعاون مع الجهات التمويلية المعتمدة. وجميعها متوافقة مع احكام الشريعة الاسلامية.</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-md-12 col-sm-12 wow fadeIn w-50" data-wow-delay="0.5s">
                                        <a class="cat-item d-block bg-lights text-center">
                                            <div class="p-4 category">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/solution.png" alt="Icon">
                                                </div>
                                                <h6>الحلول العقارية</h6>
                                                <span>نوفر لعملائنا مجموعة من الحلول العقارية الفريده و المبتكرة التي لن تجدها سوى في شركة الوسيط للحلول العقارية   .</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-xxl py-5" style="display:none">
                            <div class="container">
                                <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                                    <h1 class="mb-3">أنواع العقارات</h1>
                                    <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد </p>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.1s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-apartment.png" alt="Icon">
                                                </div>
                                                <h6>شقة</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.3s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-villa.png" alt="Icon">
                                                </div>
                                                <h6>فيلا</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.5s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-house.png" alt="Icon">
                                                </div>
                                                <h6>مسكن</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.7s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-housing.png" alt="Icon">
                                                </div>
                                                <h6>مكتب</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.1s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-building.png" alt="Icon">
                                                </div>
                                                <h6>مبنى</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.3s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-neighborhood.png" alt="Icon">
                                                </div>
                                                <h6>تاون هاوس</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.5s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-condominium.png" alt="Icon">
                                                </div>
                                                <h6>محل</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="col-lg-3 col-sm-6 wow fadeIn w-50" data-wow-delay="0.7s">
                                        <a class="cat-item d-block bg-customer text-center rounded" href="">
                                            <div class="rounded p-4">
                                                <div class="icon mb-3">
                                                    <img class="img-fluid" src="'.WEP_SITE.'images/icon-luxury.png" alt="Icon">
                                                </div>
                                                <h6>كراج</h6>
                                                <span>123 خصائص</span>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';

                        echo '
                        <div class="container-xxl py-5" style="display:none;">
                            <div class="container">
                                <div class="row g-0 gx-5 align-items-end">
                                    <div class="col-lg-12">
                                        <div class="text-start text-center mx-auto mb-5 wow slideInLeft" data-wow-delay="0.1s">
                                            <h1 class="mb-3">العقارات المتاحة</h1>
                                            <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم توليد هذا النص من مولد النص العربى، حيث يمكنك أن تولد مثل هذا النص أو العديد </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 text-center text-lg-end wow slideInRight" data-wow-delay="0.1s">
                                        <ul class="nav nav-pills d-inline-flex justify-content-end mb-5">
                                            <li class="nav-item me-2">
                                                <a class="btn btn-outline-primary active" data-bs-toggle="pill" href="#tab-1">متميز</a>
                                            </li>
                                            <li class="nav-item me-2">
                                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-2">للبيع</a>
                                            </li>
                                            <li class="nav-item me-0">
                                                <a class="btn btn-outline-primary" data-bs-toggle="pill" href="#tab-3">للإيجار</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="tab-content">
                                    <div id="tab-1" class="tab-pane fade show p-0 active">
                                        <div class="row g-4">
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.1s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-1.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">فيلا</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الرياض المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 قدم مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 غرف نوم</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 حمام</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.3s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-2.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">2 حمام</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">فيلا</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الرياض المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 قدم مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 حمام</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.5s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-3.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 قدم مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 حمام</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.1s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-4.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للإيجار</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مبنى</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع قدم</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 حمام</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.3s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-5.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مسكن</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 wow fadeIn w-50" data-wow-delay="0.5s">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-5.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للإيجار</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">محل</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع قدم</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سريع</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center wow fadeIn" data-wow-delay="0.1s">
                                                <a class="btn btn-primary py-3 px-5" href="">تصفح المزيد من العقارات</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-pane fade show p-0">
                                        <div class="row g-4">
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-1.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">شقة</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-2.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-3.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-4.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-5.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-4 col-md-6 w-50">
                                                <div class="property-item rounded overflow-hidden">
                                                    <div class="position-relative overflow-hidden">
                                                        <a href=""><img class="img-fluid" src="'.WEP_SITE.'images/property-5.jpg" alt=""></a>
                                                        <div class="bg-primary rounded text-white position-absolute start-0 top-0 m-4 py-1 px-3">للبيع</div>
                                                        <div class="bg-white rounded-top text-primary position-absolute start-0 bottom-0 mx-4 pt-1 px-3">مكتب</div>
                                                    </div>
                                                    <div class="p-4 pb-0">
                                                        <h5 class="text-primary mb-3">$12,345</h5>
                                                        <a class="d-block h5 mb-2" href="">جولدن اربن هاوس للبيع</a>
                                                        <p><i class="fa fa-map-marker-alt text-primary me-2"></i>123 ستريت ، الدمام - المملكة العربية السعودية </p>
                                                    </div>
                                                    <div class="d-flex border-top">
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-ruler-combined text-primary me-2"></i>1000 مربع</small>
                                                        <small class="flex-fill text-center border-end py-2"><i class="fa fa-bed text-primary me-2"></i>3 سرير</small>
                                                        <small class="flex-fill text-center py-2"><i class="fa fa-bath text-primary me-2"></i>2 دورة مياه</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 text-center w-50">
                                                <a class="btn btn-primary py-3 px-5" href="">تصفح المزيد من العقارات</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-xxl py-5" style="display:none">
                            <div class="container">
                                <div class="bg-light rounded p-3">
                                    <div class="bg-white rounded p-4" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                        <div class="row g-5 align-items-center">
                                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.1s">
                                                <img class="img-fluid rounded w-100" src="'.WEP_SITE.'images/call-to-action.jpg" alt="">
                                            </div>
                                            <div class="col-lg-6 wow fadeIn" data-wow-delay="0.5s">
                                                <div class="mb-4">
                                                    <h1 class="mb-3">تواصل معنا </h1>
                                                    <p>نحن دائما على استعداد لتزويدك بأعلى مستوى من الخدمة المتميزة.</p>
                                                </div>
                                                <a href="" class="btn btn-primary py-3 px-4 me-2"><i class="fa fa-phone-alt me-2"></i>إجراء مكالمة</a>
                                                <a href="" class="btn btn-dark py-3 px-4"><i class="fa fa-calendar-alt me-2"></i>احصل على موعد</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-xxl py-5" style="display:none">
                            <div class="container">
                                <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                                    <h1 class="mb-3">وكلاء العقارات</h1>
                                    <p>لكن الألم نفسه كان عظيمًا مع عمل ريبوم. حان الوقت لأن يكون الألم حقيقيًا. الساحة نفسها عادلة ، لكن rebum حقًا عبارة عن ألمين.</p>
                                </div>
                                <div class="row g-4">
                                    <div class="col-lg-3 col-md-6 wow fadeIn w-50" data-wow-delay="0.1s">
                                        <div class="team-item rounded overflow-hidden">
                                            <div class="position-relative">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/team-1.jpg" alt="">
                                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 mt-3">
                                                <h5 class="fw-bold mb-0">الاسم الكامل</h5>
                                                <small>الوصف</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 wow fadeIn w-50" data-wow-delay="0.3s">
                                        <div class="team-item rounded overflow-hidden">
                                            <div class="position-relative">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/team-2.jpg" alt="">
                                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 mt-3">
                                                <h5 class="fw-bold mb-0">الاسم الكامل</h5>
                                                <small>الوصف</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 wow fadeIn w-50" data-wow-delay="0.5s">
                                        <div class="team-item rounded overflow-hidden">
                                            <div class="position-relative">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/team-3.jpg" alt="">
                                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 mt-3">
                                                <h5 class="fw-bold mb-0">الإسم الكامل</h5>
                                                <small>الوصف</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 wow fadeIn w-50" data-wow-delay="0.7s">
                                        <div class="team-item rounded overflow-hidden">
                                            <div class="position-relative">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/team-4.jpg" alt="">
                                                <div class="position-absolute start-50 top-100 translate-middle d-flex align-items-center">
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-facebook-f"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-twitter"></i></a>
                                                    <a class="btn btn-square mx-1" href=""><i class="fab fa-instagram"></i></a>
                                                </div>
                                            </div>
                                            <div class="text-center p-4 mt-3">
                                                <h5 class="fw-bold mb-0">الإسم الكامل</h5>
                                                <small>الوصف</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-xxl py-5" style="display:none">
                            <div class="container">
                                <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                                    <h1 class="mb-3">أراء عملاؤنا!</h1>
                                    <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم تولمثل هذا النص أو العديد </p>
                                </div>
                                <div class="owl-carousel testimonial-carousel wow fadeIn" data-wow-delay="0.1s">
                                    <div class="testimonial-item bg-light rounded p-3">
                                        <div class="bg-white border rounded p-4">
                                            <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم تولمثل هذا النص أو العديد </p>
                                            <div class="d-flex align-items-center">
                                                <img class="img-fluid flex-shrink-0 rounded" src="'.WEP_SITE.'images/testimonial-1.jpg" style="width: 45px; height: 45px;">
                                                <div class="ps-3">
                                                    <h6 class="fw-bold mb-1">اسم العميل</h6>
                                                    <small>مهنة</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-item bg-light rounded p-3">
                                        <div class="bg-white border rounded p-4">
                                            <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم تولمثل هذا النص أو العديد </p>
                                            <div class="d-flex align-items-center">
                                                <img class="img-fluid flex-shrink-0 rounded" src="'.WEP_SITE.'images/testimonial-2.jpg" style="width: 45px; height: 45px;">
                                                <div class="ps-3">
                                                    <h6 class="fw-bold mb-1">اسم العميل</h6>
                                                    <small>المهنه</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="testimonial-item bg-light rounded p-3">
                                        <div class="bg-white border rounded p-4">
                                            <p> هذا النص هو مثال لنص يمكن أن يستبدل في نفس المساحة، لقد تم تولمثل هذا النص أو العديد </p>
                                            <div class="d-flex align-items-center">
                                                <img class="img-fluid flex-shrink-0 rounded" src="'.WEP_SITE.'images/testimonial-2.jpg" style="width: 45px; height: 45px;">
                                                <div class="ps-3">
                                                    <h6 class="fw-bold mb-1">اسم العميل</h6>
                                                    <small>المهنه</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    ';
                    if($row['show_call_us']=="1"){
                            echo '
                            <div class="container-xxl py-5" id="conect_us">
                            <div class="container">
                                <div class="text-center mx-auto mb-5 wow fadeIn" data-wow-delay="0.1s" style="max-width: 600px;">
                                    ';
                                    if($row["title_call_us"]!="0"){
                                            echo '<h1 class="mb-3">'.$row["title_call_us"].'</h1>';
                                    }
                                    if($row["title1_call_us"]!="0"){
                                        echo '<p>'.$row["title1_call_us"].'</p>';
                                    }
                                    echo '
                                </div>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <div class="row gy-4">';
                                            if($row["address_call_us"]!="0"){
                                                echo '
                                                <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.1s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-map-marker-alt text-primary"></i>
                                                        </div>
                                                        <span>'.$row["address_call_us"].'</span>
                                                    </div>
                                                </div>
                                            </div>
                                                ';
                                            }
                                            if($row["mail_call_us"]!="0"){
                                            echo '
                                            <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.3s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-envelope-open text-primary"></i>
                                                        </div>
                                                        <span>'.$row["mail_call_us"].'</span>
                                                    </div>
                                                </div>
                                            </div>';
                                            }
                                            if($row["cn_call_us"]!="0"){
                                            echo '
                                            <div class="col-md-6 col-lg-4 wow fadeIn" data-wow-delay="0.5s">
                                                <div class="bg-light rounded p-3">
                                                    <div class="d-flex align-items-center bg-white rounded p-3" style="border: 1px dashed rgba(0, 185, 142, .3)">
                                                        <div class="icon me-3" style="width: 45px; height: 45px;">
                                                            <i class="fa fa-phone-alt text-primary"></i>
                                                        </div>
                                                        <span>'.$row["cn_call_us"].'</span>
                                                    </div>
                                                </div>
                                            </div>';
                                            }

                                            echo '
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>';
                    }
                    if($row["google_map"]!="0"){
                        echo '
                        <iframe class="position-relative w-100 h-100" id="google_web" style="min-height: 400px; border:0;" src="https://www.google.com/maps/embed?pb='.$row["google_map"].'" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                        </iframe>';
                    }
                    //    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3628.7615472178645!2d46.518189!3d24.562901!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0!2zMjTCsDMzJzQ2LjQiTiA0NsKwMzEnMDUuNSJF!5e0!3m2!1sen!2ssa!4v1670799448206!5m2!1sen!2ssa" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>

                        echo '
                        <div class="container-fluid bg-dark text-white-50 footer pt-5 wow fadeIn" data-wow-delay="0.1s">
                            <div class="container py-5">
                                <div class="row g-5">
                                    <div class="col-lg-4 col-md-6">
                                        <h5 class="text-white mb-4">تواصل معنا</h5>';

                                        if($row["address_call_us"]!="0"){
                                            echo '<p class="mb-2"><i class="fa fa-map-marker-alt me-3">'.$row["address_call_us"].'</i></p>';
                                        }

                                        if($row["cn_call_us"]!="0"){
                                        echo '<p class="mb-2"><i class="fa fa-phone-alt me-3"></i>'.$row["cn_call_us"].'</p>';
                                        }

                                        if($row["mail_call_us"]!="0"){
                                            echo '<p class="mb-2"><i class="fa fa-envelope me-3"></i>'.$row["mail_call_us"].'</p>';
                                        }
                                        if($row["cn_call_us"] != ""){
                                            echo '<a href="tel:'.$row['cn_call_us'].'" class="connect_us_now"><i class="fa fa-phone"></i></a>';
                                        }

                                        echo '

                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <h5 class="text-white mb-4">روابط سريعة</h5>
                                        <a class="btn btn-link text-white-50" href="#id_order">قدم طلبك </a>
                                        <a class="btn btn-link text-white-50" href="#conect_us">اتصل بنا</a>
                                        <a class="btn btn-link text-white-50" href="#service">خدماتنا</a>
                                        <a class="btn btn-link text-white-50" href="#google_web">موقعنا</a>
                                    </div>
                                    <div class="col-lg-4 col-md-6">
                                        <h5 class="text-white mb-4">شركائنا</h5>
                                        <div class="row g-2 pt-2">
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank1.jpg" alt="">
                                            </div>
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank2.jpg" alt="">
                                            </div>
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank3.jpg" alt="">
                                            </div>
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank4.jpg" alt="">
                                            </div>
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank5.jpg" alt="">
                                            </div>
                                            <div class="col-4">
                                                <img class="img-fluid rounded bg-light" src="'.WEP_SITE.'images/bank6.jpg" alt="">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="container">
                                <div class="d-flex pt-2 social-links">';
                                    if($row["url_twitter"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social twitter" href="'.$row["url_twitter"].'"><i class="fab fa-twitter"></i></a>';
                                    }
                                    if($row["url_facebook"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social facebook" href="'.$row["url_facebook"].'"><i class="fab fa-facebook"></i></a>';
                                    }
                                    if($row["url_youtube"]!="0"){
                                        echo '<a href="'.$row["url_youtube"].'" class="btn btn-outline-light btn-social youtube" target="_blank"><i class="fab fa-youtube"></i></a>';
                                    }
                                    if($row["url_linkedin"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social linkedin" href="'.$row["url_linkedin"].'"><i class="fab fa-linkedin"></i></a>';
                                    }
                                    if($row["url_google"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social google" href="'.$row["url_google"].'"><i class="fab fa-google"></i></a>';
                                    }
                                    if($row["url_telegram"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social telegram" href="'.$row["url_telegram"].'"><i class="fab fa-telegram"></i></a>';
                                    }
                                    if($row["url_pinterest"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social pinterest" href="'.$row["url_pinterest"].'"><i class="fab fa-pinterest"></i></a>';
                                    }
                                    if($row["url_whatsapp"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social whatsapp" href="'.$row["url_whatsapp"].'"><i class="fab fa-whatsapp"></i></a>';
                                    }
                                    if($row["url_snapchat"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social snapchat" href="'.$row["url_snapchat"].'"><i class="fab fa-snapchat"></i></a>';
                                    }
                                    if($row["url_instagram"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social instagram" href="'.$row["url_instagram"].'"><i class="fab fa-instagram"></i></a>';
                                    }
                                echo '
                                    </div>
                            </div>
                            <div class="container">
                                <div class="copyright">
                                    <div class="row">
                                        <div class="col-md-12 text-center text-md-start mb-3 mb-md-0">';
                                            $year = date("y");
                                            echo ''.$row["txt_all_r_r"].'  &copy; 20'.$year.' لـ <a class="border-bottom" href="#">'.$row["txt_name_comp"].'</a> ';
                                            echo '
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Footer End -->


                        <!-- Back to Top -->
                        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
                    </div>

                    <div class="okewa-pulse_3" style="border-color:#0dc152;" wfd-id="5"></div>
                    <a class="whats-app" target="_blank">
                        <i class="fab fa-whatsapp" aria-hidden="true"></i>
                    </a>


                ';
            }
        }else if($new_page = 2){
            $querypage="SELECT * FROM `page` WHERE `page`.`id`=1;";
            $sql = mysqli_query($result,$querypage);
            while($row = mysqli_fetch_array($sql))
            {
                echo '
                <div class="main-countenter">
                <div class="countenter">
                    <div class="container-xxl bg-white p-0">
                        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">جار التحميل...</span>
                            </div>
                        </div>
                        <style>
                            .main1{
                                text-align: center;
                                direction: rtl;
                            }
                            .main1 h1,.main1 p{
                                color:white;
                            }
                        </style>

                        <div class="container-fluid header bg-white p-0">
                            <div class="row g-0 align-items-center flex-column-reverse flex-md-row">
                                <div class="col-md-12 animated fadeIn">
                                    <div class="owl-carousel header-carousel">
                                        <div class="owl-carousel-item">
                                            <img class="img-fluid" src="'.WEP_SITE.'images/background1.jpeg" alt="">
                                            <div class="logo_main p-2">
                                                <img class="img-fluid" src="'.WEP_SITE.'images/logo_white.png" alt="Icon" style="width: 300px;height: 200px;filter: brightness(100);">
                                                <p class="logo-text">تـحـتـاج حـلـول عـقـاريـة تـمـكـنـك مـن شـراء مـنـزلـك بـسـهـولـة ؟</p>
                                                <div class="col-lg-12 wow fadeIn main1" data-wow-delay="0.5s">
                                                    <div class="mb-4">
                                                        <h1 class="mb-3">تواصل معنا </h1>
                                                        <p>نحن نرحب دائماً باستفساراتك ومشاركتنا كل مقترحاتك، يمكنك التواصل معنا عبر الرقم الموحد أو الوتس أب، أو من خلال تعبئة النموذج أدنى.</p>
                                                    </div>';
                                                    if($row["cn_call_us"] != ""){
                                                        echo '<a href="tel:'.$row['cn_call_us'].'" class="mantine-rtl-a5xs8v"><i class="fa fa-phone-alt me-2"></i>إتصل بنا مجاناً</a>';
                                                    }
                                                    echo '

                                                    <a href="#" class="btn btn-whatsapp mantine-rtl-a5xs8v send_watsapp"><i class="fab fa-whatsapp me-2"></i> تواصل واتس أب</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="container-fluid bg-primary wow fadeIn" style="padding: 5px !important;" data-wow-delay="0.1s" style="padding: 35px;">
                            <div class="container">
                                <label class="title_order">قدم طلبك الان</label>
                                <p class="sub_title_order">قدّم طلب إستشارة أو إستفسار مجاناً فقط أرسل البيانات الأتية وسيتم الإتصال بك في أقرب وقت ممكن.</p>
                                <div class="row g-2" id="contactForm">
                                    <div id="success"></div>
                                    <div class="col-md-12" id="id_order">
                                        <div class="row g-2">
                                            <div class="col-md-12 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control text-end customer_name" placeholder="محمد محمد محمد">
                                                    <label for="name">'; if($row['customer_name']!="0"){ echo $row['customer_name'];}else{ echo "إسمك بالكامل";} echo '</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control text-end custmer_phone" placeholder="0512345678">
                                                    <label for="name">'; if($row['customer_phone']!="0"){ echo $row['customer_phone'];}else{ echo "رقم الجوال";} echo'</label>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control text-end customer_msg" placeholder="ادخل إستفسارك">
                                                    <label for="name">'; if($row['customer_note']!="0"){ echo $row['customer_note'];} else{ echo "فضلاً إكتب لنا شي (إختياري)";} echo '</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary border-0 w-100 py-3 send-order"><p class="text_send">';
                                            if($row['txt_send_order']!="0"){ echo $row['txt_send_order'];}else{ echo "إرسال الطلب";} echo '</p>
                                            <div class="ld ldld bare em-1"></div>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>';


                        echo '
                        <div class="container-fluid bg-dark text-white-50 footer pt-5 wow fadeIn" data-wow-delay="0.1s">

                            <div class="container">
                                <div class="d-flex pt-2 social-links">';
                                    if($row["url_twitter"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social twitter" href="'.$row["url_twitter"].'"><i class="fab fa-twitter"></i></a>';
                                    }
                                    if($row["url_facebook"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social facebook" href="'.$row["url_facebook"].'"><i class="fab fa-facebook"></i></a>';
                                    }
                                    if($row["url_youtube"]!="0"){
                                        echo '<a href="'.$row["url_youtube"].'" class="btn btn-outline-light btn-social youtube" target="_blank"><i class="fab fa-youtube"></i></a>';
                                    }
                                    if($row["url_linkedin"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social linkedin" href="'.$row["url_linkedin"].'"><i class="fab fa-linkedin"></i></a>';
                                    }
                                    if($row["url_google"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social google" href="'.$row["url_google"].'"><i class="fab fa-google"></i></a>';
                                    }
                                    if($row["url_telegram"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social telegram" href="'.$row["url_telegram"].'"><i class="fab fa-telegram"></i></a>';
                                    }
                                    if($row["url_pinterest"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social pinterest" href="'.$row["url_pinterest"].'"><i class="fab fa-pinterest"></i></a>';
                                    }
                                    if($row["url_whatsapp"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social whatsapp" href="'.$row["url_whatsapp"].'"><i class="fab fa-whatsapp"></i></a>';
                                    }
                                    if($row["url_snapchat"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social snapchat" href="'.$row["url_snapchat"].'"><i class="fab fa-snapchat"></i></a>';
                                    }
                                    if($row["url_instagram"]!="0"){
                                        echo '<a class="btn btn-outline-light btn-social instagram" href="'.$row["url_instagram"].'"><i class="fab fa-instagram"></i></a>';
                                    }

                                echo '
                                    </div>
                            </div>

                        </div>

                        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
                    </div>


                    <div id="watsupform" style="display: none;">
                        <div class="main_watsap animate__animated animate__zoomInDown">
                            <div>
                                <a class="close_whatsup">
                                    <i class="fa fa-close"></i>
                                </a>
                                <p class="title_whatsup">ادخل رقم جوالك للانتقال للخبير العقاري مباشرة </p>
                                <input type="text" value="3" class="website" hidden="">
                                <div class="form-group">
                                    <input class="form-control" id="cust_num" type="number" placeholder="إدخل رقم الجوال" required="required" data-validation-required-message="ادخل رقم الجوال">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <a class="whatsappnumber" href="" target="_blank" hidden=""></a>
                                <div class="text-center">
                                    <div id="success"></div>
                                    <button id="go-to-whatsapp" class="sim-btn hvr-bounce-to-top" type="submit">
                                        <p class="text_send"><i class="fab fa-whatsapp" aria-hidden="true"></i>إضغط هنا للآنتقال إلى الواتساب</p>
                                        <div class="ld ldld bare em-1"></div>
                                    </button>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="container">
                        <div class="copyright">
                            <div class="row">
                                <div class="col-md-12 text-center text-md-start mb-3 mb-md-0">';
                                    $year = date("y");
                                    echo ''.$row["txt_all_r_r"].'  &copy; 20'.$year.' لـ <a class="border-bottom" href="#">'.$row["txt_name_comp"].'</a> ';
                                    echo '
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }
        }


    ?>


        <?php
            echo '
                <div id="watsupform" style="display: none;">
                    <div class="main_watsap animate__animated animate__zoomInDown">
                        <div>
                            <a class="close_whatsup">
                                <i class="fa fa-close"></i>
                            </a>
                            <p class="title_whatsup">ادخل رقم جوالك للانتقال للخبير العقاري مباشرة </p>
                            <input type="text" value="1" class="website" hidden="">
                            <div class="form-group">
                                <input class="form-control" id="cust_num" type="number" placeholder="إدخل رقم الجوال" required="required" data-validation-required-message="ادخل رقم الجوال">
                                <p class="help-block text-danger"></p>
                            </div>
                            <a class="whatsappnumber" href="" target="_blank" hidden=""></a>
                            <div class="text-center">
                                <div id="success"></div>
                                <button id="go-to-whatsapp" class="sim-btn hvr-bounce-to-top" type="submit">
                                    <p class="text_send"><i class="fab fa-whatsapp" aria-hidden="true"></i>إضغط هنا للآنتقال إلى الواتساب</p>
                                    <div class="ld ldld bare em-1"></div>
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- JavaScript Libraries -->
                <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
                <script src="'.WEP_SITE.'lib/wow/wow.min.js"></script>
                <script src="'.WEP_SITE.'lib/easing/easing.min.js"></script>
                <script src="'.WEP_SITE.'lib/waypoints/waypoints.min.js"></script>
                <script src="'.WEP_SITE.'lib/owlcarousel/owl.carousel.min.js"></script>

                <!-- Template Javascript -->
                <script src="'.WEP_SITE.'js/main_script.js"></script>

            ';
        ?>
    </body>
</html>
