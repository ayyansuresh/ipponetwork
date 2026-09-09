//---------------------------------//

//updated version of updateCustomer for aadhaar 

function updateCustomer() {

    $('#mainModal').openModal({ dismissible: false });

    var completeurl = url + "customer-customer/updateCustomer";
    var place = "mainModal";
    $("#" + place).html("Loading");

    var formData = new FormData();

    /* ---------- Normal fields ---------- */
    formData.append("customerId", $("#customerId").val());
    formData.append("name", $("#name").val());
    formData.append("sitename", $("#sitename").val());
    formData.append("gstNumber", $("#gstNumber").val());
    formData.append("partyGstType", $("#gstType").val());
    formData.append("customerType", $("#customerType").val());
    formData.append("openingBalance", $("#openingBalance").val());
    formData.append("address1", $("#address1").val());
    formData.append("address2", $("#address2").val() || "");
    formData.append("stateId", $("#customerState").val());
    formData.append("cityId", $("#customerCity").val());
    formData.append("pincode", $("#pincode").val());
    formData.append("email", $("#email").val());
    formData.append("mobile", $("#mobile").val());
    formData.append("phone", $("#phone").val());
    formData.append("customerCountry", $("#customerCountry").val());
    formData.append("customerCityName", $("#customerCity option:selected").text());
    formData.append("zone", $("#zone").val());

    /* ---------- Aadhaar fields ---------- */
    var aadharInput = $("#aadharNumber");
    var aadharNo = aadharInput.val().trim();
    //var isReadonly = aadharInput.prop("readonly");

    formData.append("aadharno", aadharNo !== "" ? aadharNo : "");

    var fileInput = document.getElementById("aadhaarPhoto");
    var file = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;

    /*if (aadharNo !== "" && !file) {
        alert("Please upload Aadhaar file when Aadhaar number is entered.");
        $('#mainModal').closeModal();
        return;
    }*/

    // Validate Aadhaar length only when editable
    if (aadharNo !== "" && !/^\d{12}$/.test(aadharNo)) {
        alert("Aadhaar Number must be exactly 12 digits");
        $('#mainModal').closeModal();
        return;
    }

    if (file) {
        formData.append("aadharFile", file);
    }

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

function UpdateStaff() {

    $('#mainModal').openModal({ dismissible: false });

    var completeurl = url + "customer-customer/updateStaff";
    var place = "mainModal";
    $("#" + place).html("Loading");

    var formData = new FormData();

    // ---------- Normal fields ----------
    formData.append("staffid", $("#staffid").val());
    formData.append("name", $("#name").val());
    formData.append("designation_id", $("#StaffDesignation").val());
    formData.append("mobile", $("#mobile").val());

    var aadharInput = $("#aadharno");
    var aadharNo = aadharInput.val().trim();
    //var isReadonly = aadharInput.prop("readonly");

    formData.append("aadharno", aadharNo !== "" ? aadharNo : "");

    formData.append("address1", $("#address1").val());
    formData.append("address2", $("#address2").val() || "");
    formData.append("pincode", $("#pincode").val());
    formData.append("country_id", $("#customerCountry").val());
    formData.append("state_id", $("#customerState").val());
    formData.append("city_id", $("#customerCity").val());

    // ---------- Aadhaar file logic ----------
    var fileInput = document.getElementById("aadhaarPhoto");
    var file = fileInput && fileInput.files.length > 0 ? fileInput.files[0] : null;
   
    /*if (aadharNo !== "" && !file) {
        alert("Please upload Aadhaar file when Aadhaar number is entered.");
        $('#mainModal').closeModal();
        return;
    }*/
    
    // Validate Aadhaar length only when editable
    if (aadharNo !== "" && !/^\d{12}$/.test(aadharNo)) {
        alert("Aadhaar Number must be exactly 12 digits");
        $('#mainModal').closeModal();
        return;
    }

    if (file) {
        formData.append("aadharFile", file);
    }

    // ---------- AJAX ----------
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


function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'customer-customer/editCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}


function loadStateByCountryEdit() {
    var place = "loadState";
    var countryId = $("#customerCountry").val();
    var selectedValue = $("#customerStateSelectedInitial").val();
    var data = {countryId: countryId,
        selectedValue: selectedValue,
        editflag: 1};
    requesturl = url + 'global-location/getStateByCountryEdit';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}


function loadCityByStateEdit() {
    var place = "loadCity";
    var stateId = $("#customerState").val();
    var selectedValue = $("#customerCitySelectedInitial").val();
    var data = {stateId: stateId,
        selectedValue: selectedValue};
    requesturl = url + 'global-location/getCity';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
//Load shippment state
function loadStateByShippmentCountryEdit() {
    var place = "loadShippmentState"
    var countryId = $("#customerCountry").val();
    var selectedValue = $("#shippmentcustomerStateSelectedInitial").val();
    var data = {countryId: countryId,
        selectedValue: selectedValue,
        editflag: 1};
    requesturl = url + 'global-location/getStateShipment';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadCityByShippmentStateEdit() {
    var place = "loadShippmentCity"
    var stateId = $("#customerState").val();
    var selectedValue = $("#shippmentcustomerCitySelectedInitial").val();
    var data = {stateId: stateId,
        selectedValue: selectedValue};
    requesturl = url + 'global-location/getCityShipment';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function updateCustomerShipment() {
    event.preventDefault();
    var customerId = $("#customerName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/updateCustomerShipment";
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
                customerId: customerId
            });
    posting.done(function(data) {
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
function updateGoldCustomer() {
    event.preventDefault();
    //var customerId = $("#customerName").val();
    $('#mainModal').openModal({dismissible: false});
    var completeurl = url + "customer-customer/updateGoldCustomer";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                name: $("#name").val(),
                mobile: $("#mobile").val(),
                address1: $("#address1").val(),
                townName: $("#townName").val(),
                panNumber: $("#panNumber").val(),
                aadharNumber: $("#aadharNumber").val(),
                customerId: $("#customerId").val()
            });
    posting.done(function(data) {
        $("#name").val("");
        $("#" + place).html(data);
    });
}
function closeGoldMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'customer-customer/editGoldCustomerForm';
    loader();
    ajaxload('GET', requesturl, '', processor);
}