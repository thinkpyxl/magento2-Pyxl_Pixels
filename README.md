# Pyxl_Pixels
This module adds in multiple conversion tracking pixels to your Magento 2 theme. 
You can enable / disable each vendor to fit your needs  

**NOTE** - This module currently supports the FishPig integration for WP Pages, Posts, and Home Page views.

## Getting Started

If you **don't** have Pyxl_Core installed already run this first:

    composer config repositories.pyxl-core git https://github.com/thinkpyxl/magento2-Pyxl_Core.git
    composer require pyxl/core:^1.0.0
    bin/magento module:enable Pyxl_Core
    
Then require this package:

    composer config repositories.pyxl-pixels git https://github.com/thinkpyxl/magento2-Pyxl_Pixels.git
        composer require pyxl/module-pixels:^1.0.0
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
* Justin Rhyne
