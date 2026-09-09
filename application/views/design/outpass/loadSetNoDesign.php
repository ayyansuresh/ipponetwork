<div class="input-field col s12 m12">
                        <div class="input-group">
                            <label for="setNo" class="active">Set No</label>
                            <div class="sel-wrap">
                                <select id="setNo" class="floating-label active"  >
                                    <option value="" selected >Select Set No</option>
                                    <?php echo outpassBlock::getCompletedWeavingSetNo(""); ?>
                                </select>
                                <div class='bar'></div>
                            </div>  
                        </div>
                        <script>
                            floatingSelect2('setNo');
                            // $("#customerName").val("1").trigger("change");
                        </script>
</div>

