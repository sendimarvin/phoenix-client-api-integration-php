<?php

use Interswitch\Phoenix\Simulator\ClientRegistration;
use Interswitch\Phoenix\Simulator\AccountInquiry;
use Interswitch\Phoenix\Simulator\BalanceInquiry;
use Interswitch\Phoenix\Simulator\PaymentNotification;

require "vendor/autoload.php";


// $clientRegistration = ClientRegistration::main();
// $accountinquiry = AccountInquiry::main();
// $balanceInquiry = BalanceInquiry::main();
$paymentNotification = PaymentNotification::main();

var_dump($paymentNotification);