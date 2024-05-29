jQuery(document).ready(function ($) {
    let url_action    = '../action.php';
    let url_logout    = $('.url_logout').val();
    let hasInteracted = true;

    checkSession();
    const throttledUpdateSession = _.throttle(update_session, 2000);
    const Toast                  = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {

        }
    });

    $('.check_user_name').on('click', function () {
        $(this).closest('.main_users_asign').find('.check_user_name').removeClass('check_user_true');
        $(this).toggleClass('check_user_true');
        $('.show_error_not_check_user').css('display', 'none');
    });


    function handleEvent(event) {
        throttledUpdateSession();
        updateSession();
        hasInteracted = false;
        setTimeout(function () {
            hasInteracted = true;
        }, 1000)
    }


    $("body").on({
        click: handleEvent,
        dblclick: handleEvent,
        mouseenter: handleEvent,
        mouseleave: handleEvent,
        mousedown: handleEvent,
        mouseup: handleEvent,
        mousemove: handleEvent,
        contextmenu: handleEvent,
        keydown: handleEvent,
        keyup: handleEvent,
        keypress: handleEvent,
        focus: handleEvent,
        blur: handleEvent,
        scroll: handleEvent,
        resize: handleEvent,
        submit: handleEvent
        // Add more events as needed
    });


    var socend         = 2400;
    var sessionTimeout = socend * 1000;
    initializeSession();
    update_session();
    setInterval(checkInactivity, 1000);

    function initializeSession() {
        // Check if the session data is stored in localStorage
        var lastActivity = localStorage.getItem('lastActivity');

        if (lastActivity) {
            // Update the session with the stored timestamp
            updateSession();
        }
        else {
            // Set the initial session timestamp
            localStorage.setItem('lastActivity', new Date().getTime());
        }
    }

    function updateSession() {
        // Update the session timestamp in localStorage
        localStorage.setItem('lastActivity', new Date().getTime());
    }

    function checkInactivity() {
        // Get the current time
        var currentTime = new Date().getTime();

        // Get the last activity timestamp from localStorage
        var lastActivity = localStorage.getItem('lastActivity');

        if (lastActivity) {
            // Calculate the time difference
            var timeDifference = currentTime - parseInt(lastActivity);

            // Check if the session has expired
            if (timeDifference >= sessionTimeout) {
                localStorage.removeItem('lastActivity');
                LogoutUser();
            }
        }
    }

    function update_session() {
        let dataString = 'action=UpdateLoginSession&value=1&value1=1';
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (response) {
                console.log(response);
                if (parseInt(response) == 0) {
                    window.location.href = url_logout;
                }
            }
        });
    }

    function checkSession() {
        let dataString = 'action=CHECK_SEESION&value=1&value1=1';
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (response) {
                if (parseInt(response) == 0) {
                    window.location.href = url_logout;
                }
            }
        });
    }

    // $(window).on('beforeunload', function() {
    //     let dataString = 'action=CloseWindows&value=1&value1=1';
    //     $.ajax({
    //         type: "POST",
    //         url: url_action,
    //         data: dataString,
    //         catch: false,
    //         success: function (response) {
    //             console.log(response); 
    //             window.location.href = url_logout; 
    //         }
    //     });
    // });

    window.onbeforeunload = function (event) {
        if (hasInteracted) {
            closeWindows();
        }
        else {
            console.log(hasInteracted)
        }
    };
    $(window).on('unload', function (event) {
        if (hasInteracted) {
            closeWindows();
        }
        else {
            console.log(hasInteracted)
        }
    });

    $('.exit_user').find('a').on('click', function () {
        LogoutUser();
    });

    function LogoutUser() {
        let dataString = 'action=LogOutUser&value=1&value1=1';
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (response) {
                console.log(response);
                window.location.href = url_logout;
            }
        });
    }


    $('.make_event').each(function () {
        var typeEvent  = $(this).attr('type_event').split(',');
        var typeText   = $(this).attr('type_text').split(',');
        var whereClick = $(this).attr('where_click');

        $(this).on(typeEvent.join(' '), function (event) {
            var eventType = event.type;
            var index     = typeEvent.indexOf(eventType);
            if (index !== -1) {
                var text = typeText[index];
                console.log(eventType + ' - ' + text);

                let json_data = [];
                json_data.push(eventType);
                json_data.push(whereClick);
                json_data.push(text);

                let dataString = 'action=SendEvent&value=' + JSON.stringify(json_data) + '&value1=2';
                $.ajax({
                    type: "post",
                    url: url_action,
                    data: dataString,
                    catch: false,
                    success: function (html) {

                    }
                });

            }
        });
    });

    function closeWindows() {
        let dataString = 'action=CloseWindows&value=1&value1=1';
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (response) {
                console.log(response);
                window.location.href = url_logout;
            }
        });
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
                        if (element && element.id) {
                            if (!($('.alarm' + element.id).length)) {
                                audio.play();
                                $('.all_alarms').append(element.html);
                                allFunctionAlarms();
                            }
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

        $('.change_notification').off('click').on('click', function () {
            let object_dilaoge = $(this).closest('.dialoge_alarm');
            let alarm_id       = object_dilaoge.attr("alarm_id");
            console.log("change alarm 234")
            var dataString = 'action=UPDATE_DATE_ALARM&value=' + alarm_id + '&value1=1';
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


    $('body').on('click', '.view_pdf', function (e) {
        e.preventDefault(); // Prevent the default action of following the link
        let hrefValue = $(this).attr('href');
        window.open(hrefValue, '_blank');
    });

    $('body').on('click', '.delete_alarm_tr', function () {
        let alarm_id   = $(this).data("id");
        var dataString = 'action=DELETE_ALARM&value=' + alarm_id + '&value1=1';
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (html) {
            }
        }).done(function (msg) {
            $('.main_tr_'+alarm_id).remove();
            if (msg === "11111") {
                Toast.fire({
                    icon: 'success',
                    title: 'تم إستبعاد التذكير',
                });
            }
        });
    });

});

// "make_event"  type_event="click,hover" where_click="all_orders" type_text="النقر على صفحة جميع المعاملات,تمرير الماوس على صفحة جميع المعاملات">
// Mouse Events:
// click: Fires when a pointing device button (such as a mouse) is pressed and released on an element.
// dblclick: Fires when a pointing device button is clicked twice on an element.
// mouseenter: Fires when the mouse pointer enters an element.
// mouseleave: Fires when the mouse pointer leaves an element.
// mousemove: Fires when the mouse pointer is moved over an element.
// mousedown: Fires when a pointing device button is pressed down on an element.
// mouseup: Fires when a pointing device button is released over an element.

// Keyboard Events:
// keydown: Fires when a key is pressed down.
// keyup: Fires when a key is released.
// keypress: Fires when a key is pressed.

// Form Events:
// submit: Fires when a form is submitted.
// change: Fires when the value of an input element changes and then loses focus.
// focus: Fires when an element gets focus.
// blur: Fires when an element loses focus.
// input: Fires when the value of an input element changes.
// Document and Window Events:
// load: Fires when an element and all its content have been loaded.
// resize: Fires when the browser window is resized.
// scroll: Fires when the document view is scrolled.

// Touch Events (Mobile):
// touchstart: Fires when a touch point is placed on the touch surface.
// touchmove: Fires when a touch point is dragged across the touch surface.
// touchend: Fires when a touch point is removed from the touch surface.
// touchcancel: Fires when a touch point has been disrupted in some way (e.g., by an event like a modal dialog show).