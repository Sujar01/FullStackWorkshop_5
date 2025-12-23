<?php
include 'header.php';

function uploadPortfolioFile($file) {
    $allowedTypes = ['application/pdf', 'image/jpeg', 'image/png'];
    $maxSize = 2 * 1024 * 1024; 
    $uploadDir = 'upload/';

    if (!isset($file['tmp_name']) || $file['error'] !== UPLOAD_ERR_OK) {
        throw new Exception("File upload failed.");
    }

    if (!in_array($file['type'], $allowedTypes)) {
        throw new Exception("Only PDF, JPG, or PNG files are allowed.");
    }

    if ($file['size'] > $maxSize) {
        throw new Exception("File size must be less than 2MB.");
    }

    $originalName = basename($file['name']);
    $newName = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $originalName);
    $targetPath = $uploadDir . $newName;

    if (!move_uploaded_file($file['tmp_name'], $targetPath)) {
        throw new Exception("Failed to save file.");
    }

    return $newName;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $uploadedFile = uploadPortfolioFile($_FILES['portfolio']);
        echo "<p style='color: green;'>File uploaded successfully as: $uploadedFile</p>";
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
}
p {
    color: #555;
}
form {
    background-color: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
    max-width: 500px;
}
label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}
input[type="file"] {
    margin-bottom: 20px;
    padding: 10px;
}
input[type="file"]::file-selector-button {
    padding: 10px 20px;
    background-color: #007bff;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
button {
    padding: 10px 20px;
    background-color: #28a745;
    color: white;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
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
}
p[style*="red"] {
    background-color: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
    padding: 15px;
    border-radius: 4px;
    margin: 20px 0;
}
</style>

<h2>Upload Portfolio File</h2>
<p>Allowed: PDF, JPG, PNG. Max size: 2MB.</p>

<form method="POST" enctype="multipart/form-data">
    <label>Select File: <input type="file" name="portfolio" required></label><br><br>
    <button type="submit">Upload</button>
</form>

<?php
include 'footer.php';
?>
