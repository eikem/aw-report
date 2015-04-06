<?php
/**
 * Model of transactions
 * @author Eike M
 * @package aw-report Application
 *
 */

namespace Application\Model;

class Transaction
{
    
    /**
     * Merchant id
     * @var string
     */
    public $id;
    
    /**
     * Date of transaction
     * @var string (in this example)
     */
    public $date;
    
    /**
     * Value of transaction amount incl currency
     * @var string
     */
    public $value;
 
    function exchangeArray($data)
    {
  	$this->id = (isset($data['id'])) ?
  	$data['id'] : null;
  	$this->date = (isset($data['date'])) ?
  	$data['date'] : null;
  	$this->value = (isset($data['value'])) ?
  	$data['value'] : null;
    }
    
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }
    
    public function getValue()
    {
        
    }
}


