<?php
namespace ApplicationTest;

use PHPUnit_Framework_TestCase;

use Application\Service\ValueParser;

class ValueParserTest extends PHPUnit_Framework_TestCase
{
    public function testShowThatValueGetsSplit()
    {
        $parser = new ValueParser();
        $this->assertEquals(50.00, ($parser->findAmount('£50.00')));
        $this->assertSame('£', ($parser->findCurrency('£50.00')));    
    }
    
    public function testFormatCurrencyToIso()
    {
        $parser = new ValueParser();
        $this->assertSame('GBP',$parser->formatCurrencyToIso('£'));
    }

    
    
    // NOT working yet
    public function testExeptionIsThrownIfNoISOCodeFound()
    {
        $parser = new ValueParser();
        
       
    }
  
}