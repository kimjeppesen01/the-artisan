import { AdvancedMarker, useAdvancedMarkerRef, InfoWindow, Pin } from "@vis.gl/react-google-maps"
import { __, _x, sprintf } from "@wordpress/i18n"

export default function GoogleMapMarker({servicePoint, onSelect, onToggleInfoWindow, isInfoWindowOpen, iconUrl}) {
    const [markerRef, marker] = useAdvancedMarkerRef()

    return (
        <AdvancedMarker
            key={servicePoint.id}
            position={{lat: servicePoint.latitude, lng: servicePoint.longitude}}

            onClick={() => onToggleInfoWindow(!isInfoWindowOpen)}
            ref={markerRef}
        >
            <img src={iconUrl} width={'48px'} height={'48px'} />
            { isInfoWindowOpen ? (
                <InfoWindow
                    anchor={marker}
                    maxWidth={300}
                    minWidth={200}
                    onCloseClick={() => onToggleInfoWindow(false)}
                >
                    <div key={servicePoint.id} className={'shipmondo-modal-map_info-window'}>
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
                            <div className={'distance'}>
                                {sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'), parseFloat((servicePoint.distance / 1000).toFixed(2)))}
                            </div>
                        </div>
                        <button className={'button'} onClick={() => onSelect(servicePoint)}>{__('Select', 'pakkelabels-for-woocommerce')}</button>
                    </div>
                </InfoWindow>
            ) : null}
        </AdvancedMarker>
    )
}