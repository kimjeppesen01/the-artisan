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

            // Order item editing
            $(document).on('click', '.ab2b-edit-order-item', this.openEditItemModal);
            $(document).on('click', '#save-order-item', this.saveOrderItem);
            $(document).on('click', '.ab2b-delete-order-item', this.deleteOrderItem);

            // Modal close handlers
            $(document).on('click', '.ab2b-modal-close, .ab2b-modal-cancel, .ab2b-modal-overlay', this.closeModal);
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
        },

        /**
         * Open Edit Order Item Modal
         */
        openEditItemModal: function(e) {
            e.preventDefault();

            var $btn = $(this);
            var itemId = $btn.data('item-id');
            var productName = $btn.data('product-name');
            var weightLabel = $btn.data('weight-label');
            var quantity = $btn.data('quantity');
            var unitPrice = $btn.data('unit-price');

            // Populate modal fields
            $('#edit-item-id').val(itemId);
            $('#edit-product-name').val(productName);
            $('#edit-weight-label').val(weightLabel);
            $('#edit-quantity').val(quantity);
            $('#edit-unit-price').val(unitPrice);

            // Show modal
            $('#ab2b-edit-item-modal').fadeIn(200);
        },

        /**
         * Close Modal
         */
        closeModal: function(e) {
            if (e) e.preventDefault();
            $('.ab2b-modal').fadeOut(200);
        },

        /**
         * Save Order Item Changes
         */
        saveOrderItem: function(e) {
            e.preventDefault();

            var $btn = $(this);
            var originalText = $btn.text();
            var itemId = $('#edit-item-id').val();

            $btn.prop('disabled', true).text('Saving...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_update_order_item',
                    nonce: ab2b_admin.nonce,
                    item_id: itemId,
                    product_name: $('#edit-product-name').val(),
                    weight_label: $('#edit-weight-label').val(),
                    quantity: $('#edit-quantity').val(),
                    unit_price: $('#edit-unit-price').val()
                },
                success: function(response) {
                    if (response.success) {
                        var item = response.data.item;
                        var $row = $('tr[data-item-id="' + itemId + '"]');

                        // Update row data
                        $row.find('.item-product-name strong').text(item.product_name);
                        $row.find('.item-weight-label').text(item.weight_label);
                        $row.find('.item-quantity').text(item.quantity);
                        $row.find('.item-unit-price').text(AB2B_Admin.formatPrice(item.unit_price));
                        $row.find('.item-line-total').text(AB2B_Admin.formatPrice(item.line_total));

                        // Update edit button data attributes
                        var $editBtn = $row.find('.ab2b-edit-order-item');
                        $editBtn.data('product-name', item.product_name);
                        $editBtn.data('weight-label', item.weight_label);
                        $editBtn.data('quantity', item.quantity);
                        $editBtn.data('unit-price', item.unit_price);

                        // Update order total
                        $('#order-total-display').html('<strong>' + response.data.formatted_total + '</strong>');

                        // Close modal
                        AB2B_Admin.closeModal();
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
         * Delete Order Item
         */
        deleteOrderItem: function(e) {
            e.preventDefault();

            if (!confirm('Are you sure you want to delete this item from the order?')) {
                return;
            }

            var $btn = $(this);
            var itemId = $btn.data('item-id');
            var $row = $btn.closest('tr');

            $btn.prop('disabled', true).text('Deleting...');

            $.ajax({
                url: ab2b_admin.ajax_url,
                type: 'POST',
                data: {
                    action: 'ab2b_delete_order_item',
                    nonce: ab2b_admin.nonce,
                    item_id: itemId
                },
                success: function(response) {
                    if (response.success) {
                        // Remove row with animation
                        $row.fadeOut(300, function() {
                            $(this).remove();
                        });

                        // Update order total
                        $('#order-total-display').html('<strong>' + response.data.formatted_total + '</strong>');
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
         * Format price helper
         */
        formatPrice: function(price) {
            var formatted = parseFloat(price).toFixed(2);
            var symbol = ab2b_admin.currency_symbol || 'kr.';
            var position = ab2b_admin.currency_position || 'after';

            if (position === 'before') {
                return symbol + ' ' + formatted;
            }
            return formatted + ' ' + symbol;
        }
    };

    $(document).ready(function() {
        AB2B_Admin.init();
    });

})(jQuery);
