jQuery(document).ready(function ($) {


    let url_action        = '../action.php';
    let date_start_filter = "";
    let date_end_filter   = "";

    let date_alarm_from = "";
    let date_alarm_to   = "";

    let limit_row         = 100;
    let kind_employee     = $('.kind_employee').val();
    let kind_customer     = $('.kind_customer').val();

    if (kind_employee == 0 || kind_employee == 10) {
    }
    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {

        }
    });


    getallorders();


    $('.date_order_get').daterangepicker({
        "showDropdowns": true,
        "showWeekNumbers": true,
        "showISOWeekNumbers": true,
        "ranges": {
            "اليوم": [
                moment(),
                moment()
            ],
            "أمس": [
                moment().subtract(1, 'days'),
                moment().subtract(1, 'days')
            ],
            "آخر 7 أيام": [
                moment().subtract(6, 'days'),
                moment()
            ],
            "آخر 30 يومًا": [
                moment().subtract(29, 'days'),
                moment()
            ],
            "هذا الشهر": [
                moment().startOf('month'),
                moment().endOf('month')
            ],
            "الشهر الماضي": [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ],
            "جميع الأوقات": [
                moment().subtract(5, 'years').startOf('year'), // Covering the last 5 years
                moment()
            ]
        },
        "locale": {
            "direction": "rtl",
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "تطبيق",
            "cancelLabel": "إلغاء",
            "fromLabel": "من",
            "toLabel": "إلى",
            "customRangeLabel": "مخصص",
            "daysOfWeek": [
                "الأحد",
                "الاثنين",
                "الثلاثاء",
                "الأربعاء",
                "الخميس",
                "الجمعة",
                "السبت"
            ],
            "monthNames": [
                "يناير",
                "فبراير",
                "مارس",
                "إبريل",
                "مايو",
                "يونيو",
                "يوليو",
                "أغسطس",
                "سبتمبر",
                "أكتوبر",
                "نوفمبر",
                "ديسمبر"
            ],
            "firstDay": 1
        },
        "alwaysShowCalendars": true,
        "startDate": moment().subtract(5, 'years').startOf('year').format("MM/DD/YYYY"),
        "endDate": moment().format("MM/DD/YYYY"),
        "opens": "right"
    }, function (start, end, label) {
        date_start_filter = start.format('YYYY-MM-DD');
        date_end_filter   = end.format('YYYY-MM-DD');
        console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' إلى ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });
    $('.date_order_alarm').daterangepicker({
        "showDropdowns": true,
        "showWeekNumbers": true,
        "showISOWeekNumbers": true,
        "ranges": {
            "اليوم": [
                moment(),
                moment()
            ],
            "أمس": [
                moment().subtract(1, 'days'),
                moment().subtract(1, 'days')
            ],
            "آخر 7 أيام": [
                moment().subtract(6, 'days'),
                moment()
            ],
            "آخر 30 يومًا": [
                moment().subtract(29, 'days'),
                moment()
            ],
            "هذا الشهر": [
                moment().startOf('month'),
                moment().endOf('month')
            ],
            "الشهر الماضي": [
                moment().subtract(1, 'month').startOf('month'),
                moment().subtract(1, 'month').endOf('month')
            ],
            "جميع الأوقات": [
                moment().subtract(5, 'years').startOf('year'), // Covering the last 5 years
                moment()
            ]
        },
        "locale": {
            "direction": "rtl",
            "format": "MM/DD/YYYY",
            "separator": " - ",
            "applyLabel": "تطبيق",
            "cancelLabel": "إلغاء",
            "fromLabel": "من",
            "toLabel": "إلى",
            "customRangeLabel": "مخصص",
            "daysOfWeek": [
                "الأحد",
                "الاثنين",
                "الثلاثاء",
                "الأربعاء",
                "الخميس",
                "الجمعة",
                "السبت"
            ],
            "monthNames": [
                "يناير",
                "فبراير",
                "مارس",
                "إبريل",
                "مايو",
                "يونيو",
                "يوليو",
                "أغسطس",
                "سبتمبر",
                "أكتوبر",
                "نوفمبر",
                "ديسمبر"
            ],
            "firstDay": 1
        },
        "alwaysShowCalendars": true,
        "startDate": moment().subtract(5, 'years').startOf('year').format("MM/DD/YYYY"),
        "endDate": moment().format("MM/DD/YYYY"),
        "opens": "right"
    }, function (start, end, label) {
        date_alarm_from = start.format('YYYY-MM-DD');
        date_alarm_to   = end.format('YYYY-MM-DD');
        console.log("New date range selected: ' + start.format('YYYY-MM-DD') + ' إلى ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')");
    });

    $('.show_filter_main').on('click', function () {
        $('.show_filter').toggleClass('show_filter_active');
    });
    $('.close_filter').on('click', function () {
        $('.show_filter').toggleClass('show_filter_active');
    });

    $('.update_filters').on('click', function () {
        $(this).closest('.show_filter_active').removeClass('show_filter_active');
        getallorders();
    });

    $('.clear_filters').on('click', function () {
        $('.customer_name').val('');
        $('.customer_phone_number').val('');
        $('.date_order_get').val('');
        $('.date_order_alarm').val('');
        $('.number_order_select').val(100);
        $('.multi-select-menuitem').click();
        date_start_filter = '';
        date_end_filter   = '';
        date_alarm_from='';
        date_alarm_to='';
        getallorders();
    });


    function getallorders() {
        $('.loading_all').css('display', 'flex');
        $('.loading_page').css('display', 'flex');
        let object                = $('.show_filter');
        let number_order          = parseInt(object.find('.number_order').val());
        let customer_name         = object.find('.customer_name').val();
        let customer_phone_number = parseInt(object.find('.customer_phone_number').val());
        let limit_order_select    = parseInt(object.find('.number_order_select').val());
        let selectedStars         = $('#categories_stars').val();
        let categories_status     = $('#categories_status').val();
        let selectedPosible       = $('#categories_posible').val();
        let categories_users;
        if (kind_employee == 0 || kind_employee == 10) {
            categories_users = $('#categories_users').val();
        }
        let categories_source = $('#categories_source').val();

        let json_data = [];
        json_data.push(kind_customer);
        json_data.push(limit_order_select);
        json_data.push(customer_name);
        json_data.push(customer_phone_number);
        json_data.push(date_start_filter);
        json_data.push(date_end_filter);
        json_data.push(number_order);
        json_data.push(selectedStars);
        json_data.push(selectedPosible);
        json_data.push(categories_status);
        if (kind_employee == 0 || kind_employee == 10) {
            json_data.push(categories_users);
        }
        else {
            json_data.push(0);
        }
        json_data.push(categories_source);

        json_data.push(date_alarm_from);
        json_data.push(date_alarm_to);

        // console.log(json_data)
        let dataString = 'action=GetProblems&value=' + JSON.stringify(json_data) + '&value1=2&value2=1';
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (html) {
                $('.loading_all').css('display', 'none');
                $('.loading_page').css('display', 'none');
                $('.all_orders').html(html);
                init_table();
                Toast.fire({
                    icon: 'success',
                    title: 'نجح التحديث',
                });
            }
        });
    }

    function init_table() {


        $(".all_orders").fancyTable({
            pagination: true,
            paginationClass: "btn btn-light",
            paginationClassActive: "active",
            pagClosest: 5,
            searchable: false,
            perPage: 10,
            globalSearch: false,
            rowDisplayStyle: 'block',
            limit: 5,
            inputPlaceholder: "بحث...",
            onUpdate: function (table) {
                //   console.log(table);
                $('.number_orders').text((table.fancyTable.matches) + " إجمالي عدد العملاء");
            },
            onInit: function (table) {
                $('.number_orders').text((table.fancyTable.matches) + " إجمالي عدد العملاء");
            },
        });

        $('.all_chose_statuse').find('.checkbox-input').off().on('click', function () {
            $(this).closest('.all_chose_statuse').find('.checkbox-input').not(this).prop('checked', false);
        });

        $('.all_orders').find(".show_stars_diloage").off().on('click', function () {
            var this_td        = $(this);
            var order_id       = parseInt($(this).attr('id'));
            var stars          = parseInt($(this).attr('stars'));
            var serve_customer = parseInt($(this).attr('serve_customer'));
            var statuse_note   = $(this).attr('statuse_note');

            console.log(stars)
            console.log(serve_customer)
            console.log(statuse_note)
            $('.all_chose_statuse').find('.checkbox-input').each(function () {
                $(this).prop('checked', false);
                if ($(this).attr('main_id') == stars) {
                    $(this).prop('checked', true);
                }
            });

            $('.all_chose_serve_customer').find('.checkbox-input').each(function () {
                $(this).prop('checked', false);
                if ($(this).attr('main_id') == serve_customer) {
                    $(this).prop('checked', true);
                }
            });
            $('.show_statuse_dialoge').find('.statuse_order_id').val(order_id);
            $('.show_statuse_dialoge').find(".note_statuse").val(statuse_note);

        });

        $('.save_statuse_service').off().on('click', function () {
            let order_id      = $('.show_statuse_dialoge').find('.statuse_order_id').val();
            var statusValue   = $('.all_chose_statuse input[name="status"]:checked').attr('main_id');
            var serviceValue  = $('.all_chose_serve_customer input[name="service"]:checked').attr('main_id');
            var textareaValue = $('.show_statuse_dialoge').find('.note_statuse').val();

            var dataString = 'action=changeStars&value=' + order_id + '&value1=' + statusValue + '&value2=' + serviceValue + '&value3=' + textareaValue;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (response) {
                update_tr_row(order_id);
                if (response === "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل',
                    });
                }
            });
        });

        $('.all_orders').find(".show_statuse").off().on('click', function () {
            var td = $(this);
            var id = $(this).attr('id');
            (async () => {
                const inputOptions    = new Promise((resolve) => {
                    if (parseInt(kind_employee) === 0 || parseInt(kind_employee) === 10) {
                        setTimeout(() => {
                            resolve({
                                '1': 'لم يتم التحديد',
                                '2': 'ملغي',
                                '3': 'قيد التنفيذ',
                                '4': 'منتهي',
                                '5': 'لم يتم الرد (إتصال - وتس اب ) ',
                            })
                        }, 10)
                    }
                    else {
                        setTimeout(() => {
                            resolve({
                                '1': 'لم يتم التحديد',
                                '2': 'ملغي',
                                '3': 'قيد التنفيذ',
                                '5': 'لم يتم الرد (إتصال - وتس اب ) ',
                            })
                        }, 10)
                    }
                });
                const {value: starts} = await Swal.fire({
                    title: '',
                    input: 'radio',
                    inputOptions: inputOptions,
                    confirmButtonText: 'حسناً',
                    cancelButtonText: 'إلغاء',
                    showCancelButton: true,
                    showCloseButton: true,
                    inputValidator: (value) => {
                        update_tr_row(id);
                        if (!value) {
                            return 'يجب عليك إختيار حالة الطلب'
                        }
                        else {
                            console.log(value)

                            var dataString = 'action=changeStatuse&value=' + id + '&value1=' + value;
                            $.ajax({
                                type: "post",
                                url: url_action,
                                data: dataString,
                                catch: false,
                                success: function (html) {
                                    update_tr_row(id);
                                }
                            }).done(function (msg) {
                                console.log(msg)
                                if (msg === "11111") {
                                    Toast.fire({
                                        icon: 'success',
                                        title: 'تم التعديل'
                                    });
                                }
                            });
                        }
                    }
                });
            })()
            $('.swal2-popup').css('width', '58em');


        });

        if (kind_employee == 0 || kind_employee == 10) {
            $('.all_orders').find(".order_stages").off().on('click', function () {
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

                    const {value: starts} = await Swal.fire({
                        title: '',
                        input: 'radio',
                        width: '100%',
                        inputOptions: inputOptions,
                        confirmButtonText: 'حسناً',
                        cancelButtonText: 'إلغاء',
                        showCancelButton: true,
                        showCloseButton: true,
                        inputValidator: (value) => {
                            update_tr_row(id);
                            if (!value) {
                                return 'يجب عليك إختيار حالة الطلب'
                            }
                            else {
                                if (value == 1) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages1">موافقة مبدئية</p');
                                }
                                else if (value == 2) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages2">رفع الأوراق</p');
                                }
                                else if (value == 3) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages3">تقيم</p');
                                }
                                else if (value == 4) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages4">سداد</p');
                                }
                                else if (value == 5) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages5">موافقة نهائية</p');
                                }
                                else if (value == 6) {
                                    td.find('.p-text').remove();
                                    td.html('<p class="p-text order_stages6">محصل</p');
                                }
                                var dataString = 'action=changestages&value=' + id + '&value1=' + value;
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
                                            title: 'تم التعديل',
                                        });
                                    }
                                });
                            }
                        }
                    });
                })()
                $('.swal2-popup').css('width', '36em');

            });
        }

        $('.all_orders').find(".edite_order_main").off().on("click", function () {
            var id = $(this).attr("id");
            alert("asd");
            $('.edite_order_customer').addClass('loadding-data');
            var dataString = 'action=getDeatilsOrder&value=' + id + '&value1=1';
            $('.main_edite_order').on(500).fadeIn();
            $('.main_edite_order').css('display', 'flex');
            $('.main-loading').on(500).fadeIn();
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (response) {
                update_tr_row(id);
                if (response == "00000") {

                }
                else {
                    setTimeout(() => {
                        $('.set_edit_order').html(response);
                        $('.main-loading').on(500).fadeOut('slow');
                        $('.edite_order_customer').removeClass('loadding-data');
                        setmaskandselect();
                        function_eltizam();
                        function_files();
                    }, 500);

                }

            });
        });

        $('.save_statuse_service').off().on('click', function () {
            let order_id      = $('.show_statuse_dialoge').find('.statuse_order_id').val();
            var statusValue   = $('.all_chose_statuse input[name="status"]:checked').attr('main_id');
            var serviceValue  = $('.all_chose_serve_customer input[name="service"]:checked').attr('main_id');
            var textareaValue = $('.show_statuse_dialoge').find('.note_statuse').val();

            var dataString = 'action=changeStars&value=' + order_id + '&value1=' + statusValue + '&value2=' + serviceValue + '&value3=' + textareaValue;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (response) {
                update_tr_row(order_id);
                if (response === "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل',
                    });
                }
            });
        });

        $('.all_orders').find(".show_source").off().on('click', function () {
            var order_id = parseInt($(this).attr('order_id'));
            var code     = $(this).attr('code');
            console.log(order_id)
            console.log(code)
            $('.all_source_customer').find('.checkbox-input').each(function () {
                $(this).prop('checked', false);
                if ($(this).attr('code_id') == code) {
                    $(this).prop('checked', true);
                }
            });
            $('.show_source_dialoge').find(".marketing_id").val(order_id);
        });

        $('.save_source_customer').off().on('click', function () {
            let order_id = $('.show_source_dialoge').find('.marketing_id').val();
            var code_id  = $('.all_source_customer input[name="source"]:checked').attr('code_id');

            var dataString = 'action=changeSource&value=' + order_id + '&value1=' + code_id;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (response) {
                update_tr_row(order_id);
                if (response === "11111") {
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل',
                    });
                }
            });
        });

        $('.all_orders').find(".show_move_customer").off().on('click', function () {
            var this_td  = $(this);
            var order_id = parseInt($(this).attr('id'));
            $('.asing_order_employee').find('.order_id').val(order_id);
            $('.asing_order_employee').find('.check_user_name').removeClass('check_user_true');
        });

        $('.all_orders').find(".show_history").off().on('click', function () {
            var id = $(this).attr('id');
            $('.all_update').html('');
            var dataString = 'action=GetHistoryOrder&value=' + id + '&value1=1';
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (html) {
                $('.all_update').html(html);
            });
        });

        $('.all_orders').find(".delete_order").off().on('click', function () {
            var id = $(this).attr('id');
            var td = $(this).closest('tr');
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

                    var dataString = 'action=delete_order_admin&value=' + id + '&value1=' + kind_employee;
                    $.ajax({
                        type: "post",
                        url: url_action,
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
                        }
                        else if (msg == "00000") {
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

        $('.all_orders').find(".add_new_alarm").off().on("click", function () {
            var id = $(this).attr("id");
            $('.main_add_new_alarm').find('.alarm_order_id').val(id);
            $('.main_add_new_alarm').on(500).fadeIn();
            update_tr_row(id);

            var now     = new Date();
            // Get the components of the date and time
            var year    = now.getFullYear();
            var month   = (now.getMonth() + 1).toString().padStart(2, '0');
            var day     = now.getDate().toString().padStart(2, '0');
            var hours   = now.getHours().toString().padStart(2, '0');
            var minutes = now.getMinutes().toString().padStart(2, '0');

            // Get the time zone offset in minutes
            var timeZoneOffset          = -now.getTimezoneOffset();
            var timeZoneOffsetHours     = Math.floor(timeZoneOffset / 60);
            var timeZoneOffsetMinutes   = timeZoneOffset % 60;
            var timeZoneOffsetFormatted = (timeZoneOffsetHours >= 0 ? "+" : "-") +
                timeZoneOffsetHours.toString().padStart(2, '0') +
                ":" +
                timeZoneOffsetMinutes.toString().padStart(2, '0');

            // Create the formatted date and time string with the time zone offset
            var formattedDate = year + '-' + month + '-' + day + 'T' + hours + ':' + minutes + timeZoneOffsetFormatted;

            // Set the formatted date as the value for the input using jQuery
            $('.alarm_date_time').val(formattedDate);
        });

        $('.all_orders').find(".add_to_fovreite").off().on('click', function () {
            let id      = $(this).attr("id");
            let is_true = $(this).attr("is_true");
            let object  = $(this);

            object.css("transform", "scale(0)");
            var dataString = 'action=UpdateFovrite&value=' + id + '&value1=' + is_true;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (msg) {
                update_tr_row(id);
                object.css("transform", "scale(1)");
                if (msg === "11111") {
                    if (is_true === "1") {
                        object.removeClass('favorite-button');
                        object.attr("is_true", "0");
                    }
                    else {
                        object.addClass('favorite-button');
                        object.attr("is_true", "1");
                    }
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل'
                    });
                }
            });
        });

        $('.all_orders').find(".add_to_motabaa").off().on('click', function () {
            let id      = $(this).attr("id");
            let is_true = $(this).attr("is_true");
            let object  = $(this);

            object.css("transform", "scale(0)");
            var dataString = 'action=UpdateMotabaa&value=' + id + '&value1=' + is_true;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (msg) {
                update_tr_row(id);
                object.css("transform", "scale(1)");
                if (msg === "11111") {
                    if (is_true === "1") {
                        object.removeClass('motabaa-button');
                        object.attr("is_true", "0");
                    }
                    else {
                        object.addClass('motabaa-button');
                        object.attr("is_true", "1");
                    }
                    Toast.fire({
                        icon: 'success',
                        title: 'تم التعديل'
                    });
                }
            });
        });

        $('.all_orders').find(".change_note").off().on('click', function () {
            var p  = $(this).find('.p-text');
            var id = $(this).attr('id');
            Swal.fire({
                title: 'أدخل وصف للطلب',
                input: 'textarea',
                inputValue: p.attr("title"),
                inputAttributes: {
                    autocapitalize: 'true',
                },
                textContent: p.textContent,
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
                            update_tr_row(id);
                        }
                    }).done(function (msg) {
                        if (msg === "11111") {
                            Toast.fire({
                                icon: 'success',
                                title: 'تم التعديل',
                            });
                            p.text(result.value)
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

        $('.cloase_alarm').off().on('click', function () {
            $(this).closest('.main_add_new_alarm').hide();
        });

        $('.save-add-new-alarm').off().on('click', function () {
            let main_dianloge = $(this).closest('.main_add_new_alarm');
            let order_id      = main_dianloge.find('.alarm_order_id').val();
            let alarm_date    = main_dianloge.find('.alarm_date_time').val();
            let alarm_note    = main_dianloge.find('.alarm_note').val();

            var momentDate = moment(alarm_date);
            momentDate.locale('en');
            var formattedDate = momentDate.format('YYYY-MM-DD H:mm');
            console.log(formattedDate);

            var dataString = 'action=ADD_NEW_ALARM&value=' + order_id + '&value1=' + formattedDate + '&value2=' + alarm_note;
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (response) {
                    update_tr_row(order_id);
                    if (response === "1") {
                        main_dianloge.find('.cloase_alarm').click();
                        Toast.fire({
                            icon: 'success',
                            title: 'تم إضافة التذكير بنجاح',
                        });
                        main_dianloge.find('input').val('');
                        main_dianloge.find('textarea').val('');
                    }
                    else {
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

        $('.add_new_eltizam').off().on('click', function () {
            console.log('asdfasdfsdf');
            let conent = $(this).find('.card').html();
            $(this).closest('.eltzams').append(`
                <div class="card main_eltizam"> 
                    ` + conent + `
                </div>
            `);
            functionTab();
        });

        $('.delete-eltizam').off().on('click', function () {
            $(this).closest('.card').remove();
        });

        $('.cloase_edite_form').on('click', function () {
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

        $('.save-order-datialse').off().on('click', function () {
            var formm   = $(this).closest('.edite_order_customer');
            var loading = formm.find('.main-loading');
            loading.css('display', 'flex');
            var cusom_number         = formm.find('#cusom_number').val();
            var cusom_name           = formm.find('#cusom_name').val();
            var cusom_starts         = formm.find('#cusom_starts').val();
            var cusom_statues        = formm.find('#cusom_statues').val();
            var cusom_description    = formm.find('#cusom_description').val();
            var order_id             = $('.main_edite_order').find('.order_id').val();
            var name_owner           = formm.find('#name_owner').val();
            var number_owner         = formm.find('#number_owner').val();
            var kind_aqar            = formm.find('#kind_aqar').val();
            var city                 = formm.find('#city').val();
            var jop                  = formm.find('#jop').val();
            var salary               = formm.find('#salary').val();
            var resource_obligations = formm.find('#resource_obligations').val();
            var obligations          = formm.find('#obligations').val();
            var data_birth           = formm.find('#data_birth').val();
            var powered              = formm.find('#powered').val();
            var bank                 = formm.find('#bank').val();
            var order_notes          = formm.find('#order_notes').val();

            console.log(order_notes);

            if (cusom_statues == 1) {
                var msg = "يرجى اختيار حالة الطلب للعميل";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                loading.css('display', 'none');
            }
            else if (cusom_description.length > 1000) {
                var msg = "اقصى عدد الأحرف لوصف الطلب هي 100 حرف";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                loading.css('display', 'none');
            }
            else {
                var dataString = 'action=editeorderdetailse&value=' + cusom_number + '&value1=' + cusom_name + '&value2=' + cusom_starts + '&value3=' + cusom_statues + '&value4=' + cusom_description + '&value5=' + number_owner + '&value6=' + kind_aqar + '&value7=' + city + '&value8=' + jop + '&value9=' + salary + '&value10=' + resource_obligations + '&value11=' + obligations + '&value12=' + data_birth + '&value13=' + powered + '&value14=' + bank + '&value15=' + name_owner + '&value16=' + order_notes;
                $.ajax({
                    type: "post",
                    url: url_action,
                    data: dataString,
                    catch: false,
                }).done(function (msg) {
                    update_tr_row(order_id);
                    update_tr_row($('.main_edite_order').find('.order_id').val());
                    loading.css('display', 'none');
                    save_eltizam(cusom_number);
                    if (msg == "11111") {
                        var msg = "تم تعديل البيانات بنجاح";
                        formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                    }
                    else if (msg == "00000") {
                        var msg = "هناك خطاء يرجى تحديث الصفحة وإجراء تعديل على البيانات ";
                        formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                    }

                });
            }
            setTimeout(() => {
                formm.find("#success").html("");
            }, 3000);


        });


    }

    function function_eltizam() {

        $('.delete-eltizam').off().on('click', function () {
            $(this).closest('.card').remove();
        });

        $('.add_new_eltizam').off().on('click', function () {
            console.log('asdfasdfsdf');
            let conent = $(this).find('.card').html();
            $(this).closest('.eltzams').append(`
                <div class="card main_eltizam"> 
                    ` + conent + `
                </div>
            `);
            functionTab();
        });

    }

    function functionTab() {
        $('.delete-eltizam').off().on('click', function () {
            $(this).closest('.card').remove();
        });
    }

    function function_files() {

        $('.show_file_history').off().on('click', function () {
            console.log("show file history 1");
            $('.main_file_history').toggleClass('active');
        });

        $('.close_file_dilaoge').off().on('click', function () {
            console.log("show file history 2");
            $('.main_file_history').toggleClass('active');
        });

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
        console.log("just_file_name=" + just_file_name);
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
            acceptedFileTypes: ['image/*', 'pdf', 'xlsx'],
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
            server: 'https://admin.alawtar.net/assets/api/',

            fileRenameFunction: (file) => {
                return just_file_name + file.extension;
            },
        });

        var pond_input = document.querySelector('.input_tab_files');
        FilePond.destroy(pond_input);
        const pond = FilePond.create(pond_input, {
            acceptedFileTypes: ['image/*', 'pdf', 'xlsx'],
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
            just_file_name     = rundamString(15)
            var file_name      = slugify(file.filenameWithoutExtension);
            // var file_name = file.filenameWithoutExtension;
            var file_extension = (file.fileExtension).toLowerCase();
            if (file_extension === "jpeg") {
                file_extension = "jpg";
            }
            console.log('file_extension=' + file_extension);
            console.log('file_name=' + file_name);
            console.log('file_name=' + file.filenameWithoutExtension);
            console.log('just_file_name=' + just_file_name);
            // https://admin.alawtar.net/assets/api/tmp
            var path       = "https://admin.alawtar.net/assets/api/tmp/" + file.serverId + "/" + file_name + "." + file_extension;
            var folderpath = "api/tmp/" + file.serverId;

            var json_data = [];
            console.log(path)
            json_data.push(path);
            json_data.push(file_extension);
            json_data.push(file.fileSize);
            json_data.push(file.filenameWithoutExtension);
            json_data.push(folderpath);

            var dataString = "action=SaveFilesOrders&value=" + public_order_id + "&value1=" + JSON.stringify(json_data);
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                // console.log(pond.getFiles()); 
                if (parseInt(msg) == 11111) {
                    get_all_files(public_order_id);
                }
            });

        });

        function slugify(title) {
            return title
                .replace(/[^a-z0-9_ ]/gi, '')
        }

        get_all_files($('.main_edite_order').find("#order_id").val());
        fun_file_add();
    }

    function get_all_files(order_id) {
        var dataString = "action=getAllFilesOrders&value=" + order_id + "&value1=1";
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
        }).done(function (response) {
            // console.log(response)
            $('.main_edite_order').find('.customer_file_img').html(response);
            fun_file_add();
        });
    }

    function rundamString(length) {
        let result             = '';
        const characters       = 'abcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;
        let counter            = 0;
        while (counter < length) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
            counter += 1;
        }
        return result;
    }

    function fun_file_add() {

        // console.log('asdfals;dkfjal;skdjfal;ksdjflaksdjf');
        $('.main_edite_order').find('[data-gallery=photoviewer]').off().on('click', function (e) {
            e.preventDefault();
            console.log($(this).index());
            var items   = [],
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

        $('.main_edite_order').find('[data-gallery=pdfviewer]').off('click').on('click', function (e) {
            e.preventDefault();
            $('.main_show_pdf').find('iframe').attr('src', $(this).attr('href'));
            $('.main_show_pdf').css('display', "block");
        });

        $('.main_edite_order').find('.delete_file_order').off().on('click', function () {
            var file_id     = $(this).attr('file');
            var order_id    = $(this).attr('order');
            var folder_path = $(this).attr('folder');
            let object      = $(this);
            $(this).closest('.jFiler-item').find('.delete_loading').css("display", "flex");
            var dataString = 'action=DeleteFileOrders&value=' + file_id + '&value1=' + order_id + '&value2=' + folder_path;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                console.log(msg);
                if (parseInt(msg) == 11111) {
                    object.closest('.jFiler-item').remove();
                }
            });
        });

        $('.main_edite_order').find('.print_file_order').off().on('click', function () {
            let type_file = $(this).attr('type_file');
            let path      = $(this).attr('path');
            if (type_file === "pdf") {
                printFile(path)
            }
            else {
                printImage(path);
            }

        });

        $('.main_edite_order').find('.share_file_order').off().on('click', function () {
            var whatsappURL = 'whatsapp://send?text=' + encodeURIComponent($(this).attr('path'));

            window.location.href = whatsappURL;

        });

        $('.main_edite_order').find('.change_file_name').off().on('change', function () {
            $(this).closest('li').find('.jFiler-item-title').text($(this).val());
        });

        $('.main_edite_order').find('.change_file_name').off().on('blur', function () {
            var file_id    = $(this).attr('file');
            var order_id   = $(this).attr('order');
            var file_name  = $(this).val();
            var dataString = 'action=ChangeFileNameOrders&value=' + file_id + '&value1=' + order_id + '&value2=' + file_name;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                console.log(msg);
            });
        });

    }

    function printImage(imageSrc) {
        const img = new Image();
        img.src   = imageSrc;

        img.onload = function () {
            const printWindow = window.open('', '', 'width=600,height=600');
            printWindow.document.open();
            printWindow.document.write('<html><body style="margin:0;"><img src="' + imageSrc + '" style="max-width:100%;"></body></html>');
            printWindow.document.close();
            printWindow.print();
            printWindow.close();
        };
    }

    function printFile(path) {
        const printWindow  = window.open(path, '_blank');
        printWindow.onload = function () {
            printWindow.print();
        };
    }

    initGetAlarm();
    var audio = document.getElementById("alarm_sounds");

    function initGetAlarm() {
        setInterval(function () {
            var dataString = 'action=GET_ALARM_NOW&value=1&value1=2';
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (response) {
                    var dataArray = JSON.parse(response);
                    $.each(dataArray, function (index, element) {
                        // Your code to handle each item goes here
                        if (!($('.alarm' + element.id).length)) {
                            audio.play();
                            $('.all_alarms').append(element.html);
                            allFunctionAlarms();
                        }
                    });
                }
            });
        }, 5000);
    }

    function allFunctionAlarms() {
        // $(".dialoge_alarm").draggable();
        $('.delete_alarm').off().on('click', function () {
            let object     = $(this).closest('.dialoge_alarm');
            let alarm_id   = object.attr("alarm_id");
            var dataString = 'action=DELETE_ALARM&value=' + alarm_id + '&value1=1';
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                }
            }).done(function (msg) {
                if (msg === "11111") {
                    object.remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'تم إستبعاد التذكير',
                    });
                }
            });
        });
        $('.change_notification').off().on('click', function () {
            let object_dilaoge = $(this).closest('.dialoge_alarm');
            let alarm_id       = object_dilaoge.attr("alarm_id");
            var dataString     = 'action=UPDATE_DATE_ALARM&value=' + alarm_id + '&value1=1';
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (html) {
                    console.log(html)
                }
            }).done(function (msg) {
                if (msg === "11111") {
                    object_dilaoge.remove();
                    Toast.fire({
                        icon: 'success',
                        title: 'سيتم إعادة التذكير بعد عشر دقائق من الوقت الحالي',
                    });
                }
            });
        });
        $('.alarm_show_tabs').off().on('click', function () {
            var id = $(this).attr("id");
            $('.edite_order_customer').addClass('loadding-data');
            var dataString = 'action=getDeatilsOrder&value=' + id + '&value1=1';
            $('.main_edite_order').on(500).fadeIn();
            $('.main_edite_order').css('display', 'flex');
            $('.main-loading').on(500).fadeIn();
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (html) {
                if (html == "00000") {

                }
                else {
                    setTimeout(() => {
                        $('.set_edit_order').html(html);
                        $('.main-loading').on(500).fadeOut('slow');
                        $('.edite_order_customer').removeClass('loadding-data');
                        setmaskandselect();
                    }, 500);
                }

            });
        });
    }

    function setmaskandselect() {

        $('.cancel_accept_order').on('click', function () {
            var formm = $(this).closest('.edite_order_customer');

            var loading = formm.find('.main-loading');
            loading.css('display', 'flex');

            var order_id  = $(this).attr("accept_order_id");
            var accept_id = $(this).attr("accept_id");

            console.log(order_id);
            console.log(accept_id);
            var dataString = 'action=cancel_accept_order&value=' + order_id + '&value1=' + accept_id;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                refrch_msg(order_id, formm, loading);
                if (msg == "00000") {
                    var msg = "هناك خطاء حاول مرة اخرى";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }
                else if (msg == "11111") {
                    var msg = "تمت استعادة الطلب";
                    formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }
            });
        });

        $('.btn_accept_order').on('click', function () {
            var formm   = $(this).closest('.edite_order_customer');
            var loading = formm.find('.main-loading');
            loading.css('display', 'flex');

            var order_id  = $(this).attr("order_id");
            var accept_id = $(this).attr("accept_id");

            var dataString = 'action=change_accept_order&value=' + order_id + '&value1=' + accept_id;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                refrch_msg(order_id, formm, loading);
                if (msg == "00000") {
                    var msg = "هناك خطاء حاول مرة اخرى";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }
                else if (msg == "11111") {

                    var msg = "تمت الموافقة على رفع الطلب";
                    formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }

            });
        });

        $('.btn_rejection_order').on('click', function () {
            var formm   = $(this).closest('.edite_order_customer');
            var loading = formm.find('.main-loading');
            loading.css('display', 'flex');

            var order_id  = $(this).attr("order_id");
            var accept_id = $(this).attr("accept_id");

            var dataString = 'action=change_rejection_order&value=' + order_id + '&value1=' + accept_id;
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (msg) {
                refrch_msg(order_id, formm, loading);
                if (msg == "00000") {
                    var msg = "هناك خطاء حاول مرة اخرى";
                    formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }
                else if (msg == "11111") {

                    var msg = "تم رفض الطلب";
                    formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                }

            });
        });

        $('.send_msg_order').on('click', function () {
            var form    = $(this).closest('.main_send_msg_order');
            var formm   = $(this).closest('.edite_order_customer');
            var loading = formm.find('.main-loading');


            loading.css('display', 'flex');
            var msg_description = form.find('#msg_description').val();
            var order_accept    = form.find('#order_accept').prop("checked");

            var order_id = $(this).attr("order_id");
            var emp_name = "الإدارة";

            if ((msg_description.trim() == "")) {
                var msg = "يجب عليك كتابة وصف للطلب";
                formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                loading.css('display', 'none');
            }
            else {
                var dataString = 'action=SendAdminMesage&value=' + order_id + '&value1=2&value2=' + msg_description + '&value3=' + order_accept + '&value4=' + emp_name;
                $.ajax({
                    type: "post",
                    url: url_action,
                    data: dataString,
                    catch: false,
                }).done(function (msg) {
                    refrch_msg(order_id, formm, loading);
                    if (msg == "00000") {
                        var msg = "هناك خطاء حاول مرة اخرى";
                        formm.find("#success").html('<div class="alert alert-warning"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                    }
                    else if (msg == "11111") {
                        formm.find('#msg_description').val('');
                        var msg = "تم الإرسال بنجاح";
                        formm.find("#success").html('<div class="alert alert-success"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong id="text_warning">' + msg + '</strong></div>');
                    }

                });
            }

        });

        $('.bank_customer').select2({
            placeholder: "إختر",
            language: "ar",
            dir: 'rtl',
            width: '100%'
        });

        $('#city').select2({
            placeholder: "إختر",
            language: "ar",
            dir: 'rtl',
            width: '100%'
        });

        $('#kind_aqar').select2({
            placeholder: "إختر",
            language: "ar",
            dir: 'rtl',
            width: '100%'
        });

        $('#number_owner').mask('9999999999');
        $('#salary').mask('999999999999');
        $('#obligations').mask('999999999999');
    }

    $('.fancySearchRow th').eq(0).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(7).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(8).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(9).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(10).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(11).find('input').css('display', 'none');
    $('.fancySearchRow th').eq(14).find('input').css('display', 'none');


    $('.no-sort').on('click', function (e) {

    });


    if (localStorage.getItem("fontsize")) {
        var p    = $('body').find('p');
        var span = $('body').find('span');
        var a    = $('body').find('a');
        fontsize = parseInt(localStorage.getItem("fontsize"));
        if (fontsize >= 10) {
            fontsize = 10;
        }
        else if (fontsize < 1) {
            fontsize = 1;
        }
        p.each(function (idx, el) {
            var font = getnumberstring($(el).css('font-size'));
            $(el).css("font-size", (font + fontsize) + "px");
        });
        span.each(function (idx, el) {
            var font = getnumberstring($(el).css('font-size'));
            $(el).css("font-size", (font + fontsize) + "px");
        });
        a.each(function (idx, el) {
            var font = getnumberstring($(el).css('font-size'));
            $(el).css("font-size", (font + fontsize) + "px");
        });
    }
    else {
        fontsize = 1;
        localStorage.setItem("fontsize", 2);
    }

    $('.font-plus').on('click', function () {
        if (fontsize <= 10) {
            fontsize  = fontsize + 1;
            var p     = $(this).closest('body').find('p');
            var span  = $(this).closest('body').find('span');
            var a     = $(this).closest('body').find('a');
            var label = $(this).closest('body').find('label');
            p.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font + 1) + "px");
            });
            span.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font + 1) + "px");
            });
            a.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font + 1) + "px");
            });
            label.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font + 1) + "px");
            });
            localStorage.setItem('fontsize', fontsize);
        }
    });

    $('.font-minus').on('click', function () {
        if (fontsize >= 0) {
            fontsize  = fontsize - 1;
            var p     = $(this).closest('body').find('p');
            var span  = $(this).closest('body').find('span');
            var a     = $(this).closest('body').find('a');
            var label = $(this).closest('body').find('label');
            p.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font - 1) + "px");
            });
            span.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font - 1) + "px");
            });
            a.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font - 1) + "px");
            });
            label.each(function (idx, el) {
                var font = getnumberstring($(el).css('font-size'));
                $(el).css("font-size", (font - 1) + "px");
            });
            localStorage.setItem('fontsize', fontsize);
        }
    });

    $('.gofs').on('click', function () {
        var fullscreen     = 0;
        var isInFullScreen = (document.fullscreenElement && document.fullscreenElement !== null) ||
            (document.webkitFullscreenElement && document.webkitFullscreenElement !== null) ||
            (document.mozFullScreenElement && document.mozFullScreenElement !== null) ||
            (document.msFullscreenElement && document.msFullscreenElement !== null);

        var docElm = document.documentElement;
        if (!isInFullScreen) {
            if (docElm.requestFullscreen) {
                docElm.requestFullscreen();
            }
            else if (docElm.mozRequestFullScreen) {
                docElm.mozRequestFullScreen();
            }
            else if (docElm.webkitRequestFullScreen) {
                docElm.webkitRequestFullScreen();
            }
            else if (docElm.msRequestFullscreen) {
                docElm.msRequestFullscreen();
            }
        }
        else {
            if (document.exitFullscreen) {
                document.exitFullscreen();
            }
            else if (document.webkitExitFullscreen) {
                document.webkitExitFullscreen();
            }
            else if (document.mozCancelFullScreen) {
                document.mozCancelFullScreen();
            }
            else if (document.msExitFullscreen) {
                document.msExitFullscreen();
            }
        }

    });

    function getnumberstring(value) {
        return parseInt(value.replace(/^\D+/g, ''));
    }


    init_page();

    function init_page() {
        $('.refrch_orders').on('click', function () {
            $('.customer_name').val('');
            $('.customer_phone_number').val('');
            $('.date_order_get').val('');
            $('.number_order_select').val(100);
            date_start_filter = '';
            date_end_filter   = '';
            getallorders();
        });


        $('#categories_stars').multiSelect({
            noneText: 'غير محدد',
            presets: [
                {
                    name: 'اختيار الكل',
                    all: true
                },
                {
                    name: 'إلغاء الكل',
                    all: false
                },
            ]
        });

        $('#categories_posible').multiSelect({
            noneText: 'غير محدد',
            presets: [
                {
                    name: 'اختيار الكل',
                    all: true
                },
                {
                    name: 'إلغاء الكل',
                    all: false
                },
            ]
        });
        if (kind_employee == 0 || kind_employee == 10) {
            $('#categories_users').multiSelect({
                noneText: 'غير محدد',
                presets: [
                    {
                        name: 'اختيار الكل',
                        all: true
                    },
                    {
                        name: 'إلغاء الكل',
                        all: false
                    },
                ]
            });
        }

        $('#categories_source').multiSelect({
            noneText: 'غير محدد',
            presets: [
                {
                    name: 'اختيار الكل',
                    all: true
                },
                {
                    name: 'إلغاء الكل',
                    all: false
                },
            ]
        });


    }


    function refrch_msg(order_id, form, loading) {
        var dataString = 'action=refrch_msg&value=' + order_id + '&value1=1';
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
        }).done(function (msg) {
            console.log(msg)
            form.find("#timelinehtml").html(msg);
            loading.css('display', 'none');
            setTimeout(() => {
                form.find("#success").html("");
            }, 3000);
        });
    }

    function save_eltizam(order_id) {
        var cardValues = [];

        $('.eltzams .main_eltizam').each(function () {
            var cardData            = {};
            cardData.jehaht_eltizam = $(this).find('.kind_jehah').val();
            cardData.cast           = $(this).find('.cast').val();
            cardData.total_eltizam  = $(this).find('.total_eltizam').val();
            cardData.note           = $(this).find('.note').val();
            cardValues.push(cardData);
        });

        var cardValuesJSON = JSON.stringify(cardValues);
        // console.log(cardValues)
        var dataString     = 'action=SAVE_NEW_ELTIZAM&value=' + order_id + '&value1=' + cardValuesJSON;
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
        }).done(function (response) {
            console.log(response)
        });


    }

    function arabicToEnglish(arabicNumber) {
        var arabicNumbers  = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
        var englishNumbers = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

        for (var i = 0; i < arabicNumbers.length; i++) {
            arabicNumber = arabicNumber.replace(new RegExp(arabicNumbers[i], 'g'), englishNumbers[i]);
        }

        return arabicNumber;
    }

    // ==============================================================END REFRCHE JS

    $('.save_asign_order').on('click', function () {
        let form     = $(this).closest('.asing_order_employee');
        let order_id = parseInt(form.find('.order_id').val());
        let user_id  = parseInt(form.find('.check_user_true').attr('user_id'));

        if (isNaN(user_id) || user_id === 0) {
            $('.show_error_not_check_user').css('display', 'block');
        }
        else {
            form.find('.check_user_name').removeClass('check_user_true');
            form.find('.close').click();
            let dataString = 'action=MoverOrder&value=' + order_id + '&value1=' + user_id;
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (response) {
                    update_tr_row(order_id);
                    if (parseInt(response) == 11111) {
                        Toast.fire({
                            icon: 'success',
                            title: 'نجح تحويل العميل.',
                        });
                    }
                    else {
                        Toast.fire({
                            icon: 'error',
                            title: 'لم تنجح العملية، يرجى المحاولة في وقت لاحق',
                        });
                    }
                }
            });
        }
    });


    function update_tr_row(order_id) {
        console.log('Update row customers=' + order_id);
        var dataString = 'action=UpdateRowUploadCustomer&value=' + order_id + '&value1=' + 1;
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
        }).done(function (response) {
            $('.main_tr_' + order_id).html(response);
            init_table();
        });
    }


});


