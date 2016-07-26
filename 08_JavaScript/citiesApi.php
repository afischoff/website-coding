<?php

// gather request params
$state = urldecode($_GET['state']);
$city = urldecode($_GET['city']);

// connect to db
$db = new PDO("mysql:dbname=afischof_websites_class", "afischof_class", "i}6n+{XbFu-#");

// search database based on input params
// prepare the statements
if (empty($city) && empty($state)) {
	// no search params - get the states
	$statement = $db->prepare("select distinct(state) from cities order by state");

} else if (empty($city) && !empty($state)) {
	// search by state
	$statement = $db->prepare("select distinct(city) from cities where state = :state order by city");
	$statement->bindParam(':state', $state);

} else {
	// search by city and state
	$statement = $db->prepare("select zip from cities where state = :state and city = :city order by zip");
	$statement->bindParam(':state', $state);
	$statement->bindParam(':city', $city);
}

// run the statements
$statement->execute();

// build response array
$output = [];
while ($row = $statement->fetch()) {
	$output[] = current($row);
}

// output the results
header('Content-Type: application/json');
echo json_encode($output);
