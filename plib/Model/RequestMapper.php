<?php
/**
 * RequestMapper 
 **/

class modules_rmsp_Model_RequestMapper extends modules_rmsp_Model_Abstract
{
    protected $_clientsCache = null;

    public function get($id)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM request WHERE id = :id');
        $sth->bindParam('id', $id);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $sth->fetch()) {
            return new modules_rmsp_Model_Request($row); 
        }
    }

    public function getList($list)
    {
        foreach($list as &$val) {
                $val = $this->_dbh->quote($val);
        }

        $in = implode(',', $list);
        $sth = $this->_dbh->prepare('SELECT * FROM request WHERE id in ( ' . $in . ' )');
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $objects = array();
        while ($row = $sth->fetch()) {
            $objects[] = new modules_rmsp_Model_Request($row);
        }
        return $objects;
    } 

    public function getAll($state)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM request WHERE state = :state');
        $sth->bindParam('state', $state);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $objects = array();
        while($row = $sth->fetch()) {
            $request = new modules_rmsp_Model_Request($row);
            // :TODO:
            $request->client_name = $this->_getClientNameById($request->customer_id);
            $objects[] = $request; 
        }

        return $objects;
    }

    protected function _getClientNameById($id)
    {
        if (is_null($this->_clientsCache)) {
            $this->_clientsCache = array();
        }

        if (isset($this->_clientsCache[$id])) {
            return $this->_clientsCache[$id];
        }

        $request = <<<XML
<customer>
    <get>
        <filter>
            <id>$id</id>
        </filter>
        <dataset>
            <gen_info/>
        </dataset>
    </get>
</customer>
XML;
        $response = pm_ApiRpc::getService('1.6.3.0')->call($request);
        return (string) $response->customer->get->result->data->gen_info->pname;
    }

    public function getByClientId($id, $state)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM request WHERE customer_id = :id and state = :state');
        $sth->bindParam('id', $id);
        $sth->bindParam('state', $state);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $objects = array();

        while($row = $sth->fetch()) {
            $objects[] = new modules_rmsp_Model_Request($row); 
        }

        return $objects;
    }

    public function save(modules_rmsp_Model_Request $request)
    {
        if ($request->description === '') {
            return "Error on save: Description of request is empty.";
        }

        if (is_null($request->id)) {
            $sth = $this->_dbh->prepare("INSERT INTO request(customer_id, description) values (:customer_id, :description)");
            $sth->bindParam(':customer_id', $request->customer_id);
            $sth->bindParam(':description', $request->description);
        } else {
            $sth = $this->_dbh->prepare("UPDATE request SET state = :state, customer_id = :customer_id, description = :description WHERE id = :id");
            $sth->bindParam(':id', $request->id);
            $sth->bindParam(':state', $request->state);
            $sth->bindParam(':customer_id', $request->customer_id);
            $sth->bindParam(':description', $request->description);
        }

        $res = $sth->execute();

        if (!$res) {
            $error = $sth->errorInfo();
            return "Error: code='{$error[0]}', message='{$error[2]}'.";
        }

        return 0;
    }

    public function updateStateByIds(Array $requestIds, $state)
    {
        $in = implode(',', $requestIds);

        $sth = $this->_dbh->prepare("UPDATE request SET state = :state WHERE id in (" . $in . ")");
        $sth->bindParam(':state', $state);

        $res = $sth->execute();

        if (!$res) {
            $error = $sth->errorInfo();
            return "Error: code='{$error[0]}', message='{$error[2]}'.";
        }

        return 0;
    }

    public function remove($id)
    {
        $sth = $this->_dbh->prepare("DELETE from request where id = :id");
        $sth->bindParam('id', $this->_data['id']);
        $sth->execute();
    }
}
