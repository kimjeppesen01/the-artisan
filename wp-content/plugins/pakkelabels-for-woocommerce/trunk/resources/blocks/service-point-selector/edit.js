import {registerBlockType} from '@wordpress/blocks';
import metadata from './block.json';
import {__, _x, sprintf} from '@wordpress/i18n';

import './style/style.scss';

registerBlockType(metadata, {
    edit: () => {
        return (
            <div className={'shipmondo_service_point_selection'}>
                <h3 className={'service_point_title'}>{__('Service Point', 'pakkelabels-for-woocommerce')}</h3>
                <div className={'selected_service_point service_point'}>
                    <>
                        <div className={'header'}>
                            <span className={'name'}>{_x('Service Point Name', 'Example for editor', 'pakkelabels-for-woocommerce')}</span>
                            <span className={'rate_name'}>{_x('Rate Name', 'Example for editor', 'pakkelabels-for-woocommerce')}</span>
                        </div>
                        <div className={'location'}>
                            <div className={'address_info'}>
                                {sprintf(_x('%1$s, %2$s %3$s', 'Address display: %1$s - street and number, %2$s zipcode and %3$s city', 'pakkelabels-for-woocommerce'),
                                    _x('Streename 1', 'Example for editor', 'pakkelabels-for-woocommerce'),
                                    '1234',
                                    _x('Cityname', 'Example for editor', 'pakkelabels-for-woocommerce')
                                )}
                            </div>
                            <div
                                className={'distance'}>{sprintf(_x('%s km', 'Distance display', 'pakkelabels-for-woocommerce'), 1.2)}</div>
                        </div>
                    </>
                </div>
                <div className={'powered_by_shipmondo'}>
                    <p>{__('Powered by Shipmondo', 'pakkelabels-for-woocommerce')}</p>
                </div>
            </div>
        )
    }
})