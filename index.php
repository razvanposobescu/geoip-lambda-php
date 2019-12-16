<?php

declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

use GeoIp2\Database\Reader;

lambda(static function (array $event) : string {
    try {
        $reader = new Reader('/opt/maxminddb/GeoLite2-City.mmdb');
        $record = $reader->city($event['ip']);

        $data = [
            'city' => $record->city->name,
            'state' => $record->mostSpecificSubdivision->name,
            'country' => $record->country->isoCode,
        ];
    } catch (Exception $exception) {
        $data = [
            'error' => $exception->getMessage(),
        ];
    }

    return \json_encode($data);
});
