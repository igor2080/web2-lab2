<?php
require("../task2/logger.php");
$logger = new Logger("c:/lablog.txt");
$server = "127.0.0.1:3306";
$database = "mobile";
$user = "root";
$password = "password";
$mysqli = new mysqli($server, $user, $password, $database);
 
$manufacturers = array();
$manufacturer_handle = $mysqli->query("select id, title from manufacturers
order by title");
while ($row = $manufacturer_handle->fetch_assoc()) {
    $manufacturers[$row["id"]] = $row["title"];
}

$colors = array();
$color_handle = $mysqli->query("select id, title from colors
order by title");
while ($row = $color_handle->fetch_assoc()) {
    $colors[$row["id"]] = $row["title"];
}
if (isset($_GET["year"]) && isset($_GET["manufacturer"]) && isset($_GET["color"])) {

    $year = htmlspecialchars($_GET["year"]);
    $manufacturer = htmlspecialchars($_GET["manufacturer"]);
    $color = htmlspecialchars($_GET["color"]);

    if (
        !empty($year) &&
        !empty($manufacturer) &&
        !empty($color) &&
        ctype_digit($year) &&
        ctype_digit($manufacturer) &&
        ctype_digit($color)
    ) {
        $results = array();
        $query = $mysqli->prepare("
   select
    manufacturers.title as manufacturer,
    models.title as model,
    count(*) as count
   from
    manufacturers
    inner join models on manufacturer_id = manufacturers.id
    inner join cars on cars.model_id = models.id
   where
    manufacturer_id = ?
    and color_id = ?
    and cars.registration_year = ?
   group by
    manufacturers.title,
    models.title
   order by
    count desc
    ");
        $query->bind_param('iii', $manufacturer, $color, $year);
        $query->execute();
        $results = $query->get_result();
    } else {
        $error = "The following parameters contain invalid data: ";
        $error .= (!empty($manufacturer) && ctype_digit($manufacturer)) ? '' : 'manufacturer/brand, ';
        $error .= (!empty($color) && ctype_digit($color)) ? '' : 'color, ';
        $error .= (!empty($year) && ctype_digit($year)) ? '' : 'year, ';
        $error = rtrim($error, ", ");
    }
}

$logger->log(isset($error) ? "ERROR" : "OK");

require("view.php");