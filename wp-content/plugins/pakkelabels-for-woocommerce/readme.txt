=== Shipmondo - A complete shipping solution for WooCommerce ===

Contributors: pakkelabels
Plugin URI: https://shipmondo.com
Tags: Shipmondo, shipping, GLS, PostNord, Bring, DAO365, Pakkeshop, fragt, woocommerce, pakkelabels, fragtmodul
Requires at least: 6.2
Requires PHP: 7.4
Tested up to: 6.7
Stable tag: 5.0.5
License: Shipmondo
License URI: https://shipmondo.com

Shipmondo for WooCommerce – Provide pick-up points in checkout and manage shipping easily


== Description ==

https://www.youtube.com/watch?v=jLjlPbCr-WI

Offer different delivery options in your checkout and handle your freight booking efficiently.

Take your cargo to the next level. Let your customers choose a specific pick-up point from a list of the closest ones based on postcode. Set up shipping rules and delivery methods based on order amount, order weight, zip codes or number of items.

Let your customers decide where, when, and how they want their parcel to be delivered. With Shipmondo Delivery Checkout you can, among other things, fix the shipping price according to different variables, offer free delivery, and let your customers choose between several carriers. You can also offer Click and Collect, and let your customers collect their orders at your doorstep.

Create a free integration with Shipmondo, and get a complete and automated flow to handle shipping and orders. Manage your orders, shipping, and customs frictionlessly in a setup, where you can mass-create shipments and print shipping labels efficiently.

= Functions =

* Access to multiple carriers in one plugin
* A list of nearest pick-up points
* Google Maps map of nearest delivery locations
* Delivery locations in several countries including: Denmark, Norway, Sweden, Finland, the Netherlands, Germany, Belgium and Luxembourg
* Shipping information stored on the order
* Complete order, customs, and freight solutions. Minimize time per order
* Supports multi-site stores
* Supports free shipping when using coupons
* Option to offer a "free shipping for orders over x-order amount." function
* Option to set the shipping price based on the total weight/price/number of items in the shopping cart
* Offer local pick-up, Click and Collect

= Supported Carriers for Parcel-shop Collection =

* Bring
* dao
* GLS
* PostNord
* DHL
* DB Schenker
* Other

= All Supported Carriers =

