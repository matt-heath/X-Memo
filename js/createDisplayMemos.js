function displayMemos(data)
{
	$("#memos").empty();
	output="";
	for(var i = 0; i < data.memos.length; i++)
	{	
		//Closes 'columns' div tag every 3 memos and creates a new row of coumns
		if(i == 0 || i %3 ==0 && i >0 ){
			output += '</div><div class="columns">';
		}
		output +='<div class="column card container">';
		output += '<b>Memo ID: </b>'+data.memos[i].id+'<br>';
		output += '<b>Title: </b>'+data.memos[i].title+'<br>';
		output += '<b>Author: </b>'+data.memos[i].sender+'<br>';
		//.join() returns elements of an array as a string - learnt from https://www.w3schools.com/jsref/jsref_join.asp
		output += '<b>Recipients: </b>'+data.memos[i].recipients.join(", ")+'<br>';
		output += '<b>Summary: </b>'+data.memos[i].summary+'<br>';
		
		if(data.memos[i].url !== ''){
			output += '<b>URL: </b><a href="http://'+data.memos[i].url+'" target="_blank">'+data.memos[i].url+'</a><br>';
		}
		output += '<b>Date: </b>'+data.memos[i].publishedDate+'<br><br>';
		//https://stackoverflow.com/questions/10805125/how-to-remove-all-line-breaks-from-a-string - used to remove potential line breaks from the summary string causing an error when returning summary data
	  	output += '<div><a data-target="#updateModal" class="button is-info is-outlined modal-button-edit" style="margin: 2px" onclick="updateModal('+data.memos[i].id+',\''+data.memos[i].title+'\',\''+data.memos[i].summary.replace(/(\r\n|\n|\r)/gm,"")+'\',\''+data.memos[i].url+'\',)"><b>Edit Memo</b></a>';
		output += '<a data-target="#deleteModal" class="button is-danger is-outlined modal-button-delete" id="modal-button-delete" style="margin: 2px" onclick="deleteModal('+data.memos[i].id+'\)"><b>Delete Memo</b></a></div>';
		output += '</div></form>';	
	}
	output+='</div>';
	$("#memos").append(output);
}	