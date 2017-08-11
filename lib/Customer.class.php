<?php
require_once "CustomerInterface.php";

abstract class Customer implements CustomerInterface
{
    /** @var string - Name of the customer. */
    protected $name;
    /** @var float - Available balance on the account. */
    protected $balance;
    /** @var array - List of transactions customer ever made. */
    protected $transactions;
    /** @var int - Customer's permissions. */
    protected $permissions;

    /******************************************************************************************************************/

    /**
     * Customer constructor.
     * @param string $name - Name of the customer.
     * @param float $initTransactions - Initialize first transaction and account balance.
     */
    public function __construct(string $name, float $initTransactions)
    {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING);
        $this->balance = filter_var($initTransactions, FILTER_SANITIZE_NUMBER_FLOAT);
        $this->transactions = array($initTransactions);
        $this->permissions = 0;
    }

    /******************************************************************************************************************/

    /**
     * @return mixed - Name of the customer.
     */
    public function getName()
    {
        return $this->name;
    }

    /******************************************************************************************************************/

    /**
     * @return array - List of transactions.
     */
    public function getTransactions(): array {
        return $this->transactions;
    }

    /******************************************************************************************************************/

    /**
     * Adds new transaction to the customers list and corrects customer's account balance.
     *
     * @param float $amount - Amount of transaction.
     * @return bool = True when transaction passed through.
     */
    public function addTransaction(float $amount): bool
    {
        $amount = filter_var($amount, FILTER_SANITIZE_NUMBER_FLOAT);

        // Check if the customer has got enough permissions for making this transaction.
        if (
                ($this->permissions & Customer::PERMISSION_PAYMENT && $amount >= 0) ||
                ($this->permissions & Customer::PERMISSION_WITHDRAWAL && $amount <= 0)
            )
        {
            // Permission granted. Add transaction to the list of transactions.
            $this->transactions[] = $amount;

            // Count new account balance.
            $this->balance += $amount;

            // TODO: Implement overdraft limit and return false when balance after transaction would be over limit.
            return true;
        }
        else
        {
            // Permission refused, return false.
            return false;
        }
    }
}