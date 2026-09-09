function loadBankAccountDetails()
{
    var requesturl = url + 'bankAccount-bankAccount/loadBankAccountDetails';
    var accountRefId = $("#bankName").val();
    var data = "accountRefId=" + accountRefId;
    $("#loadBankAccountDetails").html('<div style="text-align:center;padding:0% 0%;"><img style="width:100px;" src="' + url + 'assets/img/loading.gif"/><br/><label>Please Wait...</label></div>');
    ajaxload('GET', requesturl, data, 'loadBankAccountDetails');
}
function addBankAccount() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    //bankAccountTypeName = $('#bankAccountType option:selected').text();
    var completeurl = url + "bankAccount-bankAccount/addBankAccount";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                accountType: $("#accountType").val(),
                accountName: $("#accountName").val(),
                accountNumber: $("#accountNumber").val(),
                accountBankAccountType: $("#bankAccountType").val(),
                bankAccountTypeName: $("#bankAccountType").val(),
                accountIfsCode: $("#ifscCode").val(),
                openingBalance: $("#openingBalance").val()
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function closeMainModal() {
    $('#mainModal').closeModal();
    requesturl = url + 'bankAccount-bankAccount/loadAddAccount';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function updateBankAccount() {
    event.preventDefault();
    $('#mainModal').openModal({dismissible: false});
    updateOpeningBalance = $("#updateOpeningBalance").val();
    accountOpeningBalance = $("#updateAccountOpeningBalance").val();
    accountTrialBalance = $("#updateAccountTrialBalance").val();
    accountCloseBalance = $("#updateAccountCloseBalance").val();
    updateBankAccountTypeName = $('#updateBankAccountType').val();
    var completeurl = url + "bankAccount-bankAccount/updateBankAccount";
    var place = "mainModal";
    $("#" + place).html("Loading");
    var posting = $.get(completeurl,
            {
                updateAccountType: $("#updateAccountType").val(),
                updateAccountName: $("#updateAccountName").val(),
                updateAccountNumber: $("#updateAccountNumber").val(),
                updateBankAccountType: $("#updateBankAccountType").val(),
                updateBankAccountTypeName: updateBankAccountTypeName,
                updateIfscCode: $("#updateIfscCode").val(),
                updateAccountRefId: $("#updateAccountRefId").val(),
                accountOpeningBalance: accountOpeningBalance,
                accountTrialBalance: accountTrialBalance,
                accountCloseBalance: accountCloseBalance,
                updateOpeningBalance: updateOpeningBalance
            });
    posting.done(function(data) {
        $("#" + place).html(data);
    });
}
function closeMainModalUpdate() {
    $('#mainModal').closeModal();
    requesturl = url + 'bankAccount-bankAccount/loadUpdateAccount';
    loader();
    ajaxload('GET', requesturl, '', processor);
}
function printBankAccountReport()
{
    var completeurl = url + 'bankAccount-bankAccount/addbankAccountReport';
    window.open(completeurl);
}