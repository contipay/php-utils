<?php

require_once __DIR__ . '/../app/bootstrap.php';

use SanixAI\Utils\Core\Phone\Phone;

// Sample ZW numbers per carrier, matched against the carrier name from libphonenumber's mapper
$cases = [
    ['number' => '790086411', 'carrier' => 'Econet'],
    ['number' => '712345678', 'carrier' => 'Net*One'],
    ['number' => '732222222', 'carrier' => 'Telecel'],
];

$failures = 0;

foreach ($cases as $case) {
    $number = $case['number'];
    $expectedCarrier = $case['carrier'];

    $phone = new Phone($number, 'ZW');
    $isValid = $phone->isValid() === 'true';
    $carrier = $phone->providerInfo();

    echo "Number: {$number}\n";
    echo "Valid: " . ($isValid ? 'true' : 'false') . "\n";
    echo "Carrier: {$carrier}\n";

    $matches = $isValid && stripos($carrier, $expectedCarrier) !== false;

    if ($matches) {
        echo "PASS: {$number} is a valid {$expectedCarrier} number.\n\n";
        continue;
    }

    echo "FAIL: {$number} is not recognised as a valid {$expectedCarrier} number.\n\n";
    $failures++;
}

exit($failures > 0 ? 1 : 0);
