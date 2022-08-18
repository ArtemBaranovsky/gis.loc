<?php

Namespace App\Models;

use App\DB;

class Trips
{
    /**
     * Returns an array with columns driver_id and total_minutes_with_passenger
     * taking into account number of passengers
     *
     * @return array
     */
    public static function getAllTripsMinutes(): array {
        $sql = '
            select 
                driver_id,
                sum((JULIANDAY(dropoff) - JULIANDAY(pickup)) * 60 * 24) / count(id) AS total_minutes_with_passenger
            FROM trips
            GROUP BY driver_id
            ORDER BY driver_id
        ';

        return DB::getInstance()->query($sql)->fetchAll();
    }
}