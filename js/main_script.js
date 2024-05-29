(function ($) {
    "use strict";

    // Spinner
    var spinner = function () {
        setTimeout(function () {
            if ($('#spinner').length > 0) {
                $('#spinner').removeClass('show');
            }
        }, 1);
    };
    spinner();
    
    
    // Initiate the wowjs
    // new WOW().init();


    // Sticky Navbar
    $(window).scroll(function () {
        if ($(this).scrollTop() > 100) {
            $('.nav-bar').addClass('sticky-top');
        } else {
            $('.nav-bar').removeClass('sticky-top');
        }
    });
    
    
    // Back to top button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 300) {
            $('.back-to-top').fadeIn('slow');
        } else {
            $('.back-to-top').fadeOut('slow');
        }
    });
    $('.back-to-top').click(function () {
        $('html, body').animate({scrollTop: 0}, 0, 'easeInOutExpo');
        return false;
    });


    // Header carousel
    $(".header-carousel").owlCarousel({
        autoplay: false,
        smartSpeed: 1500,
        items: 1,
        dots: false,
        loop: false,
        nav : false,
        navText : [
            '<i class="bi bi-chevron-left"></i>',
            '<i class="bi bi-chevron-right"></i>'
        ]
    });


    // Testimonials carousel
    $(".testimonial-carousel").owlCarousel({
        autoplay: false,
        smartSpeed: 1000,
        margin: 24,
        dots: false,
        loop: false,
        nav : false,
        navText : [
            '<i class="bi bi-arrow-left"></i>',
            '<i class="bi bi-arrow-right"></i>'
        ],
        responsive: {
            0:{
                items:1
            },
            992:{
                items:2
            }
        }
    });

    var regex = new RegExp(/^(05|5)(05|0|5|3|6|4|9|1|8|7|2)([0-9]{7})$/);
    function toEnglishNumber(strNum) {
    
       var ar = [
           '٠','١','٢','٣','٤','٥','٦','٧','٨','٩',' ','-','/','|','~','٫'
       ];
    
       var en = [
           '0','1','2','3','4','5','6','7','8','9','','','','','','.'
       ];
    
       var cache = strNum;
    
       for (var i = 0; i < 10; i++) {
           var regex_ar = new RegExp(ar[i], 'g');
           cache = cache.replace(regex_ar, en[i]);
       }
       return cache;
    }

    var currentValue = localStorage.getItem('session');
    var url_action ="https://demo.alwaseet.sa/crm/admin/action.php"; 
    initSessiont();
    function initSessiont(){
        let marketing_code = $('.marketing_code').val();
        let replay = 1;
        if (currentValue === null) { 
            localStorage.setItem('session', 1); 
            replay = 1;
        } else {
            replay = 0;
        }

        let dataString = 'action=new_visitings&value=' + marketing_code + '&value1='+replay;
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,  
            success: function(msg) {
            
            },
            error: function() {
            
            },
            complete: function() { 
                
            }
        }); 
    }
    
    function pad (str, max) {
        str = str.toString();
        return str.length < max ? pad("0" + str, max) : str;
    }

    $('.send-order').on('click',function(){ 
        var this_button=$(this);
        var formm = $(this).closest('#contactForm'); 
        var cust_name = formm.find('.customer_name').val();
        var number_phone = formm.find('.custmer_phone').val();
        var cust_msg = formm.find('.customer_msg').val();
        let marketing_code = $('.marketing_code').val();

        formm.find('.ldld').css('display','block');
        this_button.prop("disabled", true);
        this_button.find('.text_send').css('display','none');
        
        var english_phone =toEnglishNumber($.trim(number_phone));
            
        var cust_num; 
        var first = english_phone.charAt(0);
        switch(first){
            case '5':
                cust_num = pad($.trim(english_phone), 10);
                break; 
            default:
                cust_num = english_phone;
            break;
        };
        
        if (cust_name.trim() == "") {
            formm.find('#success').html("<div class='alert alert-warning'>");
            formm.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
            formm.find('#success > .alert-warning').append(("<strong>يرجى إدخال إسمك الكامل</strong>"))
            formm.find('#success > .alert-warning').append('</div>');
            $('.ldld').css('display','none');
            this_button.prop("disabled", false);
            this_button.find('.text_send').css('display','block');
        } else if (cust_num.trim() == "") {
            formm.find('#success').html("<div class='alert alert-warning'>");
            formm.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
            formm.find('#success > .alert-warning').append(("<strong>يرجى إدخال رقم الجوال الخاص بك</strong>"))
            formm.find('#success > .alert-warning').append('</div>');
            this_button.find('.text_send').css('display','block');
            this_button.prop("disabled", false);
            $('.ldld').css('display','none');
        } else if (!(regex.test(cust_num))) {
            formm.find('#success').html("<div class='alert alert-warning'>");
            formm.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
            formm.find('#success > .alert-warning').append(("<strong> يرجى ادخال رقم جوال بصيغة <hr style='margin: 3px;'> 0512345678 - 512345678 </strong>"))
            formm.find('#success > .alert-warning').append('</div>');
            this_button.prop("disabled", false);
            this_button.find('.ldld').css('display','none');
            this_button.find('.text_send').css('display','block');
        } else {
            this_button.prop("disabled", true); 
            let orders = "";
            let dataString = 'action=add_order_rafa&value=' + marketing_code + '&value1='+cust_name+ '&cus_phone='+cust_num+ '&cus_note=' + cust_msg + '&req_text='+orders;
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false, 
                success: function(msg) {
                    
                    setTimeout(function() {
                        if (msg === "22222") {
                            formm.find('#success').html("<div class='alert alert-warning'>");
                            formm.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
                            formm.find('#success > .alert-warning').append($("<strong>").text("عذراً تم إرسال طلب سابق على الرقم  " + cust_num + " ,لمتابعة طلبك أضغط على أيقونة الوتس اب ثم ادخل رقمك ثم  إرسال للتواصل مع مستشارك العقاري "));
                            formm.find('#success > .alert-warning').append('</div>');
                            formm.find('#contactForm').trigger("reset");
                            this_button.find('.ldld').css('display','none');
                            this_button.find('.text_send').css('display','block');
                        } else if (msg === "11111") {
                            formm.find('#success').html("<div class='alert alert-success'>");
                            formm.find('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
                            formm.find('#success > .alert-success').append("<strong>تم إرسال طلبك بنجاح</strong>");
                            formm.find('#success > .alert-success').append('</div>');
                            //clear all fields
                            formm.find('#contactForm').trigger("reset");
                            this_button.find('.ldld').css('display','none');
                            this_button.find('.text_send').css('display','block');
                        } else if (msg === "00000") {
                            formm.find('#success').html("<div class='alert alert-danger'>");
                            formm.find('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
                            formm.find('#success > .alert-danger').append($("<strong>").text("عذراً " + cust_name + ", يبدو أن الخادم الخاص بي لا يستجيب.الرجاء معاودة المحاولة في وقت لاحق!"));
                            // $('#success > .alert-danger').append($("<strong>").text("Sorry " + firstName + ", it seems that my mail server is not responding. Please try again later!"));
                            formm.find('#success > .alert-danger').append('</div>');
                            //clear all fields
                            $('#contactForm').trigger("reset");
                            this_button.find('.ldld').css('display','none');
                            this_button.find('.text_send').css('display','block');
                        } else {

                        }
                    }, 1000);
                },
                error: function() {
                    // Fail message
                    formm.find('#success').html("<div class='alert alert-danger'>");
                    formm.find('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
                    formm.find('#success > .alert-danger').append($("<strong>").text("عذراً " + cust_name + ", يبدو أن الخادم الخاص بي لا يستجيب.الرجاء معاودة المحاولة في وقت لاحق!"));
                    // $('#success > .alert-danger').append($("<strong>").text("Sorry " + firstName + ", it seems that my mail server is not responding. Please try again later!"));
                    $('#success > .alert-danger').append('</div>');
                    //clear all fields
                    formm.find('#contactForm').trigger("reset");
                    formm.find('.ldld').css('display','none');
                    formm.find('.send-order').find('.text_send').css('display','block');
                },
                complete: function() {
                    setTimeout(function() {
                        formm.find('.send-order').prop("disabled", false); // Re-enable submit button when AJAX call is complete
                    }, 1000);
                }
            });

        }
        
    });

    $('.whats-app').on('click', function() {
        $('#watsupform').css('display', 'flex');
    });
    
    $('.send_watsapp').on('click', function() {
        $('#watsupform').css('display', 'flex');
    });

    $('.close_whatsup').on('click', function() {
        $('#watsupform').on(100).fadeOut("slow");
    });
    
    $('.close').on('click',function(){
        $(this).closest('.alert').remove();
    });
    
    $('.close_menu').on('click', function() {
        $('#navbarResponsive').removeClass("show");
    });
    
    $('#go-to-whatsapp').on('click', function() {
        var this_button = $('#go-to-whatsapp');
        var form = $(this).closest('#watsupform');
        var number_phone = form.find('#cust_num').val(); 
        var marketing_code = $('.marketing_code').val();
        
        var english_phone =toEnglishNumber($.trim(number_phone));
            
        var cust_num; 
        var first = english_phone.charAt(0);
        switch(first){
            case '5':
                cust_num = pad($.trim(english_phone), 10);
                break; 
            default:
                cust_num = english_phone;
            break;
        }; 
        if (cust_num.trim() == "") {
            form.find('#success').html("<div class='alert alert-warning'>");
            form.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
            form.find('#success > .alert-warning').append(("<strong>يرجى إدخال رقم الجوال الخاص بك</strong>"))
            form.find('#success > .alert-warning').append('</div>');
        } else if (!(regex.test(cust_num))) {
            form.find('#success').html("<div class='alert alert-warning'>");
            form.find('#success > .alert-warning').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
            form.find('#success > .alert-warning').append(("<strong> يرجى ادخال رقم جوال بصيغة <hr style='margin: 3px;'> 0512345678 </strong>"))
            form.find('#success > .alert-warning').append('</div>');
        } else {
            this_button.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
            var dataString = 'action=getemploynumber&value=' + cust_num + '&value1=' + marketing_code;
            $.ajax({
                type: "POST",
                url:  url_action,
                data: dataString,
                cache: false,
                success: function(response) {
                    console.log(dataString)
                    console.log(response)
                    if (response != "00000" ||response != "22222") {
                        var whatsappUrl = "https://wa.me/" + response;
                        window.location.href = whatsappUrl;
                        this_button.prop("disabled", false);
                    } else { 
                        // window.open("whatsapp://send/?phone=" + response + "&text=");
                        // openWhatsAppChat(response);
                        // window.open("https://wa.me/" + response);
                        // window.open("https://api.whatsapp.com/send/?phone="+response+"&text&type=phone_number&app_absent=0");
                        // openWhatsAppChat(response);
                        // this_button.prop("disabled", false); // Re-enable submit button when AJAX call is complete
                        // form.find('.whatsappnumber').prop("href", "https://api.whatsapp.com/send?phone="+msg);
                        // form.find('.whatsappnumber').trigger('click'); 
                    }
                },
                error: function() {
                    // Fail message
                    form.find('#success').html("<div class='alert alert-danger'>");
                    form.find('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;").append("</button>");
                    form.find('#success > .alert-danger').append($("<strong>").text("عذراً , يبدو أن الخادم الخاص بي لا يستجيب.الرجاء معاودة المحاولة في وقت لاحق!"));
                    // $('#success > .alert-danger').append($("<strong>").text("Sorry " + firstName + ", it seems that my mail server is not responding. Please try again later!"));
                    form.find('#success > .alert-danger').append('</div>');
                    //clear all fields
                    form.find('#contactForm').trigger("reset");
                    form.find("input#phone").closest('#contactForm').find('.ld').css('display', 'none');
                    form.find("input#phone").closest('#contactForm').find('.text_send').css('display', 'block');
                },
                complete: function() {
                    setTimeout(function() {
                        this_button.prop("disabled", false); // Re-enable submit button when AJAX call is complete
                    }, 1000);
                }
            });

        }
    });

    
    
})(jQuery);

