# TagServeTracking

Magento 2 Module to implement TAG tracking: https://www.theaffiliategateway.com/uk

The module accepts input in the form of tagrid query string parameter, sets this as a cookie with 30 day expiry. On completed purchase the module requests the tagserve tracking pixel with order detail: number of items, total order value, along with Merchant and Program id (set in Magento admin configuration), combined with tagrid.
