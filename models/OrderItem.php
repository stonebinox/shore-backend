<?php
/**
 * Main class file for order_item_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class OrderItem extends Order
{
    /**
     * The current object's ID
     */
    private $_orderItemId = false;

    /**
     * Flag to check if the current object is valid
     */
    public $orderItemValid = false;

    /**
     * Main constructor
     * 
     * @param mixed $orderItemId Optional order ID
     */
    public function __construct($orderItemId = false)
    {
        if ($orderItemId && is_numeric($orderItemId)) {
            $this->_orderItemId = $orderItemId;
            $this->orderItemValid = $this->validateOrderItem();
        }
    }

    /**
     * Validates this object
     * 
     * @return bool
     */
    public function validateOrderItem(): bool
    {
        if ($this->_orderItemId) {
            $orderItemId = $this->_orderItemId;
            $app = $this->app;
            $query = "SELECT order_master_idorder_master FROM order_item_master WHERE deleted_at IS NULL AND idorder_item_master = '$orderItemId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $orderId = $query['order_master_idorder_master'];
                Order::__construct($orderId);
                if ($this->orderValid) {
                    return true;
                }
            }
        }

        return false;
    }
}
