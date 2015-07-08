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

class Attributes extends TableGateway
{
    const TABLE_NAME = 'attributes';

    public function getAttributes($user) {

        $results = $this->select(array('username'=>$user))->toArray();

        $attributes=array();
        foreach($results as $row) {
            $attributes[$row['attribute']]=$row['value'];
        }

        return $attributes;
    }
}
