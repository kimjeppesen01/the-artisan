/**
 * External dependencies
 */
import { registerCheckoutBlock } from '@woocommerce/blocks-checkout';

/**
 * Internal dependencies
 */
import { ServicePointSelectorBlock } from './block';
import metadata from './block.json';
import './style/style.scss';

registerCheckoutBlock( {
    metadata,
    component: ServicePointSelectorBlock,
} );