$(function () { 
    moment.locale('ar');
    
    $('#AllOrders').on('change', 'input', function () {  
            var rowcount= $('#AllOrders').find('tr').filter(function() {
                return $(this).css('display') !== 'none';
            }).length;
            $('.number_orders').text((rowcount-1)+" إجمالي الطلبات");
    }); 
  
    $('#AllOrders_upload').on('change', 'input', function () {  
        var rowcount= $('#AllOrders_upload').find('tr').filter(function() {
            return $(this).css('display') !== 'none';
        }).length;
        $('.number_orders').text((rowcount-1)+" إجمالي الطلبات");
    }); 
    
    showcountrow();
    function showcountrow(){ 
        var rowcount= $('#AllOrders').find('tr').filter(function() {
                return $(this).css('display') !== 'none';
        }).length;
        var rowcount1= $('#AllOrders_upload').find('tr').filter(function() {
                return $(this).css('display') !== 'none';
        }).length;
            $('.number_orders').text((rowcount-1)+" إجمالي الطلبات");
            $('.number_orders_upload').text((rowcount1-1)+" إجمالي الطلبات");
    }
        
    $('.addneworder').on('click',function(){
        $('#modeladdneworder').show();
    });
    
    $('.closemodel').on('click',function(){
        var model=$(this).closest('.modal');
        model.hide();
    });
    
    $('.closemodelbutton').on('click',function(){
        var model=$(this).closest('.modal');
        model.hide();
    }); 
    
    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
            //   toast.addEventListener('mouseenter', Swal.stopTimer);
            //   toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    
    if (localStorage.getItem("fontsize")) {
        var p = $('body').find('p');
        var span = $('body').find('span');
        var a = $('body').find('a'); 
        fontsize=parseInt(localStorage.getItem("fontsize")); 
        if(fontsize>=10){
           fontsize=10; 
        }else if(fontsize<1){
            fontsize=1;
        }
        p.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+fontsize)+"px"); 
            });  
            span.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+fontsize)+"px"); 
            }); 
             a.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+fontsize)+"px"); 
            });
    }else{
        fontsize=1;
        localStorage.setItem("fontsize", 2); 
    }  

    $('.font-plus').on('click',function(){
         if(fontsize<=10){
            fontsize=fontsize+1; 
            var p = $(this).closest('body').find('p');
            var span =$(this).closest('body').find('span');
            var a =$(this).closest('body').find('a');
            p.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+1)+"px"); 
            });  
            span.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+1)+"px"); 
            }); 
             a.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+1)+"px"); 
            });
            localStorage.setItem('fontsize', fontsize);
        }
    });

    $('[data-toggle="tooltip"]').tooltip(); 
    
    $('.font-minus').on('click',function(){ 
        if(fontsize>=0){
            fontsize=fontsize-1; 
            var p = $(this).closest('body').find('p');
            var span =$(this).closest('body').find('span');
            var a =$(this).closest('body').find('a');
            p.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font-1)+"px"); 
            }); 
            span.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font-1)+"px"); 
            });
             a.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font-1)+"px"); 
            });
            localStorage.setItem('fontsize', fontsize);
        }
    });
    
    $('.gofs').on('click',function(){ 
        var fullscreen=0;
        var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
            (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
            (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
            (document.msFullscreenElement && document.msFullscreenElement !== null);
        
        var docElm = document.documentElement;
        if (!isInFullScreen) {
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen();
            } else if (docElm.mozRequestFullScreen) {
                docElm.mozRequestFullScreen();
            } else if (docElm.webkitRequestFullScreen) {
                docElm.webkitRequestFullScreen();
            } else if (docElm.msRequestFullscreen) {
                docElm.msRequestFullscreen();
            }
        } else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            } else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            } else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            } else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }
              
    });

    function getnumberstring(value){
        return parseInt(value.replace( /^\D+/g, ''));
    }

    $('.add_city').on('click',function(){
        console.log("sdlfjlaskdfj")
       var main=$(this).closest('.main-citys');
      
        Swal.fire({
                title: 'أدخل إسم المدينة',
                input: 'text',
                inputValue: "",
                inputAttributes: {
                  autocapitalize: 'true',
                },
                textContent:p.textContent,
                showCancelButton: true,
                confirmButtonText: 'حفظ',
                cancelButtonText: 'إلغاء',
                showLoaderOnConfirm: true,
                preConfirm: (login) => { 
                },
                allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                if (result.isConfirmed) { 
                  
                    
                }
              }); 
    });
    
    $('.add_new_order').on('click',function(){ 
        $('.loading_all').css('display','flex'); 
        var model=$(this).closest('.modal');
        var form_add=$(this).closest('.form_add');
        var model_error=model.find('.model_error');
        var model_normal=model.find('.model_normal');
        var model_successful=model.find('.model_successful');
        
        var emp_name=model.find('#emp_name').val();
        var emp_phone=model.find('#emp_phone').val();
        var note=model.find('#note').val(); 
        var regex = new RegExp(/^(9665|055|05)(05|5|0|3|6|4|5|9|1|8|7)([0-9]{7})$/);
        if($.trim(emp_name)===""){
            model.find('#emp_name').css({
                'border-width' : '1px',
                'border-style' : 'solid',
                'border-color' : 'red'
            });
            model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text("يرجى ادخال حقل اسم العميل");
        }else if($.trim(emp_phone)===""){
            model.find('#emp_phone').css({
                'border-width' : '1px',
                'border-style' : 'solid',
                'border-color' : 'red'
            });
            model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text('يرجى ادخال حقل رقم جوال العميل');
        }else if(!(regex.test(emp_phone.trim()))){
         model.find('#emp_phone').css({
                'border-width' : '1px',
                'border-style' : 'solid',
                'border-color' : 'red'
            });
            model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text("يرجى ادخال رقم جوال بالصيغة (0541234567) ");
        }else{
            model_successful.hide();
            model_normal.show(); 
            model_error.hide();  
            model_normal.text('يرجى الإنتظار جاري اضافة الطلب');
            var dataString = 'action=add_employ_order' + '&value=' + emp_name + '&value1='+ emp_phone + '&note='+ note;
            $.ajax({
                type: "post",
                url: "users.php",
                data: dataString,
                catch: false,
                success: function (html) {
                    $('#msg').html(html);
                }
            }).done(function (msg) {  
                if (msg == "11111") { 
                    model.find('#emp_name').val("")
                    model.find('#emp_phone').val("");
                    model.find('#note').val(""); 
                    model_successful.hide();
                    model_normal.hide(); 
                    model_error.hide();  
                    Toast.fire({
                        icon: 'success',
                        title: 'تم إضافة العميل',
                    });
                    
                    model.on(1000).fadeOut();
                    $('.loading_all').css('display','none'); 
                    GetOrders(1);
                    
                } else if(msg==="00000") {
                    Swal.fire({
                        title: 'فشل',
                        text: 'هناك خطاء لم يتم إضافة الطلب',
                        icon: 'error', 
                    }); 
                    $('.loading_all').css('display','none'); 
                }else{
                    $('.loading_all').css('display','none'); 
                    model_successful.hide();
                    model_normal.hide(); 
                    model_error.show();  
                    model_error.text(msg); 
                }

            });
        }
   
    });

    $('.check_valdations').on('input',function(){ 
            $(this).css({
                'border-width' : '1px',
                'border-style' : 'solid',
                'border-color' : '#d5d5d5',
            });
    });

    
 
    function GetOrders(id) {
        var dataString = 'action=GetOrders&value=' + id + '&value1=nodata';
        $('.loading_all').css('display','flex'); 
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false, 
        }).done(function (msg) {
            $("#AllOrders").html(msg);	 
            refreshjs();
        });
    }
    
    $('.refrushtable').on('click',function(){
       GetOrders(1); 
    });
    GetOrders(1);
    refreshjs();

    $('.refrushtable').click();

    function refreshjs(){
         

        if($('#AllOrders').length > 0){
            let len_row_orders = $('#AllOrders').find('tbody').find('tr').length;
            console.log("len_row_orders"+len_row_orders)
        $('.number_orders').html(len_row_orders+' إجمالي الطلبات');
        }
        if($('#AllOrders_upload').length > 0){ 
            let len_row_upload = $('#AllOrders_upload').find('tbody').find('tr').length;
            console.log("len_row_upload"+len_row_upload)
            $('.number_orders_upload').html(len_row_upload+' إجمالي الطلبات');
        }
        
        $('#AllOrders').find(".change_note").each(function(index) {
            $(this).on('click',function(){
            var p=$(this).find('.p-text');
            var id=$(this).attr('id');
            Swal.fire({
                title: 'أدخل وصف للطلب',
                input: 'textarea',
                inputValue: p.attr("title"),
                inputAttributes: {
                  autocapitalize: 'true',
                },
                textContent:p.textContent,
                showCancelButton: true,
                confirmButtonText: 'حفظ',
                cancelButtonText: 'إلغاء',
                showLoaderOnConfirm: true,
                preConfirm: (login) => { 
                },
                allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                if (result.isConfirmed) { 
                    var dataString = 'action=changenote&value=' + id + '&value1=' + result.value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) { 
                        if(msg==="11111"){
                        Toast.fire({
                            icon: 'success',
                            title: 'تم التعديل',
                            });
                        }
                    });
                }
            });
        });
        }); 


        
        $('#AllOrders_upload').find(".change_note").each(function(index) {
            $(this).on('click',function(){
            var p=$(this).find('.p-text');
            var id=$(this).attr('id');
            Swal.fire({
                title: 'أدخل وصف للطلب',
                input: 'textarea',
                inputValue: p.attr("title"),
                inputAttributes: {
                  autocapitalize: 'true',
                },
                textContent:p.textContent,
                showCancelButton: true,
                confirmButtonText: 'حفظ',
                cancelButtonText: 'إلغاء',
                showLoaderOnConfirm: true,
                preConfirm: (login) => { 
                },
                allowOutsideClick: () => !Swal.isLoading()
              }).then((result) => {
                if (result.isConfirmed) { 
                    var dataString = 'action=changenote&value=' + id + '&value1=' + result.value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) { 
                        if(msg==="11111"){
                        Toast.fire({
                            icon: 'success',
                            title: 'تم التعديل',
                            });
                        }
                    });
                    // alert(result.value)
                //   Swal.fire({
                //     title: `${result.value.login}'s avatar`,
                //     imageUrl: result.value.avatar_url
                //   })
                }
              });
        });
        }); 
        
        $('#AllOrders').find(".show_status").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
                '2': 'ملغي',
                '3': 'قيد التنفيذ',
                '4': 'مفرغ', 
                })
            }, 10)
            }); 
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً' ,
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار حالة الطلب'
                }else{
                   if (value == 2) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #ff000030; padding: 5px;">ملغي</p'); 
                    } else if (value == 3) {
                        td.find('.p-text').remove(); 
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #0008ff30; padding: 5px;">قيد التنفيذ</p>');
                    } else if (value == 4) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #cef0cc; padding: 5px;">مفرغ</p>');
                    } 
                    var dataString = 'action=changestatuse&value=' + id + '&value1=' + value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) {
                        if(msg==="11111"){
                        Toast.fire({
                            icon: 'success',
                            title: 'تم التعديل',
                            });
                        }
                    }); 
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','36em'); 
    
        });
        });  
        
        $('#AllOrders_upload').find(".show_status").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
                '2': 'ملغي',
                '3': 'قيد التنفيذ',
                '4': 'مفرغ', 
                })
            }, 10)
            }); 
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً' ,
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار حالة الطلب'
                }else{
                   if (value == 2) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #ff000030; padding: 5px;">ملغي</p'); 
                    } else if (value == 3) {
                        td.find('.p-text').remove(); 
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #0008ff30; padding: 5px;">قيد التنفيذ</p>');
                    } else if (value == 4) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text" style="border-radius: 10px; background-color: #cef0cc; padding: 5px;">مفرغ</p>');
                    } 
                    var dataString = 'action=changestatuse&value=' + id + '&value1=' + value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) {
                        if(msg==="11111"){
                        Toast.fire({
                            icon: 'success',
                            title: 'تم التعديل',
                            });
                        }
                    }); 
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','36em'); 
    
        });
        });  
        
        $('#AllOrders').find(".show_starts").each(function(index) {
            $(this).on('click', function () {  
            var td = $(this);
            var id = $(this).attr('id');  
             (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({
                '1': 'غير مقيم 🤔',
                '2': 'ضعيف ☹️',
                '3': 'جيد 🙂',
                '4': 'ممتاز 🤩', 
                })
            }, 10)
            }); 
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً', 
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار تقيم'
                }else{ 
                     if (value == 1) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text starts1">غير مقيم 🤔</p>');
                    } else if (value == 2) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts2">ضعيف ☹️</p>');
                    } else if (value == 3) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts3">جيد 🙂</p>');
                    } else if (value == 4) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts4">ممتاز 🤩</p>');
                    }
                    var dataString = 'action=changestarts&value=' + id + '&value1=' + value;
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false,
                            success: function (html) { 
                            }
                        }).done(function (msg) {
                            console.log(msg)
                           if(msg==="11111"){
                            Toast.fire({
                                icon: 'success',
                                title: 'تم التعديل'
                              });
                           }
                        }); 
                //   console.log(value)
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','58em'); 
            
            
    
        });
        }); 
        
        $('#AllOrders_upload').find(".show_starts").each(function(index) {
            $(this).on('click', function () {  
            var td = $(this);
            var id = $(this).attr('id');  
             (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({
                '1': 'غير مقيم 🤔',
                '2': 'ضعيف ☹️',
                '3': 'جيد 🙂',
                '4': 'ممتاز 🤩', 
                })
            }, 10)
            }); 
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً', 
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار تقيم'
                }else{ 
                     if (value == 1) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text starts1">غير مقيم 🤔</p>');
                    } else if (value == 2) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts2">ضعيف ☹️</p>');
                    } else if (value == 3) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts3">جيد 🙂</p>');
                    } else if (value == 4) {
                         td.find('.p-text').remove();
                        td.html('<p class="p-text starts4">ممتاز 🤩</p>');
                    }
                    var dataString = 'action=changestarts&value=' + id + '&value1=' + value;
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false,
                            success: function (html) { 
                            }
                        }).done(function (msg) {
                            console.log(msg)
                           if(msg==="11111"){
                            Toast.fire({
                                icon: 'success',
                                title: 'تم التعديل'
                              });
                           }
                        }); 
                //   console.log(value)
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','58em'); 
            
            
    
        });
        }); 
        
        $('#AllOrders').find(".delete_order").each(function(index) {
            $(this).on('click',function(){ 
            var id=$(this).attr('id');
            var td=$(this).closest('tr');
            Swal.fire({
                title: 'تأكيد الحذف',
                text: " !هل أنت متأكد من حذف الطلب نهائياً ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'متأكد',
                cancelButtonText: 'لا أريد الحذف',
              }).then((result) => {
                if (result.isConfirmed) {
                 
                  var dataString = 'action=delete_order_user&value=' + id + '&value1=1';
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false,
                            success: function (html) {
                                $('#msg').html(html);
                            }
                        }).done(function (msg) {
                            if (msg == "11111") {
                                Swal.fire(
                                    '! نجح الحذف ',
                                    'لقد تم حذف الطلب نهائياً',
                                    'success'
                                  );                
                            } else if (msg == "00000") {
                                Swal.fire({
                                    icon: 'error',
                                    title: `لم يتم حذف الطلب هناك خطاء`,
                                    preConfirm: login => {
                                    }, imageUrl: result.value.avatar_url
                                });
                            }
    
                        });
                  td.remove();
                }
              })
              
        });
        });
        
        $('#AllOrders_upload').find(".delete_order").each(function(index) {
            $(this).on('click',function(){ 
            var id=$(this).attr('id');
            var td=$(this).closest('tr');
            Swal.fire({
                title: 'تأكيد الحذف',
                text: " !هل أنت متأكد من حذف الطلب نهائياً ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'متأكد',
                cancelButtonText: 'لا أريد الحذف',
              }).then((result) => {
                if (result.isConfirmed) {
                 
                  var dataString = 'action=delete_order_user&value=' + id + '&value1=1';
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false,
                            success: function (html) {
                                $('#msg').html(html);
                            }
                        }).done(function (msg) {
                            if (msg == "11111") {
                                Swal.fire(
                                    '! نجح الحذف ',
                                    'لقد تم حذف الطلب نهائياً',
                                    'success'
                                  );                
                            } else if (msg == "00000") {
                                Swal.fire({
                                    icon: 'error',
                                    title: `لم يتم حذف الطلب هناك خطاء`,
                                    preConfirm: login => {
                                    }, imageUrl: result.value.avatar_url
                                });
                            }
    
                        });
                  td.remove();
                }
              })
              
        });
        }); 
        
        $('#AllOrders').find(".order_stages").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
                '0': 'غير محدد',
                '1': 'موافقة مبدئية',
                '2': 'رفع الأوراق',
                '3': 'تقيم',
                '4': 'سداد',
                '5': 'موافقة نهائية',
                '6': 'محصل',
                })
            }, 10)
            }); 
            
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            width: '100%',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً' ,
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار مرحلة من مراحل الطلب '
                }else{
                    if (value == 0) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages1">غير محدد</p'); 
                    }else if (value == 1) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages1">موافقة مبدئية</p'); 
                    }else if (value == 2) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages2">رفع الأوراق</p'); 
                    }else if (value == 3) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages3">تقيم</p'); 
                    }else if (value == 4) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages4">سداد</p'); 
                    }else if (value == 5) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages5">موافقة نهائية</p'); 
                    }else if (value == 6) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages6">محصل</p'); 
                    }
                    var dataString = 'action=changestages&value=' + id + '&value1=' + value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) {
                        if(msg==="11111"){
                            Toast.fire({
                                icon: 'success',
                                title: 'تم التعديل',
                            });
                        }
                    }); 
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','36em'); 
    
        });
        }); 
        
        $('#AllOrders_upload').find(".order_stages").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
                '0': 'غير محدد',   
                '1': 'موافقة مبدئية',
                '2': 'رفع الأوراق',
                '3': 'تقيم',
                '4': 'سداد',
                '5': 'موافقة نهائية',
                '6': 'محصل',
                })
            }, 10)
            }); 
            
            const { value: starts } = await Swal.fire({
            title: '',
            input: 'radio',
            width: '100%',
            inputOptions: inputOptions,
            confirmButtonText: 'حسناً' ,
            cancelButtonText: 'إلغاء',
            showCancelButton: true,
            showCloseButton: true,
            inputValidator: (value) => {
                if (!value) {
                   return 'يجب عليك إختيار مرحلة من مراحل الطلب '
                }else{
                    if (value == 0) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages1">غير محدد</p'); 
                    }else if (value == 1) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages1">موافقة مبدئية</p'); 
                    }else if (value == 2) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages2">رفع الأوراق</p'); 
                    }else if (value == 3) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages3">تقيم</p'); 
                    }else if (value == 4) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages4">سداد</p'); 
                    }else if (value == 5) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages5">موافقة نهائية</p'); 
                    }else if (value == 6) {
                        td.find('.p-text').remove();
                        td.html('<p class="p-text order_stages6">محصل</p'); 
                    }
                    var dataString = 'action=changestages&value=' + id + '&value1=' + value;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) { 
                        }
                    }).done(function (msg) {
                        if(msg==="11111"){
                            Toast.fire({
                                icon: 'success',
                                title: 'تم التعديل',
                            });
                        }
                    }); 
                }
            }
            }) ; 
            })() 
             $('.swal2-popup').css('width','36em'); 
    
        });
        }); 
        
        $('#AllOrders').find(".edite_order_main" ).each(function(index) {
            $(this).on("click", function(){ 
            var id=$(this).attr("id");
            $('.edite_order_customer').addClass('loadding-data');
            var dataString = 'action=getDeatilsOrder&value=' + id + '&value1=1'; 
            $('.main_edite_order').on(500).fadeIn();
            $('.main_edite_order').css('display','flex');
            $('.main-loading').on(500).fadeIn();
            $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false, 
            }).done(function (response) { 
                if (response == "00000") {
                    
                } else { 
                    setTimeout(() => {
                        $('#set_edit_order').html(response);
                        $('.main-loading').on(500).fadeOut('slow');
                        $('.edite_order_customer').removeClass('loadding-data');
                        setmaskandselect();
                        functionTab();
                    }, 500);
                } 
               
            }); 
        });
        }); 
     
        $('#AllOrders_upload').find(".edite_order_main" ).each(function(index) {
            $(this).on("click", function(){ 
                var id=$(this).attr("id");
                $('.edite_order_customer').addClass('loadding-data');
                var dataString = 'action=getDeatilsOrder&value=' + id + '&value1=1'; 
                $('.main_edite_order').on(500).fadeIn();
                $('.main_edite_order').css('display','flex');
                $('.main-loading').on(500).fadeIn();
                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: dataString,
                    catch: false, 
                }).done(function (response) { 
                    if (response == "00000") {
                        
                    } else { 
                        setTimeout(() => {
                            $('#set_edit_order').html(response);
                            $('.main-loading').on(500).fadeOut('slow');
                            $('.edite_order_customer').removeClass('loadding-data');
                            setmaskandselect();
                            functionTab();
                        }, 500);
                    } 
                   
                }); 
            });
        }); 

        $('#AllOrders').find(".add_new_alarm" ).each(function(index) { 
            $(this).on("click", function(){ 
                var id=$(this).attr("id");
                console.log("here showing alarm content = "+id);
                $('.main_add_new_alarm').find('.alarm_order_id').val(id);
                $('.main_add_new_alarm').on(500).fadeIn();
 
                var now = new Date(); 
                // Get the components of the date and time
                var year = now.getFullYear();
                var month = (now.getMonth() + 1).toString().padStart(2, '0');
                var day = now.getDate().toString().padStart(2, '0');
                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');

                // Get the time zone offset in minutes
                var timeZoneOffset = -now.getTimezoneOffset();
                var timeZoneOffsetHours = Math.floor(timeZoneOffset / 60);
                var timeZoneOffsetMinutes = timeZoneOffset % 60;
                var timeZoneOffsetFormatted = (timeZoneOffsetHours >= 0 ? "+" : "-") +
                    timeZoneOffsetHours.toString().padStart(2, '0') +
                    ":" +
                    timeZoneOffsetMinutes.toString().padStart(2, '0');

                // Create the formatted date and time string with the time zone offset
                var formattedDate = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes + timeZoneOffsetFormatted;

                // Set the formatted date as the value for the input using jQuery
                $('.alarm_date_time').val(formattedDate);

            });
        });

        $('#AllOrders_upload').find(".add_new_alarm" ).each(function(index) { 
            $(this).on("click", function(){ 
                var id=$(this).attr("id");
                console.log("here showing alarm content = "+id);
                $('.main_add_new_alarm').find('.alarm_order_id').val(id);
                $('.main_add_new_alarm').on(500).fadeIn();
                
                
                var now = new Date(); 
                // Get the components of the date and time
                var year = now.getFullYear();
                var month = (now.getMonth() + 1).toString().padStart(2, '0');
                var day = now.getDate().toString().padStart(2, '0');
                var hours = now.getHours().toString().padStart(2, '0');
                var minutes = now.getMinutes().toString().padStart(2, '0');

                // Get the time zone offset in minutes
                var timeZoneOffset = -now.getTimezoneOffset();
                var timeZoneOffsetHours = Math.floor(timeZoneOffset / 60);
                var timeZoneOffsetMinutes = timeZoneOffset % 60;
                var timeZoneOffsetFormatted = (timeZoneOffsetHours >= 0 ? "+" : "-") +
                    timeZoneOffsetHours.toString().padStart(2, '0') +
                    ":" +
                    timeZoneOffsetMinutes.toString().padStart(2, '0');

                // Create the formatted date and time string with the time zone offset
                var formattedDate = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes + timeZoneOffsetFormatted;

                // Set the formatted date as the value for the input using jQuery
                $('.alarm_date_time').val(formattedDate);
                
            });
        });
    
     
        function GetAllDetals(id) {
            var dataString = 'action=GetAllDetals&value=' + id + '&value1=nodata';
            $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false,
                success: function (html) {
                    $('#return_data').html(html);
    
                }
            }).done(function (msg) {
                //										 location.reload();
            });
        } 

        function functionTab(){
            $('.add_new_eltizam').off().on('click',function(){
                let conent = $(this).find('.card').html(); 
                $(this).closest('.eltzams').append(`
                    <div class="card main_eltizam"> 
                        `+conent+`
                    </div>
                `);
                functionTab();
            });
            $('.delete-eltizam').off().on('click',function(){
                $(this).closest('.card').remove();
            })

            function_files();
        }


        
