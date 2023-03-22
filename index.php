<?php

session_start();

//CHECK TO SEE IF USER IS LOGGED IN

if (isset($_SESSION["user_id"])) {
    
    $mysqli = require __DIR__ . "/database.php";
    
    $sql = "SELECT * FROM users
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
}

?>


<!DOCTYPE html>
<html>
<head>
    <title>Contactr</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
	<link type="text/css" href="css/bootstrap-table.css" rel="stylesheet">
	<link type="text/css" href="css/font-awesome.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<style>
        * {box-sizing: border-box;}

        body {
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
        }

        .topnav {
        overflow: hidden;
        background-color: #e6e6fa;
        }

        .topnav a {
        float: left;
        display: block;
        color: black;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;
        }

        .topnav a:hover {
        background-color: #ddd;
        color: black;
        }

        .topnav a.active {
        background-color: #2196F3;
        color: white;
        }

        .topnav .search-container {
        float: right;
        }

        .topnav input[type=text] {
        padding: 6px;
        margin-top: 8px;
        margin-bottom: 8px;
        font-size: 17px;
        border: none;
        }

        .topnav .search-container button {
        float: right;
        padding: 6px 10px;
        margin-top: 8px;
        margin-bottom: 8px;
        margin-right: 16px;
        background: #ddd;
        font-size: 17px;
        border: none;
        cursor: pointer;
        }

        .topnav .search-container button:hover {
        background: #ccc;
        }

        @media screen and (max-width: 600px) {
            .topnav .search-container {
                float: none;
            }
            .topnav a, .topnav input[type=text], .topnav .search-container button {
                float: none;
                display: block;
                text-align: left;
                width: 100%;
                margin: 0;
                padding: 14px;
            }
            .topnav input[type=text] {
                border: 1px solid #ccc;  
            }
            
        }
        .btn-text-right{
	            text-align: right;
        }

    </style>
</head>
<body style = "background-color:#E6E6FA;">

<div class="container my-3">   
 <!-- This is the Main body of the page once logged in -->
    <h1>Contactr</h1>       
    <?php if (isset($user)): ?>
        
    <h4>Hello <?= ($user["userName"]) ?></h4>
    <p>Below are your contacts.</p>
    <!--<a style="text-align:right;" class="btn btn-primary" href="logout.php" role="button">Logout</a>-->
    <div class="btn-text-right">
    <a class="btn btn-primary" href="logout.php" role="button">Logout</a>
    </div>


    
	
	 <div class="topnav">
        <div class="search-container">
            <form action="search.php" method="post">
                <input type="text" placeholder="Search..." name="search">
                <button type="submit"><i class="fa fa-search"></i></button>
            </form>
        </div>
    </div>
	
    <div class="panel panel-success">						 
		<div class="panel-body">
			<div class="row">
            <a class="btn btn-primary" href="new-create-contact.php" role="button">Add Contact</a>
				<div class="col-md-12">					 
					<table id= "table"class="table table-hover"data-show-columns="true"data-height="460"></table>
                </div>
            </div>
		</div>
                           
	</div>           
<!--    <p><a href="logout.php">Log out</a></p> -->

        
    <?php else: header("Location: login.php");?>
   <!-- This is the Main body of the page with no user logged in -->      
        <h5><a href="login.php">Log In</a> or <a href="new-signup.php">Sign Up</a></h5>
        
    <?php endif; ?>
         
</div>

 <!-- This is the Modal which appears when the remove contact button is pressed -->
<div class="modal" id="delete-modal" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Are you sure? </h4>
            </div>
            <div class="modal-body">
                
                <p>Press OK to delete this contact.</p>
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-success" id="deleteSubmit">
                 </form>
            </div>
        </div>				
	</div>     
