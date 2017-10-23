function deleteModal(id)
{
  $("#deleteID").val(id); //gets the id value through the onClick of the ahref button in createDisplayMemos.js
}

$(document).on('click', '.modal-button-delete', function (e) { 
  // $("#deleteModal").addClass("has-modal-open");
  // $("#deleteModal").addClass("is-active");

  //Sweet alert 2 sample adapted from https://limonte.github.io/sweetalert2/

  //asks user for confirmation that they want to delete the memo before they delete it
  swal({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    type: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  })
  //if user hits 'Yes, delete it!', the id is passed to the data object and then posted to the deleteMemo function in deleteMemo.php
  .then(function () {
    var data = {
      'id' : $('#deleteID').val(),
    };
    
    // console.log(data);
    $.ajax({
      type  : 'POST',
      url   : 'deleteMemo.php',
      data  : data,
      dataType: 'json',
      encode  : true
    }).done(function(data){
    if(data.success == true)
    {
      swal({
          type: 'success', title: 'Memo Deleted!', text: 'Your memo was removed from the X-Memo database.', timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true}
        ).then(
          function () {},
          // handling the promise rejection
          function (dismiss) {
            if (dismiss === 'timer') {
              // console.log('I was closed by the timer')
            }
          }
        );
      getValues();
    }else
    {
      $('#modal').removeClass('has-model-open');
      $('#modal').removeClass('is-active');
      
      swal({
        type: 'error', title: 'Error!', text: 'Something went wrong deleting the memo.', timer: 3000, showCancelButton: false,showConfirmButton: false, showCloseButton: true
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
  })
  }).catch(swal.noop); //code to handle dismissal promise - found on https://github.com/limonte/sweetalert2#handling-dismissals
});