import { _x } from '@wordpress/i18n'
import { sprintf } from '@wordpress/i18n'


export default function ServicePointList({servicePoints, onSelect, selectedServicePoint}) {
    return (
        <div className={'service_points_list'}>
            {
                servicePoints.map((servicePoint) => {
                    return (
                        <div key={servicePoint.id} className={'service_point' + (selectedServicePoint && selectedServicePoint.id === servicePoint.id ? ' selected' : '')}
                             onClick={() => onSelect(servicePoint)}>
                            <div className={'header'}>
                                <span className={'name'}>{servicePoint.name}</span>
                            </div>
                            <div className={'location'}>
                                <div className={'address_info'}>
                                    {sprintf(_x('%1$s, %2$s %3$s', 'Address display: %1$s - street and number, %2$s zipcode and %3$s city', 'pakkelabels-for-woocommerce'),
                                        servicePoint.address,
                                        servicePoint.zipcode,
                                        servicePoint.city
                                    )}
                                </div>
                                <div
                                    className={'distance'}>{sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'), parseFloat((servicePoint.distance / 1000).toFixed(2)))}</div>
                            </div>
                        </div>
                    )
                })
            }
        </div>
    )
}