function function_files(){
    // Register plugins 
    FilePond.registerPlugin(
        FilePondPluginFileValidateSize,
        FilePondPluginImageExifOrientation,
        FilePondPluginImageCrop,
        FilePondPluginFileRename,
        FilePondPluginImageResize,
        FilePondPluginImagePreview,
        FilePondPluginImageTransform
    );
    var just_file_name = rundamString(15);
    console.log("just_file_name="+just_file_name);
    const ar_ar = {
        labelIdle: 'اسحب و ادرج ملفاتك أو <span class="filepond--label-action"> تصفح </span>',
        labelInvalidField: 'الحقل يحتوي على ملفات غير صالحة',
        labelFileWaitingForSize: 'بانتظار الحجم',
        labelFileSizeNotAvailable: 'الحجم غير متاح',
        labelFileLoading: 'بالإنتظار',
        labelFileLoadError: 'حدث خطأ أثناء التحميل',
        labelFileProcessing: 'يتم الرفع',
        labelFileProcessingComplete: 'تم الرفع',
        labelFileProcessingAborted: 'تم إلغاء الرفع',
        labelFileProcessingError: 'حدث خطأ أثناء الرفع',
        labelFileProcessingRevertError: 'حدث خطأ أثناء التراجع',
        labelFileRemoveError: 'حدث خطأ أثناء الحذف',
        labelTapToCancel: 'انقر للإلغاء',
        labelTapToRetry: 'انقر لإعادة المحاولة',
        labelTapToUndo: 'انقر للتراجع',
        labelButtonRemoveItem: 'مسح',
        labelButtonAbortItemLoad: 'إلغاء',
        labelButtonRetryItemLoad: 'إعادة',
        labelButtonAbortItemProcessing: 'إلغاء',
        labelButtonUndoItemProcessing: 'تراجع',
        labelButtonRetryItemProcessing: 'إعادة',
        labelButtonProcessItem: 'رفع',
        labelMaxFileSizeExceeded: 'الملف كبير جدا',
        labelMaxFileSize: 'حجم الملف الأقصى: {filesize}',
        labelMaxTotalFileSizeExceeded: 'تم تجاوز الحد الأقصى للحجم الإجمالي',
        labelMaxTotalFileSize: 'الحد الأقصى لحجم الملف: {filesize}',
        labelFileTypeNotAllowed: 'ملف من نوع غير صالح',
        fileValidateTypeLabelExpectedTypes: 'تتوقع {allButLastType} من {lastType}',
        imageValidateSizeLabelFormatError: 'نوع الصورة غير مدعوم',
        imageValidateSizeLabelImageSizeTooSmall: 'الصورة صغير جدا',
        imageValidateSizeLabelImageSizeTooBig: 'الصورة كبيرة جدا',
        imageValidateSizeLabelExpectedMinSize: 'الحد الأدنى للأبعاد هو: {minWidth} × {minHeight}',
        imageValidateSizeLabelExpectedMaxSize: 'الحد الأقصى للأبعاد هو: {maxWidth} × {maxHeight}',
        imageValidateSizeLabelImageResolutionTooLow: 'الدقة ضعيفة جدا',
        imageValidateSizeLabelImageResolutionTooHigh: 'الدقة مرتفعة جدا',
        imageValidateSizeLabelExpectedMinResolution: 'أقل دقة: {minResolution}',
        imageValidateSizeLabelExpectedMaxResolution: 'أقصى دقة: {maxResolution}'
    };
    FilePond.setOptions(ar_ar);
    // Set default FilePond options
    FilePond.setOptions({
        // chunkUploads: true,
        // chunkForce:true,
        // chunkSize: '50000000000000000',
        // maximum allowed file size 
        allowFileTypeValidation: true,
        acceptedFileTypes: ['image/*','pdf','xlsx'],
        allowFileRename: true,
        allowMultiple: true,
        maxFileSize: '5MB', 
        // crop the image to a 1:1 ratio
        // imageCropAspectRatio: '1:1', 
        maxParallelUploads: 2,
        allowPaste: false,
        // resize the image
        // imageResizeTargetWidth: 200,
        maxFiles: 15,
        // upload to this server end point 
        server: 'https://alawtar.net/ADMIN/api/',

        fileRenameFunction: (file) => {
            return just_file_name+file.extension;
        },
    });

    var pond_input = document.querySelector('.input_tab_files');
    FilePond.destroy(pond_input);
    const pond = FilePond.create(pond_input,{
        acceptedFileTypes: ['image/*','pdf','xlsx'],
    }); 

     

    pond.on('processfile', (error, file) => {
        let public_order_id = $('.main_edite_order').find("#order_id").val();
        if (error) {
            console.log('هناك خطاء ما عند معالجة رفع الملف ! تأكد من إتصالك في الإنترنت');
            return;
        } 
        setTimeout(() => {
            pond.removeFile(file);
        }, 1000); 
        just_file_name = rundamString(15)
        var file_name = slugify(file.filenameWithoutExtension);
        // var file_name = file.filenameWithoutExtension;
        var file_extension = (file.fileExtension).toLowerCase();
        if(file_extension === "jpeg"){
            file_extension = "jpg";
        }
        console.log('file_extension=' +file_extension);
        console.log('file_name='+file_name);
        console.log('file_name='+file.filenameWithoutExtension);
        console.log('just_file_name='+just_file_name);

        var path = "https://alawtar.net/ADMIN/api/tmp/"+file.serverId+"/"+file_name +"."+file_extension;
        var folderpath = "api/tmp/"+file.serverId;
        
        var json_data = [];
        console.log(path)
        json_data.push(path);
        json_data.push(file_extension);  
        json_data.push(file.fileSize);
        json_data.push(file.filenameWithoutExtension); 
        json_data.push(folderpath);
        
        var dataString = "action=SaveFilesOrders&value="+public_order_id+"&value1="+JSON.stringify(json_data);
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false,
        }).done(function (msg) { 
            // console.log(pond.getFiles()); 
            if(parseInt(msg) == 11111){
               get_all_files(public_order_id);
            } 
        });

    });


    function slugify(title){
        return title  
            .replace(/[^a-z0-9_ ]/gi, '')
    }

    fun_estmara_file_add(); 
    get_all_files($('.main_edite_order').find("#order_id").val());
}

