<?php
/**
 *
 * @author jstormes
 * @version 1
 */

namespace JStormes\SimpleSAMLphp\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Where;

class Users extends TableGateway
{
    const TABLE_NAME = 'users';
    
    public function getUser($user, $password) {

        $results = $this->select(array('user_nm'=>$user))->toArray();
        
        foreach($results as $row) {           
            if (password_verify($password, $row['password_hash'])===TRUE) {
                unset($row['password_hash']);
                return $row;
            }
        }
            
        return array();
    }
}
