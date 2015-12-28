<!DOCTYPE html>
<html>
	<head>
		<title>TEST - retrieving users from MySQL with jquery, ajax and PHP</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="js/select.js" type="text/javascript"></script>
        <!--<link rel="stylesheet" type="text/css" href="content/index.css">-->
        <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="Content/Css/index.css">
	</head>
	<body>
                <div class="error-div alert alert-danger" role="alert">
                <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
                <span class="sr-only">Error:</span>
                
                </div>
		<input type="text" id="txtId" />
        	<button id="btnSelectById" class="btn btn-default">Select by ID</button>
       		<button id="btnSelectAll" class="btn btn-default">Select All</button>
        	<div id="content"></div>
        	<div id="addEmployee">
            	<table  id ="employeeTable" class="table-hover table table-bordered">
               		<thead>
                   	    <tr>
                        	<th>first name</th>
                        	<th>last name</th>
                        	<th>phone number</th>
                                <th>address</th>
                                <th>age</th>
                        	<th>hair color</th>
                        	<th>height</th>
                        	<th>eye color</th>
                                <th>weight</th>
                                <th colspan="2">command</th>
                           </tr>
                	</thead>
                	<tbody>
                    	<tr id="addRow">
                        	<td><input type="text" id="txtNewFirstName" placeholder="first name" /></td>
                        	<td><input type="text" id="txtNewLastName" placeholder="last name" /></td>
                        	<td><input type="text" id="txtNewPhoneNumber" placeholder="phone number" /></td>
                                <td><input type="text" id="txtNewAddress" placeholder="Address" /></td>
                                <td><input type ="text" id="txtNewAge" placeholder="age" /></td>
                                <td><input type="text" id="txtNewHairColor" placeholder="Hair Color" /></td>
                                <td><input type ="text" id="txtNewHeight" placeholder="height" /></td>
                        	<td><input type="text" id="txtNewEyeColor" placeholder="eye color" /></td>
                                <td><input type="text" id="txtNewWeight" placeholder="weight"/></td>
                        	<td colspan="2"><button id="btnAddEmployee" class="btn-default btn">Add Employee</button></td>
                    	</tr>
                	</tbody>
            	</table>
        	</div>
    </body>
</html>

