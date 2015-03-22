<?php
// Copyright 1999-2015. Parallels IP Holdings GmbH.
/**
 * Model Request
 **/
class Modules_Rmsp_Model_Request extends Modules_Rmsp_Model_Abstract
{
    const STATE_UNRESOLVED = 0;
    const STATE_RESOLVED = 1;

    //create table request(id INTEGER PRIMARY KEY AUTOINCREMENT, state INTEGER default 0 not null, customer_id INTEGER default 1 not null, description TEXT default '' not null, post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
    protected $_data = array(
        'id' => null,
        'post_date' => null,
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