Airmee, Best Transport, Bring, Brink Transport, bPost, Budbee, Burd, DASCHER, Danske Fragtmænd, dao, Deutsche Post, DHL, Doorhub, DPD, DSV, Early Bird, FedEx, FREJA, GLS, helthjem, PostNord, Posti, PostNL, Swipbox, TNT, UPS, Xpressen, B2C Europe, Blue Water Shipping, Interfjord, GEODIS, United Broker, NTG and many more…
See all: [https://shipmondo.com/carriers/](https://shipmondo.com/carriers/)


== Frequently Asked Questions ==

= What does Shipmondo cost? =

Shipmondo Delivery Checkout is a free plugin that you can utilize, when you book freight through Shipmondo. No subscription and no binding. You only pay for your actual consumption. Create a free account and follow the instructions under Installation.
Read more about our prices here: [https://shipmondo.com/pricing/](https://shipmondo.com/pricing/)

= Can I buy freight through Shipmondo? =

Yes, with a Shipmondo account, you get access to freight booking across our cooperating carriers at attractive prices. Create a free account and book your first shipment.

Have you negotiated your own shipping agreements? Then, you can easily have them activated on your free account and gather all of your freight booking together on one platform.
See all of our supported carriers: [https://shipmondo.com/carriers/](https://shipmondo.com/carriers/)

= What is Shipmondo? =

Shipmondo is a complete shipping solution and e-commerce tool. You can manage your orders, freight, customs, and returns efficiently from one solution. Provide good customer experiences at the checkout of your webshop and keep your customers informed with personalized messages, including tracking information.
Pick and pack your orders efficiently, withdraw payments, and complete orders in one frictionless workflow. Setup a Return Portal and manage return orders and refunds efficiently.

Read more about Shipmondo: [https://shipmondo.com/](https://shipmondo.com/)

== Installation ==

Getting started with Shipmondo and setting up the freight module.

You just need to create a free account at [https://shipmondo.com](https://shipmondo.com), in order to be able to use Shipmondo’s services.

(Danish installation guide: [https://help.shipmondo.com/en/articles/2032087-woocommerce-shipping-module-setup](https://help.shipmondo.com/en/articles/2032087-woocommerce-shipping-module-setup))

*   Install and activate this plugin.
*   To set up your Shipmondo-account, go to settings and then API, where you can generate your freight module key.
*   Go to [https://developers.google.com/maps/documentation/javascript/get-api-key](https://developers.google.com/maps/documentation/javascript/get-api-key) and get a free Google Maps API key.
*   Go back to your WordPress-admin, then WooCommerce and then finally to Shipmondo settings and then insert your freight module key and Google Maps API key from the step 2) and 3).
*   To set up shipping zones and methods, go to WooCommerce Settings.
        a. For WooCommerce 2.5.x > go to Settings and set up your Shipping Methods there.
        b. For WooCommerce 2.6.x > go to Settings, then Shipping and set up Shipping Zones and Shipping Methods according to your needs there.
*   Your customer's choice of shipping method and pickup point will be saved on the order under Shipping Details.

Remember to set up the integration with Shipmondo, so you can create shipping labels with all the information from each order.↵
Follow this step by step guide to set up your integration here [https://help.shipmondo.com/en/articles/2027780-woocommerce-webshop-integration-setup](https://help.shipmondo.com/en/articles/2027780-woocommerce-webshop-integration-setup)

Note! Requires at least WooCommerce 3.0.0.


== Screenshots ==

1. Ship with multiple carriers in one app: PostNord, Bring, DB Schenker, DHL, UPS, etc.
2. Gather all your shipping agreements or use ours. No subscription.
3. Manage orders and customs efficiently: Pick, pack, print and send
4. Determine shipping price based on order amount, order weight or number of items
5. Let your customers choose pickup point and parcelshop in checkout
6. Make returns and refunds easy with Shipmondo Return Portal
7. Design and send personal SMS and emails during order management


== Changelog ==

= 5.0.5 =
* Fixes a deprecation warning for tax calculation

= 5.0.4 =
* Fix error in scripts, causing error to be thrown in the developer console in some cases
* Fix error in WooCommerce Blocks implementation, if shipping package does not contain a valid shipping method

= 5.0.3 =
* Fix error in WooCommerce Blocks implementation, if shipping methods does not contain a service point

= 5.0.2 =
* Change block to only show package name if more than one shipping package
* Fix capitalization caused by some themes in the selector display
* Fix generic class name for modal, causing conflicts with some themes

= 5.0.1 =
* Change error message on service point selector, if address not set
* Change styling on info window in Google Maps block edition
* Change distance display to have max 2 decimals
* Fix error causing problems with checkout if the customer did not manually select a service point

= 5.0.0 =
* Add support for WooCommerce Checkout Block
* Add feature to auto select first available service point as standard based on address information
* Change implementation of service point selector to auto fetch service points based on address information instead of using zip code field and manual trigger button
* Fix implementation with Google Maps API: "Missing callback" error
* Fix PHP 8.3 compatibility issues
* Fix integration with WooCommerce Subscriptions: Was setting the initial orders service point on the subscription order if a service point was not needed.

= 4.2.0 =
* Added support for WooCommerce HPOS

= 4.1.1 =
* Solve problem with installation if backup path is not writeable

= 4.1.0 =
* Changed how pickup point data is saved and displayed, to keep shipping address information
* Changed styling for dropdown and modal to handle built in browser list style
* Solved compatibility problem with older devices and browsers

= 4.0.10 =
* Changed agent specific icons with a static icon in modal
* Removed icons from dropdown
* Solved problem with showing prevoius chosen pickup point in the modal or dropdown

= 4.0.9 =
* Removed shop ID from pickup point selection in checkout

= 4.0.8 =
* Updated version due to translation issues

= 4.0.6 =
* Updated strings and links

= 4.0.5 =
* Solved problem with WooCommerce subscriptions where shipping packages and chosen pickup points where incorrectly missing in some cases

= 4.0.4 =
* Solved problem with migration of "Other" shipping methods from v. 3.x.x to 4.x.x
* Solved problem with error message in some cases where coupon code array is not set as an array

= 4.0.3 =
* Solved problem with price intervals on saving
* Added validation of Shipmondo API Key
* Added support for content dir placed outside the public folder
* Removed depricated jQuery function, which caused errors with jQuery 3.0.0+

= 4.0.2 =
* Solved problem with coupons not apllyable

= 4.0.1 =
* Solved problem with transient not set correctly

= 4.0.0 =
* Merged shipping methods into one method with carrier selection
* Added dynamically update of carriers from Shipmondo API
* Changed some descriptions and links to reflect Shipmondo's new setup

= 3.2.1 =
* Solved problem, which caused Google Maps to not be displayed

= 3.2.0 =
* Solved problem with WooCoomerce subscriptions, syncronized subscriptions and trial subscriptions
* Solved php 7.4 depricated function notices
* Solved WooCommerce depricated cart tax notice
* Updated tested up to tags for WooCommerce and WordPress

= 3.1.2 =
* Solved problem with company name was not required, when choosing a business shipping method

= 3.1.1 =
* Solved problem with subscriptions ordered together with other products or with af trial period

= 3.1.0 =
* Added support for WooCommerce Subscriptions
* Allow more than one of same shipping type
* Added version information in API call
* Changed how it enqueues scripts and styles so it will work with alternative WP installation methods

= 3.0.5 =
* Solved problem with pickup point and name on recipient if choosing alternative delivery address

= 3.0.4 =
* Solved currency conflict with WPML/WCML
* Solved problem with mathematical expressions in shipping prices (quantity, cost and fee shortcodes)

= 3.0.3 =
* Solved problem with pickup point drop down

= 3.0.2 =
* Solved problem with text domain caused by name change - related to missing translations from WP Plugin Repository

= 3.0.1 =
* Updated some translations

= 3.0.0 =
* Changed name from Pakkelabels.dk to Shipmondo (functions and settings names included)
* Added DB migration functionality because of the settings name change
* Removed creation of non used table for differentiated prices

= 2.2.0 =
* Added support for DIBS Eeasy for WooCommerce
* Added support for Klarna Checkout for WooCommerce
* Added saving pickup point choice in WooCommerce Session
* Added support for WooCommerce Shipping Classes
* Added custom shipping agent
* Fixed Google Translate bug
* Fixed problem with Google Maps styling

= 2.1.1 =
* Fixed problem with missing service-point ID when using dropdown instead of modal

= 2.1.0 =
* Added option to change pickup point selector to dropdown instead of modal
* Fixed CSS problem with the theme Flatsome
* Fixed error in JS if zipcode field not exists

= 2.0.11 =
* Fixed JS syntax errors
* Changed text on Pakkelabels settings page

= 2.0.10 =
* Fixed problem with modal loaded on payment page
* Fixed problem with passing country code to Pakkelabels API, if buyer is only allowed from one country

= 2.0.9 =
* Fixed problem with accepting terms after modal was open on IOS

= 2.0.8 =
* Fixed problem with some payment gateways on order-pay

= 2.0.7 =
* Fixed some problems with tagged version in the plugin repository

= 2.0.6 =
* Fixed problem with getting shipping billing country if zipcode is not added

= 2.0.5 =
* Fixed problem with finding pickup points, when only one shipping method is activated

= 2.0.4 =
* Fixed problem with array conversion in some PHP versions

= 2.0.3 =
* Fixed problem with demands pickup point on virtual product after deleting non virtual product from cart
* Fixed problem with using one shipping agent pickup point choise when choosing another pickup point

= 2.0.2 =
* Fixed problem with modal included on order confirmation page

= 2.0.1 =
* Removed javaScript from order confirmation page
* Fixed problem with chosen pickup point when WooCommerce reloads delivery options
* Added version number on javascript and css files

= 2.0.0 =
* New design and functionality for the pickup point picker
* Rewrote javaScript
* Rewrote a large part of the core functionality
* Fixed issue with zipcode validation for non danish zipcodes

= 1.1.11 =
* Fixed issue with WPML and free shipping when multi currency is disabled

= 1.1.10 =
* Changed text domain for translation
* Fixed issue with pickup point selector not displaying correct when free delivery

= 1.1.9 =
* Fixed issue with pickup point selector not displaying correct

= 1.1.8 =
* Fixed issue with hiding shipping methode when differentiated shipping price and free shipping was combined
* Added simple support for WPML multi currency, so free shipping is calculated based on the WPML currency converter
* Added .pot file for translation

= 1.1.7 =
* Fixed issue with coupon codes in WooCommerce version less than 3.0.0
* Fixed issue with loading of plugin if WooCommerce is installed as MU Plugin

= 1.1.6 =
* Fixed an issue where customers could complete checkout without selecting a pick-up point for Bring

= 1.1.5 =
* Added support for pickup points in multiple countries
* Added support for free shipping when using coupons
* Added option to hide shipping method, if conditions are not met
* Added "(free)" text on shipping method description, if shipping method is free
* Added support for multi-sites/networks
* Optimized support for multi-language sites using sub-domains to differentiate site languages
* Default zipcode for pickup points is set to the customer zipcode from billing / shipping fields

= 1.1.4 =
* Tested compatible with WooCommerce 3.0
* Updated pakkelabels.dk logo and graphic

= 1.1.3 =
* Minor structure fix

= 1.1.2 =
* Added Bring
* Updated danish translations
* Minor speed optimazation


= 1.1.1 =
* Testet compatible with WooCommerce 2.7-beta 1
* Updated danish translations
* Different speed optimization
* Different code optimization

= 1.1.0 =
* Testet compatible with WordPress 4.7 and WooCommerce 2.6.9


= 1.0.8 =
* Minor javascript optimization

= 1.0.7 =
* Various optimizations

= 1.0.61 =
* Fixed an issue that might have coursed the plugin not to work with older versions of PHP

= 1.0.6 =
* Added support for diffrentiated shipping prices based on total cart weight / Price
* Added support for shipping prices based on Quantity of items in cart

= 1.0.5 =
* Fixed a Javascript bug, resulting in the map not showing up correctly

= 1.0.4 =
* Fixed a issue with the zipcode field not getting rendered if the checkout and cart was combined to a single page
* Fixed a issue with to many ; in the legacy main class
* Fixed a couple of missing translations

= 1.0.3 =
* Fixed a issues with the Avada theme
* Fixed a issues with conflicting Javascript

= 1.0.2 =
* Added a field for a Google Mapi API key in the plugin options - and is a requirement to use the plugin from now on!

= 1.0.1 =
* Added support for free shipping
* Added support for prices with both periods and commas
* Added support for tax status

= 1.0.0 =
* First release.

== Upgrade Notice ==

= 4.0.0 =
This is a major update - Changed how setup of shipping methods is working -> Migration of shipping methods will be manipulating DB data - Be sure to backup your website before updating and test the plugin after update!

= 3.1.0 =
Changed how data is captured from the customer - Be sure to test your site after updating the plugin!

= 3.0.0 =
Namechange from Pakkelabels.dk to Shipmondo - This is a major update manipulating DB data - Be sure to backup your website before updating and test the plugin before publishing!

= 2.0.0 =
This is a major update - Be sure to backup your website before updating and test the plugin before publishing!
