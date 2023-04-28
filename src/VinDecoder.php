<?php

namespace gertexllc\yii2\vindecoder;

/**
 * VinDecoder is a Yii2 component for decoding vehicle VINs.
 */
class VinDecoder extends \yii\base\Component
{
    /**
     * @var string The URL of the NHTSA VIN decoder API.
     */
    const API_URL = 'https://vpic.nhtsa.dot.gov/api/vehicles/DecodeVinValuesExtended/';

    /**
     * @var VinData The decoded VIN data.
     */
    private $_vinData;

    /**
     * Decodes the specified VIN and returns the decoded data as a VinData object.
     *
     * @param string $vin The VIN to decode.
     * @return VinData The decoded VIN data.
     * @throws \Exception If the VIN is not in a valid format, the check digit is incorrect, or the API call fails.
     */
    public function decode($vin)
    {
        // Validate the VIN format and check digit.
        $checkDigit = $this->calculateCheckDigit($vin);
        if ($vin[8] != $checkDigit) {
            throw new \Exception("Invalid VIN check digit: $checkDigit");
        }

        // Make the API request.
        $url = self::API_URL . "?format=json&data=$vin&modelyear=&make=&manufacturer=&plant=";
        $response = file_get_contents($url);
        $data = json_decode($response, true);

        // Check for errors.
        if (isset($data['Results'][0]['ErrorReport']['ErrorCode'])) {
            throw new \Exception("NHTSA API error: {$data['Results'][0]['ErrorReport']['Description']}");
        }

        // Load the response into the VinData object.
        $this->_vinData = new VinData();
        $this->loadResponse($data, $this->_vinData);

        return $this->_vinData;
    }

    /**
     * Calculates the check digit for the specified VIN.
     *
     * @param string $vin The VIN to calculate the check digit for.
     * @return string The calculated check digit.
     * @throws \Exception If the VIN is not in a valid format or contains an invalid character.
     */
    private function calculateCheckDigit($vin)
    {
        $transliterationTable = [
            'A' => 1, 'B' => 2, 'C' => 3, 'D' => 4, 'E' => 5, 'F' => 6, 'G' => 7, 'H' => 8, 'I' => 9, 'J' => 1,
            'K' => 2, 'L' => 3, 'M' => 4, 'N' => 5, 'O' => 6, 'P' => 7, 'Q' => 8, 'R' => 9, 'S' => 2, 'T' => 3,
            'U' => 4, 'V' => 5, 'W' => 6, 'X' => 7, 'Y' => 8, 'Z' => 9
        ];

        $weights = [
            8, 7, 6, 5, 4, 3, 2, 10, 0, 9, 8, 7, 6, 5, 4, 3, 2
        ];

        $vin = strtoupper($vin);
        $checkDigit = 0;

        if (!preg_match('/^[A-Z0-9]{17}$/', $vin)) {
            throw new \Exception('Invalid VIN format');
        }

        for ($i = 0; $i < 17; $i++) {
            $char = $vin[$i];
            if (isset($transliterationTable[$char])) {
                $char = $transliterationTable[$char];
            }
            $checkDigit += $weights[$i] * $char;
        }

        $checkDigit %= 11;
        if ($checkDigit == 10) {
            $checkDigit = 'X';
        }

        return strval($checkDigit);
    }

    /**
     * Loads the decoded VIN data from the specified API response into the specified VinData object.
     *
     * @param array $data The decoded JSON data from the NHTSA VIN decoder API.
     * @param VinData $vinData The VinData object to load the data into.
     */
    private function loadResponse($data, $vinData)
    {
        foreach ($data['Results'][0] as $key => $value) {
            switch ($key) {
                case 'Make':
                    $vinData->make = $value;
                    break;
                case 'Model':
                    $vinData->model = $value;
                    break;
                case 'ModelYear':
                    $vinData->year = $value;
                    break;
                case 'Trim':
                    $vinData->trim = $value;
                    break;
                case 'BodyClass':
                    $vinData->bodyType = $value;
                    break;
                case 'EngineType':
                    $vinData->engineType = $value;
                    break;
                case 'DriveType':
                    $vinData->driveType = $value;
                    break;
                case 'FuelTypePrimary':
                    $vinData->fuelType = $value;
                    break;
                case 'PlantCountry':
                    $vinData->plantCountry = $value;
                    break;
                case 'PlantState':
                    $vinData->plantState = $value;
                    break;
                default:
                    // Ignore unknown fields.
                    break;
            }
        }
    }

}

