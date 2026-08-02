<?php

namespace App\Interfaces;

interface AirlineRepositoryInterface
{
    public function getAllAirports();

    public function getAirportBySlug($slug);

    public function getAirportByIataCode($iatacode);
}
