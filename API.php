<?php
// Step 1: API Endpoint URL
$apiUrl = "https://data.gov.bh/api/explore/v2.1/catalog/datasets/01-statistics-of-students-nationalities_updated/records?where=colleges%20like%20%22IT%22%20AND%20the_programs%20like%20%22bachelor%22&limit=100";

try {
    // Step 2: Fetch data from API
    $response = file_get_contents($apiUrl);
    
    // Check if response is not false
    if ($response === false) {
        throw new Exception("Failed to fetch data from API.");
    }

    // Step 3: Decode JSON response
    $data = json_decode($response, true);

    // Step 4: Extract records from the response
    if (isset($data['results'])) {
        $records = $data['results'];
    } else {
        echo "<pre>";
        echo "Raw API Response:\n";
        print_r($data); // Output the raw response for debugging
        echo "</pre>";
        die("Invalid response structure.");
    }
} catch (Exception $e) {
    // Handle exceptions and display error message
    die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UOB Student Nationalities</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f3f4f6;
            margin: 0;
            padding: 0;
            color: #333;
        }
        header {
            background: #2c3e50;
            color: white;
            padding: 1.5rem 1rem;
            text-align: center;
        }
        header h1 {
            margin: 0;
            font-size: 2rem;
        }
        header p {
            margin: 0.5rem 0 0;
            font-size: 1rem;
        }
        main {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 1rem;
        }
        .error {
            color: red;
            text-align: center;
            font-size: 1.2rem;
        }
        .table-wrapper {
            overflow-x: auto;
            border-radius: 8px;
            background: white;
            padding: 1rem;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-spacing: 0;
            border-collapse: separate;
        }
        table thead {
            background: #34495e;
            color: white;
        }
        table th, table td {
            text-align: center;
            padding: 0.75rem;
            border-bottom: 1px solid #ddd;
        }
        table th:first-child, table td:first-child {
            border-top-left-radius: 8px;
            border-bottom-left-radius: 8px;
        }
        table th:last-child, table td:last-child {
            border-top-right-radius: 8px;
            border-bottom-right-radius: 8px;
        }
        table tbody tr:nth-child(even) {
            background: #f9f9f9;
        }
        table tbody tr:hover {
            background: #f1f1f1;
        }
        footer {
            background: #2c3e50;
            color: white;
            text-align: center;
            padding: 1rem;
        }
        footer a {
            color: #ecf0f1;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <header>
        <h1>University of Bahrain: Student Demographics</h1>
        <p>Data on IT College Students in Bachelor Programs</p>
    </header>
    <main>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php elseif (!empty($records)): ?>
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Semester</th>
                            <th>Program</th>
                            <th>Nationality</th>
                            <th>College</th>
                            <th>Students</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($records as $record): ?>
                            <tr>
                                <td><?= htmlspecialchars($record['year'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['semester'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['the_programs'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['nationality'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['colleges'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($record['number_of_students'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="error">No data available to display. Please try again later.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>Data powered by <a href="https://data.gov.bh" target="_blank">Bahrain Open Data Portal</a></p>
    </footer>
</body>
</html>