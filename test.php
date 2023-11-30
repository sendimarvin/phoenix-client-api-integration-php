<?php

use Interswitch\Phoenix\Simulator\ClientRegistration;
use Interswitch\Phoenix\Simulator\AccountInquiry;
use Interswitch\Phoenix\Simulator\BalanceInquiry;

require "vendor/autoload.php";


// $clientRegistration = ClientRegistration::main();
// $accountinquiry = AccountInquiry::main();
$balanceInquiry = BalanceInquiry::main();

var_dump($balanceInquiry);