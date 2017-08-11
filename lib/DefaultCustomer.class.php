<?php
require_once "Customer.class.php";
/**
 * Default Customer class stores basic data about customer's account.
 */
class DefaultCustomer extends Customer
{
    /**
     * DefaultCustomer constructor.
     * @param string $name - Name of the customer.
     * @param float $initTransactions - Initialize first transaction and account balance.
     */
    public function __construct(string $name, float $initTransactions)
    {
        parent::__construct($name, $initTransactions);
        // Sets specific permissions for this type of customer.
        $this->permissions = Customer::PERMISSION_PAYMENT | Customer::PERMISSION_WITHDRAWAL;
    }
}