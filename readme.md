Sure, here is an updated version of the `README.md` file for the `VinDecoder` component:

# VinDecoder

`VinDecoder` is a Yii2 component that decodes vehicle VINs using the NHTSA VIN decoder API. The component validates whether the VIN is correctly formatted and the check digits are correct, then submits it to the API and returns the result as an associative array.

## Installation

You can install the `VinDecoder` component using [Composer](https://getcomposer.org/) by running the following command:

```
composer require gertexllc/yii2-vin-decoder
```

## Usage

To use the `VinDecoder` component in your Yii2 application, you first need to configure it in your application configuration file (`config/main.php`):

```php
'components' => [
    'vinDecoder' => [
        'class' => 'gertexllc\vindecoder\VinDecoder',
    ],
],
```

You can then use the `VinDecoder` component in your application code to decode VINs. Here's an example:

```php
try {
    $vin = '1GNKVJED9CJ211239';
    $vinData = Yii::$app->vinDecoder->decode($vin);
    echo "Make: {$vinData->make}\n";
    echo "Model: {$vinData->model}\n";
    echo "Year: {$vinData->year}\n";
    echo "Trim: {$vinData->trim}\n";
    echo "Body Type: {$vinData->bodyType}\n";
    echo "Engine Type: {$vinData->engineType}\n";
    echo "Drive Type: {$vinData->driveType}\n";
    echo "Fuel Type: {$vinData->fuelType}\n";
    echo "Plant Country: {$vinData->plantCountry}\n";
    echo "Plant State: {$vinData->plantState}\n";
} catch (\Exception $e) {
    echo "Error: {$e->getMessage()}\n";
}
```

In this example, we first define a VIN to decode (`$vin`). We then call the `decode()` method of the `vinDecoder` component to decode the VIN, which returns a `VinData` object with the decoded data. We can then access the decoded data using the properties of the `VinData` object.

## VinData Object

The `VinData` object is a simple data object that contains the decoded VIN data. The object has the following properties:

- `make` - The make of the vehicle.
- `model` - The model of the vehicle.
- `year` - The model year of the vehicle.
- `trim` - The trim level of the vehicle.
- `bodyType` - The body type of the vehicle.
- `engineType` - The engine type of the vehicle.
- `driveType` - The drive type of the vehicle.
- `fuelType` - The primary fuel type of the vehicle.
- `plantCountry` - The country where the vehicle was manufactured.
- `plantState` - The state or province where the vehicle was manufactured.

## Requirements

The `VinDecoder` component requires PHP 7.1 or later and the [Yii2 framework](https://www.yiiframework.com/) version 2.0 or later.

## License

The `VinDecoder` component is open-source software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Author

The `VinDecoder` was developed and brought to you free of charge by GerTex, LLC