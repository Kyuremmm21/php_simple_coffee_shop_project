<?php
include 'db_config.php';


if (isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval(mysqli_real_escape_string($conn, $_POST['price']));
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $availability = isset($_POST['availability']) ? 1 : 0;

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES['image']['name']);

        if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
            $image = $targetFile;
        } else {
            echo "Error uploading image.";
        }
    } else {
        $image = '';
    }

    $sql = "INSERT INTO coffees (name, description, price, image, category, size, availability) 
            VALUES ('$name', '$description', '$price', '$image', '$category', '$size', '$availability')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php"); // Redirect to the list
    } else {
        echo "Error adding coffee: " . mysqli_error($conn);
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Coffee</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #fff7e6;
        }

        h1 {
            font-family: 'Brush Script MT', cursive;
            color: #800000;
            text-align: center;
        }

        form {
            background-color: #f6efd9;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 20px auto;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        textarea {
            height: 100px;
        }

        input[type="file"] {
            margin-bottom: 15px;
        }

        button[type="submit"] {
            background-color: #fff;
            color: #333;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        button[type="submit"]:hover {
            background-color: #f0f0f0;
        }

        button[type="submit"] i {
            font-size: 1.2em;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <h1>Add New Coffee</h1>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required><br><br>

        <label for="description">Description:</label>
        <textarea id="description" name="description"></textarea><br><br>

        <label for="price">Price:</label>
        <input type="number" id="price" name="price" step="0.01" required><br><br>

        <label for="image">Image:</label>
        <input type="file" id="image" name="image"><br><br>

        <label for="category">Category:</label>
        <select id="category" name="category">
            <option value="Espresso">Espresso</option>
            <option value="Latte">Latte</option>
            <option value="Iced">Iced</option>
        </select><br><br>

        <label for="size">Size:</label>
        <select id="size" name="size">
            <option value="Small">Small</option>
            <option value="Medium">Medium</option>
            <option value="Large">Large</option>
        </select><br><br>

        <label for="availability">Availability:</label>
        <input type="checkbox" id="availability" name="availability" value="1"><br><br>

        <button type="submit" name="submit"><i class="fas fa-save"></i> Save</button>
    </form>
</body>
</html>
