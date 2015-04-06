<?php
/**
 * Parse a string which contains value and currency
 * @author Eike M
 * @package aw-report Application
 */

namespace Application\Service;

class ValueParser
{
    
    /**
     * Value to be split in amount and ISO currency
     *
     * @var string
     */
    private $value; 
    
    /**
     * ISO currency
     *
     * @var string
     */
    private $isoCurrency;
    
    /**
     * Array which stores ISO currency and amount 
     *
     * @var array
     */
    private $parsedValueArray;
    
    
   /**
     * Array which stores preg_match results 
     *
     * @var array
     */
    private $matches;
    
    /**
     * Amount without Currency
     *
     * @var atring
     */
    private $amount;

   
   /**
    * Take the string which contains the amount and currency and splits into currency and amount
    * @param $value
    * @return array array contains the ISO currency and amount
    */
    public function splitTransactionValue($value)
    {
        if ($value != NULL){
            $this->findAmount($value);
            $this->findCurrency($value);
            $isoCurrency = $this->formatCurrencyToIso($this->currency);
            
            if ($isoCurrency == NULL) {
                throw new \Exception(sprintf('"%s" is not a valid currency.', $this->currency));
            }
   
            $parsedValueArray = array('currency'=>$isoCurrency,'amount'=>$this->amount);
            return $parsedValueArray;
        }
    }
    
   /**
    * Take the string which contains the amount and currency and preg_match for amount
    * @param $value
    * @return float amount
    */
    function findAmount($value)
    {
        $re_amount="/[0-9\.]+/";
        preg_match($re_amount, $value, $this->matches);
        $this->amount = \floatval($this->matches[0]);
        return  $this->amount;
    }
    
   /**
    * Take the string which contains the amount and currency and preg_match for currency
    * @param $value
    * @return string currency
    */
    function findCurrency($value)
    {
        $re_curr="/[£\$€]+/";
        preg_match($re_curr, $value, $this->matches);
        $this->currency = $this->matches[0];
        return  $this->currency;
    }
    
   /**
    * Take the currency
    * @param $currency
    * @return string ISO currency
    */
    function formatCurrencyToIso($currency)
    {
        switch($currency)
        {
            case '£':
                return 'GBP';
            case '€':
               return 'EUR';
            case '$':
                return 'USD';
            default:
                return \NULL;
        }

    }
}
