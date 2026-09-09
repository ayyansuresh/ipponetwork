var url = "http://127.0.0.1/ipponetwork/";
// var url = "http://35.154.95.158/mahilchi/";


function ajaxload(method, url, data, place)
{
    $.ajax({
        type: method,
        url: url,
        data: data,
        cache: false,
        success: function (result) {
            console.log("resultresult"+result)
            $("#" + place).html(result);
        }});
}

/*function ajaxloadwithmessage(method, url, data, place)
 {
 $.ajax({
 type: method,
 url: url,
 data: data,
 cache: false,
 success: function (result) {
 $("#ReturnMessage").html(result);
 $("#ReturnMessage").attr("hidden=true");
 $("#" + place).html("");
 }});
 }
 */

function loadDataTable(id) {
    $('#' + id).dataTable({"pageLength": 5});
}
function ajaxloadwithresponsesnonjson(type, completeurl, data) {
    console.log("test");
    console.log(data);
    var responsemessage = $.ajax({
        type: type,
        url: completeurl,
        data: data,
        async: false
    }).responseText;
    return responsemessage;
}
function ajaxloadwithresponses(type, completeurl, data) {
    var responsemessage = $.ajax({
        type: type,
        url: completeurl,
        data: data,
        async: false
    }).responseText;
    if (responsemessage)
        return $.parseJSON(responsemessage);
}

$(function () {
    $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).stop(true, true).fadeIn("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");
            },
            function () {
                $('.dropdown-menu', this).stop(true, true).fadeOut("fast");
                $(this).toggleClass('open');
                $('b', this).toggleClass("caret caret-up");
            });
});
function loadMulitpleProductCateogry() {
    $('#productCategory').multiselect({
        includeSelectAllOption: true
    });
}

function getLoginDetails()
{
    /*var userid = document.forms["myForm"]["userid"].value;
     var password = document.forms["myForm"]["password"].value;
     var company = document.forms["myForm"]["company"].value;*/
    var userid = $("#username").val();
    //alert(userid);
    var password = $("#password").val();
    var firmId = $("#firmName").val();
    var firmName = $("#firmName option:selected").text();
    var accountingYearId = $("#accountingYear").val();
    var accountingYearName = $("#accountingYear  option:selected").text();
    if (userid == "") {
        alert("Enter the User Name");
        return false;
    }
    if (password == "") {
        alert("Enter the Password");
        return false;
    }
    if (firmId == "") {
        alert("Select the Firm");
        return false;
    }
    if (accountingYearId == "") {
        alert("Select the accounting Year");
        return false;
    }
    var data = "userid=" + userid +
            "&password=" + password +
            "&firmId=" + firmId +
            "&firmName=" + firmName +
            "&accountingYearId=" + accountingYearId +
            "&accountingYearName=" + accountingYearName;
    var completeurl = url + 'dashboard-dashboard/loginvalidation';
    $("#loadLogin").html('<center><img class="circle responsive-img valign profile-image-login" src="' + url + 'assets/img/loading.gif"/>');
    ajaxload('POST', completeurl, data, 'loadLogin');
}

function validateForm() {
    var username = document.forms["myForm"]["username"].value;
    var password = document.forms["myForm"]["password"].value;
    if (username == null || username == "") {
        alert("User Name must be filled out");
        document.myForm.username.focus();
        return false;
    }
    if (password == null || password == "") {
        alert("Password must be filled out");
        document.myForm.password.focus();
        return false;
    }

}

function scrollDown(loadBillEntry)
{
    $('html,body').animate({
        scrollTop: $("#" + loadBillEntry).offset().top},
            'slow');
}

function clickScrollDown(classname, id) {
    $("." + classname).click(function () {
        $('html,body').animate({
            scrollTop: $("#" + id).offset().top},
                'slow');
    });
}

$(".allownumericwithoutdecimal").on("keypress keyup blur", function (event) {
    $(this).val($(this).val().replace(/[^\d].+/, ""));
    if ((event.which < 48 || event.which > 57)) {
        event.preventDefault();
    }
});
function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode == 46) {
        return true;
    } else if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    } else {
        return true;
    }
}

function isTextKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 32)
    {
        return true;
    } else {
        return false;
    }
}
function isText(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
    {
        return false;
    }
    return true;
}
function loadselectDropdown(id) {
    $("." + id).attr("data-placeholder", "Please Select");
    $("." + id).select2();
}
function placeholderLot(id) {
    $("#" + id).attr("data-placeholder", "Please Select");
    $("#" + id).select2();
}
function loadmultipleDropdown(id) {
    $("#" + id).select2();
}
function loadParticularDate(id) {
    $("#" + id).Zebra_DatePicker({
        direction: [false, 30],
        format: 'Y-m-d'
    });
}
function loadDate(id) {
    $("#" + id).Zebra_DatePicker({
        format: 'Y-m-d'
    });
}
function loadDateByClass(id) {
    $("." + id).Zebra_DatePicker();
}
function loadParticularDateByClass(id) {
    $("." + id).Zebra_DatePicker({
        direction: [false, 30],
        format: 'Y-m-d'
    });
}

