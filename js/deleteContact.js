
$(document).ready(function(){	
	$("#deleteForm").submit(function(event){
        

        

		//deleteForm();

	});
});



function deleteForm(){
    $.ajax({
       type: "POST",
       url: "process-removal.php",
       cache:false,
       data: id,
       success: function(response){
           $("#delete").html(response);

           $("#delete-modal").modal('hide');
            location.reload();

       },
       error: function(){
           alert("Error");
       }
   });
}
