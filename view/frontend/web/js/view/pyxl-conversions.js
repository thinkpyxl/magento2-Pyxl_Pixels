/**
 * Copyright © 2013-2017 Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */
define([
    'ko',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (ko, Component, customerData) {
    'use strict';
    return Component.extend({
        initialize: function () {
            let self = this;
            self._super();
            customerData.get('pyxl-conversions').subscribe(function(loadedData){
                if (loadedData && "undefined" !== typeof loadedData.events) {
                    for (let eventCounter = 0; eventCounter < loadedData.events.length; eventCounter++) {
                        let eventObj = loadedData.events[eventCounter];
                        if ("undefined" !== typeof eventObj.eventData && eventObj.eventData) {
                            switch (eventObj.vendor) {
                                case 'facebook': {
                                    fbq('track', eventObj.eventName, eventObj.eventData || {});
                                    break;
                                }
                                case 'pinterest': {
                                    pintrk('track', eventObj.eventName, eventObj.eventData || {});
                                    break;
                                }
                                default: {
                                    break;
                                }
                            }
                        }
                    }
                    customerData.set('pyxl-conversions', {});
                }
            });
        }
    });
});