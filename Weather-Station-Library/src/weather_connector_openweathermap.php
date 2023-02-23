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
if($weather_api == "openweathermap.org"){

    // retrieve latitude, longitude, and api_key
    // latlon comes from an expression, so we need to use getTimeSeries for this
    $latlon = json_decode($station->attributes['geo_location']->getTimeSeries(new DateTime(), new DateTime())['values'][0], true);
    echo PHP_EOL;

    $lat = floatval($latlon['latitude']);
    $lon = floatval($latlon['longitude']);
    $api_key = $station->attributes['api_key']->current_value;
    // echo print_r($latlon, true) . PHP_EOL;
    // echo $lat . PHP_EOL;
    // echo $lon . PHP_EOL;

    // documentation for api endpoint is here: https://openweathermap.org/current
    // call the weather api with our lat, lon, and api_key
    // we have our system setup to use imperial units
    $data = json_decode(file_get_contents("http://api.openweathermap.org/data/2.5/weather?lat=$lat&lon=$lon&appid=$api_key&units=imperial"), true);
    $epoch = $data['dt'];

    $timestamp = new DateTime("@$epoch");
    // echo print_r($timestamp, true) . PHP_EOL;
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

    $data_parsed['air_pressure']=$data['main']['pressure'] / 33.864; // we need to convert mbar (same as hPa) to inch of mercury
    // $data_parsed['dew_point']=$data['dewPoint']['value'];
    $data_parsed['relative_humidity']=$data['main']['humidity'];
    $data_parsed['temperature']=$data['main']['temp'];
    // $data_parsed['wet_bulb']=$data['wetBulbTemperature']['value'];
    $data_parsed['wind_direction']=($data['wind']['deg'] + 180) % 360; // we need to add 180 deg to get where the wind is blowing towards
    $data_parsed['wind_speed']=$data['wind']['speed'];

    // calculate dew point according to https://en.wikipedia.org/wiki/Dew_point
    $b = 18.678;    //constant b
    $c = 257.14;    //constant c
    $t_c = ($data['main']['temp'] - 32) / 1.8; //dry bulb temp in deg C
    $rh = $data['main']['humidity'];

    // echo $t_c . PHP_EOL;
    // echo $rh . PHP_EOL;
    $gamma = log($rh / 100) +  $b * $t_c / ($c + $t_c);
    // echo $gamma . PHP_EOL;
    $dew_point = $c * $gamma / ($b - $gamma);
    // echo $dew_point . PHP_EOL;
    $data_parsed['dew_point']= $dew_point;


    // wet bulb is a mess. use this one: https://forum.arduino.cc/t/formula-for-outputting-wet-bulb-temp-from-temp-and-rh/231797/5
    $tw = 5.391260E-01 * $t_c + 1.047837E-01 * $rh -7.493556E-04 * $rh * $rh -1.077432E-03 * $t_c * $t_c + 6.414631E-03 * $t_c * $rh - 5.151526E+00;
    // echo $tw . PHP_EOL;
    $data_parsed['wet_bulb']= ($tw * 1.8 ) + 32; //dry bulb temp in deg F

    // echo print_r(json_encode($data_parsed), true) . PHP_EOL;

    // save the raw data
    $station->attributes['raw_data']->insertTimeSeries([json_encode($data)], [$timestamp]);

    // save the parsed data
    $station->attributes['raw_data_parsed']->insertTimeSeries([json_encode($data_parsed)], [$timestamp]);


} else {
    // element does not use this connector
    // echo "nothing to do here" . PHP_EOL;
}

// the end
$logger->info("Done running at " . (new DateTime())->format("Y-m-d H:i:s"));

$context->return_data();