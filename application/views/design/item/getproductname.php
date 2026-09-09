<div class="input-field col s12 m4">
    <div class="input-group">
        <label for="productName">Sub Product Name</label>
        <div class="sel-wrap">
            <select id="productName" class="floating-label active" data-validation="select" data-content="Please select a Product">
                <option value="" selected >Select Sub Product</option>
                <?php echo itemBlock::getProductName(); ?>
            </select>
            <div class='bar'></div>
        </div>  
    </div>
    <script>
        floatingSelect2('productName');
    </script>
</div>