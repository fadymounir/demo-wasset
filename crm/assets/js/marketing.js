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

    getall_marketings();
    function getall_marketings(){
        let dataString = 'action=GetAllMarketings&value=1&value1=1';
        $.ajax({
            type: "POST",
            url: url_action,
            data: dataString,
            catch: false,
            success: function (response) {
                $('.all_marketings').html(response);
                init_marketing();
            }
        });
    }

    function init_marketing(){
        $('.delete_marketing').on('click',function(){
            let mr_id = $(this).attr('mr_id');
            let marketing_id = $(this).attr('marketing_id');
            
            var spinner = '<span class="spinner"></span>';
            var del_btn = $(this);

            Swal.fire({
				title: 'تأكيد الإزالة',
				text: "هل أنت متأكد من إزالة الرابط، يرجى العلم أنه لا يمكن إزالة الروابط المرتبطة في المعاملات!!",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'لا',
				confirmButtonText: 'نعم أزل ذلك'
			}).then((result) => {
				if (result.value) {
                    del_btn.prop('disabled', true); 
                    del_btn.html(spinner);  
                    let dataString = 'action=DeleteMarketings&value='+mr_id+'&value1='+marketing_id;
                    $.ajax({
                        type: "POST",
                        url: url_action,
                        data: dataString,
                        catch: false,
                        success: function (response) {
                            console.log(response)
                            if(parseInt(response) == 11111){ 
                                Toast.fire({
                                    icon: 'success',
                                    title: 'نجح الإزالة',
                                });
                                del_btn.closest('tr').remove();
                            }else if(parseInt(response) == 22222){
                                Toast.fire({
                                    icon: 'error',
                                    title: 'لم تنجح العملية، رمز التتبع مرتبط مع مصادر أخرى.',
                                });
                            }else{
                                Toast.fire({
                                    icon: 'error',
                                    title: 'لم تنجح العملية، يرجى المحاولة في وقت لاحق',
                                });
                            }
                            del_btn.prop('disabled', false);
                            del_btn.html(`<i class="fa fa-trash-o"></i>`);
                        }
                    });
				}
			});

        });

        $('.mask_input_code').on('input', function () {
            
            var inputValue = $(this).val(); 
            var sanitizedValue = inputValue.replace(/[^a-zA-Z0-9]/g, ''); 
            $(this).val(sanitizedValue);
        });

        $('.add_new_marketing').on('click',function(){
            var button_add_marketing = $(this);
            var spinner = '<span class="spinner"></span>';

            button_add_marketing.addClass('btn_loading');
            button_add_marketing.html(spinner);
            button_add_marketing.prop('disabled', true);

            let dataString = 'action=AddMarketing&value=1&value1=2';
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (response) { 
                    if(parseInt(response) == 11111){
                        getall_marketings();
                        Toast.fire({
                            icon: 'success',
                            title: 'نجح الإضافة',
                        });
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'لم تنجح العملية، يرجى المحاولة في وقت لاحق',
                        });
                    }
                    button_add_marketing.prop('disabled', false);
                    button_add_marketing.removeClass('btn_loading').html(`<i class="fa fa-plus"></i> إضافة رابط تسويق`);
                }
            });
        });

        $('.change_marketing').off('change').on('change',function(){
            let marketing_id = $(this).closest('tr').attr('marketing_id');
            let column = $(this).attr('column');
            let value = $(this).val();
            let type = $(this).attr('type_int');
            
            let dataString = 'action=UpdateMarketing&value='+marketing_id+'&value1='+column+'&value2='+value+'&value3='+type;
            $.ajax({
                type: "POST",
                url: url_action,
                data: dataString,
                catch: false,
                success: function (response) {
                    console.log(response)
                    getall_marketings();
                    if(parseInt(response) == 11111){
                        Toast.fire({
                            icon: 'success',
                            title: 'نجح التعديل',
                        });
                    }else if(parseInt(response) == 22222){
                        Toast.fire({
                            icon: 'error',
                            title: 'رمز التتبع المدخل موجود مسبقاً لدى رابط أخر',
                        });
                    }else{
                        Toast.fire({
                            icon: 'error',
                            title: 'لم تنجح العملية، يرجى المحاولة في وقت لاحق',
                        });
                    }
                }
            });
        });

        $('.btn_copy_url').off().on('click',function(){
            let textToCopy = $(this).attr("url"); 
            let copy_url = $(this);
            // Create a textarea element to hold the text temporarily
            var $tempTextarea = $('<textarea>');
            $('body').append($tempTextarea);
            $tempTextarea.val(textToCopy).select();

            // Copy the selected text
            document.execCommand('copy');

            // Remove the temporary textarea
            $tempTextarea.remove();

            Toast.fire({
                icon: 'success',
                title: 'تم نسخ الرابط:'+textToCopy,
            });
            copy_url.css('background-color','#23b177c4');
            copy_url.html(`<i class="fa fa-check" aria-hidden="true"></i>`);
            setTimeout(function(){
                copy_url.css('background-color','#00000075');
                copy_url.html(`<i class="fa fa-copy" aria-hidden="true"></i>`);
            },2000);
        });
    }

});
