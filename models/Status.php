<?php
/**
 * Class file for order statuses, mapped to status_master table.
 * 
 * @author Anoop Santhanam <anoop.santhanam@gmail.com>
 */
class Status
{
    /**
     * The current object's product type ID
     */
    private $_statusId = null;

    /**
     * Flag to check if the current product type object is valid
     */
    public $statusValid = false;

    /**
     * Stores the app var
     */
    public $app = false;

    /**
     * Constructor for setting up the product type object
     */
    public function __construct($statusId = false)
    {
        $this->app = $GLOBALS['app'];
        if ($statusId && is_numeric($statusId)) {
            $this->_statusId = $statusId;
            $this->statusValid = $this->validateStatus();
        }
    }

    /**
     * Validates a status ID
     * 
     * @return bool
     */
    public function validateStatus(): bool
    {
        if ($this->_statusId) {
            $statusId = $this->_statusId;
            $app = $this->app;
            $query = "SELECT idstatus_master FROM status_master WHERE idstatus_master = '$statusId' AND deleted_at IS NULL";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                return true;
            }
        } 

        return false;
    }

    /**
     * Gets a status
     * 
     * @return array
     */
    public function getStatus(): array
    {
        $status = [];
        $app = $this->app;
        if ($this->statusValid) {
            $statusId = $this->_statusId;
            $query = "SELECT * FROM status_master WHERE idstatus_master = '$statusId'";
            if (!empty($query = $app['db']->fetchAssoc($query))) {
                $status = $query;
            }
        }

        return $status;
    }

    /**
     * Gets all statuses
     * 
     * @return array
     */
    public function getStatuses(): array
    {
        $statuses = [];
        $app = $this->app;
        $query = "SELECT idstatus_master FROM status_master WHERE deleted_at IS NULL ORDER BY idstatus_master ASC";
        $query = $app['db']->fetchAll($query);
        
        foreach ($query as $row) {
            $statusId = $row['idstatus_master'];
            $this->__construct($statusId);
            if (!empty($status = $this->getStatus())) {
                array_push($statuses, $status);
            }
        }

        return $status;
    }
}
