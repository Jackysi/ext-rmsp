<?php
/**
 * Model Comment
 **/
class modules_rmsp_Model_Comment extends modules_rmsp_Model_Abstract
{
    //create table comment(id INTEGER PRIMARY KEY AUTOINCREMENT, request_id INTEGER not null, owner_id INTEGER default 1 not null, text TEXT default '' not null, post_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP);
    protected $_data = array(
        'id' => null,
        'post_date' => null,
        'request_id'  => null,
        'owner_id' => null,
        'text' => null,
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
