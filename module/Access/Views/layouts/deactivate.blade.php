<div class="modal fade" id="deactivateModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border border-warning">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">Warning</h5>
            </div>

            <div class="modal-body bg-light-warning">
                <p>Are you sure you want to activate / deactivate this item?</p>
            </div>
            
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelDeactivation" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeactivation">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    function statusUpdate(selectElement, id, url) {
        const $select = $(selectElement);
        const newStatus = $select.val();

        let action = url.replace(':id', id);

        if (newStatus === 'Inactive' || newStatus === 'Active') {
            // Show the modal
            $('#deactivateModal').modal('show');

            // Handle the confirm deactivation
            $('#confirmDeactivation').off('click').on('click', function () {
                // AJAX request to update the status
                $.ajax({
                    url: action,
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data: {
                        is_active: newStatus
                    },
                    success: function (response) {
                        if (response.success) {
                            toastr.success(`Status updated to ${newStatus}`);

                            $('#deactivateModal').modal('hide');

                            $select.data('current_status', newStatus); // Update the current status
                        } 
                    },
                    error: function (xhr) {
                        toastr.error('Failed to update status');
                        console.error(xhr);
                        $select.val($select.data('current_status')); // Revert to the previous value
                    }
                });
            });

            // Handle the cancel deactivation
            $('#cancelDeactivation').off('click').on('click', function () {
                const previousStatus = $select.data('current_status');
                $select.val(previousStatus).trigger('change');
                $('#deactivateModal').modal('hide');
            });

            return; // Prevent further execution until modal input
        }
    }

    $(document).ready(function () {
        $('select.status').each(function () {
            const $select = $(this);
            $select.data('current_status', $select.val());
        });
    });
</script>