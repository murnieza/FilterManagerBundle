# Custom Filter  

There is possibility to add custom filters to filter managers via tagged filter service.
You must create filter class, define it as a service with `ongr_filter_manager.filter` tag.
  
## 1. Create filter class  
 
Class must implement ``FilterInterface``.
  
```php
  
   # File location: ONGR\FilterManagerBundle\Filters\FilterInterface.pnp
  
   /**
     * Resolves filter state by given request.
     *
     * @param Request $request
     *
     * @return FilterState
     */
    public function getState(Request $request);
  
    /**
     * Modifies search request by given state. Usually should be used to add query or post_filter parameters.
     *
     * @param Search        $search  Search request.
     * @param FilterState   $state   Current filter state.
     * @param SearchRequest $request State of all filters.
     */
    public function modifySearch(Search $search, FilterState $state = null, SearchRequest $request = null);
  
    /**
     * Modifies search request by given state and related search. Usually is used to add aggregations into query.
     *
     * Related search does not include conditions from not related filters. Conditions made by filter
     * itself are also excluded on $relatedSearch. This method normally is called after modifySearch just before search
     * query execution
     *
     * @param Search      $search
     * @param Search      $relatedSearch
     * @param FilterState $state
     *
     * @return mixed
     */
    public function preProcessSearch(Search $search, Search $relatedSearch, FilterState $state = null);
  
    /**
     * Prepares all needed filter data to pass into view.
     *
     * @param DocumentIterator $result Search results.
     * @param ViewData         $data   Initial view data.
     *
     * @return ViewData
     */
    public function getViewData(DocumentIterator $result, ViewData $data);
  
    /**
     * Returns all tags assigned to the filter.
     *
     * @return array
     */
    public function getTags();
```
  
## 2. Defining service  

Filter service must be tagged with ``ongr_filter_manager.filter`` tag, ``manager`` and ``filter_name`` nodes are required.
Filter will be added to specified ``manager````FilterContainer``.
  
```yaml
  
    parameters:
      ongr_filter_manager.filter.foo_range.class: ONGR\FilterManagerBundle\Tests\app\fixture\Acme\TestBundle\Filters\FooRange\FooRange
  
    services:
      ongr_filter_manager.filter.foo_range:
        class: %ongr_filter_manager.filter.foo_range.class%
        arguments:
          - 'price'
          - 'price'
        tags:
            - { name: ongr_filter_manager.filter, manager: foo_filters, filter_name: foo_range }
```
Arguments from service definition can be passed to filters constructor.
  
```php
  
    # File location: ONGR\FilterManagerBundle\Tests\app\fixture\Acme\TestBundle\Filters\FooRange\FooRange.php;
  
    /**
     * @param string $requestField
     * @param string $field
     */
    public function __construct($requestField, $field)
    {  
        $this->setRequestField($requestField);
        $this->setField($field);
    }
```
  
Filter example can be found [here](https://github.com/ongr-io/FilterManagerBundle/blob/master/Tests/app/fixture/Acme/TestBundle/Filters/FooRange/FooRange.php).
  
Services [configuration](https://github.com/ongr-io/FilterManagerBundle/blob/master/Tests/app/fixture/Acme/TestBundle/Resources/config/services.yml).
  
  
## 3. Using filter  

Filter can be used as other filters trough ``FilterManager``, see FilterManager bundle usage `(documentation)[../usage.md]`.