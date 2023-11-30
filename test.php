<?php

use Interswitch\Phoenix\Simulator\ClientRegistration;
use Interswitch\Phoenix\Simulator\AccountInquiry;

require "vendor/autoload.php";


// $clientRegistration = ClientRegistration::main();
$accountinquiry = AccountInquiry::main();

var_dump($accountinquiry);