function get_all_files(order_id){
    var dataString = "action=getAllFilesOrders&value="+order_id+"&value1=1"; 
    $.ajax({
        type: "post",
        url: "action.php",
        data: dataString,
        catch: false,
    }).done(function (response) {
        // console.log(response)
        $('.main_edite_order').find('.customer_file_img').html(response);  
        fun_estmara_file_add();  
    }); 
}

function rundamString(length) {
    let result = '';
    const characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
    const charactersLength = characters.length;
    let counter = 0;
    while (counter < length) {
    result += characters.charAt(Math.floor(Math.random() * charactersLength));
    counter += 1;
    }
    return result;
}

function fun_estmara_file_add(){

    // console.log('asdfals;dkfjal;skdjfal;ksdjflaksdjf');
    $('.main_edite_order').find('[data-gallery=photoviewer]').off().on('click', function (e) {
        console.log("sdfasldkfjal;skdjfalskdjflaksdjflaksjdf afeef");
        e.preventDefault(); 
        console.log($(this).index());
        var items = [],
        options = {
            index: parseInt($(this).attr('index')),
            draggable: true,
            movable: true,
            keyboard: true,
            initAnimation: true,
            i18n: {
                minimize: 'تصغير',
                maximize: 'ملئ الصفحة',
                close: 'إغلاق',
                zoomIn: 'تكبير الصورة (+)',
                zoomOut: 'تصغير الصورة (-)',
                prev: 'الصورة السابق (←)',
                next: 'الصورة التالي (→)',
                fullscreen: 'ملئ الشاشة',
                actualSize: 'الحجم الحقيقي (Ctrl+Alt+0)',
                rotateLeft: 'تدويل لليسار (Ctrl+,)',
                rotateRight: 'تدويل لليمين (Ctrl+.)',
            },
            modalWidth: 400,
            modalHeight: 400,
            customButtons: {
                myCustomButton1: {
                    text: 'تنزيل',
                    title: 'تنزيل الصورة',
                    click: function (context, e) {
                        alert('قيد التطوير');
                    }
                }, 
            },
        }; 

        $('.main_edite_order').find('[data-gallery=photoviewer]').each(function () {
            items.push({
                src: $(this).attr('href'),
                title: $(this).attr('data-title')
            });
        });
    
        new PhotoViewer(items, options);
    }); 

    $('.main_edite_order').find('[data-gallery=pdfviewer]').off('click').on('click',function(e){
        e.preventDefault(); 
        $('.main_show_pdf').find('iframe').attr('src', $(this).attr('href'));
        $('.main_show_pdf').css('display',"block");
    });

    $('.main_edite_order').find('.delete_file_order').off().on('click',function(){
        var file_id = $(this).attr('file');
        var order_id = $(this).attr('order');
        var folder_path = $(this).attr('folder');
        let object = $(this);
        $(this).closest('.jFiler-item').find('.delete_loading').css("display","flex");
        var dataString = 'action=DeleteFileOrders&value='+file_id+'&value1='+order_id+'&value2='+folder_path;
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false, 
        }).done(function (msg) {   
            console.log(msg);
            if(parseInt(msg) == 11111 ){ 
                object.closest('.jFiler-item').remove();
            }
        });
    });

    $('.main_edite_order').find('.print_file_order').off().on('click',function(){
        let type_file = $(this).attr('type_file');
        let path = $(this).attr('path');
        if(type_file === "pdf"){
            printFile(path)
        }else{
            printImage(path); 
        }
        
    });

    $('.main_edite_order').find('.share_file_order').off().on('click',function(){
        var whatsappURL = 'whatsapp://send?text=' + encodeURIComponent($(this).attr('path')); 
        
        window.location.href = whatsappURL; 
         
    });
    
    $('.main_edite_order').find('.change_file_name').off().on('change',function(){
        $(this).closest('li').find('.jFiler-item-title').text($(this).val());
    });

    $('.main_edite_order').find('.change_file_name').off().on('blur',function(){
        var file_id = $(this).attr('file');
        var order_id = $(this).attr('order');
        var file_name = $(this).val();
        var dataString = 'action=ChangeFileNameOrders&value='+file_id+'&value1='+order_id+'&value2='+file_name;
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false, 
        }).done(function (msg) {   
            console.log(msg); 
        });
    });

}

