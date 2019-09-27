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
        $this->app = $GLOBALS['app'];
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

    /**
     * Gets an order item. 
     * 
     * @see Does not hydrate the row with parent data for order_master_idorder_master
     * 
     * @return array
     */
    public function getOrderItem(): array
    {
        $orderItem = [];

        if ($this->orderItemValid) {
            $app = $this->app;
            $orderItemId = $this->_orderItemId;
            $query = "SELECT * FROM order_item_master WHERE idorder_item_master = '$orderItemId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $productId = $query['product_master_idproduct_master'];
                Product::__construct($productId);
                if (!empty($product = $this->getProduct())) {
                    $query['product_master_idproduct_master'] = $product;
                }

                $statusId = $query['status_master_idstatus_master'];
                Status::__construct($statusId);
                if (!empty($status = $this->getStatus())) {
                    $query['status_master_idstatus_master'] = $status;
                }

                $orderItem = $query;
            }
        }

        return $orderItem;
    }

    /**
     * Gets an array of order items in an order
     * 
     * @param int $orderId The order ID
     * 
     * @return array
     */
    public function getOrderItems(int $orderId): array
    {
        $app = $this->app;
        $orderItems = [];

        $query = "SELECT idorder_item_master FROM order_item_master WHERE deleted_at IS NULL AND order_master_idorder_master = '$orderId' ORDER BY created_at ASC";
        if (!empty($query = $app['db']->fetchAll($query))) {
            foreach ($query as $orderItemData) {
                $orderItemId = $orderItemData['idorder_item_master'];
                $this->__construct($orderItemId);
                $orderItem = $this->getOrderItem();
                if (!empty($orderItem)) {
                    array_push($orderItems, $orderItem);
                }
            }
        }

        return $orderItems;
    }
}
