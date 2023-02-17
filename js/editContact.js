//TO-DO, notify when contact was not successfully updated (e.g. no fields were filled in)

$(document).ready(function(){	
	$("#contactForm").submit(function(event){
		submitForm();
		return false;
	});
});
function submitForm(){
    $.ajax({
       type: "POST",
       url: "process-update.php",
       cache:false,
       data: $('form#contactForm').serialize(),
       success: function(response){
           $("#contact").html(response);

           $("#contact-modal").modal('hide');
            location.reload();

       },
       error: function(){
           alert("Error");
       }
   });
}