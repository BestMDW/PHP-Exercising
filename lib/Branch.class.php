<?php
require_once "DefaultCustomer.class.php";
require_once "LimitedCustomer.class.php";

/**
 * Contains list of the customers assigned to the branch and allows to do basic operations on that list.
 */
class Branch
{
    /** @var string - Name of the branch. */
    protected $name;
    /** @var array - List of customers assigned to the branch. */
    protected $customers;

    /******************************************************************************************************************/

    /**
     * Branch constructor.
     * @param string $name - Name of the branch.
     */
    public function __construct(string $name)
    {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING);
        $this->customers = array();
    }

    /******************************************************************************************************************/

    /**
     * @return string - Name of the branch.
     */
    public function getName(): string
    {
        return $this->name;
    }

    /******************************************************************************************************************/

    /**
     * @return array - List of customers.
     */
    public function getCustomers(): array
    {
        return $this->customers;
    }

    /******************************************************************************************************************/

    /**
     * Adds new customer to the list of customers.
     *
     * @param string $name - Name of the new Customer.
     * @param float $initTransaction - First customer's transaction.
     * @return bool - True when customer has been added, false otherwise.
     */
    public function addCustomer(string $name, float $initTransaction): bool
    {
        // Check if customer doesn't exists on the list.
        if ($this->findCustomer($name) == null) {
            // Doesn't exists, add new Customer to the list.
            $this->customers[] = new DefaultCustomer($name, $initTransaction);
            // Customer has been added, return true.
            return true;
        }
        // Customer is already on the list, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Adds new limited customer to the list of customers.
     *
     * @param string $name - Name of the new Customer.
     * @param float $initTransaction - First customer's transaction.
     * @return bool - True when customer has been added, false otherwise.
     */
    public function addLimitedCustomer(string $name, float $initTransaction): bool
    {
        // Check if customer doesn't exists on the list.
        if ($this->findCustomer($name) == null) {
            // Doesn't exists, add new Customer to the list.
            $this->customers[] = new LimitedCustomer($name, $initTransaction);
            // Customer has been added, return true.
            return true;
        }
        // Customer is already on the list, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Adds new transaction assigned with specific customer.
     *
     * @param string $name - Name of the client who made transaction.
     * @param float $amount - Transaction's amount.
     * @return bool - True when transaction passed through, false otherwise.
     */
    public function addTransaction(string $name, float $amount): bool
    {
        // Try to find this customer on the branch Customers list.
        $foundCustomer = $this->findCustomer($name);
        if ($foundCustomer != null)
        {
            // Customer has been found. Try to assign new transaction and return true when assigned, false otherwise.
            return $foundCustomer->addTransaction($amount);
        }

        // Customer IS NOT on the list, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Checks if customer exists on the branch Customers list.
     *
     * @param string $name - Name of the customer to find.
     * @return DefaultCustomer - Returns specific Customer object if found, null otherwise.
     */
    public function findCustomer(string $name): ?Customer
    {
        // Check the list and try to find specific customer.
        foreach ($this->customers as $customer)
        {
            if ($customer->getName() == filter_var($name, FILTER_SANITIZE_STRING))
            {
                // Customer has been found, return this Customer.
                return $customer;
            }
        }
        // Customer wasn't found, return null.
        return null;
    }
}