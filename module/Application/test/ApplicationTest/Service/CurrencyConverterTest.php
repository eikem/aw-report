<?php
namespace ApplicationTest;

use PHPUnit_Framework_TestCase;
use Application\Service\CurrencyConverter;

class CurrencyConverterTest extends PHPUnit_Framework_TestCase
{
   
    public function testGetExchangeRate()
    {
   
        $converter = new CurrencyConverter;
        $converter->setExchangeRate('GBP', 'EUR');
        $this->assertEquals(1.35840, ($converter->getExchangeRate()));
    }
    
    public function testGetCurrentCurrency()
    {
        $converter = new CurrencyConverter;
        $converter->setCurrentCurrency('EUR');
        $this->assertEquals('EUR', ($converter->getCurrentCurrency()));
    }
    
    
    public function testConversion()
    {

        $converter = new CurrencyConverter;
        $converter->setCurrentCurrency('GBP');       
        $converter->setExchangeRate('GBP', 'EUR');
        
        $this->assertEquals('GBP', ($converter->getCurrentCurrency()));
        $this->assertEquals(1.35840, ($converter->getExchangeRate()));
       
    }
    
    
    // Test that the Value gets converted 
    public function testValueGetsConverted()
    {
        $converter = new CurrencyConverter;
        $converter->setCurrentCurrency('GBP');
        $amountToConvert = 10;
        $convertTo = 'EUR';
        $converter->setAmount($amountToConvert);
        $result = $converter->convertValue($convertTo);
        $this->assertInternalType('float', $result);
        $this->assertEquals('GBP', ($converter->getCurrentCurrency()));
        $this->assertEquals(1.3584, ($converter->getExchangeRate()));
        $this->assertEquals(13.58, $converter->convertValue($convertTo));
    }
    
     
  
}