function loadCurrentDate(id) {
    $("#" + id).Zebra_DatePicker({
        direction: [false, 3],
        format: 'Y-m-d'
    });
}
function loadBillDate(id) {
    $("#" + id).Zebra_DatePicker({
        direction: [false, 30],
        format: 'Y-m-d'
    });
}
function validateFloatvalue() {
    $(".validateFloatvalue").on('keypress', function (event) {
        if (event.which >= 90 || event.which < 48 ||
                (event.which > 57 && event.which < 65) ||
                (event.which > 90 && event.which < 97) ||
                (event.which > 122 && event.which < 190)) {
            if (event.which !== 46)
                event.preventDefault();
        }
    });
}
function validateInteger() {
    $(".validateInteger").on('keypress', function (event) {
        if (event.which >= 90 || event.which < 48 ||
                (event.which > 57 && event.which < 65) ||
                (event.which > 90 && event.which < 97) ||
                (event.which > 122 && event.which < 190)) {
            // if(event.which !==46)
            event.preventDefault();
        }
    });
}
function loadPurchasetDropdown(id) {
    $("#" + id).attr("data-placeholder", "Please Select");
    $("#" + id).select2();
}
function readURL(input, count) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#blah' + count)
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
    $("#blah" + count).show();
}
function imagePopup(count)
{
    // Get the modal
    var modal = document.getElementById('myModal');
// Get the image and insert it inside the modal - use its "alt" text as a caption
    var img = document.getElementById('blah' + count);
    var modalImg = document.getElementById("img01");
    var captionText = document.getElementById("caption");
    img.onclick = function () {
        modal.style.display = "block";
        modalImg.src = this.src;
        captionText.innerHTML = this.alt;
    }
}
function imagePopupClose()
{
    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];
    var modal = document.getElementById('myModal');
// When the user clicks on <span> (x), close the modal
    span.onclick = function () {
        modal.style.display = "none";
    }
}
function loaderInline(place) {
    $("#" + place).html('Loadings');
}

function floatingSelect2(id) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true,
    })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('.focus').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    // $selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        //console.log("test");
    });
}
function floatingSelect2Change(id, functionName) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    //$selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        window[functionName]();
    });
}
function billTypeLoad() {
    var normalcustomerdisplay = "none";
    var villagecustomerdisplay = "none";
    if ($("#billType").val() === "3") {
        normalcustomerdisplay = "none";
        villagecustomerdisplay = "block";
        // $("#customerName").val("1").trigger("change");
        $("#barcodeId0").focus();
    } else
    {

        normalcustomerdisplay = "block";
        villagecustomerdisplay = "none";
    }
    $('#normalCustomer').css('display', normalcustomerdisplay);
    $('#villageCustomer').css('display', villagecustomerdisplay);
}

function loadPurchaseBill() {
    var place = "loadPurchaseBill";
    var customerId = $("#customerNameSearch").val();
    var data = {customerId: customerId};
    requesturl = url + 'purchase-purchase/getBill';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function floatingSelect2ChangePurchase(id, functionName) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    //$selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        window[functionName]();
    });
}

function floatingSelect2WithFocus(id, id1) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                var select2 = $('#' + id1).data('select2');
                $("#" + id1).val('').trigger("change");
                select2.open();
                $("#" + id1).val(null).trigger("change");
            })

            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                var select2 = $('#' + id1).data('select2');
                $("#" + id1).val('').trigger("change");
                select2.open();
                $("#" + id1).val(null).trigger("change");
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
        var select21 = $('#' + id).data('select2');
        select21.open();


    });

}

function floatingSelect2WithFocusText(id, id1) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#' + id1).focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#' + id1).focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
}

