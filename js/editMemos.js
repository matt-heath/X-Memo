//function to assign elements within the update modal some values.
function updateModal(id, title, summary, url) {
	$("#updateTitle").val(title);
	$("#updateID").val(id);
	$("#updateSummary").val(summary);
	$("#updateURL").val(url);
}

$(document).ready(function () {
	$('.form-update').submit(function (e) {
		//gets values from the update form within update modal to be used in the ajax post to editMemo.php
		var data = {
			'id': $('#updateID').val(),
			'summary': $('#updateSummary').val(),
			'url': $('#updateURL').val(),
			'title': $('#updateTitle').val()
		};

		console.log(data);
		$.ajax({
				type: 'POST',
				url: 'editMemo.php',
				data: data,
				dataType: 'json',
				encode: true
			})

			.done(function (data) {
				// console.log(data);
				if (data.success == true) {
					//closes modal by removing classes
					$('#updateModal').removeClass('has-model-open');
					$('#updateModal').removeClass('is-active');

					//Sweet alert 2 sample adapted from https://limonte.github.io/sweetalert2/
					swal({
						type: 'success',
						title: 'Memo Updated!',
						text: 'Your memo was successfully updated.',
						timer: 3000,
						showCancelButton: false,
						showConfirmButton: false,
						showCloseButton: true
					}).then(
						function () {},
						// handling the promise rejection
						function (dismiss) {
							if (dismiss === 'timer') {
								// console.log('I was closed by the timer')
							}
						}
					);

					getValues();
				} else {
					$('#updateModal').removeClass('has-model-open');
					$('#updateModal').removeClass('is-active');

					swal({
						type: 'error',
						title: 'Error!',
						text: 'Something went wrong editing the memo.',
						timer: 3000,
						showCancelButton: false,
						showConfirmButton: false,
						showCloseButton: true
					}).then(
						function () {},
						// handling the promise rejection
						function (dismiss) {
							if (dismiss === 'timer') {
								// console.log('I was closed by the timer')
							}
						}
					);
				}
				getValues();
			});
		e.preventDefault();
	});
});