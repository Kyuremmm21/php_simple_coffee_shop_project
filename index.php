<!DOCTYPE html>
<html>
<head>
    <title>Coffee Shop CRUD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>
<body>
    <h1>Coffee Menu</h1>
    <div class="search-container">
        <input type="text" id="search-input" placeholder="Search coffees...">
        <button id="search-button"><i class="fas fa-search"></i></button>
        <a href="create.php" class="add-button"><i class="fas fa-plus"></i></a> 
    </div> 
    <table id="coffee-table">
        <thead>
            <tr>
                <th>Price</th>
                <th>Image</th>
                <th>Name</th>
                <th>Description</th>
                <th>Category</th>
                <th>Size</th>
                <th>Availability</th>
                <th>Manage</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'db_config.php';

            $sql = "SELECT * FROM coffees";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>₱" . $row['price'] . "</td>";
                    echo "<td><img src='" . $row['image'] . "' width='50' height='50'></td>";
                    echo "<td>" . $row['name'] . "</td>";
                    echo "<td>" . $row['description'] . "</td>";
                    echo "<td>" . $row['category'] . "</td>";
                    echo "<td>" . $row['size'] . "</td>";
                    echo "<td>" . ($row['availability'] ? 'Available' : 'Unavailable') . "</td>";
                    echo "<td>
                            <div class='action-buttons'>
                                <a href='read.php?id=" . $row['id'] . "' class='read-button'><i class='fas fa-eye'></i></a>
                                <a href='edit.php?id=" . $row['id'] . "' class='edit-button'><i class='fas fa-edit'></i></a>
                                <a href='delete.php?id=" . $row['id'] . "' class='delete-button'><i class='fas fa-trash'></i></a>
                            </div>
                        </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='8'>No coffees found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        const searchInput = document.getElementById('search-input');
        const searchButton = document.getElementById('search-button');
        const coffeeTable = document.getElementById('coffee-table');

        searchButton.addEventListener('click', () => {
            const searchTerm = searchInput.value.toLowerCase();

            const rows = coffeeTable.querySelectorAll('tbody tr');
            rows.forEach(row => {
                
                const coffeeName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();

                if (coffeeName.includes(searchTerm)) {
                    row.style.display = 'table-row';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>