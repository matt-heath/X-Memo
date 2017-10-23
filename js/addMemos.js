$(document).ready(function () {

  $('.form-memo').submit(function (e) {
    //retrieves values from form-memo and assigns to the data object.
    var data = {
      'title': $('#title').val(),
      'sender': $("#senderModalSelect").val(),
      'recipients': $("#recipientsModalSelect").val(),
      'summary': $('#summary').val(),
      'date': $('#date').val(),
      'url': $('#url').val()
    };

    console.log(data);

    //clears values from within the add memo modal so it can be used again if page isn't refreshed.
    $('#title').val('');
    $("#senderModalSelect").val('');
    $("#recipientsModalSelect").val('');
    $('#summary').val('');
    $('#date').val('');
    $('#url').val('');

    //Posts values from the data object to the 'addMemo' function within addMemo.php
    $.ajax({
      type: 'POST',
      url: 'addMemo.php',
      data: data,
      dataType: 'json',
      encode: true
    })
      .done(function (data) {
        // console.log(data);
        //if true is returned from the addMemo.php file, the add memo modal is closed and a sweet alert pops up. All call is made to getValues() to retrieve the new list of values.
        if (data.success == true) {
          $('#modal').removeClass('has-model-open');
          $('#modal').removeClass('is-active');

          //Sweet alert 2 sample adapted from https://limonte.github.io/sweetalert2/
          swal({
            type: 'success', title: 'Memo added!', text: 'Your memo was added to the X-Memo database.', timer: 3000, showCancelButton: false, showConfirmButton: false, showCloseButton: true
          }).then(
            function () { },
            // handling the promise rejection
            function (dismiss) {
              if (dismiss === 'timer') {
                // console.log('I was closed by the timer')
              }
            }
            );
          getValues();
        }
        else {
          $('#modal').removeClass('has-model-open');
          $('#modal').removeClass('is-active');

          swal({
            type: 'error', title: 'Error!', text: 'Something went wrong adding the memo.', timer: 3000, showCancelButton: false, showConfirmButton: false, showCloseButton: true
          }).then(
            function () { },
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