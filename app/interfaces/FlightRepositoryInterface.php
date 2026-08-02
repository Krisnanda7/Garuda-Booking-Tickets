<?php

namespace App\Interfaces;

interface FlightRepositoryInterface
{
    public function gettALLFlights($filter = null);

    public function getFlightByFlightNumber($flightNumber);
}
