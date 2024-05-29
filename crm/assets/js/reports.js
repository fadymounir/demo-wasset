(function($) {
    let url_action = '../action.php';
    let date_start_filter = "";
    let date_end_filter = "";
    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {

        }
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

    $('#categories_status').multiSelect({
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

    $('#categories_move').multiSelect({
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
                all: true,
            }, 
            {
                name: 'إلغاء الكل',
                all: false,
            },
        ],
    });  

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
        date_end_filter = end.format('YYYY-MM-DD');  
    });

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
    
    $('.update_filter').off().on('click',function(){
        // $('.loading_all').css('display', 'flex');
    
        let categories_users    = $('#categories_users').val(); 
        let categories_source   = $('#categories_source').val(); 
        let categories_stars    = $('#categories_stars').val(); 
        let categories_move     = $('#categories_move').val(); 
        let categories_status   = $('#categories_status').val(); 
        let categories_posible  = $('#categories_posible').val(); 
        
    

        let json_data = [];
        json_data.push(date_start_filter); 
        json_data.push(date_end_filter); 
        json_data.push(categories_users);
        json_data.push(categories_source);
        json_data.push(categories_stars);
        json_data.push(categories_move);
        json_data.push(categories_status);
        json_data.push(categories_posible);

        console.log(json_data)
        let dataString = 'action=GetReports&value=' + JSON.stringify(json_data) + '&value1=2';
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (html) {  
                $('.main_report').html(html); 
                Toast.fire({
                    icon: 'success',
                    title: 'نجح الفلتر',
                });
            },
            error: function (xhr, status, error) {
                // Handle the error here, for example, show an error message
                console.error("AJAX Error:", error);
                console.error("status Error:", status);
                console.error("xhr Error:", xhr); 
            }
        }).done(function (msg) {
            console.log(msg)
        });
    })

})(jQuery);



