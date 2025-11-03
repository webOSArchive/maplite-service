# Overview

A PHP service, leveraging Bing Maps and IPInfo.org to provide a maps service and proxy for retro devices that are capable of displaying images, but may not be able to get a geofix, load tiles or render vectors.

# Archival

In 2024, the Bing Maps API changed and this service no longer functions. Since webOS can't handle vector-based maps, which most APIs have migrated to, there doesn't seem to be a way to deliver this service any longer.

# Requirements

Provide your Bing Maps API key and IPInfo.org token in a file called config.php. See the config-example.php for structure.

Get your Bing Maps API credentials here: https://www.microsoft.com/en-us/maps/create-a-bing-maps-key/#basic

Get your IPInfo token here: https://ipinfo.io/

Create a `cache` folder (or symlink) that the web user can write to

# Prerequisites

* Apache (or other web server) with PHP 7
* sudo apt install php-gd
* sudo apt install php7.x-curl
* sudo apt install php7.x-xml
