<?php

namespace gertexllc\vindecoder;

/**
 * VinData is a container for decoded vehicle VIN data.
 */
class VinData
{
    /**
     * @var string The make of the vehicle.
     */
    public $make;

    /**
     * @var string The model of the vehicle.
     */
    public $model;

    /**
     * @var string The year of the vehicle.
     */
    public $year;

    /**
     * @var string The trim level of the vehicle.
     */
    public $trim;

    /**
     * @var string The body type of the vehicle.
     */
    public $bodyType;

    /**
     * @var string The engine type of the vehicle.
     */
    public $engineType;

    /**
     * @var string The drive type of the vehicle.
     */
    public $driveType;

    /**
     * @var string The primary fuel type of the vehicle.
     */
    public $fuelType;

    /**
     * @var string The country where the vehicle was manufactured.
     */
    public $plantCountry;

    /**
     * @var string The state where the vehicle was manufactured.
     */
    public $plantState;
}
