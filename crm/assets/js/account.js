jQuery(document).ready(function ($) {
	var url_action = '../action.php';
	var start_date = moment().startOf('day').format('YYYY-MM-DD HH:mm:ss');
	var end_date = moment().endOf('day').format('YYYY-MM-DD HH:mm:ss');
	var can_update_click_it = 0;
	initFunction(); 

	setInterval(getAllUsers, 20000);
 
	getAllUsers();
	function getAllUsers(){
		var dataString = 'action=GetUsersDetals&value='+start_date+'&value1='+end_date;
		$.ajax({
			type: "POST",
			url: url_action,
			data: dataString,
			catch: false,
			success: function (html) {
				console.log("update users statuse")
				$('.all_users').html(html); 
				initAllFunction();
				if(can_update_click_it == 1){
					can_update_click_it = 0;
					showTost('تم التحديث بنجاح',3000,'success'); 
				}
			}
		}).done(function (msg) { });
	}

	function initAllFunction(){

		$('.edit_user_dateails').off().on('click',function(){
			let user_id = $(this).attr('user_id');
			var dataString = 'action=GETUSERFORM&value='+user_id+'&value1=';
			$.ajax({
				type: "POST",
				url: url_action,
				data: dataString,
				catch: false,
				success: function (html) {
					console.log("update users statuse")
					$('#show_edit_details').find('.modal-body').html(html); 
					inifFormFunction();
				}
			}).done(function (msg) {

			});
		});

		$('.show_diloge_details').off().on('click',function(){
			$diloge = $('#show_diloge_details');
			$diloge.find('#exampleModalLabel').text($(this).attr("title")); 
			$diloge.find('.modal-body').html(`<div class="lds-roller"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>`);
			let type_diloag = $(this).attr("type_diloage");
			let user_id = $(this).closest('.user_card').attr("user_id");
			console.log(type_diloag)
			console.log(user_id)
			var dataString = 'action=GETDETALESDILOGE&value='+user_id+'&value1='+type_diloag+'&value2='+start_date+'&value3='+end_date;
			$.ajax({
				type: "POST",
				url: url_action,
				data: dataString,
				catch: false,
				success: function (html) {
					$diloge.find('.modal-body').html(html); 
				}
			}); 
		
		});
		
		var totalRows = 0;
		var successfulInsertions = 0;
		var rows = 0;
		var kind_account = 10101010101;
		var row_index = 0;

		function extractValuesAsJson() {
			kind_account = $('.kind_account_exel').val();
			if (kind_account == 10101010101) {
				showTost('يرجى إختيار مصدر العملاء', 3000, 'error');
				return; // Exit the function if kind_account is not selected
			}
			
			rows = $('#excelTable tr'); // Exclude header row
			totalRows = rows.length;
			successfulInsertions = 0; // Reset successfulInsertions counter
			processRow(row_index);
		}

		function processRow(index) {
			if (index < totalRows) {
				var this_tr = rows.eq(index);
				console.log(this_tr);
				var name = this_tr.find('td:eq(1)').text();
				var phoneNumber = this_tr.find('td:eq(2)').text();
				var message = this_tr.find('td:eq(3)').text();

				let json_data = [];
				json_data.push(name);
				json_data.push(phoneNumber);
				json_data.push(message);

				let dataString = 'action=AddExelOrders&value=' + JSON.stringify(json_data) + '&value1=' + kind_account;
				$.ajax({
					type: "POST",
					url: url_action,
					data: dataString,
					cache: false,
					success: function (response) {
						console.log(response)
						if (parseInt(response) === 11111) {
							successfulInsertions++;
						}
						row_index = row_index +1;
						processRow(row_index);
					},
					error: function () {
						showTost('حدث خطأ أثناء إضافة العميل', 3000, 'error');
						// Handle errors here
					}
				});
			} else {
				showTost('تمت إضافة جميع العملاء بنجاح', 3000, 'success');
				totalRows = 0;
				successfulInsertions = 0;
				rows = 0;
				kind_account = 10101010101;
				row_index = 0;
			}
		}


		$('.exel_file').on('change', function (e) {
			var file = e.target.files[0];
	
			if (file) {
				var reader = new FileReader();
	
				reader.onload = function (e) {
					var data = new Uint8Array(e.target.result);
					var workbook = XLSX.read(data, { type: 'array' });
	
					// Assuming there's only one sheet in the Excel file
					var sheet = workbook.Sheets[workbook.SheetNames[0]];
	
					// Convert sheet data to an array of objects
					var excelData = XLSX.utils.sheet_to_json(sheet, { header: 1 });
	
					// Display data in the table
					displayExcelData(excelData);
					
				};
	
				reader.readAsArrayBuffer(file);
				$('.exel_file').reset();
			}
		});

		// function ckeck_done() {
		// 	let count = $('#excelTable tr').length;
		// 	console.log("count="+count);
		// 	console.log("save_all="+save_all);
		// 	if(count >= save_all){
		// 		showTost('نجح إضافة جميع العملاء ',300,'success');
		// 	}
		// }

		function displayExcelData(data) {
			
			$('.save_exel_data').off().on('click', function () {
				extractValuesAsJson();
			});
		
			var table = $('#excelTable');
			table.empty();
		
			// Create header row
			var headerRow = $('<tr></tr>');
			data[0].forEach(function (cellData) {
				headerRow.append('<th>' + cellData + '</th>');
			});
			headerRow.append('<th>Action</th>'); // Added Action header
			table.append(headerRow);
		
			// Create data rows
			for (var i = 1; i < data.length; i++) {
				console.log(i);
				var dataRow = $('<tr></tr>');
				dataRow.append(`
					<td>
						` + i + `
					</td>
				`);
				data[i].forEach(function (cellData) {
					dataRow.append('<td>' + cellData + '</td>');
				});
				dataRow.append(`
					<td>
						<button class="button delete_row_phone">
							<i class="fa fa-trash"></i> Delete
						</button>
					</td>
				`);
				table.append(dataRow);
			} 
			$('#excelTable tr:first').remove();
			function_exel();
		}
		


		function function_exel(){
			$('.delete_row_phone').on('click',function(){
				$(this).closest('tr').remove();
			});
			check_phone_exists();
		}

		function check_phone_exists() {
			$('#excelTable tr').each(function () {
				// Skip the header row
				if (!$(this).hasClass('headerRow')) { 
					var phoneNumber = $(this).find('td:eq(2)').text();
					$(this).find('td:eq(2)').html('<i class="fa fa-spinner" aria-hidden="true"></i>'+ phoneNumber);
				}
			});
			processTableRow(0); 
			$('#excelTable tr:last').remove();
		}

		function processTableRow(index) {
			var $currentRow = $('#excelTable tr').eq(index);
			var max_length = $('#excelTable tr').length;
			
		
			// Check if it's not the header row
			if (!$currentRow.hasClass('headerRow')) {
				var phoneNumber = $currentRow.find('td:eq(2)').text();
				
		
				var dataString = 'action=CheckPhoneNumber&value=0' + phoneNumber + '&value1=1';
				$.ajax({
					type: "post",
					url: url_action,
					data: dataString,
					cache: false,
				}).done(function (response) {
					console.log("response="+response);
					console.log("phone="+phoneNumber);
					$currentRow.find('td:eq(2)').find('.fa-spinner').remove(); 
					if (parseInt(response) == 1) {
						$currentRow.css({
							'background-color': '#00a65aa1',
							'color': 'white'
						});
					}
					var progressPercent = (index / max_length) * 100; 
					if (index + 1 < max_length) {
						updateProgressBar(progressPercent);
						processTableRow(index + 1);
					}else{
						return false;
					}
				});
			} else {
				processTableRow(index + 1);
			}
		}
		
		function updateProgressBar(percent) {
			percent = percent + 3.51;
			if(percent > 100){
				percent = 100.00;
			}
			// console.log("max_length="+percent)
			var $progressBar = $('.progressBar');
			// $progressBar.find('div').css({ width: percent.toFixed(0) + '%' }, 500).html(percent.toFixed(2) + "% ");
			$progressBar.find('div').css({
				width: percent.toFixed(0) + '%'
			}).html(percent.toFixed(2) + "% ");
		}
		
		// Start the iteration with the first row (index 1)

		

		$('.deleteemployee').off().on('click', function () {
			var id = $(this).attr('id');
			var user_card = $(this).closest('.user_card');
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
						url: url_action,
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
							user_card.remove();
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

		$('.change_checkbox_user').change(function() {
			var user_id = $(this).closest('.checkbox-wrapper').attr('user_id');
			var isChecked = $(this).is(':checked'); 
			let type_event = $(this).attr("type_event");
			console.log("User ID:", user_id);
			console.log("Checked:", isChecked); 
			var dataString = 'action=UpdateUserSetting&value=' + user_id + '&value1=' + isChecked  + '&value2=' + type_event;
			$.ajax({
				type: "post",
				url: url_action,
				data: dataString,
				catch: false,
			}).done(function (response) {
				if(parseInt(response) == 11111 ){ 
					showTost('تم التغير بنجاح',3000,'success'); 
				}else{
					showTost('هناك مشكلة ما',3000,'error');
				}
				console.log(response)
			});
		});
		$('.changeImageUsers').on('click',function(){
			$(this).closest('.user_card').find(".fileInput").trigger('click');
		});
		 // Change event handler for the file input
		$(".fileInput").change(function(event) {
            // Get the selected file
			let user_id = $(this).closest('.user_card').find('.user_id').val();
			let customer_user_id = $('.customer_user_id').val();
			let btn = $(this);
            const selectedFile = event.target.files[0];
			const formData = new FormData();
            if (selectedFile) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    btn.closest('.banner').find('img').attr('src', event.target.result);
                    btn.closest('.banner').css('background-image', 'url(' + event.target.result + ')');
					if(user_id === customer_user_id){
						$('.customer_user_img').attr('src', event.target.result);
					}
					if (selectedFile) {
						formData.append('userImage', selectedFile); // Append the file to FormData
						formData.append('action', 'SaveUserImage'); // Add additional data if needed
						formData.append('value', user_id); // Add additional data if needed
						formData.append('value1', '1'); // Add additional data if needed
						$.ajax({
							type: "POST",
							url: url_action,
							data: formData,
							processData: false,
							contentType: false,
							success: function(response) {
								console.log(response);
							},
							error: function(xhr, status, error) {
								console.error(xhr.responseText);
							}
						});
					}
                };

                // Read the selected file as a Blob
                reader.readAsDataURL(selectedFile);
            }
        });
	}

	function inifFormFunction(){

		
		
	}
	refrechjsmoveemplly();
	function refrechjsmoveemplly() {

		$('.header_details').find('.checkbox').on('click', function () {
			$('.emplay_loadding').css('display', 'flex');
			if ($('.header_details').find('.checkbox').is(':checked')) {
				$('.empllay_detals').each(function (index) {
					var checkbox = $(this).find('.checkbox');
					if (!checkbox.is(':checked')) {
						$(this).click();
					}
				});
			} else {
				$('.empllay_detals').each(function (index) {
					var checkbox = $(this).find('.checkbox');
					if (checkbox.is(':checked')) {
						$(this).click();
					}
				});
			}
			$('.emplay_loadding').css('display', 'none');
		});

		$('.empllay_detals').on('click', function () {
			var isChecked = $(this).find('.checkbox').is(':checked')
			$(this).toggleClass('empllay_detals_checked');
			$(this).find('.checkbox').prop('checked', !isChecked);
			changeEmplloyCount();
		});

		$('.form__input').on('input', function (index) {
			var str1 = $(this).val();
			$('.empllay_detals').each(function (index) {
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
		$('.btn_send_emplloy').on('click', function () {
			$('.btn_send_emplloy').prop('disabled', true);
			var ids = [];
			$('.empllay_detals').each(function (index) {
				var checkbox = $(this).find('.checkbox');
				var emplloyeId = $(this);
				if (checkbox.is(':checked')) {
					ids.push(emplloyeId.attr('value_emplloy'));
				}
			});
			var model = $(this).closest('.modal');
			var model_error = model.find('.model_error');
			var model_normal = model.find('.model_normal');
			var model_successful = model.find('.model_successful');

			var valueName1 = model.find('.name1').find(":selected").val();
			var valueName2 = model.find('.name2').find(":selected").val();
			var textName1 = model.find('.name1').find(":selected").text()
			var textName2 = model.find('.name2').find(":selected").text();

			if ((valueName1 === "1") || (valueName2 === "1")) {
				model_successful.hide();
				model_normal.hide();
				model_error.show();
				model_error.text("يرجى اختيار الموظف الأول ثم الموظف الأخر ");
				changebutton(false, 'يرجى اختيار الموظف الأول ثم الموظف الأخر', true);
				$('.btn_send_emplloy').prop('disabled', false);

			} else if (valueName1 == valueName2) {
				model_successful.hide();
				model_normal.hide();
				model_error.show();
				model_error.text("يرجى اختيار موظفين مختلفين");
				changebutton(false, 'يرجى إختيار موظفين مختلفين', true);
				$('.btn_send_emplloy').prop('disabled', false);
			} else if (ids.length == 0) {
				model_successful.hide();
				model_normal.hide();
				model_error.show();
				model_error.text("يرجى تحديد عميل واحد على الأقل");
				changebutton(false, 'يرجى تحديد عميل واحد على الأقل', true);
				$('.btn_send_emplloy').prop('disabled', false);
			} else {
				changebutton(true, 'يرجى الإنتظار ', false);
				model_normal.text("يرجى الإنتظار جاري ارسال الطلب ...");
				model_successful.hide();
				model_normal.show();
				model_error.hide();
				changebutton(true, '', false);
				var dataString = 'action=savechangeorder&value=' + valueName1 + '&value1=' + valueName2 + '&value2=' + ids + '&value3=' + textName1 + '&value4=' + textName2;
				$.ajax({
					type: "post",
					url: url_action,
					data: dataString,
					catch: false,
				}).done(function (msg) {
					$('.btn_send_emplloy').prop('disabled', false);
					changebutton(false, msg, false);
					model_successful.show();
					model_normal.hide();
					model_error.hide();
					model_successful.text(msg);
					console.log("msg length = " + msg.length);


				});
			}

		});
	}

	function changeEmplloyCount() {
		var count = 0;
		$('.empllay_detals').find('.checkbox').each(function (index) {
			if ($(this).is(':checked')) {
				count++;
			}
		});
		var name1 = $('.main_movement').find('.name1').find(":selected").text();
		var name2 = $('.main_movement').find('.name2').find(":selected").text();
		if (count == 0) {
			$('.btn_send_emplloy').css('background', '#ff0000a1');
			$('.move_count_emp').text('يرجى أختيار عميل واحد على الأقل');
		} else {
			$('.btn_send_emplloy').css('background', '#1c751ed1');
			$('.move_count_emp').text('تحويل ' + count + ' عميل من الموظف/ـة ( ' + name1 + ') إلى الموظف/ـة (' + name2 + ' )');
		}

	}
	

	function initFunction() {

	 
		$('.emp_name, .username, .email, .password, .kind_account').off().on('input', function() {
			$(this).siblings('.form-text').text(''); // Clear the error message when input received
		});
		
		$('.add_employee_data').off().on('click', function() {
			var form = $('.add_new_user');  
			var empName = form.find('.emp_name').val();
			var userName = form.find('.username').val();
			var email = form.find('.email').val();
			var password = form.find('.password').val();
			var kindAccount = form.find('.kind_account').val();
			var phoneNumber = form.find('.phone_number').val();
		
			// Reset all error messages
			$('.form-text').text('');
		
			// Validation for empName
			if (empName.trim() === '') {
				form.find('.emp_name').siblings('.form-text').text('الرجاء إدخال اسم موظف.');
				return;
			}
		
			// Validation for userName
			if (!userName.match(/^[A-Z][a-z]*$/)) {
				form.find('.username').siblings('.form-text').text('يجب أن يبدأ اسم المستخدم بحرف كبير ويحتوي على أحرف فقط.');
				return;
			}
		
			// Validation for email
			if (!validateEmail(email)) {
				form.find('.email').siblings('.form-text').text('الرجاء إدخال بريد إلكتروني صحيح.');
				return;
			}
		
			// Validation for password (a simple check for length)
			if (password.length < 8) {
				form.find('.password').siblings('.form-text').text('يجب أن تكون كلمة المرور على الأقل 8 أحرف.');
				return;
			}

			if (phoneNumber.length < 8) {
				form.find('.password').siblings('.form-text').text('يجب أن تكون كلمة المرور على الأقل 8 أحرف.');
				return;
			}
		
			// Validation for kindAccount
			if (kindAccount !== '0' && kindAccount !== '2') {
				form.find('.kind_account').siblings('.form-text').text('الرجاء اختيار نوع حساب.');
				return;
			}

			
			if (!validatePhoneNumber(phoneNumber)) { 
				form.find('.phone_number').siblings('.form-text').text('الرجاء إدخال رقم هاتف صحيح يبدأ بـ "05" ويحتوي على 10 أرقام.');
			} 
 
			const formData = new FormData();
			formData.append('action', 'AddUserAccount'); // Add additional data if needed 
			formData.append('value', '1'); // Add additional data if needed
			formData.append('value1', '1'); // Add additional data if needed
			formData.append('empName', empName); // Add empName data
			formData.append('userName', userName); // Add userName data
			formData.append('email', email); // Add email data
			formData.append('password', password); // Add password data
			formData.append('kindAccount', kindAccount); // Add kindAccount data
			formData.append('phoneNumber', phoneNumber); // Add kindAccount data
			$.ajax({
				type: "POST",
				url: url_action,
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) { 
					// console.log()
					if(parseInt(response) == 11111 ){ 
						showTost('تم إضافة المستخدم بنجاح',3000,'success');
						form.find('input').text();
						$('.close_add_users').click();
					}else{
						showTost('هناك مشكلة ما',3000,'error');
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		
			// If all validations pass, proceed to submit the form
			// Your code to submit the form data goes here
		});
		$('.save_employee_data').off().on('click', function() {
			var form = $('.show_edit_details'); 
			var userId = form.find('.user_id').val();
			var empName = form.find('.emp_name').val();
			var userName = form.find('.username').val();
			var email = form.find('.email').val();
			var password = form.find('.password').val();
			var kindAccount = form.find('.kind_account').val();
			var phoneNumber = form.find('.phone_number').val();
		
			// Reset all error messages
			$('.form-text').text('');
		
			// Validation for empName
			if (empName.trim() === '') {
				form.find('.emp_name').siblings('.form-text').text('الرجاء إدخال اسم موظف.');
				return;
			}
		
			// Validation for userName
			if (!userName.match(/^[A-Z][a-z]*$/)) {
				form.find('.username').siblings('.form-text').text('يجب أن يبدأ اسم المستخدم بحرف كبير ويحتوي على أحرف فقط.');
				return;
			}
		
			// Validation for email
			if (!validateEmail(email)) {
				form.find('.email').siblings('.form-text').text('الرجاء إدخال بريد إلكتروني صحيح.');
				return;
			}
		
			// Validation for password (a simple check for length)
			if (password.length < 8) {
				form.find('.password').siblings('.form-text').text('يجب أن تكون كلمة المرور على الأقل 8 أحرف.');
				return;
			}

			if (phoneNumber.length < 8) {
				form.find('.password').siblings('.form-text').text('يجب أن تكون كلمة المرور على الأقل 8 أحرف.');
				return;
			}
		
			// Validation for kindAccount
			if (kindAccount !== '0' && kindAccount !== '2') {
				form.find('.kind_account').siblings('.form-text').text('الرجاء اختيار نوع حساب.');
				return;
			}

			
			if (!validatePhoneNumber(phoneNumber)) { 
				form.find('.phone_number').siblings('.form-text').text('الرجاء إدخال رقم هاتف صحيح يبدأ بـ "05" ويحتوي على 10 أرقام.');
			} 

			


			const formData = new FormData();
			formData.append('action', 'UpdateUserAccount'); // Add additional data if needed 
			formData.append('value', '1'); // Add additional data if needed
			formData.append('value1', userId); // Add additional data if needed
			formData.append('empName', empName); // Add empName data
			formData.append('userName', userName); // Add userName data
			formData.append('email', email); // Add email data
			formData.append('password', password); // Add password data
			formData.append('kindAccount', kindAccount); // Add kindAccount data
			formData.append('phoneNumber', phoneNumber); // Add kindAccount data
			$.ajax({
				type: "POST",
				url: url_action,
				data: formData,
				processData: false,
				contentType: false,
				success: function(response) {
					if(parseInt(response) == 11111 ){ 
						showTost('تم تعديل المستخدم بنجاح',3000,'success');
						form.find('input').text();
						$('.close_update_user').click();
					}else{
						showTost('هناك مشكلة ما',3000,'error');
					}
				},
				error: function(xhr, status, error) {
					console.error(xhr.responseText);
				}
			});
		
			// If all validations pass, proceed to submit the form
			// Your code to submit the form data goes here
		});
		
		// Function to validate email format
		function validateEmail(email) {
			var re = /\S+@\S+\.\S+/;
			return re.test(email);
		}

		function validatePhoneNumber(phoneNumber) {
			const phoneRegex = /^05\d{8}$/; // Regular expression for '05' followed by 8 digits
		
			return phoneRegex.test(phoneNumber);
		}

		$('.daterange_users').daterangepicker({
			locale: {
				direction: 'rtl', // Right-to-left language direction
				format: 'YYYY-MM-DD HH:mm:ss',
				separator: ' - ',
				applyLabel: 'تطبيق',
				cancelLabel: 'إلغاء',
				fromLabel: 'من',
				toLabel: 'إلى',
				customRangeLabel: 'نطاق مخصص',
				weekLabel: 'W',
				daysOfWeek: ['أح', 'إث', 'ثل', 'أر', 'خم', 'جم', 'سب'],
				monthNames: [ 'يناير','فبراير', 'مارس', 'أبريل','مايو','يونيو','يوليو','أغسطس','سبتمبر','أكتوبر','نوفمبر','ديسمبر'],
				firstDay: 0,
				startDate: moment().startOf('day'), // Set the start date as the beginning of today
				endDate: moment().endOf('day') 
			},
			ranges: {
				'اليوم': [moment(), moment()],
				'أمس': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
				'آخر 7 أيام': [moment().subtract(6, 'days'), moment()], 
				'هذا الشهر': [moment().startOf('month'), moment().endOf('month')],
				'الشهر الماضي': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
				'الكل': [moment().subtract(50, 'year'), moment().add(50, 'year')]
				// Add more custom ranges as needed
			},
			startDate: moment().subtract(29, 'days'),
			endDate: moment()
		}, function (start, end) {
			start_date = start.format('YYYY-MM-DD HH:mm:ss');
			end_date = end.format('YYYY-MM-DD HH:mm:ss');
			$('.all_users').html(`<div class="lds-roller"> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> <div></div> </div>`);
			getAllUsers();
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
                    url: url_action,
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
        
            
            
        });

		$('.update_users').off().on('click', function () {
			can_update_click_it = 1;
			getAllUsers();
		});

		$('.refrch_store_order').on('click', function () {
			Swal.fire({
				title: 'تأكيد',
				text: "هل أنت متأكد من اعادة عدد الطلبات الى القيمة صفر لجميع الموظفين، سيتم إستعادة توزيع ( الواتس اب - توزيع الطلبات ) ",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'لا',
				confirmButtonText: 'نعم'
			}).then((result) => {
				if (result.value) {

					var dataString = 'action=make_order_zero&value=1&value1=1';
					$.ajax({
						type: "post",
						url: url_action,
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
								text: 'تم إعادة الضبط يرجى تحديث الصفحة',
								icon: 'success',
								confirmButtonText: 'حسناً'
							});
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

		$('.refrch_whatsapp_order').on('click', function () {
			Swal.fire({
				title: 'تأكيد',
				text: "سيتم إعادة توزيع طلبات الوتس اب إلى القيمة صفر لجميع الموظفين",
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				cancelButtonText: 'لا',
				confirmButtonText: 'نعم'
			}).then((result) => {
				if (result.value) {

					var dataString = 'action=make_whatsapp_order_zero&value=1&value1=1';
					$.ajax({
						type: "post",
						url: url_action,
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
								text: ' تم إعادة ضبط طلبات الوتس اب',
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

		$('.changeuserorder').on('click', function () {
			$('#changeuserordermodel').show();
		});

		$('[data-toggle="tooltip"]').tooltip();

		$('.refrch_store').on('click', function () {
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
						url: url_action,
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

		$('.main_movement').find('.name1').on('change', function () {
			$('.emplay_loadding').css('display', 'flex');
			var selected_option_value = $(this).find(":selected").val();
			console.log(selected_option_value);
			if (selected_option_value != 0) {
				var dataString = 'action=getEmployyes&value=' + selected_option_value + '&value1=1';
				$.ajax({
					type: "post",
					url: url_action,
					data: dataString,
					catch: false,
				}).done(function (msg) {
					$('.emplay_loadding').css('display', 'none');
					// console.log(msg);
					if (msg == "11111") {

					} else {
						$('.main_emplloyes_move').find('.main_emplay').html(msg);
						$('.btn_send_emplloy').css('background', '#ff0000a1');
						$('.move_count_emp').text('يرجى أختيار عميل واحد على الأقل');
						refrechjsmoveemplly();
					}

				});
			} else {

			}
		});


		$('.SubmitFormData').off().on('click', function () {
			let event = $(this);
			var u_name = $(event).closest('form').find('input[name="u_name"]');
			var u_job = $(event).closest('form').find('input[name="u_job"]');
			var kind = $(event).closest('form').find('select[name="kind"]');
			var phone_number = $(event).closest('form').find('input[name="phone_number"]');
			var email = $(event).closest('form').find('input[name="email"]');
			var user_name = $(event).closest('form').find('input[name="user_name"]');
			var passrword = $(event).closest('form').find('input[name="passrword"]');
			var passrword1 = $(event).closest('form').find('input[name="passrword1"]');

			if (u_name.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب إدخال حقل اسم الموظف")
			} else if (u_job.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب إدخال حقل الوظيفة الموظف")
			} else if (phone_number.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب ادخال حقل رقم الجوال");
			} else if (email.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب ادخال حقل الإيميل");
			} else if (user_name.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب ادخال حقل اسم المستخدم");
			} else if (passrword.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب ادخال حقل كلمة المرور");
			} else if (passrword1.val().trim() == "") {
				$(event).closest('form').find('.error_input').text("يجب ادخال حقل اعادة كلمة المرور");
			} else if (passrword.val().trim() != passrword1.val().trim()) {
				$(event).closest('form').find('.error_input').text("كلمة المرور غير متطابقتان");
			} else {
				var dataString = 'action=adduser&value=' + 1 + '&value1=' + 21 + '&u_name=' + u_name.val() + '&u_job=' + u_job.val() + '&kind=' + kind.val() + '&phone_number=' + phone_number.val() + '&email=' + email.val() + '&user_name=' + user_name.val() + '&passrword=' + passrword.val() + '&passrword1=' + passrword1.val();
				$.ajax({
					type: "post",
					url: url_action,
					data: dataString,
					catch: false,
					success: function (html) {
						// $('#msg').html(html);
					}
				}).done(function (msg) {
					console.log(msg)
					if (msg === "111111") {
						get_all_users();
						Swal.fire({
							icon: 'success',
							title: `تم إضافة مستخدم جديد`,
							preConfirm: login => {

							}
						});
					} else {
						$(event).closest('form').find('.error_input').text(msg);
					}
				});

			}
		});



	}
 
	function showTost(text,time,type){
		var color='';
		if(type == "error"){
			color = '#dd4b39';
		} else if(type == "success"){
			color = '#00a65a';
		} else if(type == "info"){
			color = '#3c8dbc';
		} else if(type == "warring"){
			color = '#f39c12';
		}
		$.toast({
			text : text,
			hideAfter: 3000, 
			heading: '', 
			showHideTransition: 'fade', 
			allowToastClose: false, 
			hideAfter: time, 
			loader: true,
			loaderBg: '#fff', 
			stack: 5, 
			position: 'top-right', 
			bgColor: color, 
			textColor: '#eee', 
			textAlign: 'right', 
			icon: false, 
			beforeShow: function () {},
			afterShown: function () {},
			beforeHide: function () {},
			afterHidden: function () {},
			onClick: function () {} 
		});
	}

});