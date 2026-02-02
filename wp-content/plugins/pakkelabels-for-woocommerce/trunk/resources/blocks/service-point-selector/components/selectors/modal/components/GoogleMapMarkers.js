import { useMapsLibrary, useMap } from '@vis.gl/react-google-maps'
import { useEffect, useState } from '@wordpress/element'
import GoogleMapMarker from './GoogleMapMarker'

export default function GoogleMap({servicePoints, onSelect, selectedServicePoint, iconUrl, iconUrlSelected}) {
    const mapsLibrary = useMapsLibrary('core')
    const map = useMap()

    const [openInfoWindow, setOpenInfoWindow] = useState(null)

    useEffect(() => {
        if(!mapsLibrary || !map) {
            return
        }

        const bounds = new mapsLibrary.LatLngBounds()

        servicePoints.forEach((servicePoint) => {
            bounds.extend(new mapsLibrary.LatLng(servicePoint.latitude, servicePoint.longitude))
        })

        map.fitBounds(bounds);
    }, [servicePoints, map, mapsLibrary])

    return (
        <>
            {
                servicePoints.map((servicePoint) => {
                    return (
                        <GoogleMapMarker
                            isInfoWindowOpen={openInfoWindow === servicePoint.id }
                            onToggleInfoWindow={(open) => setOpenInfoWindow(open ? servicePoint.id : null)}
                            key={servicePoint.id}
                            servicePoint={servicePoint}
                            onSelect={onSelect}
                            iconUrl={selectedServicePoint && selectedServicePoint.id === servicePoint.id ? iconUrlSelected : iconUrl}
                        />
                    )
                })
            }
        </>
    )
}