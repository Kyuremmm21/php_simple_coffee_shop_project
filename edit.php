<?php
include 'db_config.php';


if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM coffees WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
}

if (isset($_POST['submit'])) {
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval(mysqli_real_escape_string($conn, $_POST['price']));
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $size = mysqli_real_escape_string($conn, $_POST['size']);
    $availability = isset($_POST['availability']) ? 1 : 0;

    $image = $row['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);
        $imageFileType = strtolower(pathinfo($targetFile,PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if($check !== false) {
            echo "File is an image - " . $check["mime"] . ".";

            // Allow certain file formats
            $allowedTypes = array("jpg", "jpeg", "png", "gif");
            if (in_array($imageFileType, $allowedTypes)) {
                if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                    $image = $targetFile;
                    echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }
            } else {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }
        } else {
            echo "File is not an image.";
        }
    }

    $sql = "UPDATE coffees SET name = '$name', description = '$description', price = '$price', image = '$image', category = '$category', size = '$size', availability = '$availability' WHERE id = '$id'";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error updating coffee: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Coffee</title>
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
    <h1>Edit Coffee</h1>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>
        <label for="description">Description:</label>
        <textarea id="description" name="description" required><?php echo $row['description']; ?></textarea><br><br>
        <label for="price">Price:</label>
        <input type="number" id="price" name="price" value="<?php echo $row['price']; ?>" required><br><br>
        <label for="image">Image:</label>
        <input type="file" id="image" name="image" accept="image/*"><br>
        <?php if (!empty($row['image'])) : ?>
            <img src="<?php echo $row['image']; ?>" width="100" height="100" alt="Coffee Image">
        <?php endif; ?>
        <br><br>
        <label for="category">Category:</label>
        <select id="category" name="category" required>
            <option value="Espresso" <?php if ($row['category'] == 'Espresso') echo 'selected'; ?>>Espresso</option>
            <option value="Latte" <?php if ($row['category'] == 'Latte') echo 'selected'; ?>>Latte</option>
            <option value="Cappuccino" <?php if ($row['category'] == 'Cappuccino') echo 'selected'; ?>>Cappuccino</option>
            <option value="Iced Coffee" <?php if ($row['category'] == 'Iced Coffee') echo 'selected'; ?>>Iced Coffee</option>
            <option value="Frappuccino" <?php if ($row['category'] == 'Frappuccino') echo 'selected'; ?>>Frappuccino</option>
        </select><br><br>
        <label for="size">Size:</label>
        <select id="size" name="size" required>
            <option value="Small" <?php if ($row['size'] == 'Small') echo 'selected'; ?>>Small</option>
            <option value="Medium" <?php if ($row['size'] == 'Medium') echo 'selected'; ?>>Medium</option>
            <option value="Large" <?php if ($row['size'] == 'Large') echo 'selected'; ?>>Large</option>
        </select><br><br>
        <label for="availability">Availability:</label>
        <input type="checkbox" id="availability" name="availability" <?php if ($row['availability']) echo 'checked'; ?>><br><br>
        <button type="submit" name="submit"><i class="fas fa-save"></i> Update</button>
    </form>
</body>
</html>
