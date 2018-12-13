<?php?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" integrity="sha384-gfdkjb5BdAXd+lj+gudLWI+BXq4IuLW5IT+brZEZsLFm++aCMlF1V92rMkPaX4PP" crossorigin="anonymous">

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" />

    <title>WaziUp | IoT Bootcamp </title>
</head>

<body>

    <!-- Sidebar -->
    <ul class="sidebar" id="mtabs">
        <img src="waziupLogo.png" class="logo" alt="Waziup">
        <h4 class="text-center" style="color:#1BA1E7">SmartChick </h4>
        <li class="active">
            <a href="#context" rel="context">
                <h5 style="color:white">Feeding <i class="fab fa-bitbucket"></i></h5>
            </a>
        </li>
        <li>
            <a href="#value" rel="value">
                <h5 style="color:white">Lighting <i class="far fa-lightbulb"></i></h5>
            </a>
        </li>
        <li>
            <a href="#map" rel="map">
                <h5 style="color:white">Locations <i class="fas fa-map-marked-alt"></i></h5>
            </a>
        </li>
        <li>
            <a href="#graph" rel="graph">
                <h5 style="color:white">Analytics <i class="fas fa-chart-area"></i></h5>
            </a>
        </li>
        <li>
            <a href="#stockform" rel="stockform">
                <h5 style="color:white">Stock Management <i class="fas"></i></h5>
            </a>
        </li>
        <li>
            <a href="#stockreport" rel="stockreport">
                <h5 style="color:white">Stock Report <i class="fas"></i></h5>
            </a>
        </li>
    </ul>
    <!-- Page Content -->
    <div class="content">
        <nav class="navbar" style="background:#254a66; border-radius:25px">
            <i class="far fa-bell float-left" style="size:20rem"></i>
        </nav>
        <div id="mtabs_content_container">
            <!-- Sensor Selecter -->
            <div class="form-group row">
                <div class="col-sm">
                    <label for="select" style="color:#1BA1E7">Sensors</label>
                    <select class="form-control" id="selectSensor" onchange="onSensorSelect()">
                </select>
                </div>
                <div class="col-sm">
                    <label for="select" style="color:#1BA1E7">Measurements</label>
                    <select class="form-control" id="selectMeasurement" onchange="onMeasurementSelect()">
                </select>
                </div>
            </div>
            <div id="context" class="mtab_content" style="display: block;">
                <div>
                    <ul class="list-group">
                        <li class="list-group-item active">Sensor Context</li>
                        <li class="list-group-item" id="sensor_name_context">Name</li>
                        <li class="list-group-item" id="sensor_owner">Owner</li>
                        <li class="list-group-item" id="sensor_domain">Domain</li>
                        <li class="list-group-item" id="sensor_gateway">Gateway</li>
                    </ul>
                </div>
            </div>
            <div id="value" class="mtab_content">
                <div>
                    <ul class="list-group">
                        <li class="list-group-item active">Sensor Value for Measurement <span id="sensor_value_id"></span></li>
                        <li class="list-group-item" id="sensor_name_value">Name</li>
                        <li class="list-group-item" id="sensor_last_value">Last Value</li>
                        <li class="list-group-item" id="sensor_quantity_kind">Quantity Kind</li>
                        <li class="list-group-item" id="sensor_sensing_device">Sensing Device</li>
                        <li class="list-group-item" id="sensor_unit">Unit</li>
                    </ul>
                </div>
            </div>
            <div id="map" class="mtab_content">
                <div id="mapid" style="height:600px"></div>
            </div>
            <div id="graph" class="mtab_content">
                <canvas id="myChart" width="800" height="600">Loading...</canvas>
            </div>

            <div id="stockform" class="stockform_content">
                <div>
                    <ul class="list-group">
                        <li class="list-group-item active">Daily Stock Management<span id="sensor_value_id"></span></li>
                        <form method="POST" action="processor.php">
                          <div class="form-group">
                            <label for="exampleInputEmail1">Stock Type</label>
                            <input type="text" class="form-control" name="stocktype" aria-describedby="emailHelp" placeholder="Enter Stock Type">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Quantity (kgs)</label>
                            <input type="number" class="form-control" name="qty" aria-describedby="emailHelp" placeholder="Enter Quantity (kgs)">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Date</label>
                            <input type="date" class="form-control" name="date" aria-describedby="emailHelp" placeholder="Enter Quantity (kgs)">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Time</label>
                            <select class="form-control" name="time" >
                                <option>Select Time of the day</option>
                                <option>Morning</option>
                                <option>Midday</option>
                                <option>Evening</option>
                            </select>
                          </div>
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </ul>
                </div>
            </div>

            <div id="stockreport" class="stockreport_content">
                <div>
                    <table class="table table-bordered" style="background: white;" id="resultTable" data-responsive="table" style="text-align: left;">
    <thead>
        <tr>
            <th width=""> Stock Type </th>
            <th width=""> Qty </th>
            <th width=""> StockDate </th>
            <th width=""> TimeOfDay </th>
        </tr>
    </thead>
    <tbody>
        
            <?php
                include('connect.php');
                $result = $db->prepare("SELECT * FROM stocktable ORDER BY RecordId DESC");
                $result->execute();
                for($i=0; $row = $result->fetch(); $i++){
            ?>
            <tr class="record">
            <td><?php echo $row['Stocktype']; ?></td>
            <td><?php echo $row['Qty']; ?></td>
            <td><?php echo $row['StockDate']; ?></td>
            <td><?php echo $row['TimeOfDay']; ?></td>
            </tr>
            <?php
                }
            ?>
        
    </tbody>
