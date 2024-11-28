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
       /* General Styling */
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
}

/* Header and Footer */
header, footer {
    width: 100%; /* Full width */
    padding: 1rem;
    background: #444;
    color: white;
    text-align: center;
    box-sizing: border-box; /* Include padding in width calculation */
}

main {
    max-width: 1200px; /* Center content */
    margin: 0 auto;
    padding: 1rem;
}

/* Table Styling */
table {
    width: 100%;
    border-collapse: collapse;
    margin: 1rem 0;
    background-color: #fff;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    border-radius: 8px;
}

thead {
    background-color: #333;
    color: #fff;
}

th, td {
    padding: 0.75rem;
    text-align: center;
}

tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

tbody tr:hover {
    background-color: #f1f1f1;
}

th {
    position: sticky;
    top: 0;
    z-index: 1;
}

td {
    color: #555;
}

.error {
    color: red;
    text-align: center;
}

footer a {
    color: #0056D2;
    text-decoration: underline;
}

footer a:hover {
    color: #cccccc;
}


    </style>
</head>
<body>
    <header>
        <h1>University of Bahrain Student Enrollment</h1>
        <p>A comprehensive view of student demographics in the IT College.</p>
    </header>
    <main>
        <?php if (!empty($records)): ?>
            <!-- Responsive Table -->
            <table>
                <thead>
                    <tr>
                        <th>Year</th>
                        <th>Semester</th>
                        <th>The Programs</th>
                        <th>Nationality</th>
                        <th>Colleges</th>
                        <th>Number of Students</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($records as $record): ?>
                        <tr>
                            <td data-label="Year"><?= htmlspecialchars($record['year'] ?? 'N/A') ?></td>
                            <td data-label="Semester"><?= htmlspecialchars($record['semester'] ?? 'N/A') ?></td>
                            <td data-label="The Programs"><?= htmlspecialchars($record['the_programs'] ?? 'N/A') ?></td>
                            <td data-label="Nationality"><?= htmlspecialchars($record['nationality'] ?? 'N/A') ?></td>
                            <td data-label="Colleges"><?= htmlspecialchars($record['colleges'] ?? 'N/A') ?></td>
                            <td data-label="Number of Students"><?= htmlspecialchars($record['number_of_students'] ?? 'N/A') ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="error">No data available to display. Please try again later.</p>
        <?php endif; ?>
    </main>
    <footer>
        <p>API Data Powered by <a href="https://data.gov.bh" target="_blank">Bahrain Open Data Portal</a></p>
    </footer>
</body>
</html>