<?php
/**
 * Main class file for product_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class Product extends ProductType
{
    /**
     * The current object's ID
     */
    private $_productId = false;

    /**
     * Flag to check if the current object is valid
     */
    public $productValid = false;

    /**
     * Main constructor
     * 
     * @param mixed $productId Optional product ID
     */
    public function __construct($productId = false)
    {
        if ($productId && is_numeric($productId)) {
            $this->_productId = $productId;
            $this->productValid = $this->validateProduct();
        }
    }

    /**
     * Validates this object
     * 
     * @return bool
     */
    public function validateProduct(): bool
    {
        if ($this->_productId) {
            $productId = $this->_productId;
            $app = $this->app;
            $query = "SELECT product_type_master_idproduct_type_master FROM product_master WHERE deleted_at IS NULL AND idproduct_master = '$productId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $productTypeId = $query['idproduct_type_master'];
                ProductType::__construct($productTypeId);
                if ($this->productTypeValid) {
                    return true;
                }
            }
        }

        return false;
    }
}
