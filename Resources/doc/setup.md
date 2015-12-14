# Setup

## Step 1: Install FilterManager bundle

FilterManager bundle is installed using [Composer](https://getcomposer.org).

```bash
$ composer require ongr/filter-manager-bundle "~1.0"
```

> Please note that filter manager requires Elasticsearch bundle, guide on how to install and configure it can be found [here](https://github.com/ongr-io/ElasticsearchBundle/blob/master/Resources/doc/setup.md).

## Step 2: Enable FilterManager bundle

Enable Filter Manager bundle in your AppKernel:

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
        new ONGR\FilterManagerBundle\ONGRFilterManagerBundle(),
        // ...
    );
    
    // ...
}
```

## Step 3: Add configuration for manager

Add minimal configuration for FilterManager bundle.

```yaml
#app/config/config.yml

ongr_filter_manager:
    managers:
        search_list:
            filters:
                - country
            repository: 'es.manager.default.product'
    filters:
        multi_choice:
            country:
                request_field: 'country'
                field: country
```

In this particular example, we defined a single manager named `item_list` to filter documents from item repository, and we will be using the filter named `sorting` to sort the item list with title either descending or ascending.

## Step 4: Use your new bundle

FilterManagerBundle is ready to use. You can take a look at our [search page example](examples/search_example.md).
