<div class="input-field col s12 m4" id="loadItemDetail">
    <div class="input-group">
        <label for="itemTypeId">Main Product Name</label>
        <div class="sel-wrap">

            <select id="itemTypeId" class="floating-label">

                <option value="" disabled selected>Select Main Product Name</option>

                <?php echo stockBlock::getItemNameDetail(); ?> 

            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('itemTypeId');
    </script>
</div>