<div class="input-group">
    <label for="productType">Product Type Name</label>
    <div class="sel-wrap">
        <select id="productType" class="floating-label active"
                data-validation="select" data-content="Select Product Type"
                >
            <option value="" disable selected>Select Product Type</option>
            <?php echo itemBlock::getProductTypeName(); ?>
        </select>
        <div class='bar'></div>
    </div>  
</div>
<script>
    floatingSelect2('productType');
</script>
