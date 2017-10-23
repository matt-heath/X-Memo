function retrieveUserMemos(name, type)
{
  //resets other values to default dependant on the 'type' - Minor bug whereby the value reset but doesn't change visually in the dropdown (emailed regarding this)
	switch(type) {
    case "sender":
      $('#memoid').val('');
  		$('#recipientsDropdown').val('');
  		$('#dateSelect').val('');
      $('#titleSelect').val('');
    break;
    case "recipient":
  		$('#memoid').val('');
  		$('#senderDropdown').val('');
  		$('#dateSelect').val('');
      $('#titleSelect').val('');
    break;
    case "memoID":
  		$('#recipientsDropdown').val('');
  		$('#senderDropdown').val('');
  		$('#dateSelect').val('');
      $('#titleSelect').val('');
    break;
  	case "date":
  		$('#recipientsDropdown').val('');
  		$('#senderDropdown').val('');
  		$('#memoid').val('');
      $('#titleSelect').val('');
		break;
    case "title":
      $('#recipientsDropdown').val('');
      $('#senderDropdown').val('');
      $('#memoid').val('');
      $('#dateSelect').val('');
  }

	
	
	var data = {
		'name'		: name,
		'type'		: type
	};
	// console.log(data);
	$.ajax({
		type	: 'POST',
		url		: 'retrieveUserMemos.php',
		data 	: data,
		dataType: 'json',
		encode	: true
	})
	.done(function(data)
  {
		// console.log(data);

    //checks to see if data.success has returned true
		if(data.success == true)
		{
			// console.log(data);
			if(data.memos !== ""){
				displayMemos(data);
			}	
		}else{
			displayMemos(data);
		}		
	});
}

$(document).ready(function(){
  //checks the value of the dropdown isn't empty and then passes value of dropdown and the 'type' to the relevant function within retrieveUserMemos.php or if the value is empty, it returns all the memos.

	$('#noMemosFound').empty();

  $("#titleSelect").change(function(){
    this.value !== "" ? retrieveUserMemos(this.value, "title") : getValues();
  });

  $("#senderDropdown").change(function(){
  	if(this.value !== "")
    {
  		retrieveUserMemos(this.value, "sender");
  	}else{
  		getValues();
  	}
	});

  $("#recipientsDropdown").change(function(){
  	if(this.value !== "")
    {
  		retrieveUserMemos(this.value, "recipient");
  	}else{
  		getValues();
  	}      
  });

	$("#memoid").change(function(){
		if(this.value !== "")
    {
			retrieveUserMemos(this.value, "memoID");			
		}else{
			getValues();
		}
	});

	$("#dateSelect").change(function(){
		if(this.value !== "")
    {
			retrieveUserMemos(this.value, "date");
		}else{
			getValues();
		}
	});

  //when reset button clicked, it clears the value of the selects
	$("#resetDropdowns").click(function() {
    //found out how to clear the value onchange from here: https://stackoverflow.com/questions/5760873/trigger-change-event-when-setting-selects-value-with-val-function
		$('#memoid').val('').change();
		$('#recipientsDropdown').val('').change();
    $('#senderDropdown').val('').change();
		$('#dateSelect').val('').change();
    $('#titleSelect').val('').change();
  });

  getValues();
});