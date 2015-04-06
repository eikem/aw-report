<?php
namespace ApplicationTest\Model;

use Application\Model\TransactionTable;
use Application\Model\Transaction;
use Zend\Db\ResultSet\ResultSet;
use PHPUnit_Framework_TestCase;

class TransactionTableTest extends PHPUnit_Framework_TestCase
{
    
    public function testFetchAllReturnsAllTransactions()
    {
        $resultSet = new ResultSet();
        $mockTableGateway = $this->getMock(
            'Zend\Db\TableGateway\TableGateway',
            array('select'),
            array(),
            '',
            false
        );
        $mockTableGateway->expects($this->once())
                         ->method('select')
                         ->with()
                         ->will($this->returnValue($resultSet));

        $transactionTable = new \Application\Model\TransactionTable($mockTableGateway);
        $this->assertSame($resultSet, $transactionTable->fetchAll());
    }
    
    
    public function testCanRetrieveAllTransactionsByMerchantId()
    {
        $resultSet = new ResultSet();
        $mockTableGateway = $this->getMock(
            'Zend\Db\TableGateway\TableGateway',
            array('select'),
            array(),
            '',
            false
        );
        $mockTableGateway->expects($this->once())
                     ->method('select')
                     ->with(array('id' => 1))
                     ->will($this->returnValue($resultSet));

        $transactionTable = new \Application\Model\TransactionTable($mockTableGateway);
        $this->assertSame($resultSet, $transactionTable->fetchTransactionsByMerchantId(1));
    }
    
    
    
   
    
}