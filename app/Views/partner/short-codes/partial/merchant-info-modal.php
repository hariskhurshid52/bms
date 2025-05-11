<div class="modal fade modal-md" id="mdMerchantDetails" tabindex="-1" role="dialog" aria-hidden="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Merchant Details</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="merchantDetailsCnt">
                <div class="d-flex justify-content-center">
                    <div class="spinner-border" role="status"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->section('scripts') ?>
<script>
    $(document).ready(() => {
        $("#merchantDetails").click(() => {
            getMerchantDetails()
        })
    })

    getMerchantDetails = (id) => {
        const merchantId = $("#merchant").val();
        if (!merchantId) {
            showDangerToast("Please select a merchant")
            return
        }
        $('#mdMerchantDetails #merchantDetailsCnt').html(`<div class="d-flex justify-content-center"> <div class="spinner-border" role="status"></div></div>`)
        $('#mdMerchantDetails').modal('show')

        ajaxCall('<?=route_to('shortCode.merchant.content')?>', {
            merchantId
        }).then((response) => {
            $('#mdMerchantDetails #merchantDetailsCnt').html(response.html)
        }).catch(err => {
            console.log(err)
            $('#mdMerchantDetails #merchantDetailsCnt').html(`<div class="d-flex justify-content-center"> <div class="spinner-border" role="status"></div></div>`)
            $('#mdMerchantDetails').modal('hide')
            showDangerToast("Unable to find merchant info")
        })
    }
</script>
<?= $this->endSection() ?>