</div>
 <!-- This is the Modal which appears when the edit contact button is pressed -->

 <div id="contact-modal"class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-bs-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Contact </h4>
            </div>


            <div class="modal-body">
            <form id="contactForm" name="contact" role="form">


                <div class="form-group">
                    <label for="firstName">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="firstName" >             
                </div>
                <div class="form-group">
                    <label for="lastName">Last Name</label>
                    <input type="text" class="form-control" id="lastName"name="lastName">             
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email"name="email">             
                </div>
                <div class="form-group">
                    <label for="phoneNumber">Phone Number</label>
                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber">             
                </div>
            
            </div>
            <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-bs-dismiss="modal">Close</button>
						<input type="submit" class="btn btn-success" id="editSubmit">
            </div>
    </form>
        </div>				
	</div>     
</div>

<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-table.js"></script>


<script type="text/javascript">

    var currentSelection = 0; //tmp var to store clicked row index
    var _firstName = ""; //tmp var to populate edit modal
    var _lastName = "";
    var _email = "";
    var _phoneNo = "";

        //function to grab id of contact stored in clicked row
    $('#table').on('click-row.bs.table', function (e, row, $element) {
        var index = $element.data('index');
        var test =$table.bootstrapTable('getData');
        var al = test[index]['id'];
        currentSelection = al;
	 _firstName = test[index]['first'].toString();
	 _lastName = test[index]['last'].toString();
	 _email = test[index]['email'].toString();
	 _phoneNo  = test[index]['phone'].toString();
         $('#contact-modal form input[id=firstName]').val(_firstName);
	 $('#contact-modal form input[id=lastName]').val(_lastName);
	 $('#contact-modal form input[id=email]').val(_email);
	 $('#contact-modal form input[id=phoneNumber]').val(_phoneNo);
    });

//here we have to ajax the edit and delete commands to php (because they're nested inside of modals)

    $(document).ready(function(){	

        $('#deleteSubmit').on('click', function(event) {
            deleteForm();
            return false;
        });

        $("#editSubmit").on('click', function(event){
            submitForm();
            return false;
        });
        
    });

    function submitForm(){

      
    $.ajax({
       type: "POST",
       url: "process-update.php",
       cache:false,
       data:  $('form#contactForm').serialize()+"&id="+currentSelection,
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
    function deleteForm(){
     
    $.ajax({
       type: "POST",
       url: "process-removal.php",
       cache:false,
       data: { id:currentSelection},
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


    //this just allows the table to be created in js with dynamic edit and delete buttons
    function operateFormatter(value, row, index) {
        return [
        '<a class="edit" href="javascript:void(0)" title="Edit">',
        '<i class="fa fa-pencil"></i>',
        '</a>  ',
        '<a class="remove" href="javascript:void(0)" title="Delete">',
        '<i class="fa fa-trash"></i></a>',

        ].join('')
    }
     //Popups open when edit or delete are clicked 
    window.operateEvents = {
        'click .edit': function (e, value, row, index) {
	
         
            $('#contact-modal').modal('show');


        },
        'click .remove': function (e, value, row, index) {
 
           
            $('#delete-modal').modal('show');
            
        }
        


  }
  //table value format created in jquery
	 var $table = $('#table');
		     $table.bootstrapTable({
			      url: 'showContacts.php',
			      pagination: true,
			      buttonsClass: 'primary',
			      showFooter: false,
			      minimumCountColumns: 2,
			      columns: [{
			          field: 'num',
			          title: '#',
			          sortable: true,
			      },{
			          field: 'id',
			          title: 'id',
			          sortable: true,
                      visible: false,
			      },
                  {
			          field: 'first',
			          title: 'First Name',
			          sortable: true,
              
			      },{
			          field: 'last',
			          title: 'Last Name',
			          sortable: true,
    
			          
			      },{
			          field: 'email',
			          title: 'Email',
			          sortable: true,
             
				 },{
				      field: 'dateCreated',
				      title: 'Date Created',
				      sortable: true,
			          
			      },{
				      
			          field: 'phone',
			          title: 'Phone Number',
			          sortable: true,
			   
			      },{
                    field: 'operate',
                    title: 'Edit/Delete',
                    align: 'center',
                    
                    events: window.operateEvents,
                    formatter: operateFormatter,
                  }
                  ],
 
  			 });



</script>


</body>


</html>
    
    
    
    
    
    
    
    
    
    
    
