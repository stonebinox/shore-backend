<?php
/**
 * Main class file for product_image_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class ProductImage extends Product
{
    /**
     * The current object's ID
     */
    private $_productImageId = false;

    /**
     * Flag to check if the current object is valid
     */
    public $productImageValid = false;

    /**
     * Main constructor
     * 
     * @param mixed $productImageId Optional product ID
     */
    public function __construct($productImageId = false)
    {
        if ($productImageId && is_numeric($productImageId)) {
            $this->_productImageId = $productImageId;
            $this->productImageValid = $this->validateProductImage();
        }
    }

    /**
     * Validates this object
     * 
     * @return bool
     */
    public function validateProductImage(): bool
    {
        if ($this->_productImageId) {
            $productImageId = $this->_productImageId;
            $app = $this->app;
            $query = "SELECT product_master_idproduct_master FROM product_image_master WHERE deleted_at IS NULL AND idproduct_image_master = '$productImageId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $productId = $query['product_master_idproduct_master'];
                Product::__construct($productId);
                if ($this->productValid) {
                    return true;
                }
            }
        }

        return false;
    }
}
