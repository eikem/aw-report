<?php
/**
 * Source of transactions, can read
 * @author Eike M 
 * @package aw-report Application
 *
 */
namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;

class TransactionTable
{
    
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    
   /**
    * Fetch all transactions from db
    * @return resultset
    */
    public function fetchAll()
    {
        $resultSet = $this->tableGateway->select();
        return $resultSet;
    }
    
   /**
    * Fetch all transactions from db
    * @param int $id
    * @return resultset
    */
    public function fetchTransactionsByMerchantId($id)
    {
         $resultSet = $this->tableGateway->select(array('id' => $id));
         return $resultSet;
    }
  
}