<?php
/**
 * AW-Report Class to convert a value from one currency to another currency
 * @author Eike M
 * @package aw-report Application 
 */
namespace Application\Service;


class CurrencyConverter
{
    
   /**
     * ISO  currency code
     * @var string
     */
    protected $currentCurrency;
    
   /**
     * convertTo
     * @var string
     */
    protected $amount; 
    
   /**
     * amount
     * @var float
     */
    protected $convertTo; 
            
   /**
     * exchange rates
     * @var array
     */
    protected $rates = array(
          'GBP' => 
                  array(
                      'EUR'  => 1.35840,                           
                      'USD'  => 1.49083,                  
                      'GBP'  => 1,
                  ),
          'EUR' => 
                  array(
                      'EUR'  => 1,                           
                      'USD'  => 1.09663,                  
                      'GBP'  => 0.73516,
                  ),
          'USD' => 
                  array(
                      'EUR'  => 0.91064,                           
                      'USD'  => 1,                  
                      'GBP'  => 0.66987,
                  ),
    );
    
   /**
    * Sets rate of two currencies
    * @param $currentCurrency, $convertTo
    */
    public function setExchangeRate($currentCurrency, $convertTo)
    {
        $this->exchangeRate = $this->rates[$currentCurrency][$convertTo];
    }  
    
   /**
    * Gets rate of two currencies
    * @return exchangeRate
    */
    public function getExchangeRate() 
    {
        return  $this->exchangeRate;
    }
      
    /**
     * Set current Currency
     * @param $currency
     */   
    public function setCurrentCurrency($currency)
    {
        $this->currentCurrency = $currency;
    }
    
   /**
    * Get current Currency
    * @return current Currency  
    */   
    public function getCurrentCurrency()
    {
        return $this->currentCurrency;
    }
    
    /**
     * Set Amount to convert
     * @param $amount
     */   
    public function setAmount($amount)
    {
        $this->amount = $amount;
    }
    
   /**
    * Get Amount to convert
    * @return amount  
    */   
    public function getAmount()
    {
        return $this->amount;
    }
       
   /**
    * Converts a currency value to another currency  
    * @return converted value  
    */ 
    public function convertValue($convertTo)
    {
        $currentCurrency = $this->getCurrentCurrency();
        $this->setExchangeRate($currentCurrency, $convertTo);
        $convertedSingleTransactionValue = ($this->amount * $this->getExchangeRate());
        
        return round($convertedSingleTransactionValue, 2);
    }

}