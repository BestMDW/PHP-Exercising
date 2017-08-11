<?php
require_once "Customer.class.php";
/**
 * Limited Customer class stores basic data about customer's account and CAN NOT withdrawal money from account.
 */
class LimitedCustomer extends Customer
{
    /**
     * LimitedCustomer constructor.
     * @param string $name - Name of the customer.
     * @param float $initTransactions - Initialize first transaction and account balance.
     */
    public function __construct(string $name, float $initTransactions)
    {
        parent::__construct($name, $initTransactions);
        // Sets specific permissions for this type of customer.
        $this->permissions = Customer::PERMISSION_PAYMENT;
    }
}