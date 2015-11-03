Setup
=====

> Note: Documentation on bundle [usage].

Step 1: Install FilterManager bundle
------------------------------------

FilterManager bundle is installed using [Composer].

``` {.sourceCode .bash}
$ php composer.phar require ongr/filter-manager-bundle "~1.0"
```

> **note**
>
> Please note that filter manager requires Elasticsearch bundle, guide
> on how to install it can be found [here].

Step 2: Enable FilterManager bundle
-----------------------------------

Enable Filter Manager bundle in your AppKernel:

``` {.sourceCode .php}
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        // Elasticsearch bundle - should be already added.
        new ONGR\ElasticsearchBundle\ONGRElasticsearchBundle(),
        // The line you need to add.
        new ONGR\FilterManagerBundle\ONGRFilterManagerBundle(),
    );
}
```

Step 3: Add configuration for manager
-------------------------------------

Add minimal configuration for FilterManager bundle.

``` {.sourceCode .yaml}
#app/config/config.yml
ongr_filter_manager:
    managers:
        item_list:
            filters:
                - sorting
            repository: 'item'
    filters:
        sort:
            sorting:
                request_field: 'sort'
                choices:
                    - { label: Title ascending, field: title, default: true }
                    - { label: Title descending, field: title, order: desc }
```

> **note**
>
> This is the basic example only, for more information about manager
> configuration, please take a look at [manager] chapter.

In this particular example, we defined a single manager named item\_list
to filter documents from item repository, and we’ll be using the filter
named sorting to sort the item list with title either descending or
ascending.

Step 4: Add configuration for routing
-------------------------------------

Add a simple route:

``` {.sourceCode .yaml}
#src/Acme/DemoBundle/Resources/config/routing.yml
ongr_search_page:
    pattern: /list
    methods:  [GET]
    defaults:
        _controller: ONGRFilterManagerBundle:Manager:manager
        managerName: "item_list"
        template: "AcmeDemoBundle:List:results.html.twig"
```

This example will handle www.mypage.com/list route, rendering template
AcmeDemoBundle:List:results.html.twig with an object with results passed
to a view named filter\_manager.

> **note**
>
> You can also use your own custom controller specifying a route if
> needed (example can be found at [usage] chapter).

Step 5: Use your new bundle
---------------------------

Usage documentation for the FilterManager bundle is available
[here][usage].

  [usage]: usage.html
  [Composer]: https://getcomposer.org
  [here]: http://ongr.readthedocs.org/en/latest/components/ElasticsearchBundle/setup.html
  [manager]: manager.html