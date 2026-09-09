<?php
$advancePayment = generalhelper::getGetElement('advancePayment'); ?>
    <div class="input-field col s12 m12">
        <div class="input-group">
            <i class="mdi-action-event prefix"></i>
               <input id="dueDate" type="date" class="datepicker" data-validation="date" data-content="Date cannot be empty"
                    value="<?php echo date('Y-m-d'); ?>">
                <input id="billUpdateFlag" type="hidden"  value="0">
                <label for="dueDate" class="active">Due Date</label>
        </div>
    </div>


