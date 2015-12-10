# Search page example

This example will be implemented on empty symfony standard project (can be previewed at [this](https://github.com/symfony/symfony-standard/tree/bfdf6292e14ee1dc24bda9476244437b715a6b6a) link).
Documents will be defined in already created `AppBundle`.

Make sure that you have ESB configured and working before continuing. More info about that in [official documentation](https://github.com/ongr-io/ElasticsearchBundle/blob/master/Resources/doc/setup.md).

## Sample data
In this example we will use `Product` documents:

```php
# src/AppBundle/Document/Product.php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;
use ONGR\ElasticsearchBundle\Document\AbstractDocument;

/**
 * @ES\Document
 */
class Product extends AbstractDocument
{
    /**
     * @var string
     *
     * @ES\Property(name="title", type="string", options={"index"="not_analyzed"})
     */
    private $title;

    /**
     * @var string
     *
     * @ES\Property(name="color", type="string", options={"index"="not_analyzed"})
     */
    private $color;

    /**
     * @var string
     *
     * @ES\Property(name="country", type="string", options={"index"="not_analyzed"})
     */
    private $country;

    /**
     * @var string
     *
     * @ES\Property(name="weight", type="float")
     */
    private $weight;

    /**
     * @var string
     *
     * @ES\Property(name="weight", type="float", options={"index"="no"})
     */
    private $image;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     *
     * @return Product
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     *
     * @return Product
     */
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param string $country
     *
     * @return Product
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @param string $weight
     *
     * @return Product
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;

        return $this;
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * @param string $image
     *
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }
}

```

## Define filters
Now filters have to be defined in configuration (`app/config/config.yml`):

```yaml
ongr_filter_manager:
    managers:
        search_list:
            filters:
                - search
                - color
                - country
                - weight
                - search_pager
            repository: 'es.manager.default.product'
    filters:
        choice:
            color:
                request_field: 'color'
                field: color
            country:
                request_field: 'country'
                field: country
        match:
            search:
                request_field: 'q'
                field: title
        range:
            weight:
                request_field: 'weight'
                field: weight
        pager:
            search_pager:
                request_field: 'page'
                count_per_page: 5
```

## Define route

Next step is to define route for search page, let's add following lines to `app/config/routing.yml`:
```yaml
ongr_search_page:
    pattern: /search
    methods:  [GET]
    defaults:
        _controller: ONGRFilterManagerBundle:Manager:manager
        managerName: "search_list"
        template: "AppBundle:search.html.twig"
```
## Templating
