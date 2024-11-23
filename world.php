<?php
$host = 'localhost';
$username = 'lab5_user';
$password = 'password123';
$dbname = 'world';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $country = isset($_GET['country']) ? trim($_GET['country']) : '';
    $lookup = isset($_GET['lookup']) ? trim($_GET['lookup']) : 'country';

    if (!empty($country)) {
        if ($lookup === 'cities') {
            $stmt = $conn->prepare("
                SELECT cities.name AS city_name, cities.district, cities.population
                FROM cities
                JOIN countries ON cities.country_code = countries.code
                WHERE countries.name LIKE :country
            ");
            $stmt->execute([':country' => "%$country%"]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<table border='1'>";
                echo "<thead>
                        <tr>
                            <th>City Name</th>
                            <th>District</th>
                            <th>Population</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['city_name']) . "</td>
                            <td>" . htmlspecialchars($row['district']) . "</td>
                            <td>" . htmlspecialchars($row['population']) . "</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No cities found for the specified country.</p>";
            }
        } else {
            $stmt = $conn->prepare("SELECT name, continent, independence_year, head_of_state FROM countries WHERE name LIKE :country");
            $stmt->execute([':country' => "%$country%"]);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if ($results) {
                echo "<table border='1'>";
                echo "<thead>
                        <tr>
                            <th>Country Name</th>
                            <th>Continent</th>
                            <th>Independence Year</th>
                            <th>Head of State</th>
                        </tr>
                      </thead>";
                echo "<tbody>";
                foreach ($results as $row) {
                    echo "<tr>
                            <td>" . htmlspecialchars($row['name']) . "</td>
                            <td>" . htmlspecialchars($row['continent']) . "</td>
                            <td>" . htmlspecialchars($row['independence_year'] ?: 'N/A') . "</td>
                            <td>" . htmlspecialchars($row['head_of_state'] ?: 'N/A') . "</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "<p>No countries found.</p>";
            }
        }
    } else {
        echo "<p>Please specify a country name.</p>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
    die();
}
?>
