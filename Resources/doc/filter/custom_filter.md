# Custom Filter  

There is possibility to add custom filters to filter managers via tagged filter service.
You must create filter class, define it as a service with `ongr_filter_manager.filter` tag.
  
## 1. Create filter class  
 
Class must implement [`FilterInterface`](https://github.com/ongr-io/FilterManagerBundle/blob/master/Filters/FilterInterface.php).
  
  
## 2. Defining service  

Filter service must be tagged with `ongr_filter_manager.filter` tag, `filter_name` node is required.
  
```yaml
# app/config/services.yml

services:
    ongr_filter_manager.filter.foo_range:
        class: ADD_CLASS
        arguments:
            - 'price'
            - 'price'
        tags:
            - { name: ongr_filter_manager.filter, filter_name: foo_range }
```

## 3. Adding filter to manager

You can add custom filter in same way that you add regular filters. Say you want to add just created `foo_range` filter to `foo_manager`, your configuration would look like this:
```yaml
# app/config/config.yml

ongr_filter_manager:
    managers:
        foo_manager:
            filters:
                - foo_range
            repository: 'es.manager.default.product'
```
  
## 4. Using filter  

Filter can be used as other filters trough ``FilterManager``, see one of our  [`examples`](../index.md#usage-examples).