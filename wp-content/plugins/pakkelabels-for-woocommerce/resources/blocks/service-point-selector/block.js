import { CART_STORE_KEY } from '@woocommerce/block-data';
import { useEffect, useState } from '@wordpress/element'
import { useSelect } from '@wordpress/data';
import ServicePointSelector from './components/ServicePointSelector';

export const ServicePointSelectorBlock = ({checkoutExtensionData, extensions}) => {

    const store = useSelect(CART_STORE_KEY)

    const storeShippingRates = store.getShippingRates()

    const [shippingRates, setShippingRates] = useState([])

    useEffect(() => {
        let mergedShippingRates = []

        storeShippingRates.forEach((shippingRate) => {
            mergedShippingRates.push(shippingRate)
        })

        // Make support for subscriptions by including subscription carts
        extensions.subscriptions?.forEach((subscription) => {
            subscription.shipping_rates.forEach((shippingRate) => {
                mergedShippingRates.push(shippingRate)
            })
        })

        setShippingRates(mergedShippingRates)
    }, [storeShippingRates, extensions?.subscriptions])

    return (
        <>
            {
                shippingRates.map((shippingPackage) => {
                    return (
                        <ServicePointSelector shippingPackage={shippingPackage} checkoutExtensionData={checkoutExtensionData} displayPackageTitle={shippingRates.length > 1}  key={shippingPackage.package_id} />
                    )
                })
            }
        </>
    );
}