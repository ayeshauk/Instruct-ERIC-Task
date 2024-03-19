<?php
$services = [
    ['Ref' => 'APPLAB1', 'Centre' => 'Aperture Science', 'Service' => 'Portal Technology', 'Country' => 'FR'],
    ['Ref' => 'BLULAB1', 'Centre' => 'Blue Sun Corp', 'Service' => 'Behaviour Modification', 'Country' => 'FR'],
    ['Ref' => 'BMELAB1', 'Centre' => 'Black Mesa', 'Service' => 'Interdimensional Travel', 'Country' => 'DE'],
    ['Ref' => 'WEYLAB1', 'Centre' => 'Weyland Yutani Research', 'Service' => 'Xeno-biology', 'Country' => 'GB'],
    ['Ref' => 'BLULAB3', 'Centre' => 'Blue Sun R&D', 'Service' => 'Behaviour Modification', 'Country' => 'CZ'],
    ['Ref' => 'BMELAB2', 'Centre' => 'Black Mesa Second Site', 'Service' => 'Interdimensional Travel', 'Country' => 'DE'],
    ['Ref' => 'TYRLAB1', 'Centre' => 'Tyrell Research', 'Service' => 'Synthetic Consciousness', 'Country' => 'GB'],
    ['Ref' => 'BLULAB2', 'Centre' => 'Blue Sun Corp', 'Service' => 'Behaviour Modification', 'Country' => 'IT'],
    ['Ref' => 'TYRLAB2', 'Centre' => 'Tyrell Research', 'Service' => 'Synthetic Optics', 'Country' => 'PT'],
];

function queryServicesByCountry($countryCode)
{
    global $services;

    $countryServices = array_filter($services, function ($service) use ($countryCode) {
        return strtoupper($service['Country']) === strtoupper($countryCode);
    });

    return $countryServices;
}

function displayServices($services)
{
    if (empty($services)) {
        echo "No services found for this country code.\n";
    } else {
        echo "Services provided:\n";
        foreach ($services as $service) {
            echo "- " . $service['Service'] . " (Centre: " . $service['Centre'] . ")\n";
        }
    }
}

function displaySummary()
{
    global $services;

    $summary = [];
    foreach ($services as $service) {
        $countryCode = strtoupper($service['Country']);
        if (!isset($summary[$countryCode])) {
            $summary[$countryCode] = 0;
        }
        $summary[$countryCode]++;
    }

    echo "Summary of services by country:\n";
    foreach ($summary as $countryCode => $count) {
        echo "$countryCode: $count\n";
    }
}

if ($argc < 2) {
    echo "Usage: php service_catalogue.php <command> [<args>]\n";
    echo "Available commands:\n";
    echo "  query <country_code>   Query services by country code\n";
    echo "  summary               Display summary of services by country\n";
    exit(1);
}

$command = $argv[1];

switch ($command) {
    case 'query':
        if ($argc != 3) {
            echo "Usage: php service_catalogue.php query <country_code>\n";
            exit(1);
        }
        $countryCode = strtoupper($argv[2]);
        $services = queryServicesByCountry($countryCode);
        displayServices($services);
        break;

    case 'summary':
        if ($argc != 2) {
            echo "Usage: php service_catalogue.php summary\n";
            exit(1);
        }
        displaySummary();
        break;

    default:
        echo "Invalid command. Available commands: query, summary\n";
        exit(1);
}
