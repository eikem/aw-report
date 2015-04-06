# aw-report Command Line Program
This is a Command line program to convert a list of transactions from one currency to another and to calculate their total value. The program can either show a list for a specific merchant id or show all the transactions from all the merchants.

# Installation

### GIT

git clone https://github.com/eikem/aw-report.git


#Usage
Open command line and change into the public folder. You now got the following options:

To show both options to run the program, enter:
    
    index.php 

To show all transaction from a merchant with the id 1 enter:

    php index.php show merchant 1

To see the other merchant, just change the id 1 to 2. The total transaction values will be converted to the default currency GBP which is the default. If you would like to
see the total in a different currency, add the ISO Currency at the end. F.e:

    php index.php show merchant 1 EUR

To show all transactions from all merchants available, enter the below. The transactions and the total will be again converted to GBP. 

    php index.php show transactions

If you would like to see the list and total in a different currency, add the ISO Currency at the end. F.e:

    php index.php show transactions EUR

