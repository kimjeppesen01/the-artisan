/**
 * Artisan B2B Portal - Frontend JavaScript
 */

(function($) {
    'use strict';

    const AB2B_Portal = {
        cart: [],
        products: [],
        orders: [],
        categories: [],
        activeCategory: 'all',
        viewMode: 'grid',
        editingOrderId: null,
        editingOrderData: null,

        init: function() {
            if (!ab2b_portal.is_authenticated) {
                return;
            }

            this.loadCart();
            this.bindEvents();
            this.loadCategories();
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

            // Place order / Update order
            $(document).on('click', '.ab2b-place-order-btn, .ab2b-update-order-btn', this.placeOrder.bind(this));

            // Edit / Delete order (stop propagation so card click doesn't fire)
            $(document).on('click', '.ab2b-order-edit-btn', this.editOrder.bind(this));
            $(document).on('click', '.ab2b-order-delete-btn', this.deleteOrder.bind(this));

            // View order details (card click, but not when clicking edit/delete)
            $(document).on('click', '.ab2b-order-card', this.viewOrderDetails.bind(this));

            // Modal close
            $(document).on('click', '.ab2b-modal-close, .ab2b-modal-overlay', this.closeModal);

            // Weight select change - update price display
            $(document).on('change', '#ab2b-weight-select', this.updateWeightPrice);

            // Delivery date - enforce Fridays
            $(document).on('change', '#ab2b-delivery-date', this.validateDeliveryDate.bind(this));

            // Delivery method toggle
            $(document).on('change', 'input[name="delivery_method"]', this.updateDeliveryMethod.bind(this));

            // Category filter
            $(document).on('click', '.ab2b-cat-filter', this.filterByCategory.bind(this));

            // View toggle (grid/list)
            $(document).on('click', '.ab2b-view-btn', this.switchView.bind(this));

            // Account profile form
            $(document).on('submit', '#ab2b-profile-form', this.saveCustomerProfile.bind(this));
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
         * Load categories from API
         */
        loadCategories: function() {
            const self = this;

            this.api('/categories').done(function(categories) {
                self.categories = categories;
                self.renderCategoryFilters(categories);
            });
        },

        /**
         * Render category filter buttons (saren-style)
         */
        renderCategoryFilters: function(categories) {
            if (!categories || categories.length === 0) {
                return;
            }

            let html = '<label class="ab2b-cat-filter active" data-category="all"><input type="checkbox" checked>All</label>';

            categories.forEach(function(cat) {
                html += '<label class="ab2b-cat-filter" data-category="' + cat.id + '"><input type="checkbox">' + cat.name + '</label>';
            });

            $('#ab2b-category-filters').html(html);
            $('#ab2b-shop-controls').show();
        },

        /**
         * Filter products by category
         */
        filterByCategory: function(e) {
            e.preventDefault();
            const $filter = $(e.currentTarget);
            const category = $filter.data('category');

            this.activeCategory = category;

            // Update active state
            $('.ab2b-cat-filter').removeClass('active').find('input').prop('checked', false);
            $filter.addClass('active').find('input').prop('checked', true);

            // Filter and re-render
            this.renderFilteredProducts();
        },

        /**
         * Get filtered products based on active category
         */
        getFilteredProducts: function() {
            if (this.activeCategory === 'all') {
                return this.products;
            }

            const catId = parseInt(this.activeCategory);
            return this.products.filter(function(product) {
                return product.categories && product.categories.indexOf(catId) !== -1;
            });
        },

        /**
         * Render filtered products in current view mode
         */
        renderFilteredProducts: function() {
            const filtered = this.getFilteredProducts();
            if (this.viewMode === 'list') {
                this.renderProductsList(filtered);
            } else {
                this.renderProducts(filtered);
            }
        },

        /**
         * Switch between grid and list view
         */
        switchView: function(e) {
            const $btn = $(e.currentTarget);
            const view = $btn.data('view');

            this.viewMode = view;

            // Update active state
            $('.ab2b-view-btn').removeClass('active');
            $btn.addClass('active');

            // Re-render products
            this.renderFilteredProducts();
        },

        /**
         * Load products from API
         */
        loadProducts: function() {
            const self = this;

            this.api('/products').done(function(products) {
                self.products = products;
                self.renderFilteredProducts();
                // Show controls bar if it exists (even without categories, for the view toggle)
                if ($('#ab2b-shop-controls').length) {
                    $('#ab2b-shop-controls').show();
                }
            }).fail(function() {
                $('#ab2b-products').html('<p class="ab2b-error">' + ab2b_portal.strings.error + '</p>');
            });
        },

        /**
         * Render products grid
         */
        renderProducts: function(products) {
            const $container = $('#ab2b-products');
            $container.removeClass('ab2b-products-list').addClass('ab2b-products-grid');

            if (!products || products.length === 0) {
                $container.html('<p class="ab2b-no-products">No products available.</p>');
                return;
            }

            let html = '';

            products.forEach(function(product) {
                const placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 300 400"%3E%3Crect fill="%23f0f0f1" width="300" height="400"/%3E%3C/svg%3E';

                // Build badges HTML (only exclusive badge, no sale badge)
                let badgesHtml = '';
                if (product.is_exclusive) {
                    badgesHtml += '<span class="ab2b-badge ab2b-badge-exclusive">Exclusive</span>';
                }

                // Info tooltip if short description exists
                let infoHtml = '';
                if (product.short_description) {
                    infoHtml = `
                        <span class="ab2b-product-info-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="16" height="16"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg>
                            <span class="ab2b-product-tooltip">${product.short_description}</span>
                        </span>
                    `;
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
                            <h3 class="ab2b-product-name">${product.name}${infoHtml}</h3>
                            <p class="ab2b-product-price">${product.price_range}</p>
                        </div>
                    </div>
                `;
            });

            $container.html(html);
        },

        /**
         * Render products as list view
         */
        renderProductsList: function(products) {
            const $container = $('#ab2b-products');
            $container.removeClass('ab2b-products-grid').addClass('ab2b-products-list');

            if (!products || products.length === 0) {
                $container.html('<p class="ab2b-no-products">No products available.</p>');
                return;
            }

            let html = '';

            products.forEach(function(product) {
                const placeholder = 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"%3E%3Crect fill="%23f0f0f1" width="100" height="100"/%3E%3C/svg%3E';

                // Only exclusive badge, no sale badge
                let badgesHtml = '';
                if (product.is_exclusive) {
                    badgesHtml += '<span class="ab2b-badge ab2b-badge-exclusive">Exclusive</span>';
                }

                html += `
                    <div class="ab2b-product-list-item" data-product-id="${product.id}">
                        <div class="ab2b-product-list-image">
                            <img src="${product.image || placeholder}" alt="${product.name}" loading="lazy">
                        </div>
                        <div class="ab2b-product-list-info">
                            <div class="ab2b-product-list-top">
                                <h3 class="ab2b-product-name">${product.name}</h3>
                                ${badgesHtml ? `<div class="ab2b-product-list-badges">${badgesHtml}</div>` : ''}
                            </div>
                            ${product.short_description ? `<p class="ab2b-product-list-desc">${product.short_description}</p>` : ''}
                        </div>
                        <div class="ab2b-product-list-price">
                            <span class="ab2b-product-price">${product.price_range}</span>
                        </div>
                        <div class="ab2b-product-list-action">
                            <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-quick-add-btn" data-product-id="${product.id}">
                                ${ab2b_portal.strings.add_to_cart}
                            </button>
                        </div>
                    </div>
                `;
            });

            $container.html(html);
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

            // Lock body scroll
            this.scrollPos = window.pageYOffset;
            $('body').addClass('ab2b-modal-open').css('top', -this.scrollPos + 'px');

            let weightsHtml = '';
            product.weights.forEach(function(weight, index) {
                let optionLabel = weight.label + ' - ' + weight.price_formatted;
                if (weight.is_on_sale) {
                    // Show discount percentage in dropdown instead of "was" text
                    optionLabel = weight.label + ' - ' + weight.price_formatted + ' (-' + weight.discount_percent + '%)';
                }
                const unit = weight.unit || 'g';
                weightsHtml += `<option value="${weight.id}" data-price="${weight.price}" data-formatted="${weight.price_formatted}" data-on-sale="${weight.is_on_sale ? '1' : '0'}" data-original="${weight.original_price_formatted || ''}" data-discount="${weight.discount_percent || 0}" data-unit="${unit}" ${index === 0 ? 'selected' : ''}>${optionLabel}</option>`;
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
                    <div class="ab2b-quick-add-info">
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
                                <label for="ab2b-quantity">${ab2b_portal.strings.quantity} <span class="ab2b-quantity-unit" id="ab2b-quantity-unit">(${firstWeight.unit || 'g'})</span></label>
                                <input type="number" id="ab2b-quantity" name="quantity" value="1" min="1" max="999">
                            </div>
                            <p class="ab2b-weight-price" id="ab2b-selected-price">${priceHtml}</p>
                            <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-btn-full ab2b-add-to-cart-btn">
                                ${ab2b_portal.strings.add_to_cart}
                            </button>
                        </form>
                    </div>
                </div>
            `;

            $('#ab2b-modal-body').html(html);
            $('#ab2b-quick-add-modal').addClass('active');
        },

        /**
         * Update price display and quantity unit when weight changes
         */
        updateWeightPrice: function() {
            const $selected = $(this).find(':selected');
            const isOnSale = $selected.data('on-sale') === '1' || $selected.data('on-sale') === 1;
            const formatted = $selected.data('formatted');
            const original = $selected.data('original');
            const discount = $selected.data('discount');
            const unit = $selected.data('unit') || 'g';

            let priceHtml = formatted;
            if (isOnSale && original) {
                priceHtml = `<span class="ab2b-sale-price">${formatted}</span> <span class="ab2b-original-price">${original}</span> <span class="ab2b-discount-badge">-${discount}%</span>`;
            }

            $('#ab2b-selected-price').html(priceHtml);
            $('#ab2b-quantity-unit').text('(' + unit + ')');
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
                if (weight.value !== undefined) this.cart[existingIndex].weight_value = weight.value;
                if (weight.unit) this.cart[existingIndex].weight_unit = weight.unit;
            } else {
                this.cart.push({
                    product_id: productId,
                    weight_id: weightId,
                    product_name: product.name,
                    product_image: product.image,
                    weight_label: weight.label,
                    weight_value: weight.value || 0,
                    weight_unit: weight.unit || 'g',
                    unit: weight.unit || 'g',
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
         * Get total cart weight in kg (for international shipping tier)
         */
        getCartWeightKg: function() {
            let totalKg = 0;
            this.cart.forEach(function(item) {
                const val = (item.weight_value || 0) * (item.quantity || 1);
                const unit = (item.weight_unit || 'g').toLowerCase();
                if (unit === 'kg') {
                    totalKg += val;
                } else if (unit === 'g') {
                    totalKg += val / 1000;
                }
                // ltr, pcs etc. - treat as 0 for weight calculation
            });
            return totalKg;
        },

        /**
         * Get shipping cost for given delivery method
         */
        getShippingCost: function(method) {
            const s = ab2b_portal.shipping || {};
            const domestic = s.domestic || 100;
            const international = s.international || 125;
            const international7kg = s.international_7kg || 190;
            const threshold = s.weight_threshold_kg || 7;

            if (method === 'pickup') return 0;
            if (method === 'international') {
                return this.getCartWeightKg() >= threshold ? international7kg : international;
            }
            return domestic;
        },

        /**
         * Update date picker label and note when delivery method changes
         */
        updateDeliveryDateLabel: function(method) {
            const isPickup = method === 'pickup';
            $('#ab2b-delivery-date-label').text(isPickup ? ab2b_portal.strings.available_from_date : ab2b_portal.strings.delivery_date);
            $('.ab2b-friday-note').text(isPickup ? ab2b_portal.strings.friday_only_pickup : ab2b_portal.strings.friday_only);
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

                const unitSuffix = (item.unit && item.unit === 'pcs') ? ' ' + item.unit : '';
                itemsHtml += `
                    <div class="ab2b-cart-item" data-index="${index}">
                        <img src="${item.product_image || placeholder}" alt="${item.product_name}" class="ab2b-cart-item-image">
                        <div class="ab2b-cart-item-info">
                            <p class="ab2b-cart-item-name">${item.product_name}</p>
                            <p class="ab2b-cart-item-weight">${item.weight_label} × ${item.unit_price_formatted}</p>
                        </div>
                        <div class="ab2b-cart-item-qty">
                            <button type="button" class="ab2b-qty-btn" data-action="decrease">−</button>
                            <span class="ab2b-qty-value">${item.quantity}${unitSuffix}</span>
                            <button type="button" class="ab2b-qty-btn" data-action="increase">+</button>
                        </div>
                        <div class="ab2b-cart-item-price">${self.formatPrice(lineTotal)}</div>
                        <button type="button" class="ab2b-cart-item-remove" title="${ab2b_portal.strings.remove}">✕</button>
                    </div>
                `;
            });

            const minDate = this.getNextFriday();
            const editData = this.editingOrderData || {};
            const defaultMethod = editData.delivery_method || 'shipping';
            const defaultDate = editData.delivery_date ? editData.delivery_date : minDate;
            const defaultInstructions = editData.special_instructions || '';

            const shippingCost = this.getShippingCost(defaultMethod);
            const domesticCost = this.getShippingCost('shipping');
            const intlCost = this.getShippingCost('international');
            const isInternational = defaultMethod === 'international';
            const vat = isInternational ? 0 : (total + shippingCost) * 0.25;
            const grandTotal = total + shippingCost + vat;
            const vatRowHtml = isInternational
                ? `<div class="ab2b-cart-reverse-vat"><span>${ab2b_portal.strings.reverse_vat || 'Reverse VAT applies'}</span><span>—</span></div>`
                : `<div class="ab2b-cart-vat"><span>VAT 25%</span><span id="ab2b-vat">${this.formatPrice(vat)}</span></div>`;

            $cart.html(`
                <div class="ab2b-cart-items">
                    ${itemsHtml}
                </div>
                <div class="ab2b-cart-summary">
                    <div class="ab2b-delivery-method">
                        <label class="ab2b-delivery-method-label">Delivery Method</label>
                        <div class="ab2b-delivery-options">
                            <label class="ab2b-delivery-option ${defaultMethod === 'shipping' ? 'ab2b-delivery-option-active' : ''}">
                                <input type="radio" name="delivery_method" value="shipping" ${defaultMethod === 'shipping' ? 'checked' : ''}>
                                <span class="ab2b-delivery-option-content">
                                    <span class="ab2b-delivery-option-name">Shipping</span>
                                    <span class="ab2b-delivery-option-price">${this.formatPrice(domesticCost)} ex. VAT</span>
                                </span>
                            </label>
                            <label class="ab2b-delivery-option ${defaultMethod === 'international' ? 'ab2b-delivery-option-active' : ''}">
                                <input type="radio" name="delivery_method" value="international" ${defaultMethod === 'international' ? 'checked' : ''}>
                                <span class="ab2b-delivery-option-content">
                                    <span class="ab2b-delivery-option-name">International</span>
                                    <span class="ab2b-delivery-option-price">${this.formatPrice(intlCost)} ex. VAT</span>
                                </span>
                            </label>
                            <label class="ab2b-delivery-option ${defaultMethod === 'pickup' ? 'ab2b-delivery-option-active' : ''}">
                                <input type="radio" name="delivery_method" value="pickup" ${defaultMethod === 'pickup' ? 'checked' : ''}>
                                <span class="ab2b-delivery-option-content">
                                    <span class="ab2b-delivery-option-name">Pick up</span>
                                    <span class="ab2b-delivery-option-price">Free</span>
                                </span>
                            </label>
                        </div>
                    </div>
                    <div class="ab2b-cart-totals">
                        <div class="ab2b-cart-subtotal">
                            <span>Subtotal</span>
                            <span id="ab2b-subtotal">${this.formatPrice(total)}</span>
                        </div>
                        <div class="ab2b-cart-shipping" id="ab2b-shipping-row">
                            <span>Shipping</span>
                            <span id="ab2b-shipping-cost">${this.formatPrice(shippingCost)}</span>
                        </div>
                        <div id="ab2b-cart-vat-row">${vatRowHtml}</div>
                        <div class="ab2b-cart-total">
                            <span>${ab2b_portal.strings.total}</span>
                            <span id="ab2b-grand-total">${this.formatPrice(grandTotal)}</span>
                        </div>
                    </div>
                    <div class="ab2b-delivery-picker">
                        <label for="ab2b-delivery-date" id="ab2b-delivery-date-label">${ab2b_portal.strings.delivery_date}</label>
                        <input type="date" id="ab2b-delivery-date" min="${minDate}" value="${defaultDate}" required>
                        <p class="ab2b-friday-note">${ab2b_portal.strings.friday_only}</p>
                    </div>
                    <div class="ab2b-special-instructions">
                        <label for="ab2b-instructions">${ab2b_portal.strings.special_instructions}</label>
                        <textarea id="ab2b-instructions" rows="2" placeholder="Optional">${defaultInstructions}</textarea>
                    </div>
                    ${this.editingOrderId ? `
                    <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-btn-full ab2b-update-order-btn">
                        ${ab2b_portal.strings.update_order || 'Update Order'}
                    </button>
                    ` : `
                    <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-btn-full ab2b-place-order-btn">
                        ${ab2b_portal.strings.place_order}
                    </button>
                    `}
                </div>
            `);

            if (this.cart.length > 0 && editData.delivery_method) {
                this.updateDeliveryDateLabel(editData.delivery_method);
            }
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
         * Update delivery method and recalculate total
         */
        updateDeliveryMethod: function(e) {
            const method = $('input[name="delivery_method"]:checked').val();
            const shippingCost = this.getShippingCost(method);

            // Calculate subtotal from cart
            let subtotal = 0;
            this.cart.forEach(function(item) {
                subtotal += item.unit_price * item.quantity;
            });

            const isInternational = method === 'international';
            const vat = isInternational ? 0 : (subtotal + shippingCost) * 0.25;
            const grandTotal = subtotal + shippingCost + vat;

            // Update VAT row for international (reverse charge – no VAT)
            const vatRowHtml = isInternational
                ? `<div class="ab2b-cart-reverse-vat"><span>${ab2b_portal.strings.reverse_vat || 'Reverse VAT applies'}</span><span>—</span></div>`
                : `<div class="ab2b-cart-vat"><span>VAT 25%</span><span id="ab2b-vat">${this.formatPrice(vat)}</span></div>`;
            $('#ab2b-cart-vat-row').html(vatRowHtml);

            // Update UI
            $('#ab2b-shipping-cost').text(shippingCost > 0 ? this.formatPrice(shippingCost) : 'Free');
            $('#ab2b-grand-total').text(this.formatPrice(grandTotal));

            // Update date label for Pick up vs Delivery
            this.updateDeliveryDateLabel(method);

            // Toggle active class on options
            $('.ab2b-delivery-option').removeClass('ab2b-delivery-option-active');
            $(e.target).closest('.ab2b-delivery-option').addClass('ab2b-delivery-option-active');
        },

        /**
         * Place order
         */
        placeOrder: function(e) {
            e.preventDefault();

            const self = this;
            const $btn = $(e.currentTarget);
            const isUpdate = !!this.editingOrderId;
            const deliveryDate = $('#ab2b-delivery-date').val();
            const instructions = $('#ab2b-instructions').val();
            const deliveryMethod = $('input[name="delivery_method"]:checked').val() || 'shipping';

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

            const btnLabel = isUpdate ? (ab2b_portal.strings.updating_order || 'Updating...') : ab2b_portal.strings.placing_order;
            $btn.prop('disabled', true).text(btnLabel);

            const items = this.cart.map(function(item) {
                return {
                    product_id: item.product_id,
                    weight_id: item.weight_id,
                    quantity: item.quantity
                };
            });

            const payload = {
                items: items,
                delivery_date: deliveryDate,
                delivery_method: deliveryMethod,
                special_instructions: instructions
            };

            const endpoint = isUpdate ? '/orders/' + this.editingOrderId : '/orders';
            const method = isUpdate ? 'PUT' : 'POST';

            this.api(endpoint, method, payload).done(function(response) {
                self.cart = [];
                self.editingOrderId = null;
                self.editingOrderData = null;
                self.saveCart();
                self.updateCartUI();
                self.showMessage(isUpdate ? (ab2b_portal.strings.order_updated || 'Order updated.') : ab2b_portal.strings.order_success, 'success');

                // Switch to orders tab
                setTimeout(function() {
                    self.loadOrders();
                    $('.ab2b-tab[data-tab="orders"]').click();
                    self.renderCart();
                }, 1500);

            }).fail(function(xhr) {
                const msg = xhr.responseJSON?.message || ab2b_portal.strings.error;
                self.showMessage(msg, 'error');
            }).always(function() {
                $btn.prop('disabled', false).text(isUpdate ? (ab2b_portal.strings.update_order || 'Update Order') : ab2b_portal.strings.place_order);
            });
        },

        /**
         * Edit order – load into cart and switch to cart tab
         */
        editOrder: function(e) {
            e.preventDefault();
            e.stopPropagation();

            const orderId = $(e.currentTarget).data('order-id');
            const self = this;

            this.api('/orders/' + orderId).done(function(order) {
                if (order.status !== 'pending' || !order.items || order.items.length === 0) {
                    self.showMessage(ab2b_portal.strings.error || 'Unable to edit this order.', 'error');
                    return;
                }

                const cartItems = order.items.map(function(item) {
                    const product = self.products.find(p => p.id === item.product_id);
                    const weight = product ? product.weights.find(w => w.id === item.weight_id) : null;
                    return {
                        product_id: item.product_id,
                        weight_id: item.weight_id,
                        product_name: item.product_name,
                        product_image: product ? product.image : null,
                        weight_label: item.weight_label,
                        weight_value: weight ? (weight.value || 0) : 0,
                        weight_unit: weight ? (weight.unit || 'g') : 'g',
                        unit: weight ? (weight.unit || 'g') : 'g',
                        unit_price: item.unit_price,
                        unit_price_formatted: item.unit_price_formatted || self.formatPrice(item.unit_price),
                        quantity: item.quantity
                    };
                });

                self.cart = cartItems;
                self.editingOrderId = orderId;
                self.editingOrderData = {
                    delivery_date: order.delivery_date,
                    delivery_method: order.delivery_method || 'shipping',
                    special_instructions: order.special_instructions || ''
                };
                self.saveCart();
                self.updateCartUI();
                self.closeModal();
                self.renderCart();
                $('.ab2b-tab[data-tab="cart"]').click();
            }).fail(function() {
                self.showMessage(ab2b_portal.strings.error || 'Failed to load order.', 'error');
            });
        },

        /**
         * Delete (cancel) pending order
         */
        deleteOrder: function(e) {
            e.preventDefault();
            e.stopPropagation();

            const orderId = $(e.currentTarget).data('order-id');
            const self = this;
            const confirmMsg = ab2b_portal.strings.delete_order_confirm || 'Are you sure you want to delete this order?';

            if (!confirm(confirmMsg)) {
                return;
            }

            this.api('/orders/' + orderId, 'DELETE').done(function() {
                self.closeModal();
                self.loadOrders();
                self.showMessage(ab2b_portal.strings.order_deleted || 'Order deleted.', 'success');
            }).fail(function(xhr) {
                const msg = xhr.responseJSON?.message || ab2b_portal.strings.error;
                self.showMessage(msg, 'error');
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
                const isPending = order.status === 'pending';
                const actionBtns = isPending ? `
                    <div class="ab2b-order-actions">
                        <button type="button" class="ab2b-order-edit-btn" data-order-id="${order.id}" title="${ab2b_portal.strings.edit_order || 'Edit'}">${ab2b_portal.strings.edit_order || 'Edit'}</button>
                        <button type="button" class="ab2b-order-delete-btn" data-order-id="${order.id}" title="${ab2b_portal.strings.delete_order || 'Delete'}">${ab2b_portal.strings.delete_order || 'Delete'}</button>
                    </div>
                ` : '';
                html += `
                    <div class="ab2b-order-card" data-order-id="${order.id}">
                        <div class="ab2b-order-left">
                            <div class="ab2b-order-header">
                                <span class="ab2b-order-number">${order.order_number}</span>
                                <span class="ab2b-status ${order.status_class}">${order.status_label}</span>
                            </div>
                            <p class="ab2b-order-delivery">${order.delivery_method_label || 'Delivery'}: ${order.delivery_date_formatted}</p>
                        </div>
                        <div class="ab2b-order-right">
                            <div class="ab2b-order-total">${order.total_formatted}</div>
                            <div class="ab2b-order-date">${order.created_at_formatted}</div>
                            ${actionBtns}
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

                // Build tfoot with subtotal, shipping, total
                let tfootHtml = '';
                if (order.shipping_cost > 0) {
                    tfootHtml = `
                        <tr class="ab2b-order-subtotal-row">
                            <td colspan="4" style="text-align: right;">Subtotal</td>
                            <td>${order.subtotal_formatted}</td>
                        </tr>
                        <tr class="ab2b-order-shipping-row">
                            <td colspan="4" style="text-align: right;">Shipping</td>
                            <td>${order.shipping_cost_formatted}</td>
                        </tr>
                        <tr>
                            <td colspan="4" style="text-align: right;"><strong>Total</strong></td>
                            <td><strong>${order.total_formatted}</strong></td>
                        </tr>
                    `;
                } else {
                    tfootHtml = `
                        <tr>
                            <td colspan="4" style="text-align: right;">Total</td>
                            <td>${order.total_formatted}</td>
                        </tr>
                    `;
                }

                const deliveryMethodLabel = order.delivery_method_label || (order.delivery_method === 'pickup' ? 'Pick up' : 'Shipping');

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
                            <div class="ab2b-order-meta-item">
                                <span class="ab2b-order-meta-label">Delivery Method</span>
                                <span class="ab2b-order-meta-value">${deliveryMethodLabel}</span>
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
                                ${tfootHtml}
                            </tfoot>
                        </table>
                        ${order.special_instructions ? `<p><strong>Special Instructions:</strong> ${order.special_instructions}</p>` : ''}
                        ${order.status === 'pending' ? `
                        <div class="ab2b-order-detail-actions">
                            <button type="button" class="ab2b-btn ab2b-btn-primary ab2b-order-edit-btn" data-order-id="${order.id}">${ab2b_portal.strings.edit_order || 'Edit Order'}</button>
                            <button type="button" class="ab2b-btn ab2b-btn-outline ab2b-order-delete-btn" data-order-id="${order.id}">${ab2b_portal.strings.delete_order || 'Delete Order'}</button>
                        </div>
                        ` : ''}
                    </div>
                `;

                $('#ab2b-order-modal-body').html(html);
                self.scrollPos = window.pageYOffset;
                $('body').addClass('ab2b-modal-open').css('top', -self.scrollPos + 'px');
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
            if (tab === 'account') {
                this.loadCustomerProfile();
            }

            $('.ab2b-tab').removeClass('active');
            $('.ab2b-tab[data-tab="' + tab + '"]').addClass('active');

            $('.ab2b-tab-content').removeClass('active');
            $('#tab-' + tab).addClass('active');
        },

        /**
         * Load customer profile for Account tab
         */
        loadCustomerProfile: function() {
            const self = this;
            $('#ab2b-profile-form').hide();
            $('#ab2b-account-loading').show();

            this.api('/customer').done(function(customer) {
                $('#profile-company_name').val(customer.company_name || '');
                $('#profile-contact_name').val(customer.contact_name || '');
                $('#profile-address').val(customer.address || '');
                $('#profile-city').val(customer.city || '');
                $('#profile-postcode').val(customer.postcode || '');
                $('#profile-cvr_number').val(customer.cvr_number || '');
                $('#profile-delivery_company').val(customer.delivery_company || '');
                $('#profile-delivery_contact').val(customer.delivery_contact || '');
                $('#profile-delivery_address').val(customer.delivery_address || '');
                $('#profile-delivery_city').val(customer.delivery_city || '');
                $('#profile-delivery_postcode').val(customer.delivery_postcode || '');
                $('#profile-email').val(customer.email || '');
                $('#profile-invoice_email').val(customer.invoice_email || '');
                $('#profile-phone').val(customer.phone || '');
                $('#ab2b-account-loading').hide();
                $('#ab2b-profile-form').show();
            }).fail(function() {
                $('#ab2b-account-loading').hide();
                $('#ab2b-profile-form').show();
                self.showMessage(ab2b_portal.strings.error || 'Failed to load profile.', 'error');
            });
        },

        /**
         * Save customer profile
         */
        saveCustomerProfile: function(e) {
            e.preventDefault();
            const self = this;
            const $btn = $('#ab2b-profile-form button[type="submit"]');

            const data = {
                company_name: $('#profile-company_name').val(),
                contact_name: $('#profile-contact_name').val(),
                address: $('#profile-address').val(),
                city: $('#profile-city').val(),
                postcode: $('#profile-postcode').val(),
                cvr_number: $('#profile-cvr_number').val(),
                delivery_company: $('#profile-delivery_company').val(),
                delivery_contact: $('#profile-delivery_contact').val(),
                delivery_address: $('#profile-delivery_address').val(),
                delivery_city: $('#profile-delivery_city').val(),
                delivery_postcode: $('#profile-delivery_postcode').val(),
                email: $('#profile-email').val(),
                invoice_email: $('#profile-invoice_email').val(),
                phone: $('#profile-phone').val()
            };

            $btn.prop('disabled', true).text(ab2b_portal.strings.saving || 'Saving...');

            this.api('/customer', 'PUT', data).done(function(response) {
                self.showMessage(response.message || (ab2b_portal.strings.profile_updated || 'Your details have been updated.'), 'success');
            }).fail(function(xhr) {
                const msg = xhr.responseJSON?.message || ab2b_portal.strings.error;
                self.showMessage(msg, 'error');
            }).always(function() {
                $btn.prop('disabled', false).text(ab2b_portal.strings.save_changes || 'Save Changes');
            });
        },

        /**
         * Close modal
         */
        closeModal: function() {
            $('.ab2b-modal').removeClass('active');
            // Restore body scroll
            var scrollPos = AB2B_Portal.scrollPos || 0;
            $('body').removeClass('ab2b-modal-open').css('top', '');
            window.scrollTo(0, scrollPos);
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
