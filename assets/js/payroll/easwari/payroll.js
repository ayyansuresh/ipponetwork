    // Define rowcount and rowId globally if not already defined
    let rowcount = 1;
    let rowId = 1;
   
    function floatingSelect2lineStaffdropdown(id) {
        $('#' + id).select2({
            placeholder: 'Select an item',
            ajax: {
                url: url + 'customer-customer/getallStaffDetails',
                dataType: 'json',
                processResults: function (data) {
                    if (data) {
                        console.log(';fnfsinsfh',data);
                        return {
                            results: $.map(data, function (item) {
                                return {
                                    text: item.name,
                                    id: item.id
                                };
                            })
                        };
                    }
                },
                cache: true
            }
        });
    }
     function loadDesignationDetail()
    {
        var completeurl = url + 'customer-customer/getallDesignationDetails';
        console.log(completeurl);
        var data = "";
        loadedDesignation = ajaxloadwithresponses('POST', completeurl, data);
        console.log(loadedDesignation);
    }
      
  
    function floatingSelect2lineDesignationdropdown(id) {
        $('#' + id).select2({
            placeholder: 'Select an item',
            data:loadedDesignation,
            width: 'resolve',
            allowClear: true
            
        });
    }
    
    function appendDesignationList(id) {
        var select = document.getElementById(id);
        for (var increment = 0; increment < loadedDesignation.length; increment++) {
            var opt = document.createElement('option');
            opt.value = loadedDesignation[increment].id;
            opt.innerHTML = loadedDesignation[increment].name;
            select.appendChild(opt);
        }
    }


    
    // Event listener for designation dropdown change
