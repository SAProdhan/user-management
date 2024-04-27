<?php
use App\Database;

require_once __DIR__ . '/../src/Database.php';

$pdo = Database::getConnection();

// Output File Path
$outputFilePath = 'database.sql';

try {
    // Create SQL file handle for writing
    $fileHandle = fopen($outputFilePath, 'w');

    // Dump database schema
    $tablesQuery = $pdo->query("SHOW TABLES");
    while ($row = $tablesQuery->fetch(PDO::FETCH_NUM)) {
        $tableName = $row[0];
        $createTableQuery = $pdo->query("SHOW CREATE TABLE $tableName");
        $createTableStatement = $createTableQuery->fetch(PDO::FETCH_ASSOC);
        fwrite($fileHandle, $createTableStatement["Create Table"] . ";" . PHP_EOL);
    }

    // Dump database data
    $tablesQuery->execute();
    while ($row = $tablesQuery->fetch(PDO::FETCH_NUM)) {
        $tableName = $row[0];
        $tableDataQuery = $pdo->query("SELECT * FROM $tableName");
        while ($rowData = $tableDataQuery->fetch(PDO::FETCH_ASSOC)) {
            $rowValues = array_map(function($value) use ($pdo) {
                return $pdo->quote($value);
            }, $rowData);
            $sql = "INSERT INTO $tableName VALUES (" . implode(", ", $rowValues) . ");";
            fwrite($fileHandle, $sql . PHP_EOL);
        }
    }

    // Close file handle
    fclose($fileHandle);

    echo "Database dumped successfully to $outputFilePath";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
