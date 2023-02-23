# Summary
This readme describes the Weather Station Library. It can be used to add Weather Station instances to places, use place's Geo Location and automatically retrieve weather data from a variety of online data stores.

## Weather Data Resources
There are a lot of different places available to obtain weather data from. This is why we chose a connector architecture that can be extended as needed. Here are a couple of things to keep in mind:

Good quality weather data that can be obtained reliably and at scale is not free. Most vendors offer a free tier for developers to experiment with a limited number of transactions per day, week, or month.
Make a spreadsheet: if you want data every 15 minutes, you will make about 3,000 calls per month. Every month. For every location.
Most endpoints claim to provide data at least once per hour. We are far from "real time weather data" everywhere. The timestamp of your request is likely not the timestamp of the data set you get.
Good api's let you query locations by name, geo location, zip or airport code. An api that works well in California, doesn't mean it will work well in Canada, or Europe.
If you have HVAC applications in mind, you need dew point and wet bulb. If you think agriculture, you may be after precipitation and wind. Solar energy, however, you get the idea...
Currently the Weather Station Library contains scripts to obtain weather data from the following resources:

### Azure Maps - Geospatial Services
Microsoft has included multiple weather api's with their Maps geospatial services offering. We use the endpoint featuring current weather data, which is documented here. To use the service, you will need an azure account and obtain an api key, which is needed to configure the Weather Station equipment type included in the Weather Station Library.

- Pro: current weather data includes dew point and wet bulb
- Con: no historical weather data

OpenWeatherMap - Current Weather and Forecast
OpenWeatherMap is a dedicated data service that includes a number of api's focusing exclusively on weather and climate conditions and forecasting. We use the endpoint featuring current weather data, which is documented here. To use the service, you will need to create an account and obtain an api key, which is needed to configure the Weather Station equipment type included in the Weather Station Library.

Pro: there is an endpoint for hourly historical weather data
Con: current data does not include dew point and wet bulb

# Instructions
### 1. Import Library
Import the library, which you can download [here](dist/weather_station_library_export.json). You will need download the file and import the "weather_station_libarary.json" file into your platform.

### 2. Explore Library Content
There are a couple of units included, which will hopefully make it into the standards library soon: degree for wind direction, and inch of mercury for air pressure. This library is setup to use imperial units.
There is an equipment type "Weather Station" that includes attributes for configuration, raw and parsed data, and the following weather attributes:

- Temperature [deg F]
- Relative Humidity [%]
- Air Pressure [inHg]
- Wind Speed [mph]
- Wind Direction [deg]
- Dew Point [deg F]
- Wet Bulb [deg F]

The equipment type also contains scripts for the different weather api's. The script for OpenWeatherMap includes a messy section where dew point and wet bulb is calculated from dry bulb temperature and humidity.

Finally, the library contains a browser script that allows you to hide raw data and config attributes and set the order of weather attributes. Eventually, the equipment type will have the attributes configured correctly and this browser script won't be needed anymore.

### 3. Configure Weather Station Type with API Name and API Key
Provide the name for the connector and the corresponding api key in the equipment type. That way at creation these settings trickle into the Weather Station instances. If you want to use multiple connector types, you'll need to assure correct type and api key settings on every Weather Station instance.

### 4. Patch Attribute Settings for the Weather Station Equipment Type
We can organize the Weather Station attributes, hide raw data and configuration settings by running the "Patch Weather Station Equipment Type Attributes" headless script, which can be found in the library proper.

If we skip this step and create weather stations, we can correct attribute settings either manually, or with the "Format Weather Stations" browser script that can also be found in the library proper. Note, that this page uses the GraphQL api and that the default read only settings are not strong enough to modify model settings - you will need to elevate your GraphQL role.

### 5. Create Weather Station
You are now ready to create an equipment underneath a place that must contain a Geo Location attribute. We use an expression to feed the geo location from the parent. Head to the equipment detail page and verify the geo location attribute gets the correct values.

### 6. Make a Test Run
You should be able to open the script for your preferred data provider and give it a go. A single data point should show up in the various weather attributes of your Weather Station instance. Also, note that the raw json and an extract record with just the attributes we need are stored in the Raw Data and Raw Data Parsed attributes, respectively.

### 7. Schedule Script to Run at Specified Interval
Keep data usage costs in mind, and schedule the script to run every 15mins or hourly.

### 8. Rinse and Repeat
At this point you should be able to create more Weather Station instances as needed and future run times should work on those instances as well.