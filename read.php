<?php
include 'db_config.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM coffees WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $coffee = mysqli_fetch_assoc($result);
        } else {
            echo "Coffee not found.";
            exit;
        }
        
       
        mysqli_stmt_free_result($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Failed to prepare the statement.";
        exit;
    }
} else {
    echo "Invalid request.";
    exit;
}


mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coffee Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5dc;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 600px;
            width: 100%;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .coffee-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .coffee-image {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .coffee-info p {
            font-size: 16px;
            color: #555;
            margin: 8px 0;
        }

        .back-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #d4a373;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #b5835a;
        }

        .back-button i {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><?php echo htmlspecialchars($coffee['name']); ?> Details</h1>

        <div class="coffee-details">
            <img src="<?php echo htmlspecialchars($coffee['image']); ?>" alt="Coffee Image" class="coffee-image">
            <div class="coffee-info">
                <p><strong>Price:</strong> ₱<?php echo htmlspecialchars($coffee['price']); ?></p>
                <p><strong>Description:</strong> <?php echo htmlspecialchars($coffee['description']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($coffee['category']); ?></p>
                <p><strong>Size:</strong> <?php echo htmlspecialchars($coffee['size']); ?></p>
                <p><strong>Availability:</strong> <?php echo $coffee['availability'] ? 'Available' : 'Unavailable'; ?></p>
            </div>
            <a href="index.php" class="back-button"><i class="fas fa-arrow-left"></i> Back to Menu</a>
        </div>
    </div>
</body>
</html>