function printImage(imageSrc) {
    const img = new Image();
    img.src = imageSrc;

    img.onload = function() {
        const printWindow = window.open('', '', 'width=600,height=600');
        printWindow.document.open();
        printWindow.document.write('<html><body style="margin:0;"><img src="' + imageSrc + '" style="max-width:100%;"></body></html>');
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    };
}
function printFile(path){
    const printWindow = window.open(path, '_blank');
    printWindow.onload = function () {
        printWindow.print();
    }; 
}

    
        var Pro_id = 0;
        // function GetProblems(id) {
        //     Pro_id = id;
        //     var dataString = 'action=GetProblems&value=' + id + '&value1=nodata';
        //     $.ajax({
        //         type: "post",
        //         url: "action.php",
        //         data: dataString,
        //         catch: false,
        //         success: function (html) {
        //             // $('#AllProblems').html(html);
        //             // $('#AllProblems').excelTableFilter();  
        //         }
        //     }).done(function (msg) {
        //     });
        // }
    
        // setInterval(function () {
        //     // update_problemps(1);
        // }, 20000);
    
        // function update_problemps(id) {
        //     var dataString = 'action=GetProblems&value=' + id + '&value1=nodata';
        //     $.ajax({
        //         type: "post",
        //         url: "action.php",
        //         data: dataString,
        //         catch: false,
        //         success: function (html) { 
        //         }
        //     }).done(function (msg) {
        //         $('#AllProblems').html(msg); 
        //         $('#AllOrders_upload').excelTableFilter(); 
        //         $('#AllProblems').excelTableFilter(); 
        //     });
        // }
        
        $('#AllOrders').excelTableFilter({
            sort: false,  
        });
    
        $("#AllOrders").fancyTable({
          pagination: true,
          paginationClass: "btn btn-light",
          sortable: false,
          paginationClassActive: "active",
          pagClosest: 3,
          perPage: 10,
          searchable: false, 
          rowDisplayStyle:'block',
          limit: 5,
          inputPlaceholder:"بحث..."
        });
        
        $("#AllOrders_upload").fancyTable({
          pagination: true,
          paginationClass: "btn btn-light",
          paginationClassActive: "active",
          pagClosest: 3,
          sortable: false,
          perPage: 10,
          searchable: false,
        //   globalSearch:true,
          rowDisplayStyle:'block',
          limit: 5,
          inputPlaceholder:"بحث..."
        });
        
        $('#AllOrders_upload').excelTableFilter({
            sort: false,  
        });
        
        $('.loading_all').css('display','none');
        
        
    }

    $('#submitButt').click(function () {
        $(this).toggleClass('active');
    });
     
    
    $('.cloase_alarm').off().on('click',function(){
        $(this).closest('.main_add_new_alarm').hide();
    });

    $('.save-add-new-alarm').off().on('click',function(){
        let main_dianloge = $(this).closest('.main_add_new_alarm');
        let order_id = main_dianloge.find('.alarm_order_id').val();
        let alarm_date = main_dianloge.find('.alarm_date_time').val();
        let alarm_note = main_dianloge.find('.alarm_note').val(); 
        
        var momentDate = moment(alarm_date); 
        momentDate.locale('en');
        var formattedDate = momentDate.format('YYYY-MM-DD H:mm'); 
        console.log(formattedDate); 

        var dataString = 'action=ADD_NEW_ALARM&value=' + order_id + '&value1=' + formattedDate + '&value2=' + alarm_note ;
        $.ajax({
            type: "POST",
            url: "action.php",
            data: dataString,
            catch: false,
            success: function (response) {  
                if(response === "1"){
                    main_dianloge.find('.cloase_alarm').click();
                    Toast.fire({
                        icon: 'success',
                        title: 'تم إضافة التذكير بنجاح',
                    });
                    main_dianloge.find('input').val('');
                    main_dianloge.find('textarea').val('');
                }else{
                    Swal.fire({
                        title: 'فشل الإضافة',
                        text: 'فشل إضافة التذكير، يرجى التأكد من إتصالك في الشبكة، أو أعد تسجيل الدخول',
                        icon: 'error',  
                        confirmButtonText: 'حسناً'
                    });
                }
            }
        });
    });

    initGetAlarm();
    var audio = document.getElementById("alarm_sounds");
    function initGetAlarm(){
        setInterval(function() {
            var dataString = 'action=GET_ALARM_NOW&value=1&value1=2';
            $.ajax({
                type: "POST",
                url: "action.php",
                data: dataString,
                catch: false,
                success: function (response) { 
                    var dataArray = JSON.parse(response); 
                    $.each(dataArray, function(index, element) {
                        // Your code to handle each item goes here
                        if(!($('.alarm'+element.id).length)){
                            audio.play();
                            $('.all_alarms').append(element.html);
                            allFunctionAlarms(); 
                        } 
                    }); 
                }
            });
        }, 10000);
    }

    function allFunctionAlarms(){
        // $(".dialoge_alarm").draggable();
        $('.delete_alarm').off().on('click',function(){
            let object = $(this).closest('.dialoge_alarm');
            let alarm_id = object.attr("alarm_id");
            var dataString = 'action=DELETE_ALARM&value=' + alarm_id + '&value1=1';
            $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false,
                success: function (html) { 
                }
            }).done(function (msg) { 
                if(msg==="11111"){
                    object.remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'تم إستبعاد التذكير',
                    }); 
                }
            }); 
        });

        $('.change_notification').off().on('click',function(){
            let object_dilaoge = $(this).closest('.dialoge_alarm');
            let alarm_id = object_dilaoge.attr("alarm_id");
            var dataString = 'action=UPDATE_DATE_ALARM&value=' + alarm_id + '&value1=1';
            $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false,
                success: function (html) { 
                    console.log(html)
                }
            }).done(function (msg) { 
                if(msg==="11111"){
                    object_dilaoge.remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'سيتم إعادة التذكير بعد عشر دقائق من الوقت الحالي',
                    });  
                }
            });
        });

        $('.alarm_show_tabs').off().on('click',function(){
            var id=$(this).attr("id");
            $('.edite_order_customer').addClass('loadding-data');
            var dataString = 'action=getDeatilsOrder&value=' + id + '&value1=1'; 
            $('.main_edite_order').on(500).fadeIn();
            $('.main_edite_order').css('display','flex');
            $('.main-loading').on(500).fadeIn();
            $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false, 
            }).done(function (msg) {
                if (msg == "00000") {
                    
                } else { 
                    setTimeout(() => {
                        $('#set_edit_order').html(msg);
                        $('.main-loading').on(500).fadeOut('slow');
                        $('.edite_order_customer').removeClass('loadding-data');
                        setmaskandselect();
                    }, 500);
                } 
               
            }); 
        }); 
    }
     
    var cursor = $(".cursor");

    $(window).mousemove(function(e) {
        cursor.css({
        top: e.clientY - cursor.height() / 2,
        left: e.clientX - cursor.width() / 2
        });
    });

    $(window).mouseleave(function() {
      cursor.css({
        opacity: "0"
      });
    }).mouseenter(function() {
      cursor.css({
        opacity: "1"
      });
    });

    $(".link").mouseenter(function() {
      cursor.css({
        transform: "scale(3.2)"
      });
    }).mouseleave(function() {
      cursor.css({
        transform: "scale(1)"
      });
    });

    $(window).mousedown(function() {
      cursor.css({
        transform: "scale(.2)"
      });
    }).mouseup(function() {
      cursor.css({
        transform: "scale(1)"
      });
    });
     
    
    function refrch_msg(order_id,form,loading){ 
        var dataString = 'action=refrch_msg&value=' + order_id;  
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false, 
        }).done(function (msg) {
            console.log(msg)
            form.find("#timelinehtml").html(msg); 
            loading.css('display','none');
        }); 
    }
    
    function setmaskandselect(){
        
        $('.send_msg_order').on('click',function(){
            var form=$(this).closest('.main_send_msg_order');
            var formm=$(this).closest('.edite_order_customer');
            var loading=formm.find('.main-loading'); 
            loading.css('display','flex');
            var order_id=$(this).attr("order_id");
            var emp_name=$(this).attr("emp_name"); 
            
            var title=form.find('#title_description').val();
            var msg_description = form.find('#msg_description').val();
            var order_accept =form.find('#order_accept').prop("checked");
            if(order_accept==false){
                order_accept=0;
                if((title.trim()=="")||(msg_description.trim()=="")){ 
                        var alert_msg="يجب تعبية جميع الحقول (العنوان+وصف الرسالة)";
                        formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+alert_msg+'</strong></div>');
                        loading.css('display','none');
                        setTimeout(() => {
                             formm.find("#success").html("");
                        }, 3000);
                }else{ 
                        var dataString = 'action=SendAdminMesage&value=' + order_id + '&value1='+title+ '&value2='+msg_description+ '&value3='+order_accept+ '&value4='+emp_name;  
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false, 
                        }).done(function (msg) {
                            form.find('#title_description').val("");
                            form.find('#msg_description').val(""); 
                            refrch_msg(order_id,formm,loading);
                            loading.css('display','none');
                            if (msg == "00000") {
                                
                            } else if(msg =="11111") {  
                                if(form.find('#order_accept').prop("checked")){
                                    form.find('#order_accept').parent().css({
                                        "display": "none", 
                                    });
                                }
                                var alert_msg="تم الإرسال بنجاح";
                                formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+alert_msg+'</strong></div>');
                            } 
                            setTimeout(() => {
                                 formm.find("#success").html("");
                            }, 3000);
                           
                        }); 
                    } 
            }else{ 
                order_accept=1;
                var cusom_number =formm.find('#cusom_number').val(); 
                var cusom_name =formm.find('#cusom_name').val();
                var cusom_starts =formm.find('#cusom_starts').val();
                var cusom_statues =formm.find('#cusom_statues').val();
                var cusom_description =formm.find('#cusom_description').val(); 
                
                var name_owner =formm.find('#name_owner').val();
                var number_owner =formm.find('#number_owner').val();
                var kind_aqar =formm.find('#kind_aqar').val();
                var city =formm.find('#city').val();
                var jop =formm.find('#jop').val();
                var salary =formm.find('#salary').val();
                var resource_obligations =formm.find('#resource_obligations').val();
                var obligations =formm.find('#obligations').val();
                var data_birth =formm.find('#data_birth').val();
                var powered =formm.find('#powered').val();
                var bank =formm.find('#bank').val();  
                
                if((cusom_number.trim()=="")||(cusom_name.trim()=="")||(cusom_starts==0)||(cusom_statues==0)||(cusom_description.trim()=="")||(name_owner.trim()=="")||(number_owner.trim()=="")||(kind_aqar==0)&&(city!=0)||(jop.trim()=="")||(salary.trim()=="")||(resource_obligations.trim()=="")||(obligations.trim()=="")||(data_birth.trim()=="")||(powered.trim()=="")||(bank==0)){
                    var alert_msg="يجب تعبية الحقول التالي لإستكمال عملية رفع الطلب :";
                    var alert_msg1="(اسم العميل) + (تقيم العميل) + (حالة الطلب) + (وصف الطلب) + (اسم المالك) + (رقم جوال المالك) + (نوع العقار) + (مدينة العقار) + (الوظيفة) + (الراتب) + (جهة الإلتزامات) + (مبلغ الإلتزامات) + (تاريخ الميلاد) + (حالت الدعم) + (بنك الراتب)";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+alert_msg +alert_msg1+'</strong></div>');
                    loading.css('display','none');
                    setTimeout(() => {
                         formm.find("#success").html("");
                    }, 10000);
                }else{
                    if((title.trim()=="")||(msg_description.trim()=="")){ 
                        var alert_msg="يجب تعبية جميع الحقول (العنوان+وصف الرسالة)";
                        formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+alert_msg+'</strong></div>');
                        loading.css('display','none');
                        setTimeout(() => {
                             formm.find("#success").html("");
                        }, 3000);
                    }else{ 
                        var dataString = 'action=SendAdminMesage&value=' + order_id + '&value1='+title+ '&value2='+msg_description+ '&value3='+order_accept+ '&value4='+emp_name;  
                        $.ajax({
                            type: "post",
                            url: "action.php",
                            data: dataString,
                            catch: false, 
                        }).done(function (msg) {
                            form.find('#title_description').val("");
                            form.find('#msg_description').val(""); 
                            refrch_msg(order_id,formm,loading);
                            loading.css('display','none');
                            if (msg == "00000") {
                                
                            } else if(msg =="11111") {  
                                if(form.find('#order_accept').prop("checked")){
                                    form.find('#order_accept').parent().css({
                                        "display": "none", 
                                    });
                                }
                                var alert_msg="تم الإرسال بنجاح";
                                formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+alert_msg+'</strong></div>');
                            } 
                            setTimeout(() => {
                                 formm.find("#success").html("");
                            }, 3000);
                           
                        }); 
                    } 
            
                }
            } 
            
            // console.log(title);
            // console.log(msg_description);
            // console.log(order_accept); 
            // console.log(order_id); 
            // console.log(emp_name);  
        });
        
        $('.bank_customer').select2({      
             placeholder: "إختر",       
             language: "ar",
             dir:'rtl',
             width:'100%'
        }); 
        $('#city').select2({      
             placeholder: "إختر",       
             language: "ar",
             dir:'rtl',
             width:'100%'
        });  
        $('#kind_aqar').select2({      
             placeholder: "إختر",       
             language: "ar",
             dir:'rtl',
             width:'100%'
        }); 
        $('#number_owner').mask('9999999999');
        $('#salary').mask('999999999999');
        $('#obligations').mask('999999999999');
    }
    
    $('.cloase_edite_form').on('click',function(){
       $(this).closest('.main_edite_order').on(500).fadeOut();
       $('#set_edit_order').html(`
        <div class="form-row" style="margin-top:10px">
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
                  <input type="phone" class="form-control" id="cusom_phone"readonly  placeholder="رقم جوال العميل">
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
                       <option value="">مفرغ</option>
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
                            <img src="dist/img/blank-image.svg"/>                    
                        </div>
                        <div class="fileimg">
                            <img src="dist/img/blank-image.svg"/>                    
                        </div>
                         
                        <div class="fileimg">
                             <p>
                                 <i class="fa fa-plus" aria-hidden="true"></i>
                             </p>                   
                        </div>
                  </div>
                </div>  
            </div> 
       `);
    });
    
    $("#set_edit_order").click(function(event) {
        $(this).find("#success").html('')
    });
    
    $('.save-order-datialse').on('click',function(){ 
        var formm=$(this).closest('.edite_order_customer');
        var loading=formm.find('.main-loading');
        loading.css('display','flex');

        var cusom_number =formm.find('#cusom_number').val(); 
        var cusom_name =formm.find('#cusom_name').val();
        var cusom_starts =formm.find('#cusom_starts').val();
        var cusom_statues =formm.find('#cusom_statues').val();
        var cusom_description =formm.find('#cusom_description').val(); 
        
        var name_owner =formm.find('#name_owner').val();
        var number_owner =formm.find('#number_owner').val();
        var kind_aqar =formm.find('#kind_aqar').val();
        var city =formm.find('#city').val();
        var jop =formm.find('#jop').val();
        var salary =formm.find('#salary').val();
        var resource_obligations =formm.find('#resource_obligations').val();
        var obligations =formm.find('#obligations').val();
        var data_birth =formm.find('#data_birth').val();
        var powered =formm.find('#powered').val();
        var bank =formm.find('#bank').val(); 
        var order_notes =formm.find('#order_notes').val(); 
        
         
       
                 
        if(cusom_statues==1){
            var msg="يرجى اختيار حالة الطلب للعميل";
            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            loading.css('display','none');
        }else if(cusom_description.length >100){
            var msg="اقصى عدد الأحرف لوصف الطلب هي 100 حرف";
            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            loading.css('display','none');
        }else{
            var dataString = 'action=editeorderdetailse&value=' + cusom_number + '&value1='+cusom_name+ '&value2='+cusom_starts+ '&value3='+cusom_statues+ '&value4='+cusom_description+ '&value5='+number_owner+ '&value6='+kind_aqar+ '&value7='+city+ '&value8='+jop+ '&value9='+salary+ '&value10='+resource_obligations+ '&value11='+obligations+ '&value12='+data_birth + '&value13='+powered +'&value14='+bank+'&value15='+name_owner+'&value16='+order_notes;
             $.ajax({
                type: "post",
                url: "action.php",
                data: dataString,
                catch: false, 
            }).done(function (msg) { 
                loading.css('display','none');
                save_eltizam(cusom_number);
                if (msg == "11111") { 
                    var msg="تم تعديل البيانات بنجاح";
                    formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                } else if(msg=="00000"){ 
                    var msg="هناك خطاء يرجى تحديث الصفحة وإجراء تعديل على البيانات ";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');  
                } 
               
            });
        }
        setTimeout(() => {
             formm.find("#success").html("");
        }, 3000);
        
    });
        
      

    
});

 
function save_eltizam(order_id){
    var cardValues = [];
 
    $('.eltzams .main_eltizam').each(function() {
        var cardData = {}; 
        cardData.jehaht_eltizam = $(this).find('.kind_jehah').val();
        cardData.cast = $(this).find('.cast').val();
        cardData.total_eltizam = $(this).find('.total_eltizam').val();
        cardData.note = $(this).find('.note').val(); 
        cardValues.push(cardData);
    });
   
    var cardValuesJSON = JSON.stringify(cardValues);
    var dataString = 'action=SAVE_NEW_ELTIZAM&value=' + order_id + '&value1='+cardValuesJSON;
    $.ajax({
       type: "post",
       url: "action.php",
       data: dataString,
       catch: false, 
   }).done(function (response) { 
       console.log(response)
   });


}

