<?php
function showAllRows($conn){
    $query = "SELECT `emp`.`first_name`,`emp`.`idemployee_info`,`emp`.`last_name`, `emp`.`phone_number`,`emp`.`address`,`emp`.`age`,`traits`.`hair_color`,`traits`.`height`,`traits`.`eye_color`, `traits`.`weight` 
               FROM `employee_info` AS `emp`
               INNER JOIN  `traits` ON `emp`.`idemployee_info` = `traits`.`employee_id`";
    $result = mysqli_query($conn,$query) or die ("Error executing queury");
    return $result;
            
}
function addEmployee($conn,$empAndTraits){
    $query = "INSERT INTO `test_two`.`employee_info` (`idemployee_info`,`first_name`,`last_name`,`phone_number`,`address`,`age`) "
            . "VALUES (NULL,'$empAndTraits[firstName]','$empAndTraits[lastName]','$empAndTraits[phoneNumber]','$empAndTraits[address]','$empAndTraits[age]');";
    $query .= "INSERT INTO `test_two`.`traits` (`idtraits`,`hair_color`,`eye_color`,`weight`,`height`,`employee_id`) "
            . "VALUES(NULL,'$empAndTraits[hairColor]','$empAndTraits[eyeColor]','$empAndTraits[weight]','$empAndTraits[height]',LAST_INSERT_ID());";
    if(!$conn)
    {
        die("Could not connect " . mysql_error());
    }
   if($is_successful = mysqli_multi_query($conn,$query))
   {
       do{
           if($result = mysqli_store_result($conn)){
               my_sqli_free_result($result);
           }
       }while(mysqli_next_result($conn));
   }
    if($is_successful){
        return showAllRows($conn);
    }
    else{
        $is_successful = "ERROR";
    }
}
function deleteEmployee($conn,$idToDelete){
    $query = "DELETE FROM `test_two`.`employee_info` WHERE `idemployee_info` = $idToDelete;";
    $query .="DELETE FROM `test_two`.`traits` WHERE `employee_id` = $idToDelete;";
    
    if($is_successful = mysqli_multi_query($conn,$query))
    {
       do{
           if($result = mysqli_store_result($conn)){
               my_sqli_free_result($result);
           }
       }while(mysqli_next_result($conn));
    }
    if($is_successful){
        return 'SUCCESS';
    }
    else{
      return 'ERROR';
    }
}
function editEmployee($conn,$empAndTraits){
    $query = "UPDATE  `test_two`.`employee_info`"
            . " SET `first_name`='$empAndTraits[firstName]',"
            . "`last_name` = '$empAndTraits[lastName]',"
            . "`phone_number` = '$empAndTraits[phoneNumber]',"
            . "`address`='$empAndTraits[address]',"
            . "`age`='$empAndTraits[age]'"
            . "WHERE `idemployee_info` = '$empAndTraits[idToEdit]';";  
    
    $query .= "UPDATE  `test_two`.`traits`"
            . " SET `hair_color`='$empAndTraits[hairColor]',"
            . "`eye_color` = '$empAndTraits[eyeColor]',"
            . "`weight` = '$empAndTraits[weight]',"
            . "`height`='$empAndTraits[height]'"
            . "WHERE `employee_id` = '$empAndTraits[idToEdit]';";
    
    if($is_successful = mysqli_multi_query($conn,$query))
    {
       do{
           if($result = mysqli_store_result($conn)){
               my_sqli_free_result($result);
           }
       }while(mysqli_next_result($conn));
    }
    
    if($is_successful){
        return showAllrows($conn);
    }
    else{
      return 'ERROR';
    }
}