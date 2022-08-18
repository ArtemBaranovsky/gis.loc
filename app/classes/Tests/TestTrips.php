<?php

namespace App\Tests;

use App\FileHelper;
use App\Models\Trips;

class TestTrips
{
    /**
     * @return void
     */
    public static function testTripsDuration(): void
    {
        if (FileHelper::saveToCSV('tripTime', Trips::getAllTripsMinutes())) {
            echo("Trips duration data successfully exported.");
        };
    }
}