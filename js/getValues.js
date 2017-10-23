function getValues() {
	$.ajax({
			url: 'getValuesFunctions.php',
			dataType: 'json',
			encode: true
		})

		.done(function (data) {
			console.log(data);

			$("#dateSelect").empty();
			$("#titleSelect").empty();
			$("#senderDropdown").empty();
			$("#recipientsDropdown").empty();
			$("#memoid").empty();
			$("#senderModalSelect").empty();
			$("#recipientsModalSelect").empty();
			$("#memoidForm").empty();


			//empty dropdown code idea from https://stackoverflow.com/questions/8605516/default-select-option-as-blank
			$("#recipientsDropdown").append('<option selected="selected" value> --- Select Recipient --- </option>');
			$("#senderDropdown").append('<option selected="selected" value> --- Select Author --- </option>');
			$("#memoid").append('<option selected value> --- Select Memo ID --- </option>');
			$("#dateSelect").append('<option selected="selected" value> --- Select Date --- </option>');
			$("#titleSelect").append('<option selected="selected" value> --- Select Title --- </option>');

			for (var i = 0; i < data.users.length; i++) {
				$("#recipientsModalSelect").append('<option>' + data.users[i].users + '</option');
				if (data.users[i].currentUser != null) {
					$("#senderModalSelect").val(data.users[i].currentUser);
				}

				$("#recipientsDropdown").append('<option>' + data.users[i].users + '</option>');
			}

			//The sender dropdown Only displays users that have created memos within the XMemo database.
			for (var i = 0; i < data.sender.length; i++) {
				// console.log(data.sender[i].sender);
				if (data.sender[i].sender != null) {
					$("#senderDropdown").append('<option>' + data.sender[i].sender + '</option>');
				}
			}

			// for (var i = 0; i<data.recipients.length; i++){
			// 	console.log(data.recipients[i].recipients);
			// 	if(data.recipients[i].recipients != null){
			// 				
			// 	}			
			// }

			for (var i = 0; i < data.memoID.length; i++) {
				$("#memoid").append('<option>' + data.memoID[i].id + '</option>' + ' - ' + data.memoID[i].title);
			}

			for (var i = 0; i < data.date.length; i++) {
				// console.log(data.date[i].publishedDate)
				if (data.date[i].publishedDate != null) //checks against the data returned from getValuesFunctions.php to see if publishedDate was returned as null (multiple occurences in XML database)
				{
					$("#dateSelect").append('<option>' + data.date[i].publishedDate + '</option>');
				}
			}

			for (var i = 0; i < data.title.length; i++) {
				$("#titleSelect").append('<option>' + data.title[i].title + '</option>');
			}

			displayMemos(data);
		});
};