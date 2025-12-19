<?php
include 'header.php';
?>

<style>
body {
    font-family: Arial, sans-serif;
    margin: 40px;
    background-color: #f4f4f4;
}
h2 {
    color: #333;
    text-align: center;
}
ul {
    list-style: none;
    padding: 0;
    max-width: 800px;
    margin: 0 auto;
}
li {
    background-color: white;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}
li strong {
    color: #007bff;
}
p {
    text-align: center;
    font-size: 18px;
    color: #555;
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-width: 800px;
    margin: 30px auto;
}
</style>

<h2>View Students</h2>

<?php
if (file_exists('students.txt')) {
    $lines = file('students.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    if (!empty($lines)) {
        echo "<ul>";
        foreach ($lines as $line) {
            $parts = explode(',', $line);
            if (count($parts) >= 3) {
                $name = trim($parts[0]);
                $email = trim($parts[1]);
                $skills = array_map('trim', array_slice($parts, 2));
                echo "<li>";
                echo "<strong>Name:</strong> $name<br><br>";
                echo "<strong>Email:</strong> $email<br><br>";
                echo "<strong>Skills:</strong> " . implode(', ', $skills);
                echo "</li>";
            }
        }
        echo "</ul>";
    } else {
        echo "<p>No students added yet.</p>";
    }
} else {
    echo "<p>No students file found.</p>";
}
?>

<?php
include 'footer.php';
?>