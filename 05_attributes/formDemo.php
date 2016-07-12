<!DOCTYPE html>
<html>
<head>
	<title>Form Demo</title>
</head>
<body>
<h1>Thank You!</h1>
<p>The server has received your form submission. Here is what you sent:</p>

<table>
<tr>
    <th>Field</th>
    <th>Value</th>
</tr>
<?php foreach ($_POST as $field => $value) {
    if (is_array($value)) {
        $value = implode(", ", $value);
    }
    echo "<tr><td>{$field}:</td><td>{$value}</td></tr>";
} ?>
</table>

</body>
</html>