</table>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/waziup-js@1.1.6/lib/Waziup.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
    <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            //  When user clicks on tab, this code will be executed
            $("#mtabs li").click(function() {
                //  First remove class "active" from currently active tab
                $("#mtabs li").removeClass('active');

                //  Now add class "active" to the selected/clicked tab
                $(this).addClass("active");

                //  Hide all tab content
                $(".mtab_content").hide();

                //  Here we get the href value of the selected tab
                var selected_tab = $(this).find("a").attr("href");

                //  Show the selected tab content
                $(selected_tab).fadeIn();

                //  At the end, we add return false so that the click on the link is not executed
                return false;
            });
        });
    </script>
    <script>
        Waziup.ApiClient.instance.basePath = 'https://api.waziup.io/api/v1'
        var api = new Waziup.SensorsApi()
            // default sensor values
        var domain = "waziup";
        var sensor_id = "UPPA-TESTS_Sensor6";
        var measurement_id = "TC";
        var measurementValues = [];
        var graphLabel = [];
        var myChart;

        // initializing
        loadSensors();
        loadMeasurements();

        function loadSensors() {
            // list of sensors
            var selectSensor = document.getElementById("selectSensor")
            api.getSensors({
                q: "domain==" + domain,
                limit: 1000
            }).then((sensors) => {
                for (sensor of sensors) {
                    // create and populate an option for the select
                    var opt = document.createElement("option");
                    opt.value = sensor.id;
                    opt.innerHTML = sensor.id;

                    // then append it to the select element
                    selectSensor.appendChild(opt);
                }
            })
        }

        function loadMeasurements() {
            // list of measurements
            var selectMeasurement = document.getElementById("selectMeasurement");
            // reset measurement values
            measurementValues = [];
            api.getSensorMeasurements(sensor_id).then((measurements) => {

                measurements.forEach((measurement, index) => {
                    // set measurement_id to the first measurement
                    if (index == 0) {
                        measurement_id = measurement.id
                    }
                    // create and populate an option for the select
                    var opt = document.createElement("option");
                    opt.value = measurement.id;
                    opt.innerHTML = measurement.id;

                    // then append it to the select element
                    selectMeasurement.appendChild(opt);

                    // get measurement values for each measurement
                    api.getMeasurementValues(sensor_id, measurement.id, {
                        'lastN': "20"
                    }).then((values) => {
                        var data = [];

                        // reset graph label
                        if (values.length > 0)
                            graphLabel = [];

                        // add each measurement values in an array
                        for (value of values) {
                            data.push(value.value)
                            if (value.timestamp)
                                graphLabel.push(value.timestamp)
                        }

                        // 
                        if (data.length > 0)
                            measurementValues.push({
                                label: measurement.id + (measurement.unit ? ("(" + measurement.unit + ")") : ""),
                                data: data,
                                borderColor: dynamicColors()
                            })
                    }).finally((values) => {
                        loadGraph();
                    })
                });
                loadValues();
            })
        }

        // select sensor
        function onSensorSelect() {
            var sensorsList = document.getElementById("selectSensor");
            var selectedSensor = sensorsList.options[sensorsList.selectedIndex].value;
            sensor_id = selectedSensor;
            // reset measurements list
            document.getElementById('selectMeasurement').innerText = null
            loadMeasurements();
        }

        // select measurement
        function onMeasurementSelect() {
            var measurementsList = document.getElementById("selectMeasurement");
            var selectedMeasurement = measurementsList.options[measurementsList.selectedIndex].value;
            measurement_id = selectedMeasurement;
            loadValues();
        }

        // random color generator
        var dynamicColors = function() {
            var r = Math.floor(Math.random() * 255);
            var g = Math.floor(Math.random() * 255);
            var b = Math.floor(Math.random() * 255);
            return "rgb(" + r + "," + g + "," + b + ")";
        };

        // load sensor and measurement values
        function loadValues() {

            // sensor context
            api.getSensor(sensor_id).then((sensor) => {
                document.getElementById("sensor_name_context").innerHTML = "Name : " + sensor.name;
                document.getElementById("sensor_owner").innerHTML = "Owner : " + sensor.owner;
                document.getElementById("sensor_domain").innerHTML = "Domain : " + sensor.domain;
                document.getElementById("sensor_gateway").innerHTML = "Gateway : " + sensor.gateway_id;
            })

            // sensor value
            api.getMeasurement(sensor_id, measurement_id).then((sensor) => {
                document.getElementById("sensor_value_id").innerHTML = sensor.id;
                document.getElementById("sensor_name_value").innerHTML = "Name : " + sensor.name;
                document.getElementById("sensor_last_value").innerHTML = "Last Value : " + sensor.last_value.value;
                document.getElementById("sensor_quantity_kind").innerHTML = "Quantity Kind : " + sensor.quantity_kind;
                document.getElementById("sensor_sensing_device").innerHTML = "Sensing Device : " + sensor.sensing_device;
                document.getElementById("sensor_unit").innerHTML = "Unit : " + sensor.unit;
            });
        }

        // load graph with sensor values
        function loadGraph() {
            // if chart already exists update dataset
            if (myChart) {
                myChart.data.labels = graphLabel;
                myChart.data.datasets = measurementValues;
                myChart.update();
            } else {
                var ctx = document.getElementById("myChart").getContext('2d');
                myChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: graphLabel,
                        datasets: measurementValues
                    },
                    options: {
                        responsive: false,
                    }
                });
            }
        }

        // map
        var mymap = L.map('mapid').setView([-1.97, 30.1], 8);
        L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
            attribution: 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
            maxZoom: 8,
            id: 'mapbox.streets',
            accessToken: 'pk.eyJ1IjoiY2R1cG9udDIiLCJhIjoiY2pnZTVkZ2xsMGxyZTJ4cjA5dDZ4cjNneSJ9.NJT7CULfcY0mjeavffR_vg'
        }).addTo(mymap);

        var markers = []
        api.getSensors({
            limit: 1000
        }).then((sensors) => {
            for (sensor of sensors) {
                if (sensor.location) {
                    L.marker([sensor.location.latitude, sensor.location.longitude]).addTo(mymap);
                }
            }
        })
    </script>
</body>

</html>