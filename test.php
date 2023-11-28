<?php

use Interswitch\Phoenix\Simulator\ClientRegistration;

require "vendor/autoload.php";


$clientRegistration = ClientRegistration::main();

var_dump($clientRegistration);