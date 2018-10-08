# Magento 2 Tracking Pixels
This module adds in multiple conversion tracking pixels to your Magento 2 theme. 
You can enable / disable each vendor to fit your needs  

**NOTE** - This module currently supports the FishPig integration for WP Pages, Posts, and Home Page views.

## Getting Started

If you **don't** have Pyxl/Core installed already add this to your composer.json:

    "repositories": [
        {
            "type": "git",
            "url": "git@bitbucket.org:pyxlinc/magento-2-tracking-pixels.git"
        },
        {
            "type": "package",
            "package": {
                "name": "pyxl/core",
                "version": "1.0.0",
                "type": "package",
                "source": {
                    "type": "git",
                    "url": "git@bitbucket.org:pyxlinc/pyxl-core-extension.git",
                    "reference": "master"
                }
            }
        }
    ]
    
If you already have Pyxl Core installed then run this instead:

    composer config repositories.pyxl-pixels git git@bitbucket.org:pyxlinc/magento-2-tracking-pixels.git

Then to install the module(s) run the following: 

    composer require pyxl/pixels:dev-master
    bin/magento module:enable Pyxl_Pixels
    bin/magento setup:upgrade
    bin/magento cache:clean
    
## Settings

You will find settings for this module under Stores -> Configuration -> Pyxl -> Pixels

Here you can enable / disable each vendor and for some vendors you can select which events to track. 

## Current Vendors and Events

**Facebook Pixel:**

* Purchase (Checkout)
* ViewContent
* AddToCart
* Initiate Checkout
* View Page 

**Pinterest Pixel:**

* Conversion (Checkout)
* View Page (product and page/post)
* View Category
* AddToCart
* Search

**Criteo:**

* ViewHome (cms index and WP front page)
* ViewItem (product page)
* ViewList (category & search pages)
* ViewBasket (cart)
* TrackTransaction (purchase)
    
## Authors
* Joel Rainwater