//    $(document).on('change', '[id^=linedesignationid]', function () {
//        var rowIndex = parseInt($(this).attr('id').replace('linedesignationid', ''));
//        var selectedValue = $(this).val();
//
//        if (selectedValue !== '0') {
//            addField();
//        }
//    });
    
    function updateTotalAmount() {
        var grandTotal = 0;

        for (var i = 0; i < rowcount; i++) {
            
            if ($("#linetotal" + i).length) {
                var perDaySalary = parseFloat($("#lineperdaysalary" + i).val()) || 0;
                var daysQty = parseFloat($("#linedaysqty" + i).val()) || 0;
                var lineTotal = perDaySalary * daysQty;
                $("#linetotal" + i).val(lineTotal.toFixed(2));
                grandTotal += lineTotal;
            }
        }

        $("#payrollamount").val(grandTotal.toFixed(2));
    }
    
    
    
    // Function to delete a row with confirmation
    function deleteRow(rowIndex) {
        if (rowcount > 1) {
            if (confirm("Are you sure you want to delete this row?")) {
                // Destroy Select2 instance to prevent memory leaks
                $('#linestaffid' + rowIndex).select2('destroy');
                // Remove the row
                $('#barcoderow' + rowIndex).remove();
                rowcount--;
                updateTotalAmount();
                
            }
        } else {
            alert("Cannot delete the last row");
        }
    }


    function loadChangeModeDetails(paymentmode) {
        if (paymentmode == "1") {
            $("#bankdetails").css("display", "none");
            $("#bankdetailsviapayment").css("display", "none");
        } else {
            $("#bankdetails").css("display", "block");
            $("#bankdetailsviapayment").css("display", "block");
        }
    }

    function setrowcount(lastrowindex) {
        rowcount = parseInt(lastrowindex) + 1 ;
        rowId =  parseInt(lastrowindex) + 1 ;
    }

    function getandsetdesignationid(rowindex) {
       var designationid = $("#linedesignationid" + rowindex).val();
        $("#linedesignationidvalue" + rowindex).val(designationid);

        //var selectedValue = $(this).val();
       if (designationid !== '0') {
        addField();
       }
       
    }

    function savepayrollEntry() {

        //event.preventDefault();
        var linedesignationidvalue = $('input[name="linedesignationidvalue[]"]').map(function () {
            return $(this).val();
        }).get();
        console.log("dfsugusf",linedesignationidvalue)
        var lineperdaysalary = $('input[name="lineperdaysalary[]"]').map(function () {
            return $(this).val();
        }).get();
        var linedaysqty = $('input[name="linedaysqty[]"]').map(function () {
            return $(this).val();
        }).get();
        var linetotal = $('input[name="linetotal[]"]').map(function () {
            return $(this).val();
        }).get();
        var linedescription = $('input[name="linedescription[]"]').map(function () {
            return $(this).val();
        }).get();

        $('#mainModal').openModal({dismissible: false});
        var completeurl = url + "sales-salesmalleswara/makepayrollEntry";
        var place = "mainModal";
        $("#" + place).html("Loading");
        var posting = $.post(completeurl,
            {
                linedesignationidvalues: linedesignationidvalue,
                lineperdaysalarys: lineperdaysalary,
                linedaysqtys: linedaysqty,
                linetotals: linetotal,
                linedescriptions: linedescription,
                payrolldate: $("#payrolldate").val(),
                paymentDate : $("#payrolldate").val(),
                customername: $("#customerName").val(),
                staffName : $("#staffName").val(),
                payrollamount: $("#payrollamount").val(),
                paymentPaidAmount :  $("#payrollamount").val(),
                payrolldescription: $("#payrolldescription").val(),
                paymentMode  : $("#paymentMode").val(),
                paymentBank  : $("#paymentBank").val(),
                paymentviamode  : $("#paymentviamode").val(),
                paymentDescription : $("#payrolldescription").val()
            });
        posting.done(function (data) {
            $("#" + place).html(data);
            var rows = document.querySelectorAll('#myTable tr.normalhighlight');
            rowcount = rows.length;
            rowId = rowcount;
        });
    }

    function addField() {
        console.log("Called AddField");
        var noofrows = 0;

        // Validate existing rows
        for (var i = 0; i < rowcount; i++) {
            if ($("#linestaffid" + i).length && $("#linestaffid" + i).val() === "0") {
                $("#linestaffid" + i).focus();
                return false;
            }
            noofrows++;
        }

        var myTable = document.getElementById("myTable");
        var currentIndex = rowcount;
        console.log("currentIndex: "+currentIndex);
        var currentRow = myTable.insertRow(-1);
        currentRow.setAttribute("style", "height:20px; border: 0px solid");
        currentRow.setAttribute("class", "normalhighlight");
        currentRow.setAttribute("id", "barcoderow" + currentIndex);

        // Designation Dropdown
        var designationIDselect = document.createElement("select");
        designationIDselect.setAttribute("name", "linedesignationid[]");
        designationIDselect.setAttribute("id", "linedesignationid" + currentIndex);
        designationIDselect.setAttribute("style", "height:25px; width:100% !important;");
        designationIDselect.setAttribute("data-validation", "select");
        designationIDselect.setAttribute("data-content", "Please Select designation");
        designationIDselect.setAttribute("class", "floating-label active browser-default");
        designationIDselect.setAttribute("tabindex", (currentIndex * 4 + 1).toString());
        var functionname1 = "getandsetdesignationid('" + currentIndex + "')";
        designationIDselect.setAttribute("onchange", functionname1);
        var opt = document.createElement('option');
        opt.value = "0";
        opt.innerHTML = "Select a designation";
        opt.disabled=true;
        opt.selected=true;
        designationIDselect.appendChild(opt);

        // line Designation ID hidden value
        var designationIDvalue = document.createElement("input");
        designationIDvalue.setAttribute("name", "linedesignationidvalue[]");
        designationIDvalue.setAttribute("type", "hidden");
        designationIDvalue.setAttribute("id", "linedesignationidvalue" + currentIndex);
        designationIDvalue.setAttribute("value", "0");

        // line perday salary Input
        var lineperdaysalaryInput = document.createElement("input");
        lineperdaysalaryInput.setAttribute("name", "lineperdaysalary[]");
        lineperdaysalaryInput.setAttribute("type", "text");
        lineperdaysalaryInput.setAttribute("id", "lineperdaysalary" + currentIndex);
        lineperdaysalaryInput.setAttribute("value", "0");
        lineperdaysalaryInput.setAttribute("style", "height:25px; font-size:18px;");
        lineperdaysalaryInput.setAttribute("tabindex", (currentIndex * 4 + 2).toString());
        lineperdaysalaryInput.setAttribute("onchange", "updateTotalAmount()");
        var lineperdaysalaryLabel = document.createElement("label");
        lineperdaysalaryLabel.setAttribute("for", "lineperdaysalary" + currentIndex);
        lineperdaysalaryLabel.setAttribute("class", "active");

        // line daysqty Input
        var linedaysqtyInput = document.createElement("input");
        linedaysqtyInput.setAttribute("name", "linedaysqty[]");
        linedaysqtyInput.setAttribute("type", "text");
        linedaysqtyInput.setAttribute("id", "linedaysqty" + currentIndex);
        linedaysqtyInput.setAttribute("value", "0");
        linedaysqtyInput.setAttribute("style", "height:25px; font-size:18px;");
        linedaysqtyInput.setAttribute("tabindex", (currentIndex * 4 + 3).toString());
        linedaysqtyInput.setAttribute("onchange", "updateTotalAmount()");
        var linedaysqtyLabel = document.createElement("label");
        linedaysqtyLabel.setAttribute("for", "linedaysqty" + currentIndex);
        linedaysqtyLabel.setAttribute("class", "active");

        // line Total Input
        var linetotalInput = document.createElement("input");
        linetotalInput.setAttribute("name", "linetotal[]");
        linetotalInput.setAttribute("type", "text");
        linetotalInput.setAttribute("id", "linetotal" + currentIndex);
        linetotalInput.setAttribute("value", "0");
        linetotalInput.setAttribute("style", "height:25px; font-size:18px;");
        linetotalInput.setAttribute("tabindex", (currentIndex * 4 + 4).toString());
        linetotalInput.setAttribute("onchange", "updateTotalAmount()");
        var linetotalLabel = document.createElement("label");
        linetotalLabel.setAttribute("for", "linetotal" + currentIndex);
        linetotalLabel.setAttribute("class", "active");

        // Description Input
        var descriptionInput = document.createElement("input");
        descriptionInput.setAttribute("name", "linedescription[]");
        descriptionInput.setAttribute("type", "text");
        descriptionInput.setAttribute("id", "linedescription" + currentIndex);
        descriptionInput.setAttribute("value", "");
        descriptionInput.setAttribute("style", "height:25px; font-size:18px;");
        descriptionInput.setAttribute("tabindex", (currentIndex * 4 + 5).toString());
        var descriptionLabel = document.createElement("label");
        descriptionLabel.setAttribute("for", "linedescription" + currentIndex);
        descriptionLabel.setAttribute("class", "active");

        // Delete Button
        var deleteButton = document.createElement("button");
        deleteButton.setAttribute("type", "button");
        deleteButton.setAttribute("class", "btn red");
        deleteButton.setAttribute("style", "height:25px; line-height:25px; padding:0 10px;");
        deleteButton.setAttribute("onclick", "deleteRow(" + currentIndex + ")");
        deleteButton.innerHTML = "Delete";

        // Create table cells
        var celldesignation = currentRow.insertCell(-1);
        celldesignation.setAttribute('class', 'input-field');
        var desginationDiv = document.createElement("div");
        desginationDiv.setAttribute("style", "height:25px;");
        desginationDiv.setAttribute("class", "sel-wrap");
        desginationDiv.appendChild(designationIDselect);
        desginationDiv.appendChild(designationIDvalue);
        var barDiv = document.createElement("div");
        barDiv.setAttribute("class", "bar");
        desginationDiv.appendChild(barDiv);
        celldesignation.appendChild(desginationDiv);

        var cellPerDaysalary = currentRow.insertCell(-1);
        cellPerDaysalary.setAttribute('class', 'input-field');
        cellPerDaysalary.appendChild(lineperdaysalaryInput);
        cellPerDaysalary.appendChild(lineperdaysalaryLabel);

        var cellDaysCount = currentRow.insertCell(-1);
        cellDaysCount.setAttribute('class', 'input-field');
        cellDaysCount.appendChild(linedaysqtyInput);
        cellDaysCount.appendChild(linedaysqtyLabel);

        var cellTotal = currentRow.insertCell(-1);
        cellTotal.setAttribute('class', 'input-field');
        cellTotal.appendChild(linetotalInput);
        cellTotal.appendChild(linetotalLabel);

        var cellDescription = currentRow.insertCell(-1);
        cellDescription.setAttribute('class', 'input-field');
        cellDescription.appendChild(descriptionInput);
        cellDescription.appendChild(descriptionLabel);

        var cellDelete = currentRow.insertCell(-1);
        cellDelete.setAttribute('class', 'input-field');
        cellDelete.appendChild(deleteButton);

        // Initialize Select2 for the new dropdown
        setTimeout(function() {
            var previousindex = currentIndex - 1;
            appendDesignationList('linedesignationid'+ currentIndex);
            floatingSelect2('linedesignationid'+ currentIndex);
            //floatingSelect2lineDesignationdropdown('linedesignationid' + currentIndex);
            $('#lineperdaysalary' + previousindex).focus(); 
            $('#lineperdaysalary' + previousindex).select();
            updateTotalAmount();
        }, 100);

        rowcount++;
        rowId++;
    }

    function updatepayrollEntry() {

            //event.preventDefault();
            var linedesignationidvalue = $('input[name="linedesignationidvalue[]"]').map(function () {
                return $(this).val();
            }).get();
            console.log("dfsugusf",linedesignationidvalue)
            var lineperdaysalary = $('input[name="lineperdaysalary[]"]').map(function () {
                return $(this).val();
            }).get();
            var linedaysqty = $('input[name="linedaysqty[]"]').map(function () {
                return $(this).val();
            }).get();
            var linetotal = $('input[name="linetotal[]"]').map(function () {
                return $(this).val();
            }).get();
            var linedescription = $('input[name="linedescription[]"]').map(function () {
                return $(this).val();
            }).get();
            var paymentmode = $("#paymentMode").val();
            var paymentbank = $("#paymentBank").val();
            $('#mainModal').openModal({dismissible: false});
            var completeurl = url + "sales-salesmalleswara/updatepayrollEntry";
            var place = "mainModal";
            $("#" + place).html("Loading");
            var posting = $.post(completeurl,
                {
                    payrollid : $("#payrollid").val(),
                    expenseid :  $("#expenseid").val(),
                    linedesignationidvalues: linedesignationidvalue,
                    lineperdaysalarys: lineperdaysalary,
                    linedaysqtys: linedaysqty,
                    linetotals: linetotal,
                    linedescriptions: linedescription,
                    payrolldate: $("#payrolldate").val(),
                    paymentDate : $("#payrolldate").val(),
                    customername: $("#customerName").val(),
                    staffName : $("#staffName").val(),
                    payrollamount: $("#payrollamount").val(),
                    paymentPaidAmount :  $("#payrollamount").val(),
                    payrolldescription: $("#payrolldescription").val(),
                    paymentMode  : paymentmode,
                    paymentBank  : paymentbank,
                    paymentviamode  : $("#paymentviamode").val(),
                    paymentDescription : $("#payrolldescription").val()
                });
            posting.done(function (data) {
                $("#" + place).html(data);
                var rows = document.querySelectorAll('#myTable tr.normalhighlight');
                rowcount = rows.length;
                rowId = rowcount;
            });
        }
    