<?php

// gather request params
$state = urldecode($_GET['state']);
$city = urldecode($_GET['city']);

// connect to db
$db = mysqli_connect("localhost", "afischof_class", "i}6n+{XbFu-#", "afischof_websites_class");
if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}

// search database based on input params
// prepare the statements
if (empty($city) && empty($state)) {
	// no search params - get the states
	$statement = $db->prepare("select distinct(state) from cities order by state");

} else if (empty($city) && !empty($state)) {
	// search by state
	$statement = $db->prepare("select distinct(city) from cities where state = ? order by city");
	$statement->bind_param('s', $state);

} else {
	// search by city and state
	$statement = $db->prepare("select zip from cities where state = ? and city = ? order by zip");
	$statement->bind_param('ss', $state, $city);
}

// run the statements
$statement->execute();
$result = $statement->get_result();

// build response array
$output = [];
while ($row = $result->fetch_row()) {
	$output[] = current($row);
}

// close the connection
$statement->close();
$db->close();

// output the results
header('Content-Type: application/json');
echo json_encode($output);
