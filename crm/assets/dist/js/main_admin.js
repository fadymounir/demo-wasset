$(function () {

    let url_action = '../action.php';


    $('.editeDepartment').on('click', function () {
        var id = $(this).attr('id');
        var text = $(this).closest('li').find('.emportent-text').text();
        Swal.fire({
            title: 'أدخل النص هنا',
            input: 'text',
            inputPlaceholder: 'أدخل نص هنا',
            inputValue: text,
            showClass: {
                popup: 'animate__animated animate__fadeInDown'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            },
            inputAttributes: {
                autocapitalize: 'off',
            },
            inputValidator: (value) => {
                if (!value) {
                    return 'الرجاء عدم ترك الحقل فارغ'
                }
            },
            showCancelButton: true,
            confirmButtonText: 'تعديل',
            showLoaderOnConfirm: true,
            preConfirm: login => {
                if (true) {

                    return;
                } else {
                    Swal.showValidationMessage(
                        `قم بإملاء الحقل ${errors}`);
                }
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).
            then(result => {
                if (result.value) {
                    var name = `${result.value}`;
                    var dataString = 'action=edite_emportant&value=' + id + '&value1=' + name;
                    $.ajax({
                        type: "post",
                        url: url_action,
                        data: dataString,
                        catch: false,
                    }).done(function (msg) {
                        if (msg === "11111") {
                            text.text(name)
                            Swal.fire({
                                icon: 'success',
                                title: ` تم تعديل  ${result.value}`,
                                imageUrl: result.value.avatar_url
                            });
                        } else {

                        }
                    });


                }
            });
    });

    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });


    init_function();

    function init_function() {
        $('.savepagedata').on('click', function () {
            
            var jsondata = getAllValues();
            var dataString = 'action=savedatapage&value=' + encodeURIComponent(jsondata)+ '&value1=1&user_color='+$('#user_color').val()+'&sidebar_text_color='+$('#sidebar_text_color').val()+'&navbar_color='+$('#navbar_color').val()+'&sidebar_color='+$('#sidebar_color').val()+ '&sidebar_hover_color='+$('#sidebar_hover_color').val()+ '&sidebar_text_hover_color='+$('#sidebar_text_hover_color').val()+ '&navbar_text_color='+$('#navbar_text_color').val()+ '&navbar_text_hover_color='+$('#navbar_text_hover_color').val()+ '&home_boxes='+$('#home_boxes').val();
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                console.log(msg)
                if (msg == "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل بنجاح'
                    });
                } else {
                    Swal.fire({
                        title: 'خطاء',
                        text: 'هناك خطاء',
                        icon: 'error',
                    });
                }
            });
        });

        $('.save_city').on('click', function () {
            var id = $(this).attr('id');
            var val = $(this).closest('.box-city').find('input').val();
            console.log(id);
            console.log(val)
            var dataString = 'action=save_city' + '&value=' + id + '&value1=' + val;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                if (msg == "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل',
                    });
                } else {

                }
            });

        });

        $('.delete_city').on('click', function () {
            var id = $(this).attr('id');
            var dataString = 'action=deletecity' + '&value=' + id;
            $(this).closest('.box-city').remove();
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                if (msg == "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'نجح الحذف',
                    });
                } else {

                }
            });

        });
        $('.add_city').on('click', function () {

            var main = $(this).closest('.main-citys');
            Swal.fire({
                title: 'أدخل إسم المدينة',
                input: 'text',
                inputValue: "",
                inputAttributes: {
                    autocapitalize: 'true',
                },
                textContent: "",
                showCancelButton: true,
                confirmButtonText: 'حفظ',
                cancelButtonText: 'إلغاء',
                showLoaderOnConfirm: true,
                preConfirm: (login) => {
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    var dataString = 'action=AddCity&value=' + result.value;
                    $.ajax({
                        type: "post",
                        url: url_action,
                        data: dataString,
                        catch: false,
                        success: function (html) {
                        }
                    }).done(function (msg) {

                        if (msg === "11111") {
                            Toast.fire({
                                icon: 'success',
                                title: 'نجح إضافة المدينة',
                            });

                            var dataString = 'action=getcitys' + '&value=' + 1;
                            $.ajax({
                                type: "post",
                                url: url_action,
                                data: dataString,
                                catch: false,
                            }).done(function (msg) {
                                main.find('.row-citys').html(msg);
                                init_function();
                            });

                        } else if (msg === "00000") {

                        }
                    });

                }
            });
            
        });
    }

    function getAllValues() {
        var index = 0;
        var jsonObj = "";
        $("#valuess :input").each(function () {
            if ((String($(this).attr('name')) === "undefined") || (String($(this).val()) === "undefined")) {

            } else {
                if (index > 0) {
                    jsonObj = jsonObj + ",";
                }
                jsonObj = jsonObj + "`" + $.trim(String($(this).attr('name'))) + "`";

                if ($(this).val() === "") {
                    jsonObj = jsonObj + "='0'";
                } else {
                    jsonObj = jsonObj + "=" + "'" + String($(this).val()).replace(/"/g, "").replace(/'/g, "") + "'";
                }
                index = index + 1;
            }

        });
        return jsonObj;
    }

});