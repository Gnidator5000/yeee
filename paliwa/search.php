<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stacje";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$station = isset($_GET['station']) ? $_GET['station'] : '';
$city = isset($_GET['city']) ? $_GET['city'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : 1.00;
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : 9.99;

$sql = "SELECT * FROM stacje WHERE 1=1";

if (!empty($station)) {
    $sql .= " AND nazwa_stacji LIKE '%" . $conn->real_escape_string($station) . "%'";
}

if (!empty($city)) {
    $sql .= " AND miasto = '" . $conn->real_escape_string($city) . "'";
}

$sql .= " AND cena >= " . $conn->real_escape_string($min_price);
$sql .= " AND cena <= " . $conn->real_escape_string($max_price);

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Nazwa Stacji</th>
                <th>Miasto</th>
                <th>Cena za litr</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["nazwa_stacji"] . "</td>
                <td>" . $row["miasto"] . "</td>
                <td>" . $row["cena"] . " zł</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "Brak wyników";
}

$conn->close();
?>
