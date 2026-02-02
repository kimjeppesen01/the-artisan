import { __, _x } from '@wordpress/i18n'
import apiFetch from '@wordpress/api-fetch'
import { useEffect, useState } from '@wordpress/element'
import { sprintf } from '@wordpress/i18n'
import Dropdown from './selectors/dropdown/Dropdown'
import Modal from './selectors/modal/Modal'
import { useSelect, useDispatch } from '@wordpress/data'
import { CART_STORE_KEY, CHECKOUT_STORE_KEY, VALIDATION_STORE_KEY } from '@woocommerce/block-data'
import { getSetting } from '@woocommerce/settings'

export default function ServicePointSelector({shippingPackage, checkoutExtensionData, displayPackageTitle = false}) {
    // Get selected shipping rate
    const selectedRate = shippingPackage.shipping_rates.find((rate) => rate.selected)

    if(!selectedRate) {
        return null
    }

    // Check if selected shipping rate is a service point delivery
    const isServicePointDelivery = selectedRate.method_id === 'shipmondo' && typeof selectedRate.meta_data.find((e) => e.key === 'is_service_point_delivery' && e.value) !== 'undefined'

    // Get shipping agent
    const agent = selectedRate.meta_data.find((e) => e.key === 'shipping_agent')?.value ?? null

    // if not service point delivery or no agent, return null
    if (!isServicePointDelivery || !agent) {
        return null
    }

    // List of available service points based on the shipping agent and the shipping address
    const [servicePoints, setServicePoints] = useState([])

    // Selected service point - used to check if user has selected a service point and not just used the first on the list
    const [selectedServicePoint, setSelectedServicePoint] = useState(sessionStorage.getItem('shipmondo_selected_service_point') ?? null)

    // The Service Point to ship to
    const [servicePoint, setServicePoint] = useState(null)

    const selectServicePoint = (servicePoint) => {
        setSelectedServicePoint(servicePoint.id)
        setServicePoint(servicePoint)
        setIsSelectorOpen(false)
    }

    useEffect(() => {
        if (selectedServicePoint) {
            sessionStorage.setItem('shipmondo_selected_service_point', selectedServicePoint)
        }
    }, [selectedServicePoint])

    const {setValidationErrors, clearValidationError} = useDispatch(VALIDATION_STORE_KEY)

    useEffect(() => {
        if (!isServicePointDelivery || servicePoint) {
            clearValidationError('shipmondo_service_point')
        } else {
            setValidationErrors({
                'shipmondo_service_point': {
                    'message': __('Please select a service point', 'pakkelabels-for-woocommerce'),
                    'hidden': true
                }
            })
        }
    }, [servicePoint]);

    const {getValidationError} = useSelect((select) => select(VALIDATION_STORE_KEY), [])

    const validationError = getValidationError('shipmondo_service_point')

    // Loader for the API request
    const [apiLoader, setApiLoader] = useState(false)

    // Selector open state
    const [isSelectorOpen, setIsSelectorOpen] = useState(false)

    const toggleSelector = () => {
        if (servicePoints.length > 0) {
            setIsSelectorOpen(!isSelectorOpen)
        } else {
            setIsSelectorOpen(false)
        }
    }

    // Get Service point from the extension data
    const extensionData = useSelect((select) => select(CHECKOUT_STORE_KEY).getExtensionData(), []);

    const {setExtensionData} = checkoutExtensionData;

    // Get service points based on the shipping agent and the shipping address
    const getServicePoints = async () => {
        if(!isServicePointDelivery || shippingPackage.destination.postcode === '') {
            setServicePoints([])

            return;
        }

        setApiLoader(true)
        apiFetch({
            path: 'shipmondo/v1/service-points',
            method: 'POST',
            data: {
                agent: agent,
                address: shippingPackage.destination.address_1,
                zipcode: shippingPackage.destination.postcode,
                country: shippingPackage.destination.country
            },
            parse: false
        }).then((response) => {
            if (response.status === 200) {
                return response.json()
            }
        }).then((data) => {
            setServicePoints(data)
            setApiLoader(false)
        })
    }

    // Get service points on shipping agent or shipping address change
    useEffect(() => {
        getServicePoints()
    }, [shippingPackage.destination, agent])

    // If shipping rate is being selected, show loader
    const isShippingRateBeingSelected = useSelect((select) => select(CART_STORE_KEY).isShippingRateBeingSelected(), false)

    useEffect(() => {
        setApiLoader(isShippingRateBeingSelected)
    }, [isShippingRateBeingSelected])

    // Close selector if the loader is active
    useEffect(() => {
        if (apiLoader) {
            setIsSelectorOpen(false)
        }
    }, [apiLoader])

    // Set service point to the first one in the list if not the selected service point exists in the list
    useEffect(() => {
        if (selectedServicePoint && typeof servicePoints.find((e) => selectedServicePoint === e.id) !== 'undefined') {
            setServicePoint(servicePoints.find((e) => selectedServicePoint === e.id))
        } else if (extensionData && extensionData[shippingPackage.package_id] && typeof servicePoints.find((e) => extensionData[shippingPackage.package_id].id === e.id) !== 'undefined') {
            setServicePoint(extensionData[shippingPackage.package_id])
        } else {
            setServicePoint(servicePoints[0])
        }
    }, [servicePoints])

    // Save selected service point to local storage when changed
    useEffect(() => {
        if (servicePoint) {
            setExtensionData('shipmondo', 'selected_service_points', {
                ...extensionData?.shipmondo?.selected_service_points || {},
                [shippingPackage.package_id]: servicePoint
            })
        }
    }, [servicePoint])

    const settings = getSetting('shipmondo-service-point-selector_data')

    const selectorType = settings.selector_type ?? 'dropdown'

    let selector = null

    if(selectorType === 'dropdown') {
        selector = (
            <Dropdown
                servicePoints={servicePoints}
                selectedServicePoint={servicePoint}
                onSelect={selectServicePoint}
            />
        )
    } else if(selectorType === 'modal') {
        selector = (
            <Modal
                servicePoints={servicePoints}
                selectedServicePoint={servicePoint}
                onSelect={selectServicePoint}
                onClose={() => setIsSelectorOpen(false)}
                mapsSettings={settings.maps_settings}
            />
        )
    }

    return (
        <div className={'shipmondo_service_point_selection'}>
            <h3 className={'service_point_title'}>{__('Service Point', 'pakkelabels-for-woocommerce')}{displayPackageTitle ? ' - ' + shippingPackage.name : null}</h3>

            <div className={'selected_service_point service_point ' + selectorType + (apiLoader ? ' loading' : '') + (isSelectorOpen ? ' selector_open' : '') + (servicePoints.length === 0 ? ' no_service_point' : '') + (!validationError || validationError.hidden ? '' : ' has-error')} onClick={toggleSelector}>
                {
                    servicePoint ? (
                        <>
                            <div className={'header'}>
                                <span className={'name'}>{servicePoint.name}</span>
                                <span className={'rate_name'}>{selectedRate.name}</span>
                            </div>
                            <div className={'location'}>
                                <div className={'address_info'}>
                                    {sprintf(_x('%1$s, %2$s %3$s', 'Address display: %1$s - street and number, %2$s zipcode and %3$s city', 'pakkelabels-for-woocommerce'),
                                        servicePoint.address,
                                        servicePoint.zipcode,
                                        servicePoint.city
                                    )}
                                </div>
                                <div className={'distance'}>
                                    {sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'), parseFloat((servicePoint.distance / 1000).toFixed(2)))}
                                </div>
                            </div>
                        </>
                    ) : (
                        <>
                            {
                                shippingPackage.destination.postcode === '' ? (
                                    <>
                                        {__('Please enter the shipping address to see available service points', 'pakkelabels-for-woocommerce')}
                                    </>
                                ) : (
                                    <>
                                        {__('No service point available', 'pakkelabels-for-woocommerce')}
                                    </>
                                )
                            }
                        </>
                    )
                }
            </div>
            {
                servicePoints && isSelectorOpen ? selector : null
            }
            {
                !validationError || validationError.hidden ? null : (
                    <div className={'wc-block-components-validation-error'}>
                        <p>{validationError?.message}</p>
                    </div>
                )
            }
            <div className={'powered_by_shipmondo'}>
                <p>{__('Powered by Shipmondo', 'pakkelabels-for-woocommerce')}</p>
            </div>
        </div>
    )
}