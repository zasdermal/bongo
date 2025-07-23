<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete/cancel this item?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-danger btn-confirm-delete">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    function destroy(id, url) {
        $('#deleteConfirmationModal').modal('show');

        let action = url.replace(':id', id);

        $('.btn-confirm-delete').off('click').on('click', function () {
            const button = $(this);
            button.prop('disabled', true).html(
                '<span class="spinner-border spinner-border-sm align-middle me-2"></span>Deleting...'
            );

            $.ajax({
                url: action,
                method: 'GET',
                success: function (data) {
                    toastr.success(data.message);

                    $('#deleteConfirmationModal').modal('hide');

                    setTimeout(() => {
                        location.reload();
                    }, 1500);
                },
                error: function (xhr) {
                    toastr.error('Failed to delete item');
                    console.error(xhr);
                }
            });
        });
    }
</script>