# Usage

## Default controller

Once you set up your [*managers*] you don’t need to create a controller
for each one, you can just use default manager controller
ONGRFilterManagerBundle:Manager:manager.

Example:

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

This specific example will render template
AcmeDemoBundle:List:results.html.twig, with [SearchResponse] object from
FiltersManager named item\_list.

## Custom controller

You can still use custom controller by getting your needed manager from
the container. This way you can add your custom variables if needed.

Example:

``` {.sourceCode .yaml}
#src/Acme/DemoBundle/Resources/config/routing.yml

ongr_search_page:
    pattern: /list
    methods:  [GET]
    defaults:
        _controller: AcmeDemoBundle:List:index
```

``` {.sourceCode .php}
#src/Acme/DemoBundle/Controller/ListController.php

/**
 * Controller for list pages.
 */
class ListController extends Controller
{
    /**
     * Renders my list page.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $results = $this->get('ongr_filter_manager.item_list')->execute($request);

        return $this->render(
            'AcmeDemoBundle:List:results.html.twig',
            [
                'filter_manager' => $results,
                'my_custom_variable' => $var,
            ]
        );
    }
}
```

## Template variables

If you’re using default controller, [SearchResponse] from
[FiltersManager] will be named filter\_manager in template, otherwise
it’s whatever you call it in your controller.

You can use [SearchResponse] to get results in your template:

``` {.sourceCode .twig}
{% for item in filter_manager.result %}
    <b>{{ item.title }}</b>
{% endfor %}
```

You can also use it to get data about your filter:

``` {.sourceCode .twig}
Pager url parameters: {{ filter_manager.filters.pager.getUrlParameters() }}
```

A complete list of parameters for each filter can be found can be found
on [main page].

  [*managers*]: manager.html
  [SearchResponse]: https://github.com/ongr-io/FilterManagerBundle/blob/master/Search/SearchResponse.php
  [FiltersManager]: https://github.com/ongr-io/FilterManagerBundle/blob/master/Search/FiltersManager.php
  [main page]: index.html#filters