<?php
/**
 * Created by PhpStorm.
 * User: jjuszkiewicz
 * Date: 08.09.2014
 * Time: 09:55
 */

namespace WL\AppBundle\Lib\Repository;


use Nokaut\ApiKit\ClientApi\ClientApiInterface;
use Nokaut\ApiKit\ClientApi\Rest\Async\ProductsAsyncFetch;
use Nokaut\ApiKit\ClientApi\Rest\Query\ProductsQuery;
use Nokaut\ApiKit\Repository\ProductsRepository;
use WL\AppBundle\Lib\CategoriesAllowed;

class ProductsAsyncRepository extends \Nokaut\ApiKit\Repository\ProductsAsyncRepository
{
    /**
     * @var CategoriesAllowed
     */
    private $categoriesAllowed;

    /**
     * @param string $apiBaseUrl
     * @param ClientApiInterface $clientApi
     * @param CategoriesAllowed $categoriesAllowed
     */
    public function __construct($apiBaseUrl, ClientApiInterface $clientApi, CategoriesAllowed $categoriesAllowed)
    {
        $this->categoriesAllowed = $categoriesAllowed;
        parent::__construct($apiBaseUrl, $clientApi);
    }

    /**
     * get top products
     * @param int $limit
     * @param array $categoriesIds - optional: ids of categories
     * @return ProductsAsyncFetch
     */
    public function fetchTopProducts($limit = 10, array $categoriesIds = null)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->setLimit($limit);
        $query->setOrder('popularity', 'asc');
        if ($categoriesIds) {
            $query->setCategoryIds($categoriesIds);
        } else {
            $query->setCategoryIds($this->categoriesAllowed->getAllowedCategories());
        }
        $query->setFields(ProductsRepository::$fieldsForProductBox);
        return $this->fetchProductsByQuery($query);
    }

    /**
     * get top products
     * @param int $limit
     * @param array $categoriesIds - optional: ids of categories
     * @return ProductsAsyncFetch
     */
    public function fetchProductsForMenu($limit = 6, array $categoriesIds = null)
    {
        $query = new ProductsQuery($this->apiBaseUrl);
        $query->addFacet('query');
        $query->addFacet('categories');
        $query->setLimit($limit);
        if ($categoriesIds) {
            $query->setCategoryIds($categoriesIds);
        } else {
            $query->setCategoryIds($this->categoriesAllowed->getAllowedCategories());
        }
        $fields = ProductsRepository::$fieldsForProductBox;
        $fields[] = '_categories.url_in';
        $query->setFields($fields);
        return $this->fetchProductsByQuery($query);
    }
} 