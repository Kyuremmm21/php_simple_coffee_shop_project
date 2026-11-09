<?php

include 'db_config.php';


if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "DELETE FROM coffees WHERE id = '$id'";
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
    } else {
        echo "Error deleting coffee: " . mysqli_error($conn);
    }
}
?>
