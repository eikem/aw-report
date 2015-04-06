<?php
/**
 * AW-Report Convert Transaction Values to another Currency
 * @author Eike M
 * @package aw-report Application
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Application\Service\ValueParser;
use Application\Service\CurrencyConverter;


class IndexController extends AbstractActionController
{
   /**
    * Array which stores ISO currency and amount 
    *
    * @var array
    */
    protected $transactionTable;
    
       /**
     * Array which stores ISO currency and amount 
     *
     * @var array
     */ 
    private $currency = "GBP";
    
    /**
     * Stores the total amount of all converted transactions 
     *
     * @var float
     */
    private $total;
    
    /**
     * Array which the transaction details and the total amount 
     *
     * @var array
     */
    private $results;
    
    /**
     * Stores the transaction details
     *
     * @var string
     */
    private $transactions;
    
    
    public function setCurrency($currency) { 
        $this->currency = $currency; 
    }
    public function getCurrency() { 
        return $this->currency; 
    }   
            
    public function getTransactionTable()
    {
         if (!$this->transactionTable) {
             $sm = $this->getServiceLocator();
             $this->transactionTable = $sm->get('Application\Model\TransactionTable');
         }
         return $this->transactionTable;
    }
    

    
   /**
    * Action to show all the transactions from all merchant
    * @param id optional desired currency, default GBP 
    * @return A table of all transactions and the total of all converted transaction values
    */  
    public function showAllTransactionsAction() {         
        $request = $this->getRequest();         
        //
        // Make sure that we are running in a console and the user has not tricked our         
        // application into running this action from a public web server.         
        if (!$request instanceof ConsoleRequest) {             
            throw new RuntimeException('You can only use this action from a console!');         
        } 
        
        // Get desired currency (if set) from Console 
        if ($request->getParam('currency'))
        {
            $this->setCurrency(strtoupper($request->getParam('currency')));
        }
        
        // Get all transactions
        $transactions = $this->getTransactionTable()->fetchAll();
       
        // Take all Transactions and format the information
        $results = $this->formatTransactionInformation($transactions);
       
        // Format the result output
        $tableHeadline = "\n Overview of all Transactions  \n \n";
        $tableHead = "Merchant | Date       | Currency | Transaction Value \n"; 
        $tableBody = $results['transactionrows'] ." \n ";
        $tableFooter = "Total value of Transactions:" . $this->getCurrency() .' '. $this->results['total'] . " \n \n";
        
        // return the Transaction Details
        return $tableHeadline . $tableHead . $tableBody . $tableFooter;
     }
              
   /**
    * Action to show all the transactions from a specific merchant
    * @param id optional desired currency, default GBP 
    * @return A table of all transactions and the total of all converted transaction values
    */    
    
    public function showMerchantTransactionAction() 
    {          
        $request = $this->getRequest();           
        // Make sure that we are running in a console and the user has not tricked our         
        // application into running this action from a public web server.         
        if (!$request instanceof ConsoleRequest) {             
            throw new RuntimeException('You can only use this action from a console!');         
        }
        
        // Get merchantID from Console console
        $merchantID   = $request->getParam('merchantID');
        
        // Get desired currency (if set) from Console 
        if ($request->getParam('currency'))
        {
            $this->setCurrency(strtoupper($request->getParam('currency')));
        }
              
        try{
            // If merchant ID is not numeric, throw exception and return message
            if (!is_numeric($merchantID))
            {
                throw new \Exception ('The Merchant ID is not valid ! Please enter a valid ID.'); 
            }
        }
        catch (\Exception $e) {
            return "An Error occurred !! " .$e->getMessage() . "\n \n"; 
        }
        
        // Get all transactions from Merchant
        $transactions = $this->getTransactionTable()->fetchTransactionsByMerchantId($merchantID);
        // If no records return with message
        if (count($transactions) == 0)
        {
           return "The Merchant ID does not return any records. Please try another one.\n"; 
        }
        // Take all Transactions and format the information
        $results = $this->formatTransactionInformation($transactions);
        
        // Format the result output
        $tableHeadline = "\nDetails for Merchant " .$merchantID. ": \n \n";
        $tableHead = "Merchant | Date       | Currency | Transaction Value \n"; 
        $tableBody = $results['transactionrows'] ." \n ";
        $tableFooter = "Total value of Transactions:" . $this->getCurrency() .' '. $this->results['total'] . " \n \n";
        
        // return the Transaction Details plus the Total Transaction Value to Console
        return $tableHeadline . $tableHead . $tableBody . $tableFooter;

    }
    
    
   /**
    * Sets rate of two currencies
    * @param $transactions
    * @return array Contains the rows of transactions as string and the total
    */
    function formatTransactionInformation($transactions)
    {   
        $valueParser = new ValueParser();
        $valueConverter = new CurrencyConverter();
        $this->total = 0;
        // get the Currency to convert to either default currency or set through console
        $convertTo = $this->getCurrency();
         // Loop through all the Transactions from the Merchant
        foreach ($transactions as $singleTransaction) 
        {
           // split single Transaction Value, return array with value and currency in ISO Format
           $valueToConvert = $valueParser->splitTransactionValue($singleTransaction->value); 
           // set the current Value Currency
           $valueConverter->setCurrentCurrency($valueToConvert['currency']);
           $valueConverter->setAmount($valueToConvert['amount']);
           // convert the singleTransactionValue into desired currency (default GBP), return the converted Value
           $convertedValue = $valueConverter->convertValue($convertTo);
           // add this to the Total Transaction Value
           $this->total = $this->total+$convertedValue;
           $this->transactions .= $singleTransaction->id . "        | "  . $singleTransaction->date . " | "    . $valueToConvert['currency']. "      | " . $singleTransaction->value . "\n";
        }
        $this->results = array("transactionrows" =>  $this->transactions, "total" => $this->total);
        return $this->results;
    } 
    
    
       
}
