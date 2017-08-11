<?php
interface CustomerInterface
{
    /** Permission to do payments to account. */
    const PERMISSION_PAYMENT = 1;
    /** Permission to withdrawal from account. */
    const PERMISSION_WITHDRAWAL = 2;

    /******************************************************************************************************************/

    function addTransaction(float $amount);
}