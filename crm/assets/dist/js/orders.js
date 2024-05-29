jQuery(document).ready(function($) {
   

    moment.locale('ar');
  
const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {
        //   toast.addEventListener('mouseenter', Swal.stopTimer)
        //   toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      });

    
    $("#AllProblems").fancyTable({
        pagination: true,
        paginationClass: "btn btn-light",
        paginationClassActive: "active",
        pagClosest: 5,
        searchable: true,
        perPage: 10,
        globalSearch:false,
        rowDisplayStyle:'block',
        limit: 5,
        inputPlaceholder:"بحث...",
        onUpdate:function(table){
            //   console.log(table);
            $('.number_orders').text((table.fancyTable.matches)+" إجمالي الطلبات"); 
        },
        onInit:function(table){
            $('.number_orders').text((table.fancyTable.matches)+" إجمالي الطلبات"); 
        },

        });
        
    $("#AllProblems_upload").fancyTable({
        pagination: true,
        paginationClass: "btn btn-light",
        paginationClassActive: "active",
        pagClosest: 3,
        searchable: true,
        perPage: 10,
        // globalSearch:true,
        rowDisplayStyle:'block',
        limit: 5,
        inputPlaceholder:"بحث..."
        });
        
    $('#AllProblems').excelTableFilter({
                    search:false,
                }); 
    $('#AllProblems_upload').excelTableFilter({});


    refreshjs();


    $('.fancySearchRow th').eq(0).find('input').css('display','none');
    $('.fancySearchRow th').eq(7).find('input').css('display','none');
    $('.fancySearchRow th').eq(8).find('input').css('display','none');
    $('.fancySearchRow th').eq(9).find('input').css('display','none');
    $('.fancySearchRow th').eq(10).find('input').css('display','none');
    $('.fancySearchRow th').eq(11).find('input').css('display','none');
    $('.fancySearchRow th').eq(14).find('input').css('display','none'); 
    $('.no-sort').on('click',function(e){
        // e.stopPropagations();
        // alert("afeef")
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
            var label =$(this).closest('body').find('label');
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
            label.each(function(idx, el) { 
                var font=getnumberstring($(el).css('font-size')); 
                $(el).css("font-size", (font+1)+"px"); 
            });
            localStorage.setItem('fontsize', fontsize);
        }
    });

    $('.font-minus').on('click',function(){ 
        if(fontsize>=0){
            fontsize=fontsize-1; 
            var p = $(this).closest('body').find('p');
            var span =$(this).closest('body').find('span');
            var a =$(this).closest('body').find('a');
            var label =$(this).closest('body').find('label');
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
            label.each(function(idx, el) { 
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

    function refreshjs(){

        
         
        if ($('#AllProblems').length > 0) {
            let len_row_orders =parseInt($('#AllProblems').find('tbody').find('tr').length);
            console.log("len_row_orders="+len_row_orders)
            $('.number_orders').html(len_row_orders.toString()  + ' إجمالي الطلبات');
        }else{
            $('.number_orders').html('0' + ' إجمالي الطلبات');
        }
        
        if ($('#AllProblems_upload').length > 0) {
            let len_row_upload = parseInt($('#AllProblems_upload').find('tbody').find('tr').length);
            $('.number_orders_upload').html(len_row_upload.toString() + ' إجمالي الطلبات');
        }else{
            $('.number_orders_upload').html('0' + ' إجمالي الطلبات');
        }
        
        $('.deletedepartment').on('click',function(){
            var id=$(this).attr('id');
            var li =$(this).closest('li'); 
            var pro=$(this).closest('.nav').find('.notif');
            Swal.fire({
                title: 'تأكيد ازالة الرسالة',
                text: "عند إزالة الرسالة ,فأنت توافق على أنه تم حل المشكلة أو إضافة تحديث  لدى النظام الخاص بكم ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'إلغاء',
                confirmButtonText: 'نعم',
            }).then((result) => { 
                if (result.value){
                var dataString = 'action=deletedepartment&value='+id+'&value1=1';
                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: dataString,
                    catch: false, 
                }).done(function (msg) { 
                    if (msg == "11111") { 
                        li.remove();
                        pro.text(parseInt(pro.text())-1)
                    }else{
                        
                    }
        
                });   
                }
                
            });
            
        });
        
        $('#AllProblems').on('change', 'input', function () {  
                // var rowcount1= $('.total_orders_filter').find('tr').length;
                // console.log('rowcount1='+rowcount1);
                var rowcount= $('.total_orders_filter').find('tr').filter(function() {  
                    // console.log('display:==='+$(this).css('display'));
                    return $(this).css('display') != 'none';
                }).length; 
                $('.number_orders').text((rowcount)+" إجمالي الطلبات");
        }); 
        
        $('#AllProblems_upload').on('change', 'input', function () {  
                var rowcount= $('.total_orders_filter_upload').find('tr').filter(function() { 
                    return $(this).css('display') != 'none';
                }).length;
                $('.number_orders_upload').text((rowcount)+" إجمالي الطلبات");
        }); 
        
        showcountrow();
        showcountrow1();
        
        function showcountrow(){
            var rowcount= parseInt($('.number_orders_pragrapho').text());
                $('.number_orders').text((rowcount)+" إجمالي الطلبات");
        }
        
        function showcountrow1(){
            var rowcount= parseInt($('.number_orders_pragrapho1').text());
                $('.number_orders_upload').text((rowcount)+" إجمالي الطلبات");
        }
    
    
       
        
        $('.closemodel').on('click',function(){
            var model=$(this).closest('.modal');
            model.hide();
        });
        
        $('.closemodelbutton').on('click',function(){
            var model=$(this).closest('.modal');
            model.hide();
        });
        
        $('.savechangeorder').on('click',function(){
            var model=$(this).closest('.modal');
            var model_error=model.find('.model_error');
            var model_normal=model.find('.model_normal');
            var model_successful=model.find('.model_successful');
            
            var name1=model.find('.name1').val();
            var name2=model.find('.name2').val();
            var textname=model.find('.name1').find('option:selected').text(); 
            var textname2=model.find('.name2').find('option:selected').text(); 
            if((name1==="0")||(name2==="0")){
                model_successful.hide();
                model_normal.hide(); 
                model_error.show();  
                model_error.text("يرجى اختيار الموظف الأول ثم الموظف الأخر ");
            }else if(name1==name2){
                model_successful.hide();
                model_normal.hide(); 
                model_error.show();  
                model_error.text("يرجى اختيار موظفين مختلفين");
                
            }else{
                model_normal.text("يرجى الإنتظار جاري ارسال الطلب ...");
                model_successful.hide();
                model_normal.show(); 
                model_error.hide(); 
                var dataString = 'action=savechangeorder&value='+name1+'&value1='+name2;
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false, 
                    }).done(function (msg) {
                        var index = msg;
                        if (index == "11111") {
                            model_successful.show();
                            model_normal.hide();
                            model_error.hide(); 
                            model_successful.text("تم تحويل جميع الطلبات إلى الموظف ("+textname2+")");
                            
                        } else if (index == "55555")  {
                            model_successful.hide();
                            model_normal.hide();
                            model_error.text("لا توجد طلبات للموظف ("+textname+")");
                            model_error.show(); 
                        }else{
                            model_successful.hide();
                            model_normal.hide();
                            model_error.text("هناك خطاء تأكد من توفر النت على الجهاز");
                            model_error.show(); 
                        }

                    });
            }
        });
        
        window.onclick = function(event) {
        if (event.target == "modal") {
            $('.model').hide();
        }
        }
        
        $('[data-toggle="tooltip"]').tooltip(); 

     
        
       
        
        $('.refrch_store').on('click',function(){
            Swal.fire({
                title: 'تسوية توزيع الطلبات',
                text: "هل أنت متأكد من تسوية توزيع الطلبات من القيمة صفر",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم'
            }).then((result) => {
                if (result.value) {

                    var dataString = 'action=make_order_true_zero&value=1&value1=1';
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) {
                            $('#msg').html(html);
                        }
                    }).done(function (msg) {
                        var index = msg;
                        if (index == "11111") {
                            Swal.fire({
                                title: 'نجح',
                                text: 'تم ضبط التساوي على الرقم صفر',
                                icon: 'success',  
                                confirmButtonText: 'حسناً'
                            });
                            tr.remove(); 
                        } else {
                            Swal.fire({
                                title: 'فشل',
                                text: 'هناك خطاء يرجى تصوير الشاشة وإرسال المشكلة إلى قسم تقنية المعلومات',
                                icon: 'error',  
                                confirmButtonText: 'حسناً'
                            });

                        }

                    });


                }
            });
        });
    
        
        $('.deleteemployee').on('click',function(){
            var id =$(this).attr('id');
            var tr =$(this).closest('tr'); 
            Swal.fire({
                title: 'تأكيد الحذف',
                text: "هل أنت متأكد من حذف القسم",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'لا',
                confirmButtonText: 'نعم إحذف'
            }).then((result) => {
                if (result.value) {

                    var dataString = 'action=delete_employye&value=' + id + '&value1=1';
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false,
                        success: function (html) {
                            $('#msg').html(html);
                        }
                    }).done(function (msg) {
                        var index = msg;
                        if (index == "11111") {
                            Swal.fire({
                                title: 'نجح',
                                text: 'تم حذف حساب الموظف',
                                icon: 'success',  
                                confirmButtonText: 'حسناً'
                            });
                            tr.remove(); 
                        } else {
                            Swal.fire({
                                title: 'فشل',
                                text: 'هناك خطاء لم يتم عملية الحذف',
                                icon: 'error',  
                                confirmButtonText: 'حسناً'
                            });

                        }

                    });


                }
            });

        });
    


    

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
    
    $('.save_salary').on('click',function(){
        $(this).closest('.main_edite_order').on(500).fadeOut(); 
    });
    
    $('.cloase_edite_cust').on('click',function(){
        $(this).closest('.main_edite_cust').on(500).fadeOut();
    });
    
        
        // $('#AllProblems').find(".showFilter").each(function(index) {
        //     $(this).on('click',function(){ 
        //     var tablename=$(this).attr('tablename');
        //         alert(id)
        //     });
        // }); 
        
        // ----------------- main order ---------------
        
        $('#AllProblems_upload').find(".change_note").each(function(index) {
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
        
        $('#AllProblems_upload').find(".show_status").each(function(index) {
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
        
        $('#AllProblems_upload').find(".order_stages").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
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
                return 'يجب عليك إختيار حالة الطلب'
                }else{
                if (value == 1) {
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
        
        $('#AllProblems_upload').find(".show_starts").each(function(index) {
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

        $('#AllProblems_upload').find(".delete_order").each(function(index) {
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
                
                var dataString = 'action=delete_order_admin&value=' + id + '&value1=1';
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
        
        $('#AllProblems_upload').find(".edite_order_main" ).each(function(index) {
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

        $('#AllProblems_upload').find(".add_new_alarm" ).each(function(index) { 
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
        
            
        // ----------------- main order ---------------
        $('#AllProblems').find(".change_note").each(function(index) {
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
        
        $('#AllProblems').find(".show_status").each(function(index) {
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
        
        $('#AllProblems').find(".order_stages").each(function(index) {
            $(this).on('click', function () {
            var td = $(this);
            var id = $(this).attr('id'); 
            (async () => { 
            const inputOptions = new Promise((resolve) => {
            setTimeout(() => {
                resolve({ 
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
                return 'يجب عليك إختيار حالة الطلب'
                }else{
                if (value == 1) {
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
        
        $('#AllProblems').find(".show_starts").each(function(index) {
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

        $('#AllProblems').find(".delete_order").each(function(index) {
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
                
                var dataString = 'action=delete_order_admin&value=' + id + '&value1=1';
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
        
        $('#AllProblems').find(".edite_order_main" ).each(function(index) {
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
        
        $('#AllProblems').find(".add_new_alarm" ).each(function(index) { 
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

        $("#set_edit_order").click(function(event) {
            $(this).find("#success").html('')
        });
        

        $('.save-user-datialse').on('click',function(){ 
            var formm=$(this).closest('.edite_cust_customer');
            
            var cusom_name =formm.find('#cusom_name').val(); 
            var cusom_phone =formm.find('#cusom_phone').val();
            var cusom_email =formm.find('#cusom_email').val();
            var cusom_username =formm.find('#cusom_username').val();
            var cusom_password =formm.find('#cusom_password').val(); 
            var cusom_id =formm.find('#custom_id').val();
            
            if(cusom_name.trim()==""){
                var msg="يجب تعبية حقل اسم الموظف";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else if(cusom_phone.trim()==""){
                var msg="يجب تعبية حقل رقم الجوال للموظف";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else if(cusom_email.trim()==""){
                var msg="يجب تعبية حقل البريد الإلكتروني للموظف";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else if(cusom_username.trim()==""){
                var msg="يجب تعبية حقل اسم المستخدم";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else if(cusom_password.trim()==""){
                var msg="يجب تعبية حقل كلمة المرور";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else  if(cusom_name.length <3){
                var msg="يجب ان يحتوي اسم الموظف  على 3 احرف أو أكثر  ";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else  if(cusom_phone.length <9){
                var msg="يجب ان يحتوي  رقم الجوال  على 9 ارقام أو أكثر  ";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else  if(cusom_username.length <3){
                var msg="يجب ان يحتوي اسم المستخدم  على 3 احرف أو أكثر  ";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else  if(cusom_password.length <5){
                var msg="يجب ان تحتوي كلمة المرور على 5 احرف أو أكثر  ";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else  if(cusom_id.length ==0){
                var msg="هناك خطاء يجب تحديث لوحة التحكم وإعادة المحاولة مجدداً";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
            }else{
                var dataString = 'action=editeustomerdetailse&value=' + cusom_name + '&value1='+cusom_phone+ '&value2='+cusom_email+ '&value3='+cusom_username+ '&value4='+cusom_password+ '&value5='+cusom_id;
                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: dataString,
                    catch: false, 
                }).done(function (msg) {
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

            console.log(order_notes);
            // console.log(number_owner);
            // console.log(kind_aqar);
            // console.log(city);
            // console.log(jop);
            // console.log(salary);
            // console.log(resource_obligations);
            // console.log(obligations);
            // console.log(data_birth);
            // console.log(powered);
            // console.log(bank); 
                    
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
        
        $('#AllUsers').find(".editeemployee" ).each(function(index) {
            $(this).on("click", function(){ 
                var id=$(this).attr("id");
                $('.main_edite_cust').addClass('loadding-data');
                
                var dataString = 'action=getDeatilsUsers&value=' + id + '&value1=1'; 
                $('.main_edite_cust').on(500).fadeIn();
                $('.main_edite_cust').css('display','flex');
                $('.main_edite_cust').find('.main-loading').on(500).fadeIn();
                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: dataString,
                    catch: false, 
                }).done(function (msg) {
                    if (msg == "00000") {
                        console.log(msg)
                    } else { 
                        setTimeout(() => {
                            $('.main_edite_cust').find('#set_edit_cust').html(msg);
                            $('.main_edite_cust').find('.main-loading').on(500).fadeOut('slow');
                            $('.main_edite_cust').removeClass('loadding-data');
                        }, 500);
                    } 
                
                }); 
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
                setTimeout(() => {
                    form.find("#success").html("");
                }, 3000);
            }); 
        }
        
        function setmaskandselect(){
            
            $('.cancel_accept_order').on('click',function(){
                var formm=$(this).closest('.edite_order_customer');
                
                var loading=formm.find('.main-loading'); 
                loading.css('display','flex');
                
                var order_id=$(this).attr("accept_order_id");
                var accept_id=$(this).attr("accept_id");
                
                console.log(order_id);
                console.log(accept_id);
                var dataString = 'action=cancel_accept_order&value=' + order_id + '&value1='+accept_id;  
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false, 
                    }).done(function (msg) {
                        refrch_msg(order_id,formm,loading);
                        if (msg == "00000") {
                            var msg="هناك خطاء حاول مرة اخرى";
                            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } else if(msg =="11111") {  
                            var msg="تمت استعادة الطلب";
                            formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        }  
                }); 
            });
            
            $('.btn_accept_order').on('click',function(){ 
                var formm=$(this).closest('.edite_order_customer');
                var loading=formm.find('.main-loading'); 
                loading.css('display','flex');
                
                var order_id=$(this).attr("order_id");
                var accept_id=$(this).attr("accept_id");
                
                var dataString = 'action=change_accept_order&value=' + order_id + '&value1='+accept_id;  
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false, 
                    }).done(function (msg) {
                        refrch_msg(order_id,formm,loading);
                        if (msg == "00000") {
                            var msg="هناك خطاء حاول مرة اخرى";
                            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } else if(msg =="11111") {  
                            
                            var msg="تمت الموافقة على رفع الطلب";
                            formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } 
                    
                }); 
            });
            
            $('.btn_rejection_order').on('click',function(){ 
                var formm=$(this).closest('.edite_order_customer');
                var loading=formm.find('.main-loading'); 
                loading.css('display','flex');
                
                var order_id=$(this).attr("order_id");
                var accept_id=$(this).attr("accept_id");
                
                var dataString = 'action=change_rejection_order&value=' + order_id + '&value1='+accept_id;  
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false, 
                    }).done(function (msg) {
                        refrch_msg(order_id,formm,loading);
                        if (msg == "00000") {
                            var msg="هناك خطاء حاول مرة اخرى";
                            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } else if(msg =="11111") {  
                            
                            var msg="تم رفض الطلب";
                            formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } 
                    
                }); 
            });
            
            $('.send_msg_order').on('click',function(){
                var form=$(this).closest('.main_send_msg_order');
                var formm=$(this).closest('.edite_order_customer');
                var loading=formm.find('.main-loading'); 
                
                loading.css('display','flex');
                var title=form.find('#title_description').val();
                var msg_description = form.find('#msg_description').val();
                var order_accept =form.find('#order_accept').prop("checked");
                
                var order_id=$(this).attr("order_id");
                var emp_name="الإدارة"; 
                
                if((title.trim()=="")||(msg_description.trim()=="")){
                    var msg="يجب تعبية جميع الحقول (العنوان+وصف الرسالة)";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                    loading.css('display','none');
                }else{ 
                    var dataString = 'action=SendAdminMesage&value=' + order_id + '&value1='+title+ '&value2='+msg_description+ '&value3='+order_accept+ '&value4='+emp_name;  
                    $.ajax({
                        type: "post",
                        url: "action.php",
                        data: dataString,
                        catch: false, 
                    }).done(function (msg) {
                        refrch_msg(order_id,formm,loading);
                        if (msg == "00000") {
                            var msg="هناك خطاء حاول مرة اخرى";
                            formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } else if(msg =="11111") {   
                            var msg="تم الإرسال بنجاح";
                            formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">'+msg+'</strong></div>');
                        } 
                    
                    }); 
                }
                
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
        
        $('.loading_all').css('display','none');

    } 
    
    
    $('.refrch_orders').on('click',function(){ 
        $('.loading_all').css('display','flex'); 
        update_problemps(1); 
    });
    
    $('.refrch_orders1').on('click',function(){ 
        $('.loading_all').css('display','flex');
        update_problemps1(1); 
    });
    update_problemps();

    function update_problemps(id) {
        var dataString = 'action=GetProblems&value=' + id + '&value1=nodata';
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false,
            success: function (html) { 
            }
        }).done(function (msg) {
            $('#AllProblems').html(msg);
           
            $("#AllProblems").fancyTable({
              pagination: true,
              paginationClass: "btn btn-light",
              paginationClassActive: "active",
              pagClosest: 5,
              searchable: true,
              globalSearch:false,
              perPage: 10,
              globalSearch:false,
              rowDisplayStyle:'block',
              limit: 5,
              inputPlaceholder:"بحث...",
              onUpdate:function(table){ 
                  $('.number_orders').text((table.fancyTable.matches)+" إجمالي الطلبات"); 
              }, 
              onInit:function(table){
                 $('.number_orders').text((table.fancyTable.matches)+" إجمالي الطلبات"); 
              },
        
            }); 
            
            $('#AllProblems').excelTableFilter({
                search:false,
            }); 
            
            
            refreshjs(); 
            Toast.fire({
                icon: 'success',
                title: 'تم التحديث',
            }); 
        });
    }
    
    function update_problemps1(id) {
        var dataString = 'action=GetOrderUpoload&value=' + id + '&value1=nodata';
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false,
            success: function (html) { 
            }
        }).done(function (msg) {
            $('#AllProblems_upload').html(msg);
            // $('#AllProblems').excelTableFilter();  
            
            $("#AllProblems_upload").fancyTable({
              pagination: true,
              paginationClass: "btn btn-light",
              paginationClassActive: "active",
              pagClosest: 3,
              searchable: true,
              perPage: 10,
              rowDisplayStyle:'block',
              limit: 5,
              inputPlaceholder:"بحث..."
            }); 
             $('#AllProblems_upload').excelTableFilter({});
             
             $('.fancySearchRow th').eq(0).find('input').css('display','none');
             $('.fancySearchRow th').eq(7).find('input').css('display','none');
             $('.fancySearchRow th').eq(8).find('input').css('display','none');
             $('.fancySearchRow th').eq(9).find('input').css('display','none');
             $('.fancySearchRow th').eq(10).find('input').css('display','none');
             $('.fancySearchRow th').eq(11).find('input').css('display','none');
             $('.fancySearchRow th').eq(14).find('input').css('display','none');
          
             refreshjs();
             
             Toast.fire({
                icon: 'success',
                title: 'تم التحديث',
            }); 
        });
    }

  


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

refrechjsmoveemplly();
function refrechjsmoveemplly(){ 
  
    $('.header_details').find('.checkbox').on('click', function() {
        $('.emplay_loadding').css('display','flex');
        if ($('.header_details').find('.checkbox').is(':checked')) {
            $('.empllay_detals').each(function(index) {
                var checkbox = $(this).find('.checkbox');
                if (!checkbox.is(':checked')) {
                    $(this).click();
                }
            }); 
        } else {
            $('.empllay_detals').each(function(index) {
                var checkbox = $(this).find('.checkbox');
                if (checkbox.is(':checked')) {
                    $(this).click();
                }
            });
        }
        $('.emplay_loadding').css('display','none');
    });
    
    $('.empllay_detals').on('click', function() {
        var isChecked = $(this).find('.checkbox').is(':checked')
        $(this).toggleClass('empllay_detals_checked');
        $(this).find('.checkbox').prop('checked', !isChecked);
        changeEmplloyCount();
    });
    
    $('.form__input').on('input', function(index) {
        var str1 = $(this).val();
        $('.empllay_detals').each(function(index) {
            var name = $(this).find('.name').text();
            var state = $(this).find('.state').text();
            var status = $(this).find('.status').text();
            var phone = $(this).find('.phone').text();
            if ((name.includes(str1)) || (state.includes(str1)) || (status.includes(str1)) || (phone.includes(str1))) {
                $(this).css('display', 'flex');
            } else {
                $(this).css('display', 'none');
            }
        });
    
    });
    
    $('.btn_send_emplloy').on('click', function() {
        $('.btn_send_emplloy').prop('disabled', true);
        var ids = [];
        $('.empllay_detals').each(function(index) {
            var checkbox = $(this).find('.checkbox');
            var emplloyeId = $(this); 
            if (checkbox.is(':checked')) {
                ids.push(emplloyeId.attr('value_emplloy')); 
            }
        });
        var model=$(this).closest('.modal');
        var model_error=model.find('.model_error');
        var model_normal=model.find('.model_normal');
        var model_successful=model.find('.model_successful');
        
        var valueName1=model.find('.name1').find(":selected").val();
        var valueName2=model.find('.name2').find(":selected").val();
        var textName1=model.find('.name1').find(":selected").text() 
        var textName2=model.find('.name2').find(":selected").text(); 
         
        if((valueName1==="1")||(valueName2==="1")){
            model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text("يرجى اختيار الموظف الأول ثم الموظف الأخر ");
            changebutton(false,'يرجى اختيار الموظف الأول ثم الموظف الأخر',true);
            $('.btn_send_emplloy').prop('disabled', false);
            
        }else if(valueName1==valueName2){
            model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text("يرجى اختيار موظفين مختلفين");
            changebutton(false,'يرجى إختيار موظفين مختلفين',true);
            $('.btn_send_emplloy').prop('disabled', false);
        }else if(ids.length==0){
              model_successful.hide();
            model_normal.hide(); 
            model_error.show();  
            model_error.text("يرجى تحديد عميل واحد على الأقل");
            changebutton(false,'يرجى تحديد عميل واحد على الأقل',true);
            $('.btn_send_emplloy').prop('disabled', false);
        }else{
            changebutton(true,'يرجى الإنتظار ',false);
            model_normal.text("يرجى الإنتظار جاري ارسال الطلب ...");
            model_successful.hide();
            model_normal.show(); 
            model_error.hide();   
            changebutton(true,'',false);
            var dataString = 'action=savechangeorder&value='+valueName1+'&value1='+valueName2+'&value2='+ids+'&value3='+textName1+'&value4='+textName2;
                $.ajax({
                    type: "post",
                    url: "action.php",
                    data: dataString,
                    catch: false, 
                }).done(function (msg) { 
                    $('.btn_send_emplloy').prop('disabled', false);
                    changebutton(false,msg,false);
                    model_successful.show();
                    model_normal.hide();
                    model_error.hide(); 
                    model_successful.text(msg);
                    console.log("msg length = "+msg.length);
                   

                });
        }
    
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
    });

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


function changebutton(loading,msg,red){
    if(red){
        $('.btn_send_emplloy').css('background', '#ff0000a1');
    }else{
        $('.btn_send_emplloy').css('background', '#1c751ed1');
    }
    $('.btn_send_emplloy').find('.move_count_emp').text(msg);
    if(loading){ 
        $('.btn_send_emplloy').find('i').css('display', 'block');
        $('.btn_send_emplloy').find('p').css('display', 'none');
        $('.btn_send_emplloy').find('p').css('cursor', 'no-drop');
    }else{
       $('.btn_send_emplloy').find('i').css('display', 'none');
       $('.btn_send_emplloy').find('p').css('display', 'block'); 
       $('.btn_send_emplloy').find('p').css('cursor', 'pointer');
    }
    
}

$('.main_movement').find('.name1').on('change',function(){
    $('.emplay_loadding').css('display','flex');
   var selected_option_value = $(this).find(":selected").val();
   console.log(selected_option_value);
   if(selected_option_value!=0){
        var dataString = 'action=getEmployyes&value='+selected_option_value+'&value1=1';
        $.ajax({
            type: "post",
            url: "action.php",
            data: dataString,
            catch: false, 
        }).done(function (msg) {
            $('.emplay_loadding').css('display','none');
            // console.log(msg);
            if (msg == "11111") { 
                 
            }else{
              $('.main_emplloyes_move').find('.main_emplay').html(msg);  
              $('.btn_send_emplloy').css('background', '#ff0000a1');
              $('.move_count_emp').text('يرجى أختيار عميل واحد على الأقل');
              refrechjsmoveemplly();
            }

        }); 
   }else{
       
   }
});


});


