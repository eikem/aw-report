<?php
namespace ApplicationTest\Model;

use PHPUnit_Framework_TestCase;
use Application\Model\Transaction;

class TransactionTest extends PHPUnit_Framework_TestCase
{
    public function testTransactionInitialState()
    {
        $transaction = new Transaction();

        $this->assertNull(
            $transaction->id,
            '"id" should initially be null'
        );
        $this->assertNull(
            $transaction->date,
            '"date" should initially be null'
        );
        $this->assertNull(
            $transaction->value,
            '"value" should initially be null'
        );
    }

    public function testExchangeArraySetsPropertiesCorrectly()
    {
        $transaction = new Transaction();
        $data  = array('id' => '1',
                       'date'     => '31.12.2010',
                       'value'  => '£10.55');

        $transaction->exchangeArray($data);

        $this->assertSame(
            $data['id'],
            $transaction->id,
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['date'],
            $transaction->date,
            '"date" was not set correctly'
        );
        $this->assertSame(
            $data['value'],
            $transaction->value,
            '"value" was not set correctly'
        );
    }

    public function testExchangeArraySetsPropertiesToNullIfKeysAreNotPresent()
    {
        $transaction = new Transaction();

        $transaction->exchangeArray(array('id' => '1',
                                    'date'     => '',
                                    'value'  => '£10.50'));
        $transaction->exchangeArray(array());

        $this->assertNull(
            $transaction->id, '"id" should have defaulted to null'
        );
        $this->assertNull(
            $transaction->date, '"date" should have defaulted to null'
        );
        $this->assertNull(
            $transaction->value, '"value" should have defaulted to null'
        );
    }

    public function testGetArrayCopyReturnsAnArrayWithPropertyValues()
    {
        $transaction = new Transaction();
        $data  = array('id' => '1',
                       'date'     => '26.12.1988',
                       'value'  => 'some title');

        $transaction->exchangeArray($data);
        $copyArray = $transaction->getArrayCopy();

        $this->assertSame(
            $data['id'],
            $copyArray['id'],
            '"id" was not set correctly'
        );
        $this->assertSame(
            $data['date'],
            $copyArray['date'],
            '"date" was not set correctly'
        );
        $this->assertSame(
            $data['value'],
            $copyArray['value'],
            '"value" was not set correctly'
        );
    }

   
}

