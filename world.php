<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);

// Check if country parameter is set
$country = isset($_GET['country']) ? $_GET['country'] : '';
// Check if lookup type is set (cities or countries)
$lookup = isset($_GET['lookup']) ? $_GET['lookup'] : 'countries';

if ($lookup === 'cities') {
    // CITIES LOOKUP - Join countries and cities tables
    if (!empty($country)) {
        $query = "SELECT cities.name as city_name, cities.district, cities.population 
                  FROM cities 
                  JOIN countries ON cities.country_code = countries.code 
                  WHERE countries.name LIKE '%$country%'";
        $stmt = $conn->query($query);
    } else {
        // If no country specified, show all cities
        $stmt = $conn->query("SELECT cities.name as city_name, cities.district, cities.population FROM cities");
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
// Display cities in table
?>
<table border="1">
    <thead>
        <tr>
            <th>Name</th>
            <th>District</th>
            <th>Population</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $row): ?>
        <tr>
            <td><?= htmlspecialchars($row['city_name']) ?></td>
            <td><?= htmlspecialchars($row['district']) ?></td>
            <td><?= htmlspecialchars($row['population']) ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php

} else {
    // COUNTRIES LOOKUP (default)
    if (!empty($country)) {
        $stmt = $conn->query("SELECT * FROM countries WHERE name LIKE '%$country%'");
    } else {
        $stmt = $conn->query("SELECT * FROM countries");
    }
    
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Display countries in table
    ?>
    <table border="1">
        <thead>
            <tr>
                <th>Name</th>
                <th>Continent</th>
                <th>Independence</th>
                <th>Head of State</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($results as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['name']) ?></td>
                <td><?= htmlspecialchars($row['continent']) ?></td>
                <td><?= htmlspecialchars($row['independence_year']) ?></td>
                <td><?= htmlspecialchars($row['head_of_state']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
}
?>