// $(function () {
//     $("#test").focus();
// });
// document.querySelector('.floating-btn').addEventListener('click', function (e) {
//     e.target.closest('button').classList.toggle('clicked');
// });


// setInterval(function () {
// }, 3000);
 

// var hasConsole = typeof console !== "undefined";
// var fingerprintReport = function () {
//     Fingerprint2.get(function (components) {
//         var murmur = Fingerprint2.x64hash128(components.map(function (pair) { return pair.value }).join(), 31);
//         var details;
//         for (var index in components) {
//             var obj = components[index];
//             var line = obj.key + " = " + String(obj.value).substr(0, 100);
//             details += line + "\n";
//         }
//         var dataString = 'action=DetailsComputer&value=sdf&value1=' + details;
//         $.ajax({
//             type: "post",
//             url: "action.php",
//             data: dataString,
//             catch: false,
//             success: function (html) {
//                 $('#return_data').html(html);
//             }
//         }).done(function (msg) {
//         });

//     });
// }


// class Button {
//   constructor(HTMLButtonElement) {
//     this.button = HTMLButtonElement;
//     this.width = this.button.offsetWidth;
//     this.height = this.button.offsetHeight;
//     this.left = this.button.offsetLeft;
//     this.top = this.button.offsetTop;
//     this.x = 0;
//     this.y = 0;
//     this.cursorX = 0;
//     this.cursorY = 0;
//     this.magneticPullX = 0.3;
//     this.magneticPullY = 0.3;
//     this.isHovering = false;
//     this.magnetise();
//     this.createRipple();
//   }

