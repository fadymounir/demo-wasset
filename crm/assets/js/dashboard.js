jQuery(document).ready(function ($) {
    
    let url_action = '../action.php';
    const Toast = Swal.mixin({
        toast: true,
        position: 'center',
        showConfirmButton: false,
        timer: 1000,
        timerProgressBar: true,
        didOpen: (toast) => {

        }
    });

    $('.editeNews').on('click', function () {
        var li = $(this).closest('li');
        var textContent = li.find('.news_content').text();
        var title =$(this).attr('title');
        var news_id = $(this).attr('id');
        console.log(textContent);
        console.log(title);
    
        Swal.fire({
            title: title,
            input: 'textarea',
            inputValue: textContent, 
            inputAttributes: {
                autocapitalize: 'true',
            },
            showCancelButton: true,
            confirmButtonText: 'حفظ',
            cancelButtonText: 'إلغاء',
            showLoaderOnConfirm: true,
            preConfirm: (value) => {
                // You can perform validation or additional actions here if needed
                return value;
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                var dataString = 'action=changeMarketingText&value=' + news_id + '&value1=' + result.value;
                $.ajax({
                    type: "post",
                    url: url_action,
                    data: dataString,
                    catch: false,
                }).done(function (msg) {
                    if (msg === "11111") {
                        li.find('.news_content').text(result.value);
                        Toast.fire({
                            icon: 'success',
                            title: 'تم التعديل',
                        }); 
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'هناك مشكلة ما، يرجى المحاولة في وقت لاحق!',
                        });
                    }
                });
            }
        });
    
    });
    

});