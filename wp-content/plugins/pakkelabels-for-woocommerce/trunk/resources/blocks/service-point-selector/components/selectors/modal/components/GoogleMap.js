import {APIProvider, Map} from '@vis.gl/react-google-maps';
import GoogleMapsMarkers from './GoogleMapMarkers';

export default function GoogleMap({servicePoints, onSelect, selectedServicePoint, mapsSettings}) {
    return (
        <div className={'service_points_map'}>
            <APIProvider apiKey={mapsSettings.google_maps_api_key} libraries={['marker']}>
                <Map
                    defaultCenter={{lat: 55.394729, lng: 10.383394}}
                    defaultZoom={10}
                    mapTypeControl={false}
                    streetViewControl={false}
                    fullscreenControl={false}
                    region={mapsSettings.store_country}
                    gestureHandling={'greedy'}
                    mapId={'shipmondo-service-point-selector-map'}
                >
                    <GoogleMapsMarkers
                        servicePoints={servicePoints}
                        onSelect={onSelect}
                        selectedServicePoint={selectedServicePoint}
                        iconUrl={mapsSettings.maps_icon}
                        iconUrlSelected={mapsSettings.maps_icon_selected}
                    />
                </Map>
            </APIProvider>
        </div>
    )
}