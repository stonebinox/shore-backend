<?php
/**
 * Main class file for order_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class Order extends Product
{
    /**
     * The current object's ID
     */
    private $_orderId = false;

    /**
     * Flag to check if the current object is valid
     */
    public $orderValid = false;

    /**
     * Main constructor
     * 
     * @param mixed $orderId Optional order ID
     */
    public function __construct($orderId = false)
    {
        $this->app = $GLOBALS['app'];
        if ($orderId && is_numeric($orderId)) {
            $this->_orderId = $orderId;
            $this->orderValid = $this->validateOrder();
        }
    }

    /**
     * Validates this object
     * 
     * @return bool
     */
    public function validateOrder(): bool
    {
        if ($this->_orderId) {
            $orderId = $this->_orderId;
            $app = $this->app;
            $query = "SELECT idorder_master FROM order_master WHERE deleted_at IS NULL AND idorder_master = '$orderId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                return true;
            }
        }

        return false;
    }

    /**
     * Gets an order
     * 
     * @return array
     */
    public function getOrder(): array
    {
        $order = [];

        if ($this->orderValid) {
            $orderId = $this->_orderId;
            $app = $this->app;
            $query = "SELECT * FROM order_master WHERE idorder_master = '$orderId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $order_item_model = new OrderItem();
                $orderItems = $order_item_model->getOrderItems($orderId);

                if (!empty($orderItems)) {
                    $query['order_items'] = $orderItems;
                }

                $order = $query;
            }
        }

        return $order;
    }
}
