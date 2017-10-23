$(document).ready(function () {

	$('.form-register').submit(function(e) {
		var data = {
			'name'		: $('#name').val(),
			'username'	: $('#username').val().toLowerCase(),
			'password'	: $('#password').val()
		};
		console.log(data);
		$.ajax({
			type	: 'POST',
			url		: 'registerUserSubmit.php',
			data 	: data,
			dataType: 'json',
			encode	: true
		})

		.done(function(data){
			console.log(data);

			if(!data.success)
			{
        //if error occured, error is output to sweetalert popup via the data.err return from registerUserSubmit.php

				if(data.err.password)
				{
					swal({
  					type: 'error', title: 'Error!', text: data.err.password,
  					timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
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

				if(data.err.username)
				{
          //Sweet alert 2 sample adapted from https://limonte.github.io/sweetalert2/
					swal({
  					type: 'error', title: 'Error!', text: data.err.username,
  					timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
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

				if(data.err.usernameFound)
				{
					swal({
  					type: 'error', title: 'Error!', text: data.err.usernameFound,
  					timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
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

				if(data.err.name)
				{
					swal({
  					type: 'error', title: 'Error!', text: data.err.name,
  					timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
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
			}
			else
			{ 
				swal({
  					type: 'success', title: 'Success!', text: 'User has been registered to X-Memos.',
  					timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
	          }).then(
            function () {},
            // handling the promise rejection
            function (dismiss) {
              if (dismiss === 'timer') {
                // console.log('I was closed by the timer')

								//If registration is successful, redirect to x-memos.php.
								window.location = "index.php";
              }
            }
          );
			}
		});

	e.preventDefault();
  });
});
