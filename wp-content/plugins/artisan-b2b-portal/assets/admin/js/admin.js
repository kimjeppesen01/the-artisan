/**
 * Artisan B2B Portal - Admin JavaScript
 */

(function($) {
    'use strict';

    const AB2B_Admin = {

        init: function() {
            this.bindEvents();
            this.initMediaUploader();
            this.initWeightsTable();
        },

        bindEvents: function() {
            // Delete item
            $(document).on('click', '.ab2b-delete-item', this.deleteItem);

            // Send portal link
            $(document).on('click', '.ab2b-send-link', this.sendPortalLink);

            // Regenerate access key
            $(document).on('click', '.ab2b-regenerate-key', this.regenerateKey);

            // Copy URL
            $(document).on('click', '.ab2b-copy-url', this.copyUrl);

            // Update order status
            $(document).on('click', '.ab2b-update-status', this.updateOrderStatus);

            // Save admin notes
            $(document).on('click', '.ab2b-save-notes', this.saveAdminNotes);
        },

        /**
         * Initialize Media Uploader for images
         */
        initMediaUploader: function() {
            var mediaFrame;

            $(document).on('click', '.ab2b-upload-image', function(e) {
                e.preventDefault();

                var $container = $(this).closest('.ab2b-image-upload');
                var $input = $container.find('input[type="hidden"]');
                var $preview = $container.find('.ab2b-image-preview');
                var $removeBtn = $container.find('.ab2b-remove-image');

                if (mediaFrame) {
                    mediaFrame.open();
                    return;
                }

                mediaFrame = wp.media({
                    title: 'Select Image',
                    button: { text: 'Use Image' },
                    multiple: false
                });

                mediaFrame.on('select', function() {
                    var attachment = mediaFrame.state().get('selection').first().toJSON();
                    $input.val(attachment.id);
                    $preview.html('<img src="' + (attachment.sizes.medium ? attachment.sizes.medium.url : attachment.url) + '">');
                    $removeBtn.show();
                });

                mediaFrame.open();
            });

            $(document).on('click', '.ab2b-remove-image', function(e) {
                e.preventDefault();

                var $container = $(this).closest('.ab2b-image-upload');
                var $input = $container.find('input[type="hidden"]');
                var $preview = $container.find('.ab2b-image-preview');

                $input.val('0');
                $preview.html('<span class="ab2b-no-image-placeholder">No image selected</span>');
                $(this).hide();
            });
        },

        /**
         * Initialize Weights Table
         */
        initWeightsTable: function() {
            var weightIndex = $('#weights-body tr').length;

            // Add new weight row
            $(document).on('click', '#add-weight', function() {
                var template = $('#weight-row-template').html();
                template = template.replace(/__INDEX__/g, weightIndex);
                $('#weights-body').append(template);
                weightIndex++;
            });

            // Remove weight row
            $(document).on('click', '.ab2b-remove-weight', function() {
                $(this).closest('tr').remove();
            });
        },

        /**
         * Delete Item (customer, product, order)
         */
        deleteItem: function(e) {
            e.preventDefault();

            if (!confirm(ab2b_admin.strings.confirm_delete)) {
                return;
            }

            var $btn = $(this);
            var type = $btn.data('type');
            var id = $btn.data('id');
            var redirect = $btn.data('redirect');

            $btn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_delete_item',
                    nonce: ab2b_admin.nonce,
                    type: type,
                    id: id
                },
                success: function(response) {
                    if (response.success) {
                        if (redirect) {
                            window.location.href = redirect;
                        } else {
                            $btn.closest('tr').fadeOut(function() {
                                $(this).remove();
                            });
                        }
                    } else {
                        alert(response.data.message || ab2b_admin.strings.error);
                        $btn.prop('disabled', false).text('Delete');
                    }
                },
                error: function() {
                    alert(ab2b_admin.strings.error);
                    $btn.prop('disabled', false).text('Delete');
                }
            });
        },

        /**
         * Send Portal Link to Customer
         */
        sendPortalLink: function(e) {
            e.preventDefault();

            var $btn = $(this);
            var customerId = $btn.data('customer-id');
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('Sending...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_send_portal_link',
                    nonce: ab2b_admin.nonce,
                    customer_id: customerId
                },
                success: function(response) {
                    if (response.success) {
                        alert(ab2b_admin.strings.link_sent);
                    } else {
                        alert(response.data.message || ab2b_admin.strings.error);
                    }
                    $btn.prop('disabled', false).text(originalText);
                },
                error: function() {
                    alert(ab2b_admin.strings.error);
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        },

        /**
         * Regenerate Access Key
         */
        regenerateKey: function(e) {
            e.preventDefault();

            if (!confirm('Are you sure? The current link will stop working.')) {
                return;
            }

            var $btn = $(this);
            var customerId = $btn.data('customer-id');
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('Regenerating...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_regenerate_key',
                    nonce: ab2b_admin.nonce,
                    customer_id: customerId
                },
                success: function(response) {
                    if (response.success) {
                        $('#access-key').text(response.data.access_key);
                        $('#portal-url').val(response.data.portal_url);
                        alert(ab2b_admin.strings.key_regenerated);
                    } else {
                        alert(response.data.message || ab2b_admin.strings.error);
                    }
                    $btn.prop('disabled', false).text(originalText);
                },
                error: function() {
                    alert(ab2b_admin.strings.error);
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        },

        /**
         * Copy URL to Clipboard
         */
        copyUrl: function(e) {
            e.preventDefault();

            var target = $(this).data('target');
            var $input = $(target);

            $input.select();
            document.execCommand('copy');

            var $btn = $(this);
            var originalText = $btn.text();
            $btn.text('Copied!');
            setTimeout(function() {
                $btn.text(originalText);
            }, 2000);
        },

        /**
         * Update Order Status
         */
        updateOrderStatus: function(e) {
            e.preventDefault();

            var $btn = $(this);
            var orderId = $btn.data('order-id');
            var status = $('#order-status').val();
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('Updating...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_update_order_status',
                    nonce: ab2b_admin.nonce,
                    order_id: orderId,
                    status: status
                },
                success: function(response) {
                    if (response.success) {
                        // Update status badge in header
                        var $badge = $('h1 .ab2b-status');
                        $badge.removeClass('ab2b-status-pending ab2b-status-confirmed ab2b-status-shipped ab2b-status-completed ab2b-status-cancelled');
                        $badge.addClass('ab2b-status-' + status);
                        $badge.text(response.data.label);

                        alert('Status updated successfully!');
                    } else {
                        alert(response.data.message || ab2b_admin.strings.error);
                    }
                    $btn.prop('disabled', false).text(originalText);
                },
                error: function() {
                    alert(ab2b_admin.strings.error);
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        },

        /**
         * Save Admin Notes
         */
        saveAdminNotes: function(e) {
            e.preventDefault();

            var $btn = $(this);
            var orderId = $btn.data('order-id');
            var notes = $('#admin-notes').val();
            var originalText = $btn.text();

            $btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_update_order_status',
                    nonce: ab2b_admin.nonce,
                    order_id: orderId,
                    status: $('#order-status').val(),
                    admin_notes: notes
                },
                success: function(response) {
                    if (response.success) {
                        $('.ab2b-notes-saved').fadeIn().delay(2000).fadeOut();
                    } else {
                        alert(response.data.message || ab2b_admin.strings.error);
                    }
                    $btn.prop('disabled', false).text(originalText);
                },
                error: function() {
                    alert(ab2b_admin.strings.error);
                    $btn.prop('disabled', false).text(originalText);
                }
            });
        }
    };

    $(document).ready(function() {
        AB2B_Admin.init();
    });

})(jQuery);
