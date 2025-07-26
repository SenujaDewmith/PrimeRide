<?php include '../assets/php/dbconnection.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prime Ride | Staff Dashboard | Feedbacks</title>
    <link rel="stylesheet" href="css/staff.css">
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .content-wrapper {
            margin-left: 220px; 
            padding: 40px 20px;
        }

        .Feedbacks h2 {
            margin-top: 50px;
            margin-bottom: 30px;
        }

        .table th, .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <!-- DB Connection -->
    <?php include '../assets/php/dbconnection.php'; ?>
    <!-- Header -->
     <?php include 'components/staff_header.php'; ?>
    <!-- Sidebar -->
    <?php include 'components/staff_sidebar.php'; ?>

    

<div class="content-wrapper Feedbacks">
    <h2 class="text-center">- Feedbacks -</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Feedback ID</th>
                <th>Title</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No</th>
                <th>Message</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT id, title, name, email, phone, message, submitted_at 
            FROM messages";

            $result = $conn->query($sql);

            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['title']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['phone']}</td>
                            <td>{$row['message']}</td>
                            <td>{$row['submitted_at']}</td>
                        </tr>";
                }
            }else{
                echo "<tr><td colspan = '10' class = 'text-center'>No Feedbacks Found</td></tr>";
            }
            $conn->close();
            ?>
        </tbody>
    </table>
</div>    
    
<script defer src="../assets/js/bootstrap.bundle.min.js"></script>   

</body>
</html>