<?php
/**
 * Model Request
 **/
class modules_rmsp_Model_Request extends modules_rmsp_Model_Abstract
{
    const STATE_UNRESOLVED = 0;
    const STATE_RESOLVED = 1;

    //create table request( id INTEGER AUTO INCREMENT, state INTEGER default 0 not null, customer_id INTEGER default 0 not null, description TEXT default '' not null);
    //
    protected $_data = array(
        'id' => null,
        'state' => null,
        'customer_id' => null,
        'description' => null,
    );

    public function __construct($parameters = array())
    {
        parent::__construct();
        foreach($parameters as $param => $value) {
            $this->_data[$param] = $value;
        }
    }

    public function __get($field)
    {
        if(isset($this->_data[$field])) {
            return $this->_data[$field];
        }

        return null;
    }
}
