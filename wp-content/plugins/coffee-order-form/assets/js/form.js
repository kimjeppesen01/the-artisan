(function($) {
    'use strict';

    class CoffeeOrderForm {
        constructor(container) {
            this.container = $(container);
            this.emails = this.container.data('emails');
            this.customer = this.container.data('customer');
            this.editKey = this.container.data('edit-key');
            this.productsString = this.container.data('products');
            this.pageId = this.container.data('page-id');
            this.minDaysBefore = parseInt(this.container.data('min-days-before')) || 2;
            this.products = this.productsString.split(',').map(p => p.trim());
            
            // Check if edit mode is active
            this.isEditMode = this.checkEditMode();
            
            this.newOrders = [];
            this.confirmedOrders = [];
            
            this.init();
        }
        
        checkEditMode() {
            const urlParams = new URLSearchParams(window.location.search);
            const editParam = urlParams.get('edit');
            return editParam === this.editKey;
        }
        
        init() {
            this.render();
            this.attachEvents();
            this.loadConfirmedOrders();
        }
        
        render() {
            const html = `
                <div class="cof-message-container"></div>
                
                <!-- Table 1: New Order Form -->
                <div class="cof-section">
                    <h3 class="cof-section-title">Place New Order</h3>
                    <p class="cof-info-text">Orders must be placed at least ${this.minDaysBefore} days before delivery date.</p>
                    <div class="coffee-order-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Delivery Date</th>
                                    <th>Product</th>
                                    <th>Weight</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="cof-new-orders-body">
                            </tbody>
                        </table>
                    </div>
                    <div class="cof-actions">
                        <button type="button" class="cof-btn cof-btn-secondary cof-add-new-order">Add New Line</button>
                        <button type="button" class="cof-btn cof-btn-primary cof-submit-new-orders">Send Order</button>
                    </div>
                </div>
                
                <!-- Table 2: Order Confirmation -->
                <div id="ordrer" class="cof-section cof-confirmed-section">
                    <h3 class="cof-section-title">Order Confirmation ${this.isEditMode ? '<span class="cof-edit-badge">EDIT MODE</span>' : ''}</h3>
                    <div class="coffee-order-table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Order Date</th>
                                    <th>Expected Delivery</th>
                                    <th>Product</th>
                                    <th>Weight</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    ${this.isEditMode ? '<th>Action</th>' : ''}
                                </tr>
                            </thead>
                            <tbody class="cof-confirmed-orders-body">
                                <tr><td colspan="${this.isEditMode ? '7' : '6'}" style="text-align: center;">Loading orders...</td></tr>
                            </tbody>
                        </table>
                    </div>
                    ${this.isEditMode ? '<div class="cof-actions"><button type="button" class="cof-btn cof-btn-secondary cof-add-confirmed-order">Add New Line</button><button type="button" class="cof-btn cof-btn-primary cof-save-confirmed-orders">Save Changes</button></div>' : ''}
                </div>
            `;
            
            this.container.html(html);
            
            // Add one default row to new orders
            this.addNewOrderRow();
        }
        
        attachEvents() {
            const self = this;
            
            // New order events
            this.container.on('click', '.cof-add-new-order', function() {
                self.addNewOrderRow();
            });
            
            this.container.on('click', '.cof-delete-new-order', function() {
                $(this).closest('tr').remove();
            });
            
            this.container.on('click', '.cof-submit-new-orders', function() {
                self.submitNewOrders();
            });
            
            // Confirmed order events (only in edit mode)
            if (this.isEditMode) {
                this.container.on('click', '.cof-add-confirmed-order', function() {
                    self.addConfirmedOrderRow();
                });
                
                this.container.on('click', '.cof-delete-confirmed-order', function() {
                    $(this).closest('tr').remove();
                });
                
                this.container.on('click', '.cof-save-confirmed-orders', function() {
                    self.saveConfirmedOrders();
                });
            }
        }
        
        getNextFriday() {
            const today = new Date();
            const dayOfWeek = today.getDay();
            let daysUntilFriday;
            
            if (dayOfWeek < 4) {
                daysUntilFriday = 5 - dayOfWeek;
            } else {
                daysUntilFriday = (12 - dayOfWeek) % 7;
                if (daysUntilFriday === 0) daysUntilFriday = 7;
            }
            
            const nextFriday = new Date(today);
            nextFriday.setDate(today.getDate() + daysUntilFriday);
            
            // Add minimum days buffer
            const minDate = new Date(today);
            minDate.setDate(today.getDate() + this.minDaysBefore);
            
            // If next Friday is before minimum date, go to the following Friday
            if (nextFriday < minDate) {
                nextFriday.setDate(nextFriday.getDate() + 7);
            }
            
            return nextFriday.toISOString().split('T')[0];
        }
        
        getMinimumDeliveryDate() {
            const today = new Date();
            const minDate = new Date(today);
            minDate.setDate(today.getDate() + this.minDaysBefore);
            return minDate.toISOString().split('T')[0];
        }
        
        addNewOrderRow() {
            const nextFriday = this.getNextFriday();
            const minDate = this.getMinimumDeliveryDate();
            const productsHtml = this.products.map(product => 
                `<option value="${product}">${product}</option>`
            ).join('');
            
            const rowHtml = `
                <tr>
                    <td>
                        <input type="date" class="cof-delivery-date" value="${nextFriday}" min="${minDate}" />
                    </td>
                    <td>
                        <select class="cof-product">
                            <option value="">Select Product</option>
                            ${productsHtml}
                        </select>
                    </td>
                    <td>
                        <select class="cof-weight">
                            <option value="250g">250g</option>
                            <option value="1kg">1kg</option>
                            <option value="8kg" selected>8kg</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="cof-amount" value="1" min="1" step="1" />
                    </td>
                    <td>
                        <button type="button" class="cof-delete-btn cof-delete-new-order">Delete</button>
                    </td>
                </tr>
            `;
            
            this.container.find('.cof-new-orders-body').append(rowHtml);
            this.setupFridayOnlyDatePicker();
        }
        
        setupFridayOnlyDatePicker() {
            const self = this;
            this.container.find('.cof-delivery-date').each(function() {
                const input = $(this);
                
                input.on('input change', function() {
                    const selectedDate = new Date(this.value);
                    const dayOfWeek = selectedDate.getDay();
                    const today = new Date();
                    const minDate = new Date(today);
                    minDate.setDate(today.getDate() + self.minDaysBefore);
                    
                    // Check if it's a Friday
                    if (dayOfWeek !== 5) {
                        alert('Please select a Friday for delivery.');
                        this.value = '';
                        return;
                    }
                    
                    // Check if it meets minimum days requirement
                    if (selectedDate < minDate) {
                        alert(`Orders must be placed at least ${self.minDaysBefore} days before delivery date.`);
                        this.value = '';
                        return;
                    }
                });
            });
        }
        
        addConfirmedOrderRow(orderData = null) {
            const data = orderData || {
                order_date: new Date().toISOString().split('T')[0],
                delivery_date: this.getNextFriday(),
                product: '',
                weight: '8kg',
                amount: 1,
                status: 'Pending'
            };
            
            const productsHtml = this.products.map(product => 
                `<option value="${product}" ${product === data.product ? 'selected' : ''}>${product}</option>`
            ).join('');
            
            // Determine status class for styling
            let statusClass = '';
            if (data.status === 'Confirmed') statusClass = 'status-confirmed';
            if (data.status === 'Unavailable') statusClass = 'status-unavailable';
            if (data.status === 'Pending') statusClass = 'status-pending';
            
            const rowHtml = `
                <tr data-order-id="${data.id || ''}" class="${statusClass}">
                    <td>
                        <input type="date" class="cof-confirmed-order-date" value="${data.order_date}" ${!this.isEditMode ? 'disabled' : ''} />
                    </td>
                    <td>
                        <input type="date" class="cof-confirmed-delivery-date" value="${data.delivery_date}" ${!this.isEditMode ? 'disabled' : ''} />
                    </td>
                    <td>
                        <select class="cof-confirmed-product" ${!this.isEditMode ? 'disabled' : ''}>
                            <option value="">Select Product</option>
                            ${productsHtml}
                        </select>
                    </td>
                    <td>
                        <select class="cof-confirmed-weight" ${!this.isEditMode ? 'disabled' : ''}>
                            <option value="250g" ${data.weight === '250g' ? 'selected' : ''}>250g</option>
                            <option value="1kg" ${data.weight === '1kg' ? 'selected' : ''}>1kg</option>
                            <option value="8kg" ${data.weight === '8kg' ? 'selected' : ''}>8kg</option>
                        </select>
                    </td>
                    <td>
                        <input type="number" class="cof-confirmed-amount" value="${data.amount}" min="1" ${!this.isEditMode ? 'disabled' : ''} />
                    </td>
                    <td>
                        <select class="cof-confirmed-status" ${!this.isEditMode ? 'disabled' : ''}>
                            <option value="Pending" ${data.status === 'Pending' ? 'selected' : ''}>⏳ Pending</option>
                            <option value="Confirmed" ${data.status === 'Confirmed' ? 'selected' : ''}>✓ Confirmed</option>
                            <option value="Unavailable" ${data.status === 'Unavailable' ? 'selected' : ''}>✗ Unavailable</option>
                        </select>
                    </td>
                    ${this.isEditMode ? '<td><button type="button" class="cof-delete-btn cof-delete-confirmed-order">Delete</button></td>' : ''}
                </tr>
            `;
            
            this.container.find('.cof-confirmed-orders-body').append(rowHtml);
        }
        
        loadConfirmedOrders() {
            const self = this;
            
            $.ajax({
                url: cofData.restUrl + 'orders/' + this.pageId,
                method: 'GET',
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', cofData.nonce);
                },
                success: function(response) {
                    self.container.find('.cof-confirmed-orders-body').empty();
                    
                    if (response.orders && response.orders.length > 0) {
                        response.orders.forEach(order => {
                            self.addConfirmedOrderRow(order);
                        });
                    } else {
                        const colspan = self.isEditMode ? '7' : '6';
                        self.container.find('.cof-confirmed-orders-body').html(
                            `<tr><td colspan="${colspan}" style="text-align: center;">No orders yet</td></tr>`
                        );
                    }
                },
                error: function() {
                    self.showMessage('Failed to load confirmed orders', 'error');
                }
            });
        }
        
        collectNewOrders() {
            const orders = [];
            
            this.container.find('.cof-new-orders-body tr').each(function() {
                const row = $(this);
                const order = {
                    delivery_date: row.find('.cof-delivery-date').val(),
                    product: row.find('.cof-product').val(),
                    weight: row.find('.cof-weight').val(),
                    amount: row.find('.cof-amount').val()
                };
                orders.push(order);
            });
            
            return orders;
        }
        
        collectConfirmedOrders() {
            const orders = [];
            
            this.container.find('.cof-confirmed-orders-body tr').each(function() {
                const row = $(this);
                const orderId = row.data('order-id');
                const order = {
                    id: orderId || uniqid(),
                    order_date: row.find('.cof-confirmed-order-date').val(),
                    delivery_date: row.find('.cof-confirmed-delivery-date').val(),
                    product: row.find('.cof-confirmed-product').val(),
                    weight: row.find('.cof-confirmed-weight').val(),
                    amount: row.find('.cof-confirmed-amount').val(),
                    status: row.find('.cof-confirmed-status').val()
                };
                orders.push(order);
            });
            
            return orders;
        }
        
        validateNewOrders(orders) {
            if (orders.length === 0) {
                this.showMessage('Please add at least one order line.', 'error');
                return false;
            }
            
            const today = new Date();
            const minDate = new Date(today);
            minDate.setDate(today.getDate() + this.minDaysBefore);
            
            for (let i = 0; i < orders.length; i++) {
                const order = orders[i];
                if (!order.delivery_date || !order.product || !order.weight || !order.amount) {
                    this.showMessage('Please fill in all required fields.', 'error');
                    return false;
                }
                
                // Validate Friday
                const date = new Date(order.delivery_date);
                if (date.getDay() !== 5) {
                    this.showMessage('Delivery date must be a Friday.', 'error');
                    return false;
                }
                
                // Validate minimum days before
                if (date < minDate) {
                    this.showMessage(`Orders must be placed at least ${this.minDaysBefore} days before delivery.`, 'error');
                    return false;
                }
            }
            
            return true;
        }
        
        submitNewOrders() {
            const orders = this.collectNewOrders();
            
            if (!this.validateNewOrders(orders)) {
                return;
            }
            
            const submitBtn = this.container.find('.cof-submit-new-orders');
            submitBtn.prop('disabled', true).text('Sending...');
            
            const data = {
                orders: orders,
                emails: this.emails,
                customer: this.customer,
                page_id: this.pageId
            };
            
            $.ajax({
                url: cofData.restUrl + 'submit',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', cofData.nonce);
                },
                success: (response) => {
                    this.showMessage(response.message, 'success');
                    this.container.find('.cof-new-orders-body').empty();
                    this.addNewOrderRow();
                    this.loadConfirmedOrders();
                    submitBtn.prop('disabled', false).text('Send Order');
                },
                error: (xhr) => {
                    const error = xhr.responseJSON?.message || 'Failed to submit order.';
                    this.showMessage(error, 'error');
                    submitBtn.prop('disabled', false).text('Send Order');
                }
            });
        }
        
        saveConfirmedOrders() {
            const orders = this.collectConfirmedOrders();
            
            const saveBtn = this.container.find('.cof-save-confirmed-orders');
            saveBtn.prop('disabled', true).text('Saving...');
            
            const urlParams = new URLSearchParams(window.location.search);
            const providedKey = urlParams.get('edit');
            
            const data = {
                orders: orders,
                edit_key: this.editKey,
                provided_key: providedKey,
                customer_email: this.container.data('customer-email'),
                customer_name: this.customer,
                company_logo: this.container.data('company-logo')
            };
            
            $.ajax({
                url: cofData.restUrl + 'orders/' + this.pageId,
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                beforeSend: function(xhr) {
                    xhr.setRequestHeader('X-WP-Nonce', cofData.nonce);
                },
                success: (response) => {
                    this.showMessage(response.message, 'success');
                    this.loadConfirmedOrders();
                    saveBtn.prop('disabled', false).text('Save Changes');
                },
                error: (xhr) => {
                    const error = xhr.responseJSON?.message || 'Failed to save changes.';
                    this.showMessage(error, 'error');
                    saveBtn.prop('disabled', false).text('Save Changes');
                }
            });
        }
        
        showMessage(message, type) {
            const messageHtml = `
                <div class="cof-message ${type}">
                    ${message}
                </div>
            `;
            
            this.container.find('.cof-message-container').html(messageHtml);
            
            setTimeout(() => {
                this.container.find('.cof-message').fadeOut();
            }, 5000);
        }
    }
    
    function uniqid() {
        return Date.now().toString(36) + Math.random().toString(36).substr(2);
    }
    
    $(document).ready(function() {
        $('.coffee-order-form-container').each(function() {
            new CoffeeOrderForm(this);
        });
    });
    
})(jQuery);