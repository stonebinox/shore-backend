<?php
/**
 * Class file for product types, mapped to product_type_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class ProductType extends Status
{
    /**
     * The current object's product type ID
     */
    private $_productTypeId = null;

    /**
     * Flag to check if the current product type object is valid
     */
    public $productTypeValid = false;

    /**
     * Stores the app var
     */
    public $app = false;

    /**
     * Constructor for setting up the product type object
     * 
     * @param mixed $productTypeId Optional product type ID
     */
    public function __construct($productTypeId = false)
    {
        $this->app = $GLOBALS['app'];
        if ($productTypeId && is_numeric($productTypeId)) {
            $this->_productTypeId = $productTypeId;
            $this->productTypeValid = $this->validateProductType();
        }
    }

    /**
     * Validates a product type ID
     * 
     * @return bool
     */
    public function validateProductType(): bool
    {
        if ($this->_productTypeId) {
            $productTypeId = $this->_productTypeId;
            $app = $this->app;
            $query = "SELECT idproduct_type_master FROM product_type_master WHERE idproduct_type_master = '$productTypeId' AND deleted_at IS NULL";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                return true;
            }
        } 

        return false;
    }

    /**
     * Gets a product type row
     * 
     * @return array
     */
    public function getProductType(): array
    {
        $productType = [];
        $app = $this->app;
        if ($this->productTypeValid) {
            $productTypeId = $this->_productTypeId;
            $query = "SELECT * FROM product_type_master WHERE idproduct_type_master = '$productTypeId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $productType = $query;
            }
        }

        return $productType;
    }

    /**
     * Gets all product types
     * 
     * @return array
     */
    public function getProductTypes(): array
    {
        $productTypes = [];
        $app = $this->app;
        $query = "SELECT idproduct_type_master FROM product_type_master WHERE deleted_at IS NULL ORDER BY product_type ASC";
        $query = $app['db']->fetchAll($query);
        
        foreach ($query as $row) {
            $productTypeId = $row['idproduct_type_master'];
            $this->__construct($productTypeId);
            if (!empty($productType = $this->getProductType())) {
                array_push($productTypes, $productType);
            }
        }

        return $productTypes;
    }
}
