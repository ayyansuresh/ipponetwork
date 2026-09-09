/*
 $("#formValidate").validate({
 rules: {
 name: {
 required: true,
 minlength: 5
 },
 },
 //For custom messages
 messages: {
 name: {
 required: "Enter a name",
 minlength: "Enter at least 5 characters"
 },
 },
 errorElement: 'div',
 errorPlacement: function (error, element) {
 var placement = $(element).data('error');
 if (placement) {
 $(placement).append(error)
 } else {
 error.insertAfter(element);
 }
 }
 });
 */



//updated version of addStaff

function addStaff() {

    var formData = new FormData();

    var aadharno = $("#aadharno").val();
    var fileInput = document.getElementById("aadhaarPhoto");
    var file = fileInput.files.length > 0 ? fileInput.files[0] : null;

    // Aadhaar validation
    if (aadharno !== "") {
        if (!/^\d{12}$/.test(aadharno)) {
            alert("Aadhaar Number must be exactly 12 digits");
            return;
        }

        if (!file) {
            alert("Please upload Aadhaar file");
            return;
        }

        // Append only if Aadhaar exists
        formData.append("aadharno", aadharno);
        formData.append("aadharFile", file);
    }

    formData.append("name", $("#name").val());
    formData.append("designation_id", $("#StaffDesignation").val());
    formData.append("mobile", $("#mobile").val());
   
    formData.append("address1", $("#address1").val());
    formData.append("address2", $("#address2").val() || "");
    formData.append("pincode", $("#pincode").val());
    formData.append("country_id", $("#customerCountry").val());
    formData.append("state_id", $("#customerState").val());
    formData.append("city_id", $("#customerCity").val());
        
    $('#mainModal').openModal({ dismissible: false });

    var completeurl = url + "customer-customer/addStaff";
    var place = "mainModal";
    $("#" + place).html("Loading");

   
    $.ajax({
        url: completeurl,
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#" + place).html(data);
        },
        error: function (xhr, status, error) {
            $("#" + place).html("Error: " + error);
        }
    });
}


function addDesignation() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/addDesignation";
    var place = "mainModal";
    $("#" + place).html("Loading");

    var posting = $.post(completeurl, {
        name: $("#name").val(),
    });

    posting.done(function (data) {
        $("#" + place).html(data);
        
    }).fail(function (xhr, status, error) {
        $("#" + place).html("Error: " + error);
    });
}



//updated version of addCustomer for file upload

function addCustomer() {
    //event.preventDefault();

    var formData = new FormData();

    var aadharno = $("#aadharNumber").val().trim();
    var fileInput = document.getElementById("aadhaarPhoto");
    var file = fileInput.files.length > 0 ? fileInput.files[0] : null;

    // Aadhaar validation
    if (aadharno !== "") {
        if (!/^\d{12}$/.test(aadharno)) {
            alert("Aadhaar Number must be exactly 12 digits");
            return;
        }

        if (!file) {
            alert("Please upload Aadhaar file");
            return;
        }

        // Append only if Aadhaar exists
        formData.append("aadharno", aadharno);
        formData.append("aadharFile", file);
    }

    // Normal fields
    formData.append("name", $("#name").val());
    formData.append("sitename", $("#sitename").val());
    formData.append("gstNumber", $("#gstNumber").val());
    formData.append("partyGstType", $("#gstType").val());
    formData.append("customerType", $("#customerType").val());
    formData.append("openingBalance", $("#openingBalance").val());
    formData.append("address1", $("#address1").val());
    formData.append("address2", $("#address2").val());
    formData.append("stateId", $("#customerState").val());
    formData.append("cityId", $("#customerCity").val());
    formData.append("pincode", $("#pincode").val());
    formData.append("email", $("#email").val());
    formData.append("mobile", $("#mobile").val());
    formData.append("phone", $("#phone").val());
    formData.append("customerCountry", $("#customerCountry").val());
    formData.append("customerCityName", $("#customerCity option:selected").text());
    formData.append("zone", $("#zone").val());

    $('#mainModal').openModal({ dismissible: false });
    
    //console.log(formData.get('aadharFile'));

    $.ajax({
        url: url + "customer-customer/addCustomer",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,
        success: function (data) {
            $("#formValidate")[0].reset();
            $("#aadhaarPhoto").val("");
            $("#mainModal").html(data);
        },
        error: function () {
            alert("Something went wrong!");
        }
    });
}







