<?php
/**
 * CommentMapper 
 **/

class modules_rmsp_Model_CommentMapper extends modules_rmsp_Model_Abstract
{
    public function get($id)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM comment WHERE id = :id');
        $sth->bindParam('id', $id);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $sth->fetch()) {
            return new modules_rmsp_Model_Comment($row); 
        }
    }

    public function getByRequestId($id, $names = false)
    {
        $sth = $this->_dbh->prepare('SELECT * FROM comment WHERE request_id = :id');
        $sth->bindParam('id', $id);
        $sth->execute();
        $sth->setFetchMode(PDO::FETCH_ASSOC);

        $objects = array();

        while ($row = $sth->fetch()) {
            $comment = new modules_rmsp_Model_Comment($row);
            $client = pm_Client::getByClientId($comment->owner_id);
            $comment->client_name = $client->getProperty('login');
            $objects[] = $comment;
        }
        return $objects;
    } 

    public function save(modules_rmsp_Model_Comment $comment)
    {
        if ($comment->text === '') {
            return "Error on save: Text of comment is empty.";
        }

        if (is_null($comment->id)) {
            $sth = $this->_dbh->prepare("INSERT INTO comment(owner_id, request_id ,text) values (:owner_id, :request_id , :text)");

            if ($sth === false) {
                $error = $this->_dbh->errorInfo();
                return "Error: code='{$error[0]}', message='{$error[2]}'.";
            }

            $sth->bindParam(':owner_id', $comment->owner_id);
            $sth->bindParam(':request_id', $comment->request_id);
            $sth->bindParam(':text', $comment->text);
        } else {
            $sth = $this->_dbh->prepare("UPDATE comment SET owner_id = :owner_id, request_id = :request_id, text = :text WHERE id = :id");
            $sth->bindParam(':id', $comment->id);
            $sth->bindParam(':owner_id', $comment->owner_id);
            $sth->bindParam(':request_id', $comment->request_id);
            $sth->bindParam(':text', $comment->text);
        }

        $res = $sth->execute();

        if (!$res) {
            $error = $sth->errorInfo();
            return "Error: code='{$error[0]}', message='{$error[2]}'.";
        }

        return 0;
    }

    public function remove($id)
    {
        $sth = $this->_dbh->prepare("DELETE from comment where id = :id");
        $sth->bindParam('id', $this->_data['id']);
        $sth->execute();
    }
}
