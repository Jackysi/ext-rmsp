<?php
/**
 * Model Request
 **/
class modules_rmsp_Model_Request extends modules_rmsp_Model_Abstract
{
    //create table request( id INTEGER AUTO INCREMENT, state INTEGER default 0 not null, customer_id INTEGER default 0 not null, description TEXT default '' not null);
    //
    protected $_data = array(
        'id' => null,
        'state' => null,
        'customer_id' => null,
        'description' => null,
    );

    public function getAll()
    {
        $sth = $this->_dbh->query('SELECT * FROM request');
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $objects = array();

        while($row = $sth->fetch()) {
            $objects[] = new self($row); 
        }

        return $objects;
    }

    public function getByCustomerId($id)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM request WHERE customer_id = :id');
        $sth->bindParam('id', $id);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $objects = array();

        while($row = $sth->fetch()) {
            $objects[] = new self($row); 
        }

        return $objects;
    }

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

    public function save()
    {
        if (isset($params['id'])) {
            $sth = $this->_dbh->prepare("UPDATE request set state = :state, customer_id = :customer_id, description = :description WHERE id = :id");
            $sth->execute($this->_data);
        } else {
            $sth = $this->_dbh->prepare("INSERT INTO request(customer_id, description) values (:customer_id, :description)");
            $sth->execute($this->_data);
        }
    }

    public function remove()
    {
        $sth = $this->_dbh->prepare("DELETE from request where id = :id");
        $sth->bindParam('id', $this->_data['id']);
        $sth->execute();
    }
}
