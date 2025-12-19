<?php
include 'header.php';

function formatName($name) {
    return ucwords(strtolower(trim($name)));
}
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}
function cleanSkills($string) {
    $skills = explode(',', $string);
    $cleaned = [];
    foreach ($skills as $skill) {
        $cleaned[] = trim($skill);
    }
    return $cleaned;
}
function saveStudent($name, $email, $skillsArray) {
    $line = $name . ',' . $email . ',' . implode(',', $skillsArray) . "\n";
    file_put_contents('students.txt', $line, FILE_APPEND);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $skillsString = $_POST['skills'] ?? '';
        if (empty($name) || empty($email) || empty($skillsString)) {
            throw new Exception("All fields are required.");
        }
        $formattedName = formatName($name);
        if (!validateEmail($email)) {
            throw new Exception("Invalid email address.");
        }
        $skillsArray = cleanSkills($skillsString);
        if (empty($skillsArray)) {
            throw new Exception("At least one skill is required.");
        }
        saveStudent($formattedName, $email, $skillsArray);
        echo "<p style='color: green;'>Student added successfully!</p>";
    } catch (Exception $e) {
        echo "<p style='color: red;'>Error: " . $e->getMessage() . "</p>";
    }
}
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
form {
    background-color: white;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-width: 600px;
    margin: 0 auto;
}
label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}
input[type="text"],
input[type="email"] {
    width: 100%;
    padding: 12px;
    margin-top: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    font-size: 16px;
}
input::placeholder {
    color: #999;
}
button {
    padding: 12px 30px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}
button:hover {
    background-color: #218838;
}
p[style*="green"] {
    background-color: #d4edda;
    color: #155724;
    border: 1px solid #c3e6cb;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
    text-align: center;
}
p[style*="red"] {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
    text-align: center;
}
</style>

<h2>Add Student Info</h2>

<form method="POST">
    <label>Name:<br>
        <input type="text" name="name" placeholder="Enter full name" required>
    </label><br><br>
    
    <label>Email:<br>
        <input type="email" name="email" placeholder="example@domain.com" required>
    </label><br><br>
    
    <label>Skills (comma-separated):<br>
        <input type="text" name="skills" placeholder="e.g., PHP, HTML, CSS, JavaScript" required>
    </label><br><br>
    
    <button type="submit">Add Student</button>
</form>

<?php
include 'footer.php';
?>