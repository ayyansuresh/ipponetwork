var processor = "beeprocessor";
function loadCityByState() {
    var place = "loadCity"
    var stateId = $("#customerState").val();
    var selectedValue = 1611;
    var data = {stateId: stateId,
        selectedValue: selectedValue,
        editflag: 0
    };
    requesturl = url + 'global-location/getCity';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadStateByCountry() {
    var place = "loadState"
    var countryId = $("#customerCountry").val();
    var selectedValue = 31;
    var data = {countryId: countryId,
        selectedValue: selectedValue
    };
    requesturl = url + 'global-location/getState';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}


function setNewDayRate() {
    $('#newDayRatePopup').openModal({dismissible: false});
    var place = "newDayRatePopupModal"
    var commodityRefId = $('input[name="commodityRefId[]"]').map(function () {
        return $(this).val();
    }).get(); 
    var commodityAmount = $('input[name="commodityAmount[]"]').map(function () {
        return $(this).val();
    }).get(); 
    var data = {
        commodityRefId: commodityRefId,
        commodityAmount: commodityAmount
    };
    requesturl = url + 'item-item/addDayRate';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
//For Shipping address
function loadStateByShippmentCountry() {
    var place = "loadShippmentState"
    var ShippmentCountryId = $("#shippmentcustomerCountry").val();
    var selectedValue = "31";
    var data = {countryId: ShippmentCountryId,
        selectedValue: selectedValue
    };
    requesturl = url + 'global-location/getStateShipment';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
function loadCityByShippmentState() {
    
    var place = "loadShippmentCity"
    var ShippmentStateId = $("#shippmentcustomerState").val();
    var selectedValue = "";
    var data = {stateId: ShippmentStateId,
        selectedValue: selectedValue,
        editflag: 0
    };
    requesturl = url + 'global-location/getCityShipment';
    loaderInline(place);
    ajaxload('GET', requesturl, data, place);
}
