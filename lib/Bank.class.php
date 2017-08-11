<?php
require_once "Branch.class.php";

/**
 * Contains branches assigned to the bank and allows to do basic operations on that list.
 */
class Bank
{
    /** @var string - Name of the bank. */
    protected $name;
    /** @var array - Branches assigned to the bank. */
    protected $branches;

    /******************************************************************************************************************/

    /**
     * Bank constructor.
     * @param string $name - Name of the bank.
     */
    public function __construct(string $name)
    {
        $this->name = filter_var($name, FILTER_SANITIZE_STRING);
        $this->branches = array();
    }

    /******************************************************************************************************************/

    /**
     * Add new branch to the list of the branches.
     *
     * @param string $name - Name of the new branch.
     * @return bool - True when client has been added, false otherwise.
     */
    public function addBranch(string $name): bool
    {
        // Check if branch already exists on the list.
        if ($this->findBranch($name) == null)
        {
            // Branch wasn't found, add to the list.
            $this->branches[] = new Branch($name);
            // Success, return true.
            return true;
        }

        // Branch already exists on the list, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Assigns customer to the branch and initializes first transaction of that customer.
     *
     * @param string $branch - Branch name where customer should exists.
     * @param string $customer - Name of the new customer.
     * @param float $initTransaction - Amount of the first transaction.
     * @return bool - If the branch exists and customer is not currently assigned to the list return true,
     *                false otherwise.
     */
    public function addCustomer(string $branch, string $customer, float $initTransaction): bool
    {
        // Find branch on the list.
        $foundBranch = $this->findBranch($branch);

        // Try to assign new customer to the list.
        if ($foundBranch->addCustomer($customer, $initTransaction))
        {
            // Customer has been added, return true.
            return true;
        }

        // The branch wasn't found or customer already is assigned to the branch, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Assigns limited customer to the branch and initializes first transaction of that customer.
     *
     * @param string $branch - Branch name where customer should exists.
     * @param string $customer - Name of the new customer.
     * @param float $initTransaction - Amount of the first transaction.
     * @return bool - If the branch exists and customer is not currently assigned to the list return true,
     *                false otherwise.
     */
    public function addLimitedCustomer(string $branch, string $customer, float $initTransaction): bool
    {
        // Find branch on the list.
        $foundBranch = $this->findBranch($branch);

        // Try to assign new customer to the list.
        if ($foundBranch->addLimitedCustomer($customer, $initTransaction))
        {
            // Customer has been added, return true.
            return true;
        }

        // The branch wasn't found or customer already is assigned to the branch, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Assigns transaction to the specific customer.
     *
     * @param string $branch - Branch name where customer should exists.
     * @param string $customer - Name of the customer who made transaction.
     * @param float $amount - Amount of the transaction which customer made.
     * @return bool - If the branch and the customer exists and transaction has been made then return true,
     *                false otherwise.
     */
    public function addTransaction(string $branch, string $customer, float $amount): bool
    {
        // Find branch on the list.
        $foundBranch = $this->findBranch($branch);

        // Try to assign transaction to the specific customer.
        if ($foundBranch->addTransaction($customer, $amount))
        {
            // Transaction has been assigned, return true.
            return true;
        }

        // The branch wasn't found or transaction couldn't be assigned to the customer, return false.
        return false;
    }

    /******************************************************************************************************************/

    /**
     * Checks if branch exists on the bank branches list.
     *
     * @param string $name - Name of the branch to find.
     * @return Branch - Returns specific Branch object if found, null otherwise.
     */
    public function findBranch(string $name): ?Branch
    {
        foreach ($this->branches as $branch)
        {
            if ($branch->getName() == filter_var($name, FILTER_SANITIZE_STRING))
            {
                // Branch has been found, return that Object.
                return $branch;
            }
        }
        // Branch wasn't found, return null.
        return null;
    }

    /******************************************************************************************************************/

    public function printCustomers(string $branch, bool $showTransactions = true)
    {
        // Try to find the branch.
        $foundBranch = $this->findBranch($branch);
        if ($foundBranch != null)
        {
            // Branch exists, get the customers.
            $customers = $foundBranch->getCustomers();

            echo "
            <table>
                <th>
                    <td colspan='3'>Customers of {$this->name} -> {$foundBranch->getName()}</td>
                </th>
                <tr>
                    <td>&nbsp;</td>
                    <td>Name</td>
                    <td>" . ($showTransactions ? "Transactions" : "") . "</td>
                </tr>";

            // Print out all customers.
            for ($i = 0; $i < count($customers); $i++)
            {
                $currentCustomer = $customers[$i];

                echo "
                <tr>
                    <td valign='top'>" . ($i + 1) . ".</td>
                    <td valign='top'>" . $currentCustomer->getName() . "</td>";

                // Show customer transactions if it's required.
                if ($showTransactions)
                {
                    $transactions = $currentCustomer->getTransactions();

                    echo "<td>";
                    foreach ($transactions as $transaction)
                    {
                        echo "- $transaction<br>";
                    }
                    echo "</td>";
                }

                echo "
                </tr>";
            }

            echo "
            </table>";
        }
        else
        {
            echo "Branch has not been found.";
        }
    }
}