import { __, _x } from '@wordpress/i18n'
import { useEffect, useRef } from '@wordpress/element'
import CloseButton from './components/CloseButton'
import ServicePointList from './components/ServicePointList'
import GoogleMap from './components/GoogleMap'

export default function Modal({servicePoints, onSelect, onClose,  selectedServicePoint, mapsSettings}) {
    // Lock body scroll when modal is open
    useEffect(() => {
        document.body.classList.add('shipmondo_modal_open')

        return () => {
            document.body.classList.remove('shipmondo_modal_open')
        }
    })

    // Close modal on click outside modal
    const modalRef = useRef();

    const handleClickOutside = (e) => {
        if(!modalRef.current.contains(e.target)) {
            onClose();
        }
    }

    useEffect(() => {
        document.addEventListener('mousedown', handleClickOutside)

        return () => {
            document.removeEventListener('mousedown', handleClickOutside)
        }
    })

    return (
        <div className={'service_points_modal'}>
            <div className={'shipmondo-modal_wrapper'} ref={modalRef}>
                <div className={'shipmondo-modal_content'}>
                    <CloseButton onClose={onClose}/>
                    <div className={'shipmondo-modal_header'}>
                        <h4>{_x('Select service point', 'Modal header', 'pakkelabels-for-woocommerce')}</h4>
                    </div>
                    <GoogleMap servicePoints={servicePoints} onSelect={onSelect} selectedServicePoint={selectedServicePoint} mapsSettings={mapsSettings} />
                    <ServicePointList servicePoints={servicePoints} onSelect={onSelect} selectedServicePoint={selectedServicePoint}/>
                    <div className={'shipmondo-modal_footer'}>
                        <div className={'powered_by_shipmondo'}>
                            <p>{__('Powered by Shipmondo', 'pakkelabels-for-woocommerce')}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    )
}