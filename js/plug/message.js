function messagefadeout(){	
	if($("#addmessage").html()){
		$("#flashMessage").addClass("flashmessage");
		$("#flashMessage").delay(2000).fadeOut(2000);
	}
}