<?php
    require 'DAL/employeeFunctions.php';
    
    $username="root";
    $password="";
    $dbname="test_two";

    // Create connection
    $conn = new mysqli("localhost", $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    
    $action = isset($_GET["action"]) ? $_GET["action"] : $_POST["action"];
    $query;
    $result;
    switch($action)
    {
        case "showAllRows":
            $result = showAllRows($conn);
            break;
        case "addEmployee":
            $firstName = filter_input(INPUT_POST,"firstName",FILTER_SANITIZE_STRING);
            $lastName = filter_input(INPUT_POST,"lastName",FILTER_SANITIZE_STRING);
            $phoneNumber = filter_input(INPUT_POST,"phoneNumber", FILTER_SANITIZE_STRING);
            $eyeColor = filter_input(INPUT_POST, "eyeColor", FILTER_SANITIZE_STRING);
            $weight = filter_input(INPUT_POST, "weight",FILTER_SANITIZE_STRING);
            $height = filter_input(INPUT_POST, "height",FILTER_SANITIZE_STRING);
            $age = filter_input(INPUT_POST, "age",FILTER_SANITIZE_NUMBER_INT);
            $hairColor = filter_input(INPUT_POST, "hairColor",FILTER_SANITIZE_STRING);
            $address = filter_input(INPUT_POST, "address",FILTER_SANITIZE_STRING);
             $empAndTraits = array(
                  'firstName' => $firstName,
                  'lastName' => $lastName,
                  'phoneNumber' => $phoneNumber,
                  'eyeColor' => $eyeColor,
                  'weight' => $weight,
                  'height' => $height,
                  'age' => $age,
                  'hairColor' =>$hairColor,
                  'address' => $address
                     
             );
             $result = addEmployee($conn,$empAndTraits);
        break;
        case "deleteEmployee":
            $idToDelete = filter_input(INPUT_POST,"idToDelete",FILTER_SANITIZE_STRING);
            $result = deleteEmployee($conn,$idToDelete);
            break;
        case "editEmployee":
            $idToEdit = filter_input(INPUT_POST,"idToEdit",FILTER_SANITIZE_STRING);
            $firstName = filter_input(INPUT_POST,"firstName",FILTER_SANITIZE_STRING);
            $lastName = filter_input(INPUT_POST,"lastName",FILTER_SANITIZE_STRING);
            $phoneNumber = filter_input(INPUT_POST,"phoneNumber", FILTER_SANITIZE_STRING);
            $eyeColor = filter_input(INPUT_POST, "eyeColor", FILTER_SANITIZE_STRING);
            $weight = filter_input(INPUT_POST, "weight",FILTER_SANITIZE_STRING);
            $height = filter_input(INPUT_POST, "height",FILTER_SANITIZE_STRING);
            $age = filter_input(INPUT_POST, "age",FILTER_SANITIZE_NUMBER_INT);
            $hairColor = filter_input(INPUT_POST, "hairColor",FILTER_SANITIZE_STRING);
            $address = filter_input(INPUT_POST, "address",FILTER_SANITIZE_STRING);
            $empAndTraits = array(
                  'idToEdit' =>$idToEdit,
                  'firstName' => $firstName,
                  'lastName' => $lastName,
                  'phoneNumber' => $phoneNumber,
                  'eyeColor' => $eyeColor,
                  'weight' => $weight,
                  'height' => $height,
                  'age' => $age,
                  'hairColor' =>$hairColor,
                  'address' => $address
            );
            $result = editEmployee($conn,$empAndTraits);
        default:
            $result = showAllRows($conn);
    }
    if(is_string($result) && $result == 'ERROR'){
        header('HTTP/1.1 500 Internal Server Booboo');
        header('Content-Type: application/json; charset=UTF-8');
        die(json_encode(array('message' => 'ERROR', 'code' => 1337)));
    }
    else
    {
        while($row = mysqli_fetch_assoc($result))
        {       
            echo "<tr class='dataRow'>"
                       . "<td name='firstName'>" . $row["first_name"] . "</td>" 
                       . "<td name='lastName'>" . $row["last_name"] . "</td>" 
                       . "<td name='phoneNumber'>" . $row["phone_number"] . "</td>" 
                       . "<td name='address'>". $row["address"]. "</td>"
                       . "<td name='age'>". $row["age"]. "</td>"
                       . "<td name='hairColor'>". $row["hair_color"]. "</td>"
                       . "<td name='height'>". $row["height"]. "</td>"
                       . "<td name='eyeColor'>". $row["eye_color"] . "</td>" 
                       . "<td name='weight'>". $row["weight"]. "</td>"
                       . "<td class='tdWithButton'><button class='btnEdit btn-default btn' data-employee-id=".$row["idemployee_info"].">Edit</button></td>" 
                       . "<td class='tdWithButton'><button class='btnDelete btn-default btn' data-employee-id=".$row["idemployee_info"].">Delete</button></td>"
                   . "</tr>";
        }
    }

