<?php

namespace App\Http\Controllers;

use App\Interfaces\AirlineRepositoryInterface;
use App\Interfaces\FlightRepositoryInterface;
use Illuminate\Http\Request;

class FlightController extends Controller
{
    private AirlineRepositoryInterface $airlineRepository;
    private FlightRepositoryInterface $flightRepository;

    public function __construct(AirlineRepositoryInterface $airlineRepository, FlightRepositoryInterface $flightRepository)
    {
        $this->airlineRepository = $airlineRepository;
        $this->flightRepository = $flightRepository;
    }

    public function index()
    {
        return view('pages.flight.index');
    }
}
