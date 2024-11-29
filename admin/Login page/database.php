<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database</title>
    <link rel="stylesheet" href="database.css">
    <style>
        /* Styling for logout and download links */
        #downloadLink, #logoutLink {
            display: inline-block;
            padding: 10px 20px;
            background-color: #36304a;
            color: white;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        #downloadLink:hover, #logoutLink:hover {
            color: black;
            background-color: #FFFFFF;
        }

        .logout {
            position: absolute;
            margin-top: 1.5rem;
        }

        /* Pagination styling */
        .pagination {
            text-align: center;
            margin: 20px 0;
        }

        .pagination a, .pagination span {
            margin: 0 5px;
            padding: 8px 16px;
            text-decoration: none;
            color: #fff;
            background-color: #36304a;
            border-radius: 5px;
            font-weight: bold;
            transition: background-color 0.3s ease;
        }

        .pagination a:hover {
            background-color: #FFFFFF;
            color: black;
        }

        .pagination .current {
            background-color: #d4af37;
            color: black;
            pointer-events: none;
        }
    </style>
</head>
<body>
<?php
session_start();
include 'config.php';
// Redirect if not logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header("Location: ../../index.html");
    exit();
}


if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Pagination variables
$records_per_page = 10;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($current_page - 1) * $records_per_page;

// Search functionality
$search_term = '';
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["search_term"])) {
    $search_term = mysqli_real_escape_string($con, $_POST["search_term"]);
    $query = "SELECT * FROM student_details 
              WHERE C_NAME LIKE ? OR STUDENT_ID LIKE ? 
              LIMIT $records_per_page OFFSET $offset";
    $stmt = mysqli_prepare($con, $query);
    $like_term = '%' . $search_term . '%';
    mysqli_stmt_bind_param($stmt, "ss", $like_term, $like_term);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Count total records for pagination
    $count_query = "SELECT COUNT(*) AS total FROM student_details 
                    WHERE C_NAME LIKE ? OR STUDENT_ID LIKE ?";
    $count_stmt = mysqli_prepare($con, $count_query);
    mysqli_stmt_bind_param($count_stmt, "ss", $like_term, $like_term);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $total_records_row = mysqli_fetch_assoc($count_result);
    $total_records = $total_records_row['total'];
} else {
    // Default query for all records
    $query = "SELECT * FROM student_details LIMIT $records_per_page OFFSET $offset";
    $result = mysqli_query($con, $query);

    // Count total records
    $count_query = "SELECT COUNT(*) AS total FROM student_details";
    $count_result = mysqli_query($con, $count_query);
    $total_records_row = mysqli_fetch_assoc($count_result);
    $total_records = $total_records_row['total'];
}

// Calculate total pages
$total_pages = ceil($total_records / $records_per_page);
?>
<div class="container">
    <span class="logout">
        <a href="logout.php" id="logoutLink">Logout</a>
    </span>
    <div class="se">
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" id="form">
            <input type="text" id="search" name="search_term" placeholder="Search :" value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit" id="search-form" class="button">
                <img class="search_button" src="asset/magnifier.png" alt="">
            </button>
        </form>
    </div>
    <div class="navbar">
        <ul class="list">
            <li><a href="index.php">Home</a></li>
            <li><a href="fee.php">Payments</a></li>
            <li><a href="database.php">Total Details</a></li>
        </ul>
    </div>
    <div id="ta">
        <table id="s">
            <?php
            if ($result && mysqli_num_rows($result) > 0) {
                echo '<div style="border-radius: 10px;">';
                echo '<table class="table">';
                echo '<tr class="head_row">';
                echo '<th>ID</th><th>STUDENT_ID</th><th>NAME</th><th>PHOTO</th>';
                echo '<th>DATE</th><th>EMAIL</th><th>DOB</th><th>PHONE-NO</th>';
                echo '<th>ADDITIONAL NUMBER</th><th>ADDRESS</th><th>FATHER NAME</th>';
                echo '<th>MOTHER NAME</th><th>GENDER</th><th>QUALIFICATION</th>';
                echo '<th>FIELD OF WORK</th><th>COURSE</th><th>FEES</th>';
                echo '<th>FEES PAID</th><th>BALANCE FEES</th>';
                echo '</tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<tr>';
                    foreach ($row as $key => $value) {
                        if ($key === 'PHOTO') {
                            echo "<td><img src='data:image;base64,{$value}' alt='Not available' height='100px' width='100px'></td>";
                        } else {
                            echo "<td>" . htmlspecialchars($value) . "</td>";
                        }
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '</div>';
            } else {
                echo "<p>No records found.</p>";
            }
            ?>
        </table>
    </div>
    <!-- Pagination Controls -->
    <div class="pagination">
        <?php if ($current_page > 1): ?>
            <a href="?page=<?php echo $current_page - 1; ?>">Previous</a>
        <?php endif; ?>
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <?php if ($page == $current_page): ?>
                <span class="current"><?php echo $page; ?></span>
            <?php else: ?>
                <a href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            <?php endif; ?>
        <?php endfor; ?>
        <?php if ($current_page < $total_pages): ?>
            <a href="?page=<?php echo $current_page + 1; ?>">Next</a>
        <?php endif; ?>
    </div>
    <form method="post" action="excelsheet.php">
        <button type="submit" name="download_excel" id="downloadLink">Download Excel</button>
    </form>
</div>
</body>
</html>