function floatingSelect2ChangeWithoutFocus(id, functionName) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    //$selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        window[functionName]();
    });
}
function loadPurchaseBillGoldCustomerByType() {
    var place = "loadCustomerByType";
    var customerType = $("#customerTypeSearch").val();
    var selectedValue = "";
    var data = {customerType: customerType,
        selectedValue: selectedValue
    };
    requesturl = url + 'goldPurchase-purchase/getPurchaseCustomerBytype';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadPurchaseBillGoldRegular() {
    var place = "loadPurchaseBill";
    var customerId = $("#customerNameSearch").val();
    var data = {customerId: customerId};
    requesturl = url + 'goldPurchase-purchase/getBillGoldRegular';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadPurchaseBillGoldRetail() {
    var place = "loadPurchaseBill";
    var customerId = $("#customerNameSearch").val();
    var data = {customerId: customerId};
    requesturl = url + 'goldPurchase-purchase/loadPurchaseBillGoldRetail';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function billTypeLoadGold() {
    var normalcustomerdisplay = "none";
    var villagecustomerdisplay = "none";
    if ($("#billType").val() === "3") {
        normalcustomerdisplay = "none";
        villagecustomerdisplay = "block";
        //$("#villagecustomerName").val("");
        // $("#customerName").val("1").trigger("change");
    } else
    {
        normalcustomerdisplay = "block";
        villagecustomerdisplay = "none";
        $("#villagecustomerName").val("0");
    }
    $('#normalCustomer').css('display', normalcustomerdisplay);
    $('#villageCustomer').css('display', villagecustomerdisplay);
}
function billTypeLoadNewGold() {
    var normalcustomerdisplay = "none";
    var villagecustomerdisplay = "none";
    if ($("#billType").val() === "3") {
        normalcustomerdisplay = "none";
        villagecustomerdisplay = "block";
        $("#customerName").val("").trigger("change");
        $("#villagecustomerName").val("").trigger("change");
        $("#mobileNumber").val("").trigger("change");
        $("#villagecustomerAddress").val("").trigger("change");
        $("#villagecustomerCity").val("").trigger("change");
        $("#transportName").val("").trigger("change");
        $("#aadharNumber").val("").trigger("change");

    } else
    {
        normalcustomerdisplay = "block";
        villagecustomerdisplay = "none";
        $("#mobileNumberBill").val("").trigger("change");
        $("#villagecustomerAddressBill").val("").trigger("change");
        $("#villagecustomerCityBill").val("").trigger("change");
        $("#transportNameBill").val("").trigger("change");
        $("#aadharNumberBill").val("").trigger("change");
    }
    $('#normalCustomer').css('display', normalcustomerdisplay);
    $('#loadCustomer').css('display', normalcustomerdisplay);
    $('#villageCustomer').css('display', villagecustomerdisplay);
}
function billTypeLoadUpdate() {
    var normalcustomerdisplay = "none";
    var villagecustomerdisplay = "none";
    if ($("#billType").val() === "3") {
        normalcustomerdisplay = "none";
        villagecustomerdisplay = "block";
        //$("#customerName").val("").trigger("change");
        //$("#villagecustomerName").val("").trigger("change");
        //$("#mobileNumber").val("").trigger("change");
        //$("#villagecustomerAddress").val("").trigger("change");
        //$("#villagecustomerCity").val("").trigger("change");
        //$("#transportName").val("").trigger("change");
        //$("#aadharNumber").val("").trigger("change");

    } else
    {
        normalcustomerdisplay = "block";
        villagecustomerdisplay = "none";
        $("#mobileNumberBill").val("").trigger("change");
        $("#villagecustomerAddressBill").val("").trigger("change");
        $("#villagecustomerCityBill").val("").trigger("change");
        $("#transportNameBill").val("").trigger("change");
        $("#aadharNumberBill").val("").trigger("change");
    }
    $('#normalCustomer').css('display', normalcustomerdisplay);
    $('#loadCustomer').css('display', normalcustomerdisplay);
    $('#villageCustomer').css('display', villagecustomerdisplay);
}

function readIMGURL1(input, rowcount) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#firstRowImage' + rowcount)
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURL2(input, rowcount) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#secondRowImage' + rowcount)
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURL3(input, rowcount) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#thirdRowImage' + rowcount)
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURL4(input, rowcount) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#fourthRowImage' + rowcount)
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURLSAMPLE1(input) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#sampleImg1')
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURLSAMPLE2(input) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#sampleImg2')
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURLSAMPLE3(input) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#sampleImg3')
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function readIMGURLSAMPLE4(input) {
    files = event.target.files;
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#sampleImg4')
                    .attr('src', e.target.result)
                    .width(50)

        };
        reader.readAsDataURL(input.files[0]);
    }
}
function floatingSelect2Changewithparameter(id, functionName, parameter) {
    var $selectbox = $('#' + id).select2({
        placeholder: "",
        allowClear: true
    })
            .on('select2:open', function () {
                var container = $('.select2-dropdown--below');
                container.css('top', 'auto');
                container.css('left', 'auto');
                container.css('width', '502px');
            })
            .on('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .keypress('select2:select', function () {
                $('label[for="' + id + '"]').addClass('filled active');
                $('#unitRate').focus();
            })
            .on('select2:unselect', function () {
                $('label[for="' + id + '"]').removeClass('filled');
            });
    $selectbox.on('blur', function () {
        $('label[for="' + id + '"]').removeClass('active');
    });
    //$selectbox.val("").trigger("change");
    $("#" + id).on("change", function () {
        window[functionName](parameter);
    });
}