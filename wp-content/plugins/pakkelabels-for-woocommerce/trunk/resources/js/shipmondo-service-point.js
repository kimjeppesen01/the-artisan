jQuery(document).ready(function($) {
    // Get parent wrapper
    function getWrapper(element) {
        return element.parents('.shipmondo_service_point_selection')
    }

    // get the shipping index from the parent
    function getShippingIndex(element) {
        return getWrapper(element).data('shipping_index')
    }

    // get the shipping index from the parent
    function getShippingAgent(element) {
        return getWrapper(element).data('shipping_agent')
    }

    function getSelectedServicePoint(element) {
        return getWrapper(element).data('selected_service_point')
    }

    function setSelectedServicePoint(element, servicePoint) {
        getWrapper(element).data('selected_service_point', servicePoint)
    }

    // Set HTML and input fields
    function setShopHTML(index, servicePoint, servicePointElement) {
        const wrapper = getWrapper(servicePointElement)

        wrapper.find('input[name="shipmondo[' + index + ']"]').val(servicePoint.id)
        wrapper.find('input[name="shop_name[' + index + ']"]').val(servicePoint.name)
        wrapper.find('input[name="shop_address[' + index + ']"]').val(servicePoint.address)
        wrapper.find('input[name="shop_zip[' + index + ']"]').val(servicePoint.zipcode)
        wrapper.find('input[name="shop_city[' + index + ']"]').val(servicePoint.city)

        wrapper.find('.selected_service_point .name').html(servicePoint.name)
        wrapper.find('.selected_service_point .address_info').html(servicePointElement.data('address'))
        wrapper.find('.selected_service_point .distance').html(servicePointElement.data('distance'))

        wrapper.find('.service_point.selected').removeClass('selected')
        servicePointElement.addClass('selected')
    }

    // Set shop session
    function setSelectionSession(shop, agent, index) {
        $.post(shipmondo.ajax_url,
            {
                'action': 'shipmondo_set_selection_session',
                'selection': shop,
                'agent': agent,
                'shipping_index': index,
            }, function(result) {

            })
    }

    // Service point selected
    function ServicePointSelected(shopElement) {
        var index = getShippingIndex(shopElement)
        var agent = getShippingAgent(shopElement)
        const selectedServicePoint = getSelectedServicePoint(shopElement)

        const servicePoint = shopElement.data('service_point')

        if(selectedServicePoint.id === servicePoint.id) {
            return
        }

        var shop = {
            'id': servicePoint.id,
            'name': servicePoint.name,
            'address': servicePoint.address,
            'zipcode': servicePoint.zipcode,
            'city': servicePoint.city,
        }

        setSelectedServicePoint(shopElement, servicePoint)

        setSelectionSession(shop, agent, index)

        setShopHTML(index, shop, shopElement)
    }

    // MODAL

    // Show modal
    $(document).on('click', '.shipmondo-original .selected_service_point.selector_type-modal', function(e) {
        e.stopPropagation()
        openModal(getModal($(e.target)))
    })

    // Hide modal on close button
    $(document).on('click', '.shipmondo-original .shipmondo-modal_close', function(e) {
        e.preventDefault()
        closeModal(getModal($(e.target)))
    });

    // Hide modal when clicking outsite modal content
    $(document).on('click', '.shipmondo-original .shipmondo-modal', function(e) {
        if(typeof e.target !== 'undefined' && $(e.target).hasClass('shipmondo-modal')) {
            closeModal(getModal($(e.target)))
        }
    });

    function getModal(element) {
        return getWrapper(element).find('.shipmondo-modal')
    }

    function openModal(modal) {
        modal.removeClass('shipmondo-hidden')

        initializeMap(modal)

        setTimeout(function() {
            $('body').addClass('shipmondo_modal_open')
            modal.addClass('visible')
            modal.find('.shipmondo-modal_content').addClass('visible')
        }, 100)
    }

    function closeModal(modal) {
        modal.removeClass('visible')

        $('body').removeClass('shipmondo_modal_open')

        setTimeout(function() {
            $('.shipmondo-modal-checkmark').removeClass('visible')
            modal.addClass('shipmondo-hidden')
        }, 300)
    }

    function loadGoogleMaps() {
        // Create the script tag, set the appropriate attributes
        var script = document.createElement('script')
        script.src = 'https://maps.googleapis.com/maps/api/js?key=' + shipmondo['google_maps_api_key'] + '&loading=async&callback=googleMapsInit'
        script.async = true

        // Append the 'script' element to 'head'
        document.head.appendChild(script)
    }

    // Render map
    var map = null
    var bounds = null
    var infowindow = null

    function renderMap(element) {
        map = new google.maps.Map(element[0], {
            zoom: 6,
            center: {lat: 55.9150835, lng: 10.4713954},
            mapTypeControl: false,
            streetViewControl: false,
            fullscreenControl: false
        })

        infowindow = new google.maps.InfoWindow()

        bounds = new google.maps.LatLngBounds()

        const servicePoints = element.data('service_points')

        const selectedServicePoint = getSelectedServicePoint(element)

        $.each(servicePoints, function(index, element) {
            shipmondoLoadMarker(element, selectedServicePoint)
        });

        setTimeout(function () {
            map.fitBounds(bounds)
        }, 100)
    }

    // Render Markers
    function shipmondoLoadMarker(data, selectedServicePoint) {
        var marker = new google.maps.Marker({
            position: {lat: parseFloat(data.latitude), lng: parseFloat(data.longitude)},
            map: map,
            icon: {
                url: selectedServicePoint.id === data.id ? shipmondo['icon_url_selected'] : shipmondo['icon_url'],
                size: new google.maps.Size(48, 48),
                scaledSize: new google.maps.Size(48, 48),
                anchor: new google.maps.Point(24, 24)
            }
        })

        google.maps.event.addListener(marker, 'click', (function (marker) {
            return function () {
                infowindow.setContent('<strong>' + data.company_name + '</strong><br/>' + data.address + "<br/> " + data.city + ' <br/> ' + data.zipcode + '<br/><div id="shipmondo-button-wrapper"><button class="button" id="shipmondo-select-shop" data-number="' + data.number + '">' + shipmondo.select_shop_text + '</button></div>')
                infowindow.open(map, marker)
            }
        })(marker))

        bounds.extend(marker.position)
    }

    var currentModalElement = null

    function initializeMap(modal) {
        if(typeof google === 'undefined' || typeof google.maps === 'undefined') {
            currentModalElement = modal
            loadGoogleMaps()
        } else {
            renderMap(modal.find('.service_points_map'))
        }
    }

    // Render map after google maps load
    $(document).on('googleMapsLoaded', function() {
        renderMap(currentModalElement.find('.service_points_map'))
    })

    // Select shop
    $(document).on('click', '.shipmondo-original .selector_type-modal .service_points_list .service_point', function() {
        ServicePointSelected($(this));

        $('.shipmondo-modal_content').removeClass('visible');
        $('.shipmondo-modal-checkmark').addClass('visible');

        const modal = getModal($(this))

        setTimeout(function() {
            closeModal(modal);
        }, 1800);
    });

    // Select shop
    $(document).on('click', '.shipmondo-original #shipmondo-select-shop', function(e) {
        e.preventDefault();

        var servicePointElement = getWrapper($(this)).find('.service_point[data-id=' + $(this).data('number') + ']');

        servicePointElement.trigger('click');
    });

    // DROPDOWN
    // Open dropdown
    $(document).on('click', '.shipmondo-original .selected_service_point.selector_type-dropdown', function(e) {
        e.stopPropagation()
        toggleDropdown($(this))
    })

    function getDropdown(element) {
        return getWrapper(element).find('.shipmondo-dropdown_wrapper');
    }

    function toggleDropdown(element) {
        const dropdown = getDropdown(element);

        if(element.hasClass('visible')) {
            closeDropdown(dropdown);
        } else {
            openDropdown(dropdown);
        }
    }

    function openDropdown(dropdownElement) {
        dropdownElement.addClass('visible');
        getWrapper(dropdownElement).find('.selected_service_point').addClass('selector_open');
    }

    function closeDropdown(dropdownElement) {
        dropdownElement.removeClass('visible');
        getWrapper(dropdownElement).find('.selected_service_point').removeClass('selector_open');
    }

    // Hide dropdown when clicked outsite of it
    $(document).on('click', function(e) {
        var dropdown = $('.shipmondo-original .shipmondo-dropdown_wrapper.visible');

        if(dropdown.length > 0 && (!dropdown.is(e.target) && dropdown.has(e.target).length === 0)) {
            closeDropdown(dropdown);
        }
    })

    // Set selected shop
    $(document).on('click', '.shipmondo-original .selector_type-dropdown .service_points_list .service_point', function() {
        ServicePointSelected($(this));

        closeDropdown(getDropdown($(this)));
    });
});

window.googleMapsInit = function googleMapsInit() {
    jQuery(document).trigger('googleMapsLoaded');
}