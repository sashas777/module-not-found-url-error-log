# 404 Error (Not Found) Log
[![Latest Stable Version](https://poser.pugx.org/thesgroup/module-not-found-url-error-log/v/stable)](https://packagist.org/packages/thesgroup/module-not-found-url-error-log)
[![Total Downloads](https://poser.pugx.org/thesgroup/module-not-found-url-error-log/downloads)](https://packagist.org/packages/thesgroup/module-not-found-url-error-log)
[![Latest Unstable Version](https://poser.pugx.org/thesgroup/module-not-found-url-error-log/v/unstable)](https://packagist.org/packages/thesgroup/module-not-found-url-error-log)
[![License](https://poser.pugx.org/thesgroup/module-not-found-url-error-log/license)](https://packagist.org/packages/thesgroup/module-not-found-url-error-log)
[![pipeline status](https://gitlab.com/sashas777/module-not-found-url-error-log/badges/master/pipeline.svg)](https://gitlab.com/sashas777/module-not-found-url-error-log/-/commits/master)
[![coverage report](https://gitlab.com/sashas777/module-not-found-url-error-log/badges/master/coverage.svg)](https://gitlab.com/sashas777/module-not-found-url-error-log/-/commits/master)

The Magento 2 module will log any not found page request on your website. You can view logs at the System -> Tools -> 404 Error Log. 
 

![](https://github.com/sashas777/assets/raw/master/404_error_log.png)

The log cleans by a cron task which can be configured at the admin panel Stores -> Configuration -> The S Group -> 404 Error Log

![](https://github.com/sashas777/assets/raw/master/404_error_log_cleanup.png)

## 1. Installation

Run the following command at Magento 2 root folder:

```
composer require thesgroup/module-not-found-url-error-log
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```

## 2. Remove The Module

Run the following command at Magento 2 root folder:

```
composer remove thesgroup/module-not-found-url-error-log
php bin/magento setup:upgrade
php bin/magento setup:di:compile
php bin/magento setup:static-content:deploy
```
