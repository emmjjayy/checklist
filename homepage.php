<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checklist</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        
        .table-container {
            margin-top: 80px; 
        }

        table {
            border-collapse: collapse;
            border: 1px solid #E7AD99;
            margin: 0 auto; /* center the table*/
            width: 100%;
            max-width: 800px; 
            font-size: 14px; 
        }

        th {
            background-color: #E7AD99; /* bg-color for header */
            border: 1px solid #dee2e6;
            padding: 12px;
            text-align: left;
            color: white; 
        }

        td {
            border: 1px solid #E7AD99;
            padding: 12px;
            text-align: left;
        }

        .highlight {
            background-color: #E7AD99; 
        }

        .pagination {
            text-align: center;
            margin-top: 20px;
        }

        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            color: black;
            text-decoration: none;
        }

        .pagination a.active {
            background-color: #E7AD99;
            color: white;
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const searchInput = document.querySelector('.search-input');
            searchInput.addEventListener('keypress', function (e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchInput.form.submit();
                }
            });

            // highlight the search term 
            const searchQuery = '<?php echo isset($_GET["search"]) ? htmlspecialchars($_GET["search"]) : ""; ?>';
            if (searchQuery) {
                const table = document.querySelector('table');
                const regex = new RegExp(`(${searchQuery})`, 'gi');
                table.querySelectorAll('td').forEach(td => {
                    td.innerHTML = td.innerHTML.replace(regex, '<span class="highlight">$1</span>');
                });
            }
        });
    </script>
</head>
<body>
    <nav>
        <div class="nav-container">
            <div class="title">Student Checklists</div>
            <div class="search">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET">
                    <span class="material-symbols-outlined">search</span>
                    <input class="search-input" type="search" name="search" placeholder="Search" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                </form>
            </div>
            <ul class="button">
                <li><a href="custom query.php">Custom Query</a></li>
            </ul>
        </div>
    </nav>

    <div class="container table-container">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['search'])) {
            // establish connection
            $servername = "localhost"; 
            $username = "root"; 
            $password = ""; 
            $database = "checklists"; 

            // create connection
            $conn = new mysqli($servername, $username, $password, $database);

            // check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $search = $_GET["search"];

            // sql query
            $sql = "SELECT * FROM 1styearfirstsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%' 
                    UNION ALL 
                    SELECT * FROM 1styearsecondsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%' 
                    UNION ALL 
                    SELECT * FROM 2ndyearfirstsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%' 
                    UNION ALL 
                    SELECT * FROM 2ndyearsecondsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%' 
                    UNION ALL 
                    SELECT * FROM 3rdyearfirstsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%' 
                    UNION ALL 
                    SELECT * FROM 3rdyearsecondsem 
                    WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'";

            // pagination 
            $resultsPerPage = 10;
            if (!isset($_GET['page'])) {
                $currentPage = 1;
            } else {
                $currentPage = $_GET['page'];
            }
            $offset = ($currentPage - 1) * $resultsPerPage;

            $sql .= " LIMIT $resultsPerPage OFFSET $offset";

            $result = $conn->query($sql);

            // number of rows
            $totalPagesSql = "SELECT COUNT(*) as count FROM (
                                SELECT student_id FROM 1styearfirstsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                                UNION ALL
                                SELECT student_id FROM 1styearsecondsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                                UNION ALL
                                SELECT student_id FROM 2ndyearfirstsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                                UNION ALL
                                SELECT student_id FROM 2ndyearsecondsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                                UNION ALL
                                SELECT student_id FROM 3rdyearfirstsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                                UNION ALL
                                SELECT student_id FROM 3rdyearsecondsem WHERE student_id LIKE '%$search%' OR course_code LIKE '%$search%' OR course_title LIKE '%$search%' OR grades LIKE '%$search%' OR instructor LIKE '%$search%'
                             ) as total";
            $totalResult = $conn->query($totalPagesSql);
            $totalRows = $totalResult->fetch_assoc()['count'];
            $totalPages = ceil($totalRows / $resultsPerPage);

            if ($result->num_rows > 0) {
                
                echo "<table>";
                echo "<tr><th>Student ID</th><th>Course Code</th><th>Course Title</th><th>Grades</th><th>Instructor</th></tr>";
                
                while ($row = $result->fetch_assoc()) {
                    
                    if (isset($row['student_id'])) {
                        echo "<tr><td>" . htmlspecialchars($row["student_id"]) . "</td><td>" . htmlspecialchars($row["course_code"]) . "</td><td>" . htmlspecialchars($row["course_title"]) . "</td><td>" . htmlspecialchars($row["grades"]) . "</td><td>" . htmlspecialchars($row["instructor"]) . "</td></tr>";
                    }
                }
                echo "</table>";
                
                
                echo "<div class='pagination'>";
                if ($currentPage > 1) {
                    echo "<a href='?search=$search&page=" . ($currentPage - 1) . "'><span class='material-symbols-outlined'>chevron_left</span></a>";
                }
                for ($i = 1; $i <= $totalPages; $i++) {
                    echo "<a href='?search=$search&page=$i'" . ($i == $currentPage ? " class='active'" : "") . ">$i</a>";
                }
                if ($currentPage < $totalPages) {
                    echo "<a href='?search=$search&page=" . ($currentPage + 1) . "'><span class='material-symbols-outlined'>chevron_right</span></a>";
                }
                echo "</div>"; 
            } else {
                echo "No results found.";
            }

            // close connection
            $conn->close();
        }
        ?>
    </div>
</body>
</html>