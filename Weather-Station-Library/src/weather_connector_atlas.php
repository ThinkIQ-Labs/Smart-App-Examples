<?php

use \TiqUtilities\Database\PgSQL;

use \TiqUtilities\Model\Node;
use TiqUtilities\Model\Equipment;
use TiqUtilities\Model\Attribute;

require_once 'thinkiq_context.php';
$context = new Context();
$logger = $context->logger; // shorthand to keep this script clearer

$db = new PgSQL(new \TiqConfig());

// retrieve the weather station and its attributes
$host_id = $context->std_inputs->node_id;
$station = new Equipment($host_id);
$station->getAttributes();

// check what weather api to use
$weather_api = $station->attributes['weather_api']->current_value;

// this script is only for atlas.microsoft.com
if($weather_api == "atlas.microsoft.com"){

    // documentation for api endpoint is here: https://docs.microsoft.com/en-us/rest/api/maps/weather/get-current-conditions
    // retrieve latitude, longitude, and api_key
    // latlon comes from the parent's GeoLocation attribute

    $station->getParent();
    $station->parent->getAttributes();
    $station->parent->geo_location->getGeoCoordinates();

    $lat = $station->parent->geo_location->latitude;
    $lon = $station->parent->geo_location->longitude;
    $api_key = $station->attributes['api_key']->current_value;
    // echo print_r($latlon, true) . PHP_EOL;
    // echo $lat . PHP_EOL;
    // echo $lon . PHP_EOL;

    // call the weather api with our lat, lon, and api_key
    // we have our system setup to use imperial units
    $response = json_decode(file_get_contents("https://atlas.microsoft.com/weather/currentConditions/json?api-version=1.0&query=$lat,$lon&subscription-key=$api_key&unit=imperial"), true);
    // echo print_r($response, true);

    // the response is an array, and for current, there's only one element inside
    $data = $response['results'][0];
    // echo print_r(new DateTime($data['dateTime']), true) . PHP_EOL;
    // echo print_r(json_encode($data), true) . PHP_EOL;

    // this is the parsed object we want to create

    // {
    //   "air_pressure": 1.23,
    //   "dew_point": 1.23,
    //   "relative_humidity": 1.23,
    //   "temperature": 1.23,
    //   "wet_bulb": 1.23,
    //   "wind_direction": 1.23,
    //   "wind_speed": 1.23
    // }

    $data_parsed['air_pressure']=$data['pressure']['value'];
    $data_parsed['dew_point']=$data['dewPoint']['value'];
    $data_parsed['relative_humidity']=$data['relativeHumidity'];
    $data_parsed['temperature']=$data['temperature']['value'];
    $data_parsed['wet_bulb']=$data['wetBulbTemperature']['value'];
    $data_parsed['wind_direction']=$data['wind']['direction']['degrees'];
    $data_parsed['wind_speed']=$data['wind']['speed']['value'];

    // echo print_r(json_encode($data_parsed), true) . PHP_EOL;

    // save the raw data
    $station->attributes['raw_data']->insertTimeSeries([json_encode($data)], [new DateTime($data['dateTime'])]);

    // save the parsed data
    $station->attributes['raw_data_parsed']->insertTimeSeries([json_encode($data_parsed)], [new DateTime($data['dateTime'])]);


} else {
    // element does not use this connector
    // echo "nothing to do here" . PHP_EOL;
}

// the end
$logger->info("Done running at " . (new DateTime())->format("Y-m-d H:i:s"));

$context->return_data();