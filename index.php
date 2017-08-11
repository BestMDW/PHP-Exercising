<?php
    require_once("lib/Bank.class.php");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Exercising with Objects in PHP7</title>
    </head>
    <body>
<?php
    $barclays = new Bank("Barclays");
    $lloyds = new Bank("Lloyds");

    $barclays->addBranch("Redditch");
    $barclays->addBranch("Alcester");
    $lloyds->addBranch("Birmingham");

    $barclays->addCustomer("Redditch", "Maciej", 2000);
    $barclays->addLimitedCustomer("Redditch", "Vanessa", 1000);
    $barclays->addCustomer("Alcester", "Tom", 1500);
    $lloyds->addCustomer("Birmingham", "Alan", 5000.23);

    $barclays->addTransaction("Redditch", "Maciej", 500);
    $barclays->addTransaction("Alcester", "Tom", -200);
    $barclays->addTransaction("Redditch", "Vanessa", -500); // Limited customer, can't withdrawal money.

    $barclays->printCustomers("Redditch");
    $barclays->printCustomers("Alcester");
    $lloyds->printCustomers("Birmingham");
?>
    </body>
</html>