//   onEnter = () => {
//     gsap.to(this.button, 1, {
//       x: this.x * this.magneticPullX,
//       y: this.y * this.magneticPullY,
//       ease: Power4.easeOut
//     });
//   };

//   onLeave = () => {
//     gsap.to(this.button, 0.7, {
//       x: 0,
//       y: 0,
//       ease: Elastic.easeOut.config(1.1, 0.5)
//     });
//   };

//   magnetise = () => {
//     document.querySelector("body").addEventListener("mousemove", (e) => {
//       this.cursorX = e.clientX;
//       this.cursorY = e.clientY;
     
//       const center = {
//         x: this.left + this.width / 2,
//         y: this.top + this.height * 2.5
//       };
      

//       this.x = this.cursorX - center.x;
//       this.y = this.cursorY - center.y;

//       const distance = Math.sqrt(this.x * this.x + this.y * this.y);
//       const hoverArea = this.isHovering ? 0.6 : 0.5;

//       if (distance < this.width * hoverArea) {
//         if (!this.isHovering) {
//           this.isHovering = true;
//         }
//         this.onEnter();
//       } else {
//         if (this.isHovering) {
//           this.onLeave();
//           this.isHovering = false;
//         }
//       }
//     });
//   };

//   createRipple = () => {
//     this.button.addEventListener("click", () => {
//       const circle = document.createElement("span");
//       const diameter = Math.max(
//         this.button.clientWidth,
//         this.button.clientHeight
//       );
//       const radius = diameter / 2;

//       const offsetLeft = this.left + this.x * this.magneticPullX;
//       const offsetTop = this.top + this.y * this.magneticPullY;

//       circle.style.width = circle.style.height = `${diameter}px`;
//       circle.style.left = `${this.cursorX - offsetLeft - radius}px`;
//       circle.style.top = `${this.cursorY - offsetTop - radius}px`;
//       circle.classList.add("ripple");

//       const ripple = this.button.getElementsByClassName("ripple")[0];

//       if (ripple) {
//         ripple.remove();
//       }

//       this.button.appendChild(circle);
//     });
//   };
// }

// const buttons = document.getElementsByTagName("button");
// for (const button of buttons) {
//   new Button(button);
// }




