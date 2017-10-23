$(document).ready(function () {

	$('.form-signin').submit(function (e) {
		var data = {
			'username': $('#username').val(),
			'password': $('#password').val()
		};
		console.log(data);
		$.ajax({
				type: 'POST',
				url: 'login.php',
				data: data,
				dataType: 'json',
				encode: true
			})

			.done(function (data) {
				// console.log(data);

				if (!data.success) {
					//if error occured, error is output to sweetalert popup via the data.err return from login.php

					if (data.err.password) {
						swal({
							type: 'error',
							title: 'Error!',
							text: data.err.password,
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
					if (data.err.username) {
						//Sweet alert 2 sample adapted from https://limonte.github.io/sweetalert2/
						swal({
							type: 'error',
							title: 'Error!',
							text: data.err.username,
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
				} else {
					//If login is successful, redirect to x-memos.php.
					window.location = "x-memos.php";
				}
			});

		e.preventDefault();
	});
});