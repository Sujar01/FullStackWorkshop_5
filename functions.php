<?php
// Format name properly
function formatName($name) {
    return ucwords(trim($name));
}

// Validate email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Convert skills string to array
function cleanSkills($skillsString) {
    $skillsArray = explode(",", $skillsString);
    return array_map("trim", $skillsArray);
}

// Save student info to students.txt
function saveStudent($name, $email, $skillsArray) {
    $line = $name . "|" . $email . "|" . implode(",", $skillsArray) . PHP_EOL;
    file_put_contents("students.txt", $line, FILE_APPEND);
}

// Upload portfolio file
function uploadPortfolioFile($file) {
    $allowedTypes = ['pdf', 'jpg', 'jpeg', 'png'];
    $maxSize = 2 * 1024 * 1024; // 2MB

    if ($file['error'] !== 0) {
        throw new Exception("Upload error");
    }

    $extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (!in_array($extension, $allowedTypes)) {
        throw new Exception("Only PDF, JPG, PNG allowed");
    }

    if ($file['size'] > $maxSize) {
        throw new Exception("File must be under 2MB");
    }

    if (!is_dir("uploads")) {
        throw new Exception("Uploads folder missing");
    }

    $newName = "portfolio_" . time() . "." . $extension;
    move_uploaded_file($file['tmp_name'], "uploads/" . $newName);

    return $newName;
}
?>
