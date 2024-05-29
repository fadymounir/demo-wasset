(function ($) {
    let url_action = '../action.php';

    $('.loading_page').fadeIn();
    $('.loading_page').css({
        'display': 'none',
    });
    update_message()
    setInterval(update_message, 5000);

    function update_message() {
        // console.log("update messages")
        let dataString = 'action=GetMessages&value=1&value1=2';
        $.ajax({
            type: "post",
            url: url_action,
            data: dataString,
            catch: false,
        }).done(function (html) {

            $('.all_meessages_chat').html(html);

            let num_message = $('.all_meessages_chat').find('.informationadmin').length;
            if (num_message > 0) {
                // Adding classes to elements with class 'all_meesages_nofite'
                $('.all_meesages_nofite').addClass('notif animate__animated animate__heartBeat animate__infinite');
                $('.all_meesages_nofite').addClass('label');
                $('.all_meesages_nofite').text(num_message);
            }
            else {
                // Removing classes from elements with class 'all_meesages_nofite'
                $('.all_meesages_nofite').removeClass('notif animate__animated animate__heartBeat animate__infinite');
                $('.all_meesages_nofite').removeClass('label');
            }
            function_messages();
        });
    }

    function function_messages() {

        $('.deletedepartment').off().on('click', function () {
            let order_id   = $(this).closest('.informationadmin').attr('message_id');
            let message_id = $(this).attr('id');
            info_object    = $(this);
            let dataString = 'action=DeleteMessages&value=' + message_id + '&value1=2';
            $.ajax({
                type: "post",
                url: url_action,
                data: dataString,
                catch: false,
            }).done(function (html) {
                info_object.closest('.informationadmin').remove();
                let num_message = $('.all_meessages_chat').find('.informationadmin').length;

                $('.all_meesages_nofite').text(num_message);
                if (num_message > 0) {
                    // Adding classes to elements with class 'all_meesages_nofite'
                    $('.all_meesages_nofite').addClass('notif animate__animated animate__heartBeat animate__infinite');
                }
                else {
                    // Removing classes from elements with class 'all_meesages_nofite'
                    $('.all_meesages_nofite').removeClass('notif animate__animated animate__heartBeat animate__infinite');
                }
            });
        });
    }
})(jQuery);



