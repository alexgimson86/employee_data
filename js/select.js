var employeeDataModule = (function(){
    var cachedRow;
    var $dataAttribute;
    var deleteRow = function($row){
        $row.remove();
    };
    var wireApplyButton = function($applyButton){
        $applyButton.click(function(){
            $row = $applyButton.closest('tr.dataRow');
            var employeeData = {
                 idToEdit : $dataAttribute,
                 firstName : $row.find('#txtfirstName').val(),
                 lastName : $row.find('#txtlastName').val(),
                 phoneNumber : $row.find('#txtphoneNumber').val(),
                 address : $row.find('#txtaddress').val(),
                 age : $row.find('#txtage').val(),
                 eyeColor : $row.find('#txteyeColor').val(),
                 hairColor : $row.find('#txthairColor').val(),
                 height : $row.find('#txtheight').val(),
                 weight : $row.find('#txtweight').val()
            };
            editEmployee(employeeData);
        });
    };
    var wireCancelButton = function($cancelButton){
        $cancelButton.click(function(){
            if(cachedRow){
                $row = $cancelButton.closest('tr.dataRow');
                $newRow = jQuery("<tr class = 'dataRow'>" + cachedRow + "</tr>").replaceAll($row);
                $editButton = $newRow.find('.btnEdit');
                $deleteButton = $newRow.find('.btnDelete');
                wireOneEditButton($editButton);
                wireOneDeleteButton($deleteButton);
            }
        });
    };
    var wireOneEditButton = function($editButton){
        $editButton.click(function(){
            $this = jQuery(this);
            makeRowEditable($this);
        });
    };
    var wireOneDeleteButton = function($deleteButton){
        $deleteButton.click(function(){
            var $row = jQuery(this).closest('tr.dataRow');
            employeeDataModule.deleteEmployee($row);
        });
    };
    var makeCellEditable = function($cell){
        $nameAttribute = $cell.attr('name');
        $newId = "txt"+$nameAttribute;
        $cell.replaceWith('<td><input type="text" id="'+$newId+'" placeholder="'+$nameAttribute+'" /></td>');
    };
    var replaceButtons = function($editButton){
        $row = $editButton.closest('tr.dataRow');
        $deleteButton = $row.find('.btnDelete');
        $dataAttribute = $deleteButton.data('employeeId');
        $editButton.replaceWith('<button class="btnApply btn-default btn" data-employee-id="'+$dataAttribute+'">Apply</button>');
        $deleteButton.replaceWith('<button class="btnCancel btn-default btn" data-employee-id="'+$dataAttribute+'">Cancel</button>');
        $applyButton = $row.find('.btnApply');
        $cancelButton = $row.find('.btnCancel');
        wireApplyButton($applyButton);
        wireCancelButton($cancelButton);
    };
    var makeRowEditable = function($editButton){
        $row = $editButton.closest('tr.dataRow');
        cachedRow = $row.html();
        $cellsToEdit = $row.find('td').not('.tdWithButton');
        $cellsToEdit.each(function(index){
            makeCellEditable(jQuery(this));
        });
        $row.css({'background-color': '#ffdf80'});
        replaceButtons($editButton);
    };
    var addErrorMessage = function(error){
        var responseText = jQuery.parseJSON(error.responseText); 
        var $errorDiv = jQuery('.error-div');
        $errorDiv.append('<span>' + responseText.message + responseText.code + '</span>');
        $errorDiv.css({ 'display': 'inline-block'});
    };
    var wireAllDeleteButtons = function(){
         jQuery('.btnDelete').click(function(){
             var rowToDelete = jQuery(this).closest('.dataRow');
             employeeDataModule.deleteEmployee(rowToDelete);
         });
    };
    var wireAllEditButtons = function(){
         jQuery('.btnEdit').click(function(){
             $this = jQuery(this);
             makeRowEditable($this);
         });
    };  
    var clearTextBoxes = function(){
        $textBoxes = jQuery('#addRow').find('input');
        $textBoxes.val('');
    };
    
    var showAllRows = function(){
        jQuery.ajax({
           type: 'GET',
           url: 'select.php',
           data: { 
               action: 'showAllRows'
           },
           success: function(result) {
               jQuery(result).insertBefore("#addRow");
               wireAllDeleteButtons();
               wireAllEditButtons();
           }, 
           error: function(error){
                addErrorMessage(error);
            }
        });
    };
    
    var editEmployee = function(employeeData){
        jQuery.ajax({
            type: 'POST',
            url: 'select.php',
            data: {
                idToEdit: employeeData.idToEdit,
                firstName : employeeData.firstName,
                lastName : employeeData.lastName,
                phoneNumber : employeeData.phoneNumber,
                address : employeeData.address,
                eyeColor : employeeData.eyeColor,
                hairColor : employeeData.hairColor,
                height : employeeData.height,
                weight : employeeData.weight,
                age : employeeData.age,
                action: 'editEmployee'
                
            },
            success: function(result){
                $rows = jQuery('#employeeTable').find('.dataRow');
                $rows.remove();
                jQuery(result).insertBefore("#addRow");
                wireAllDeleteButtons();
                wireAllEditButtons();
            },
            error: function(error){
                addErrorMessage(error);
            }
        });
    };
    var addEmployee = function(){
        var $firstName = jQuery('#txtNewFirstName').val();
        var $lastName = jQuery('#txtNewLastName').val();
        var $phoneNumber = jQuery('#txtNewPhoneNumber').val();
        var $address = jQuery('#txtNewAddress').val();
        var $age = jQuery('#txtNewAge').val();
        var $eyeColor = jQuery('#txtNewEyeColor').val();
        var $hairColor = jQuery('#txtNewHairColor').val();
        var $height = jQuery('#txtNewHeight').val();
        var $weight = jQuery('#txtNewWeight').val();
        
        jQuery.ajax({
            type: 'POST',
            url: 'select.php',
            data: { 
                firstName : $firstName,
                lastName : $lastName,
                phoneNumber : $phoneNumber,
                address : $address,
                eyeColor : $eyeColor,
                hairColor : $hairColor,
                height : $height,
                weight : $weight,
                age : $age,
                
                action: 'addEmployee'
            },
            success: function(result) {
                $rows = jQuery('#employeeTable').find(".dataRow");
                $rows.remove();
                jQuery(result).insertBefore("#addRow");
                clearTextBoxes();
                wireAllDeleteButtons();
                wireAllEditButtons();
            } ,
            error: function(error){
               addErrorMessage(error);
            }
        });
    };
    var deleteEmployee = function(row){
        var idToDelete = jQuery(row).find('.btnDelete').data('employeeId');
        jQuery.ajax({
            type: 'POST',
            url: 'select.php',
            data: {
                idToDelete: idToDelete,
                action: 'deleteEmployee'
            },
            success: function(){
                deleteRow(row);
            },
            error: function(error){
                addErrorMessage(error);
            }
        });
    };
    return {
        showAllRows: showAllRows,
        addEmployee: addEmployee,
        deleteEmployee: deleteEmployee,
        editEmployee: editEmployee
    };
}());

jQuery(document).ready(function(){
    employeeDataModule.showAllRows();
    jQuery('#btnAddEmployee').click(function(){
        employeeDataModule.addEmployee();
    });
});


