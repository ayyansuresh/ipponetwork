<div class="modal-content">
    <div class="row">
        <div class="col s12 m12 l12">
            <div class="card-panel">
                <h4 class="header2">FAIL MESSAGE</h4>
                <div class="row">
                    <form class="col s12">
                        <h4><label>STOCK TRANSFER DELETE FAILED</label></h4>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer green lighten-4">
    <button  class="waves-effect waves-red btn-flat modal-action" onclick="closeModal();">Close</button>
</div>
<script>
    function closeModal() {
        $('#StockTransferEntryDeletePopup').closeModal();
    }
</script>