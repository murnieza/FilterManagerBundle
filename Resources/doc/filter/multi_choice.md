Multiple Choice Filter  
======================  
This filter is very similar to choice filter, but you can select multiple options.
It groups values of a repository in a specified field and returns available options.
If you select one or more of the options, *multi choice filter* will return item list filtered by the selected options.
  
For example, lets say we have `item` repository which contains the following data:

| item_id | item_color |  
|---------|------------|
| 1       | red        |
| 2       | red        |
| 3       | blue       |
| 4       | green      |
| 5       | blue       |
  
If we apply *multi choice filter* on field `item_color`, it will return
  
  
| choices     |
|-------------|
| red         |
| green       |
| blue        |
  
We can then select multiple values from this list and get all items for it, let's say we select choices `blue` and `green`.
 
| item_id | item_color | 
|---------|------------|
| 3       | blue       |
| 4       | green      |
| 5       | blue       |
  
Configuration  
-------------  
| Setting name           | Meaning                                                                                          |
|------------------------|--------------------------------------------------------------------------------------------------|
| `request_field`        | Request field used to view the selected page. (e.g. `www.page.com/?request_field=4`)             |
| `field`                | Specifies the field in repository to apply this filter on. (e.g. `item_color`)                   |
| `sort`                 | Choices can also be sorted. You can read more about this [here](choice.md#sorting-configuration).|
| `tags`                 | Array of filter specific tags that will be accessible at Twig view data.                         |
  
Example:
  
```yaml
  
    # app/config/config.yml
  
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

Twig view data
--------------
View data returned by this filter to be used in template:

| Method                  | Value                                            |
|-------------------------|--------------------------------------------------|
| getName()               | Filter name                                      |
| getResetUrlParameters() | Url parameters required to reset filter          |
| getState()              | Filter state                                     |
| getUrlParameters()      | Url parameters representing current filter state |
| getChoices()            | Returns a list of available choices              |
| getTags()               | Lists all tags specified at filter configuration |
| hasTag($tag)            | Checks if filter has the specific tag            |

Each choice has its own data:

| Method             | Value                                      |
|--------------------|--------------------------------------------|
| isActive()         | Is this choice currently applied           |
| isDefault()        | Is this choice the default one             |
| getCount()         | Return the number of items for this choice |
| getLabel()         | Choice label                               |
| getUrlParameters() | Returns a list of available choices        |
