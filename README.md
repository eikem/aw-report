# aw-report Command Line Program
This is a Command line program to convert a list of transactions from one currency to another and to calculate their total value. The program can either show a list for a specific merchant id or show all the transactions from all the merchants.

# Installation

### GIT

git clone https://github.com/eikem/aw-report.git


#Usage
----------------------------
Open command line, change into the public folder and enter either:

    php index.php 
- This will show you the 2 options

php index.php show merchant <id> <currency>
- Will show show all transaction from a specific merchant. <id> is the merchant id 
<currency> is optional to change from the default GBP to f.e EUR 

php index.php show transactions <currency>
- Will show you all transactions from all merchants and a total of all the transactions in the default currency GBP.
<currency> is optional to change from the default GBP to f.e EUR 
 