function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'customer-customer/newCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function selectCustomerAddress(){
    var checkBox = document.getElementById("myCheck");
    //var address1 = document.getElementById("address1");
    var address1 = $("#address1").val();
    var address2 = $("#address2").val();
    var pincode = $("#pincode").val();
    var email = $("#email").val();
    var mobile = $("#mobile").val();
    var phone = $("#phone").val();
    /*var customerCountry = $("#customerCountry option:selected").text();
    alert(customerCountry);
    var customerState = $("#customerState option:selected").text();
    alert(customerState);
    var customerCity = $("#customerCity option:selected").text();
    alert(customerCity);*/
    //var address2 = document.getElementById("address2");
    if (checkBox.checked == true){
        $("#shippmentaddress1").val(address1);
        $("#shippmentaddress2").val(address2);
        $("#shipmentpincode").val(pincode);
        $("#shipmentemail").val(email);
        $("#shipmentmobile").val(mobile);
        $("#shipmentphone").val(phone);
        var customerCountry = $("#customerCountry option:selected").val();
        $("#shippmentcustomerCountry option:selected").val(customerCountry);
        var customerState = $("#customerState option:selected").val();
        $("#shippmentcustomerState").val(customerState);
        var customerCity = $("#customerCity option:selected").val();
        $("#shippmentcustomerCity").val(customerCity);
        $('#labeladdress1').hide();
        $('#labeladdress2').hide();
        $('#labelpincode').hide();
        $('#labelemail').hide();
        $('#labelmobile').hide();
        $('#labelphone').hide();
    } else {
       $("#shippmentaddress1").val("");
       $("#shippmentaddress2").val("");
       $('#labeladdress1').show();
       $('#labeladdress2').show();
       $("#shipmentpincode").val("");
       $('#labelpincode').show();
       $("#shipmentemail").val("");
       $('#labelemail').show();
       $("#shipmentmobile").val("");
       $('#labelmobile').show();
       $("#shipmentphone").val("");
       $('#labelphone').show();
    }   
}
function addShippmentCustomer() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/addShippmentCustomer";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                name: $("#name").val(),
                gstNumber: $("#gstNumber").val(),
                partyGstType: $("#gstType").val(),
                customerType: $("#customerType").val(),
                openingBalance: $("#openingBalance").val(),
                address1: $("#address1").val(),
                address2: $("#address2").val(),
                stateId: $("#customerState").val(),
                cityId: $("#customerCity").val(),
                pincode: $("#pincode").val(),
                email: $("#email").val(),
                mobile: $("#mobile").val(),
                phone: $("#phone").val(),
                aadharNumber: $("#aadharNumber").val(),
                shippmentaddress1: $("#shippmentaddress1").val(),
                shippmentaddress2: $("#shippmentaddress2").val(),
                shippmentcustomerCountry: $("#shippmentcustomerCountry").val(),
                shippmentcustomerState: $("#shippmentcustomerState").val(),
                shippmentcustomerCity: $("#shippmentcustomerCity").val(),
                shipmentpincode: $("#shipmentpincode").val(),
                shipmentemail: $("#shipmentemail").val(),
                shipmentmobile: $("#shipmentmobile").val(),
                shipmentphone: $("#shipmentphone").val(),
                customerCode: $("#customerCode").val(),
                customerNumber: $("#customerNumber").val(),
                countryOfOrgin: $("#countryOfOrgin").val(),
                incoterms: $("#incoterms").val(),
            });
    posting.done(function (data) {
        $("#name").val("");
        $("#gstNumber").val("");
        $("#gstType").val("");
        $("#customerType").val("");
        $("#openingBalance").val("");
        $("#address1").val("");
        $("#address2").val("");
        $("#customerState").val("");
        $("#customerCity").val("");
        $("#pincode").val("");
        $("#email").val("");
        $("#mobile").val("");
        $("#phone").val("");
        $("#aadharNumber").val("");
        $("#shippmentaddress1").val("");
        $("#shippmentaddress2").val("");
        $("#shippmentcustomerCountry").val("");
        $("#shippmentcustomerState").val("");
        $("#shippmentcustomerCity").val("");
        $("#shipmentpincode").val("");
        $("#shipmentemail").val("");
        $("#shipmentmobile").val("");
        $("#shipmentphone").val("");
        $("#customerCode").val("");
        $("#customerNumber").val("");
        $("#countryOfOrgin").val("");
        $("#incoterms").val("");
        //$("option:selected").prop("selected", false);
        $("#" + place).html(data);
    });
}

function printCustomerReport()
{
    var completeurl = url + 'customer-customer/addCustomerReport';
    window.open(completeurl);
}
function addRoomRentDetails() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/addRoomRentDetails";
     var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                number: $("#number").val(),
                roomSpecfType: $("#roomSpecfType").val(),
            });
              
    posting.done(function (data) {
        $("#number").val("");
        $("#roomSpecfType").val("");
        $("#" + place).html(data);
    });
}
function closeRoomRentDetails() {
    $('#mainModal').closeModal();
   requesturl = url + 'customer-customer/loadroomrent';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function loadRoomRentDetails()
{
    
    var requesturl = url + 'customer-customer/loadRoomRentDetails';
    var roomNumber = $("#roomNumber").val();
    var data = "roomNumber=" + roomNumber;
    $("#loadRoomRentDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadRoomRentDetails');
}
function updateRoomRentDetails() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/updateRoomRentDetails";
     var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                roomId: $("#roomId").val(),
                number: $("#number").val(),
                roomSpecfType: $("#roomSpecfType").val(),
            });
              
    posting.done(function (data) {
        $("#roomId").val("");
        $("#number").val("");
        $("#roomSpecfType").val("");
        $("#" + place).html(data);
    });
}
function closeUpdateRoomRentDetails() {
    $('#mainModal').closeModal();
    requesturl = url + 'customer-customer/updateroomrent';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

function addRoomSpecificationDetails() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/addRoomSpecificationDetails";
     var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                
                roomSpecfTypeName: $("#roomSpecfTypeName").val(),
                roomRentHr: $("#roomRentHr").val(),
                roomRentDay: $("#roomRentDay").val(),
                extraBedCharges: $("#extraBedCharges").val(),
                hsnCode: $("#hsnCode").val()
            });
              
    posting.done(function (data) {
        
        $("#roomSpecfTypeName").val("");
        $("#roomRentHr").val("");
        $("#roomRentDay").val("");
        $("#extraBedCharges").val("");
        $("#" + place).html(data);
    });
}

function closeRoomSpecificationDetails() {
    $('#mainModal').closeModal();
   requesturl = url + 'customer-customer/roomspecification';
    loader();
    ajaxload('GET', requesturl, '', processor);
}

