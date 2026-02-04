/**
 * Artisan B2B Portal - Frontend JavaScript
 */

(function($) {
    'use strict';

    const AB2B_Portal = {
        cart: [],
        products: [],
        orders: [],

        init: function() {
            if (!ab2b_portal.is_authenticated) {
                return;
            }

            this.loadCart();
            this.bindEvents();
            this.loadProducts();
            this.loadOrders();
            this.updateCartUI();
        },

        /**
         * Bind all event handlers
         */
        bindEvents: function() {
            // Tab switching
            $(document).on('click', '.ab2b-tab, [data-tab]', this.switchTab.bind(this));

            // Cart indicator click
            $(document).on('click', '.ab2b-cart-indicator', function() {
                $('.ab2b-tab[data-tab="cart"]').click();
            });

            // Quick add button
            $(document).on('click', '.ab2b-quick-add-btn', this.openQuickAdd.bind(this));

            // Add to cart from modal
            $(document).on('click', '.ab2b-add-to-cart-btn', this.addToCart.bind(this));

            // Cart quantity changes
            $(document).on('click', '.ab2b-qty-btn', this.updateCartQuantity.bind(this));

            // Remove from cart
            $(document).on('click', '.ab2b-cart-item-remove', this.removeFromCart.bind(this));

            // Place order
            $(document).on('click', '.ab2b-place-order-btn', this.placeOrder.bind(this));

            // View order details
            $(document).on('click', '.ab2b-order-card', this.viewOrderDetails.bind(this));

            // Modal close
            $(document).on('click', '.ab2b-modal-close, .ab2b-modal-overlay', this.closeModal);

            // Weight select change - update price display
            $(document).on('change', '#ab2b-weight-select', this.updateWeightPrice);

            // Delivery date - enforce Fridays
            $(document).on('change', '#ab2b-delivery-date', this.validateDeliveryDate.bind(this));
        },

        /**
         * API request helper
         */
        api: function(endpoint, method, data) {
            method = method || 'GET';

            const options = {
                url: ab2b_portal.api_url + endpoint,
                method: method,
                headers: {
                    'X-AB2B-Access-Key': ab2b_portal.access_key
                },
                dataType: 'json'
            };

            if (data && (method === 'POST' || method === 'PUT')) {
                options.contentType = 'application/json';
                options.data = JSON.stringify(data);
            }

            return $.ajax(options);
        },

        /**
         * Load products from API
         */
        loadProducts: function() {
            const self = this;

            this.api('/products').done(function(products) {
                self.products = products;
                self.renderProducts(products);
            }).fail(function() {
                $('#ab2b-products').html('<p class="ab2b-error">' + ab2b_portal.strings.error + '</p>');
            });
        },

        /**
         * Render products grid
         */
        renderProducts: function(products) {
            if (!products || products.length === 0) {
                $('#ab2b-products').html('<p class="ab2b-no-products">No products available.</p>');
                return;
            }

            let html = '';

            products.forEach(function(product) {
                const placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400"%3E%3Crect fill="%23f0f0f1" width="300" height="400"/%3E%3C/svg%3E';

                // Build badges HTML
                let badgesHtml = '';
                if (product.has_sale_pricing) {
                    badgesHtml += '<span class="ab2b-badge ab2b-badge-sale">Sale</span>';
                }
                if (product.is_exclusive) {
                    badgesHtml += '<span class="ab2b-badge ab2b-badge-exclusive">Exclusive</span>';
                }

                html += `
                    <div class="ab2b-product-card" data-product-id="${product.id}">
                        <div class="ab2b-product-image-wrap">
                            ${badgesHtml ? `<div class="ab2b-product-badges">${badgesHtml}</div>` : ''}
                            <img src="${product.image || placeholder}" alt="${product.name}" class="ab2b-product-image" loading="lazy">
                            ${product.hover_image ? `<img src="${product.hover_image}" alt="${product.name}" class="ab2b-product-hover-image" loading="lazy">` : ''}
                            <div class="ab2b-product-actions">
                                <button type="button" class="ab2b-product-action-btn ab2b-quick-add-btn" data-product-id="${product.id}">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M460-620v-120H340v-40h120v-120h40v120h120v40H500v120h-40ZM292.31-115.38q-25.31 0-42.66-17.35-17.34-17.35-17.34-42.65 0-25.31 17.34-42.66 17.35-17.34 42.66-17.34 25.31 0 42.65 17.34 17.35 17.35 17.35 42.66 0 25.3-17.35 42.65-17.34 17.35-42.65 17.35Zm375.38 0q-25.31 0-42.65-17.35-17.35-17.35-17.35-42.65 0-25.31 17.35-42.66 17.34-17.34 42.65-17.34t42.66 17.34q17.34 17.35 17.34 42.66 0 25.3-17.34 42.65-17.35 17.35-42.66 17.35ZM80-820v-40h97.92l163.85 344.62h265.38q6.93 0 12.31-3.47 5.39-3.46 9.23-9.61L768.54-780h45.61L662.77-506.62q-8.69 14.62-22.61 22.93t-30.47 8.31H324l-48.62 89.23q-6.15 9.23-.38 20 5.77 10.77 17.31 10.77h435.38v40H292.31q-35 0-52.35-29.39-17.34-29.38-.73-59.38l60.15-107.23L152.31-820H80Z"/></svg>
                                    <span>${ab2b_portal.strings.add_to_cart}</span>
                                </button>
                            </div>
                        </div>
                        <div class="ab2b-product-meta">
                            <h3 class="ab2b-product-name">${product.name}</h3>
                            <p class="ab2b-product-price">${product.price_range}</p>
                        </div>
                    </div>
                `;
            });

            $('#ab2b-products').html(html);
        },

        /**
         * Open quick add modal
         */
        openQuickAdd: function(e) {
            e.preventDefault();
            e.stopPropagation();

            const productId = $(e.currentTarget).data('product-id');
            const product = this.products.find(p => p.id === productId);

            if (!product) return;

            let weightsHtml = '';
            product.weights.forEach(function(weight, index) {
                let optionLabel = weight.label + ' - ' + weight.price_formatted;
                if (weight.is_on_sale) {
                    optionLabel = weight.label + ' - ' + weight.price_formatted + ' (was ' + weight.original_price_formatted + ')';
                }
                weightsHtml += `<option value="${weight.id}" data-price="${weight.price}" data-formatted="${weight.price_formatted}" data-on-sale="${weight.is_on_sale ? '1' : '0'}" data-original="${weight.original_price_formatted || ''}" data-discount="${weight.discount_percent || 0}" ${index === 0 ? 'selected' : ''}>${optionLabel}</option>`;
            });

            const firstWeight = product.weights[0];
            const placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 300"%3E%3Crect fill="%23f0f0f1" width="300" height="300"/%3E%3C/svg%3E';

            // Build price display with sale styling
            let priceHtml = firstWeight.price_formatted;
            if (firstWeight.is_on_sale) {
                priceHtml = `<span class="ab2b-sale-price">${firstWeight.price_formatted}</span> <span class="ab2b-original-price">${firstWeight.original_price_formatted}</span> <span class="ab2b-discount-badge">-${firstWeight.discount_percent}%</span>`;
            }

            const html = `
                <div class="ab2b-quick-add" data-product-id="${product.id}">
                    <img src="${product.image || placeholder}" alt="${product.name}" class="ab2b-quick-add-image">
                    <h3 class="ab2b-quick-add-name">${product.name}</h3>
                    ${product.short_description ? `<p class="ab2b-quick-add-desc">${product.short_description}</p>` : ''}
                    <form class="ab2b-quick-add-form">
                        <div class="ab2b-form-group">
                            <label for="ab2b-weight-select">${ab2b_portal.strings.select_weight}</label>
                            <select id="ab2b-weight-select" name="weight_id">
                                ${weightsHtml}
                            </select>
                        </div>
                        <div class="ab2b-form-group">
                            <label for="ab2b-quantity">${ab2b_portal.strings.quantity}</label>
                            <input type="number" id="ab2b-quantity" name="quantity" value="1" min="1" max="999">
                        </div>
                        <p class="ab2b-weight-price" id="ab2b-selected-price">${priceHtml}</p>
                        <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-btn-full ab2b-add-to-cart-btn">
                            ${ab2b_portal.strings.add_to_cart}
                        </button>
                    </form>
                </div>
            `;

            $('#ab2b-modal-body').html(html);
            $('#ab2b-quick-add-modal').addClass('active');
        },

        /**
         * Update price display when weight changes
         */
        updateWeightPrice: function() {
            const $selected = $(this).find(':selected');
            const isOnSale = $selected.data('on-sale') === '1' || $selected.data('on-sale') === 1;
            const formatted = $selected.data('formatted');
            const original = $selected.data('original');
            const discount = $selected.data('discount');

            let priceHtml = formatted;
            if (isOnSale && original) {
                priceHtml = `<span class="ab2b-sale-price">${formatted}</span> <span class="ab2b-original-price">${original}</span> <span class="ab2b-discount-badge">-${discount}%</span>`;
            }

            $('#ab2b-selected-price').html(priceHtml);
        },

        /**
         * Add item to cart
         */
        addToCart: function(e) {
            e.preventDefault();

            const $modal = $('#ab2b-quick-add-modal');
            const $container = $modal.find('.ab2b-quick-add');
            const productId = parseInt($container.data('product-id'));
            const weightId = parseInt($('#ab2b-weight-select').val());
            const quantity = parseInt($('#ab2b-quantity').val()) || 1;

            const product = this.products.find(p => p.id === productId);
            if (!product) return;

            const weight = product.weights.find(w => w.id === weightId);
            if (!weight) return;

            // Check if already in cart
            const existingIndex = this.cart.findIndex(item =>
                item.product_id === productId && item.weight_id === weightId
            );

            if (existingIndex >= 0) {
                this.cart[existingIndex].quantity += quantity;
            } else {
                this.cart.push({
                    product_id: productId,
                    weight_id: weightId,
                    product_name: product.name,
                    product_image: product.image,
                    weight_label: weight.label,
                    unit_price: weight.price,
                    unit_price_formatted: weight.price_formatted,
                    quantity: quantity
                });
            }

            this.saveCart();
            this.updateCartUI();
            this.closeModal();

            // Show feedback
            this.showMessage(ab2b_portal.strings.added, 'success');
        },

        /**
         * Update cart quantity
         */
        updateCartQuantity: function(e) {
            const $btn = $(e.currentTarget);
            const $item = $btn.closest('.ab2b-cart-item');
            const index = $item.data('index');
            const action = $btn.data('action');

            if (action === 'increase') {
                this.cart[index].quantity++;
            } else if (action === 'decrease') {
                if (this.cart[index].quantity > 1) {
                    this.cart[index].quantity--;
                }
            }

            this.saveCart();
            this.updateCartUI();
            this.renderCart();
        },

        /**
         * Remove item from cart
         */
        removeFromCart: function(e) {
            e.preventDefault();
            const $item = $(e.currentTarget).closest('.ab2b-cart-item');
            const index = $item.data('index');

            this.cart.splice(index, 1);
            this.saveCart();
            this.updateCartUI();
            this.renderCart();
        },

        /**
         * Render cart contents
         */
        renderCart: function() {
            const $cart = $('#ab2b-cart');
            const self = this;

            if (this.cart.length === 0) {
                $cart.html(`
                    <div class="ab2b-cart-empty">
                        <span class="ab2b-empty-icon">🛒</span>
                        <p>${ab2b_portal.strings.cart_empty}</p>
                        <button type="button" class="ab2b-btn ab2b-btn-primary" data-tab="shop">
                            Start Shopping
                        </button>
                    </div>
                `);
                return;
            }

            const placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 60 60"%3E%3Crect fill="%23f0f0f1" width="60" height="60"/%3E%3C/svg%3E';
            let total = 0;
            let itemsHtml = '';

            this.cart.forEach(function(item, index) {
                const lineTotal = item.unit_price * item.quantity;
                total += lineTotal;

                itemsHtml += `
                    <div class="ab2b-cart-item" data-index="${index}">
                        <img src="${item.product_image || placeholder}" alt="${item.product_name}" class="ab2b-cart-item-image">
                        <div class="ab2b-cart-item-info">
                            <p class="ab2b-cart-item-name">${item.product_name}</p>
                            <p class="ab2b-cart-item-weight">${item.weight_label} × ${item.unit_price_formatted}</p>
                        </div>
                        <div class="ab2b-cart-item-qty">
                            <button type="button" class="ab2b-qty-btn" data-action="decrease">−</button>
                            <span class="ab2b-qty-value">${item.quantity}</span>
                            <button type="button" class="ab2b-qty-btn" data-action="increase">+</button>
                        </div>
                        <div class="ab2b-cart-item-price">${self.formatPrice(lineTotal)}</div>
                        <button type="button" class="ab2b-cart-item-remove" title="${ab2b_portal.strings.remove}">✕</button>
                    </div>
                `;
            });

            const minDate = this.getNextFriday();

            $cart.html(`
                <div class="ab2b-cart-items">
                    ${itemsHtml}
                </div>
                <div class="ab2b-cart-summary">
                    <div class="ab2b-cart-total">
                        <span>${ab2b_portal.strings.total}</span>
                        <span>${this.formatPrice(total)}</span>
                    </div>
                    <div class="ab2b-delivery-picker">
                        <label for="ab2b-delivery-date">${ab2b_portal.strings.delivery_date}</label>
                        <input type="date" id="ab2b-delivery-date" min="${minDate}" value="${minDate}" required>
                        <p class="ab2b-friday-note">${ab2b_portal.strings.friday_only}</p>
                    </div>
                    <div class="ab2b-special-instructions">
                        <label for="ab2b-instructions">${ab2b_portal.strings.special_instructions}</label>
                        <textarea id="ab2b-instructions" rows="2" placeholder="Optional"></textarea>
                    </div>
                    <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-btn-full ab2b-place-order-btn">
                        ${ab2b_portal.strings.place_order}
                    </button>
                </div>
            `);
        },

        /**
         * Validate delivery date is a Friday
         */
        validateDeliveryDate: function(e) {
            const $input = $(e.target);
            const date = new Date($input.val());
            const dayOfWeek = date.getDay();

            // 5 = Friday
            if (dayOfWeek !== 5) {
                // Find next Friday
                const daysUntilFriday = (5 - dayOfWeek + 7) % 7 || 7;
                date.setDate(date.getDate() + daysUntilFriday);
                $input.val(this.formatDateForInput(date));
                this.showMessage(ab2b_portal.strings.friday_only, 'error');
            }
        },

        /**
         * Place order
         */
        placeOrder: function(e) {
            e.preventDefault();

            const self = this;
            const $btn = $(e.currentTarget);
            const deliveryDate = $('#ab2b-delivery-date').val();
            const instructions = $('#ab2b-instructions').val();

            if (!deliveryDate) {
                this.showMessage('Please select a delivery date.', 'error');
                return;
            }

            // Validate Friday
            const date = new Date(deliveryDate);
            if (date.getDay() !== 5) {
                this.showMessage(ab2b_portal.strings.friday_only, 'error');
                return;
            }

            $btn.prop('disabled', true).text(ab2b_portal.strings.placing_order);

            const items = this.cart.map(function(item) {
                return {
                    product_id: item.product_id,
                    weight_id: item.weight_id,
                    quantity: item.quantity
                };
            });

            this.api('/orders', 'POST', {
                items: items,
                delivery_date: deliveryDate,
                special_instructions: instructions
            }).done(function(response) {
                self.cart = [];
                self.saveCart();
                self.updateCartUI();
                self.showMessage(ab2b_portal.strings.order_success, 'success');

                // Switch to orders tab
                setTimeout(function() {
                    self.loadOrders();
                    $('.ab2b-tab[data-tab="orders"]').click();
                }, 1500);

            }).fail(function(xhr) {
                const msg = xhr.responseJSON?.message || ab2b_portal.strings.error;
                self.showMessage(msg, 'error');
            }).always(function() {
                $btn.prop('disabled', false).text(ab2b_portal.strings.place_order);
            });
        },

        /**
         * Load orders from API
         */
        loadOrders: function() {
            const self = this;

            this.api('/orders').done(function(orders) {
                self.orders = orders;
                self.renderOrders(orders);
            }).fail(function() {
                $('#ab2b-orders').html('<p class="ab2b-error">' + ab2b_portal.strings.error + '</p>');
            });
        },

        /**
         * Render orders list
         */
        renderOrders: function(orders) {
            if (!orders || orders.length === 0) {
                $('#ab2b-orders').html(`
                    <div class="ab2b-no-orders">
                        <p>${ab2b_portal.strings.no_orders}</p>
                    </div>
                `);
                return;
            }

            let html = '<div class="ab2b-orders-list">';

            orders.forEach(function(order) {
                html += `
                    <div class="ab2b-order-card" data-order-id="${order.id}">
                        <div class="ab2b-order-left">
                            <div class="ab2b-order-header">
                                <span class="ab2b-order-number">${order.order_number}</span>
                                <span class="ab2b-status ${order.status_class}">${order.status_label}</span>
                            </div>
                            <p class="ab2b-order-delivery">Delivery: ${order.delivery_date_formatted}</p>
                        </div>
                        <div class="ab2b-order-right">
                            <div class="ab2b-order-total">${order.total_formatted}</div>
                            <div class="ab2b-order-date">${order.created_at_formatted}</div>
                        </div>
                    </div>
                `;
            });

            html += '</div>';
            $('#ab2b-orders').html(html);
        },

        /**
         * View order details
         */
        viewOrderDetails: function(e) {
            const orderId = $(e.currentTarget).data('order-id');
            const self = this;

            this.api('/orders/' + orderId).done(function(order) {
                let itemsHtml = '';
                order.items.forEach(function(item) {
                    itemsHtml += `
                        <tr>
                            <td>${item.product_name}</td>
                            <td>${item.weight_label}</td>
                            <td>${item.quantity}</td>
                            <td>${item.unit_price_formatted}</td>
                            <td>${item.line_total_formatted}</td>
                        </tr>
                    `;
                });

                const html = `
                    <div class="ab2b-order-detail">
                        <h2>
                            ${order.order_number}
                            <span class="ab2b-status ${order.status_class}">${order.status_label}</span>
                        </h2>
                        <div class="ab2b-order-meta">
                            <div class="ab2b-order-meta-item">
                                <span class="ab2b-order-meta-label">Order Date</span>
                                <span class="ab2b-order-meta-value">${order.created_at_formatted}</span>
                            </div>
                            <div class="ab2b-order-meta-item">
                                <span class="ab2b-order-meta-label">Delivery Date</span>
                                <span class="ab2b-order-meta-value">${order.delivery_date_formatted}</span>
                            </div>
                        </div>
                        <table class="ab2b-order-items-table">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Weight</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${itemsHtml}
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" style="text-align: right;">Total</td>
                                    <td>${order.total_formatted}</td>
                                </tr>
                            </tfoot>
                        </table>
                        ${order.special_instructions ? `<p><strong>Special Instructions:</strong> ${order.special_instructions}</p>` : ''}
                    </div>
                `;

                $('#ab2b-order-modal-body').html(html);
                $('#ab2b-order-modal').addClass('active');
            });
        },

        /**
         * Tab switching
         */
        switchTab: function(e) {
            e.preventDefault();
            const tab = $(e.currentTarget).data('tab');

            if (tab === 'cart') {
                this.renderCart();
            }

            $('.ab2b-tab').removeClass('active');
            $('.ab2b-tab[data-tab="' + tab + '"]').addClass('active');

            $('.ab2b-tab-content').removeClass('active');
            $('#tab-' + tab).addClass('active');
        },

        /**
         * Close modal
         */
        closeModal: function() {
            $('.ab2b-modal').removeClass('active');
        },

        /**
         * Cart persistence
         */
        loadCart: function() {
            const stored = localStorage.getItem('ab2b_cart_' + ab2b_portal.access_key);
            if (stored) {
                try {
                    this.cart = JSON.parse(stored);
                } catch (e) {
                    this.cart = [];
                }
            }
        },

        saveCart: function() {
            localStorage.setItem('ab2b_cart_' + ab2b_portal.access_key, JSON.stringify(this.cart));
        },

        updateCartUI: function() {
            const count = this.cart.reduce((sum, item) => sum + item.quantity, 0);
            $('.ab2b-cart-count').text(count);
            $('#cart-tab-count').text(count).toggle(count > 0);
        },

        /**
         * Helpers
         */
        formatPrice: function(amount) {
            const formatted = amount.toFixed(2).replace('.', ',');
            return ab2b_portal.currency + ' ' + formatted;
        },

        getNextFriday: function() {
            const today = new Date();
            today.setDate(today.getDate() + parseInt(ab2b_portal.min_days));

            const dayOfWeek = today.getDay();
            let daysUntilFriday;

            if (dayOfWeek <= 5) {
                daysUntilFriday = 5 - dayOfWeek;
            } else {
                daysUntilFriday = 6; // Saturday -> next Friday
            }

            if (daysUntilFriday === 0 && today.getDay() !== 5) {
                daysUntilFriday = 7;
            }

            today.setDate(today.getDate() + daysUntilFriday);
            return this.formatDateForInput(today);
        },

        formatDateForInput: function(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        },

        showMessage: function(text, type) {
            const $msg = $('<div class="ab2b-message ab2b-message-' + type + '">' + text + '</div>');
            $('.ab2b-portal-content').prepend($msg);

            setTimeout(function() {
                $msg.fadeOut(function() {
                    $(this).remove();
                });
            }, 3000);
        }
    };

    $(document).ready(function() {
        AB2B_Portal.init();
    });

})(jQuery);
