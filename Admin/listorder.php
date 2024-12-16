<!DOCTYPE html>
<html>
    <title>List Order</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
<style>
         @import url("https://fonts.googleapis.com/css2?family=Odor+Mean+Chey&family=Poppins:wght@200;300;400;700&display=swap");
    body
    {
        font-family: 'Poppins';
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }
         table ,tr,td ,th {
        font-family: 'Poppins';
        text-align: center;
        border: 2px solid black;
    }
    
     tr:nth-child(n+2):hover
    {
        background-color: whitesmoke;
    }
    p
    {
        text-align: end;
    }
    .fa-plus
    {
        padding: 5px;
    }
    #container {
    width: 100%;
    padding: 10px 20px;
    max-width: 1200px;
    margin: 0 auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

td, th {
    border: 1px solid #ddd;
    padding: 12px;
    text-align: left;
}

thead {
    background-color: black;
    color: white;
}

.content {
    min-height: 100px;
}

/* Gallery Responsive Design */
.gallery-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 15px;
}

div.gallery {
    width: calc(33.333% - 15px);
    max-width: 250px;
    margin: 5px;
    border: 1px solid #ccc;
    text-align: center;
    transition: all 0.3s ease;
}

div.gallery:hover {
    border-color: #777;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

div.gallery img {
    max-width: 100%;
    height: 250px;
    object-fit: cover;
    margin: 10px 0;
}

div.desc {
    padding: 15px;
    text-align: center;
}

/* Button Styles */
.button {
    display: inline-block;
    padding: 10px 15px;
    color: white;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    border: none;
    border-radius: 5px;
    transition: all 0.2s ease-in-out;
    background-color: #4CAF50;
}

.button:hover {
    transform: scale(1.1);
    opacity: 0.9;
}

.button2 { background-color: blue; }
.button3 { background-color: red; }
.button4 { 
    background-color: #e7e7e7;
    color: black; 
}
.button5 { background-color: #555555; }

#cart {
    text-align: right;
    margin-bottom: 15px;
}

#cart a {
    font-weight: bold;
    color: blue;
    text-decoration: none;
}

.btn {
    display: flex;
    justify-content: center;
    gap: 20px;
    margin-top: 20px;
}

input[type='submit'] {
    padding: 10px 15px;
    outline: none;
    border: none;
    background-color: #4CAF50;
    color: white;
    font-family: 'Poppins', sans-serif;
    border-radius: 5px;
    cursor: pointer;
    transition: all 0.2s ease;
}

input[type='submit']:hover {
    opacity: 0.9;
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    #container {
        padding: 10px;
    }

    table {
        font-size: 0.9rem;
    }

    td, th {
        padding: 8px;
    }

    div.gallery {
        width: calc(50% - 15px);
    }

    div.gallery img {
        height: 200px;
    }

    .btn {
        flex-direction: column;
        gap: 10px;
    }
}

@media screen and (max-width: 480px) {
    #container {
        padding: 5px;
    }

    table {
        font-size: 0.8rem;
    }

    td, th {
        padding: 6px;
    }

    div.gallery {
        width: 100%;
        max-width: none;
    }

    div.gallery img {
        height: 250px;
    }

    .btn {
        flex-direction: column;
        gap: 10px;
    }

    input[type='submit'] {
        width: 100%;
        background-color: green;
    }
}
    </style>

<head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="../Style/admin.css">
</head>

<body>
    <?php require ("menu.php") ?>
    <div id="container">
        <?php
        $date1 = isset($_POST["date1"]) ? strtotime($_POST["date1"]) : strtotime(date("Y-m-d"));
        $date2 = isset($_POST["date2"]) ? strtotime($_POST["date2"]) : strtotime(date("Y-m-d"));
        ?>
        <form method="post">
            <h1 style="text-align:center;  text-decoration: underline; font-weight: bold;">List Order Info</h1> <br />
            From : <input type="date" name="date1" value="<?php echo (date("Y-m-d", $date1)) ?>">
            To : <input type="date" name="date2" value="<?php echo (date("Y-m-d", $date2)) ?>">
            <input type="submit" value="Search" name="btnsearch">
        </form>
        <table>
            <tr>
                <th>Orderid</th>
                <th>Orderdate</th>
                <th>Customer</th>
                <th>Phone Number</th>
                <th>Location</th>
                <th>Options</th>
            </tr>
            <?php
            require ("../DB/db.php");
            $sql = "SELECT * FROM tblorder ";

            //Search 
            if (isset($_POST["btnsearch"])) {
                $sql .= " where orderdate between '" . date("Y-m-d", $date1) . "' and '" . date("Y-m-d", $date2) . "'";
            }
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $result = $stmt->get_result();
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["orderid"] . "</td>";
                // formating date 
                $formattedDate = date("d-M-Y", strtotime($row["orderdate"]));
                echo "<td>" . $formattedDate . "</td>";
                echo "<td>" . $row["custname"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["location"] . "</td>";
                echo "<td>  
                        <a href='../Admin/orderdetail.php?orderid=" . $row["orderid"] . "' class='button 
button2'><i class= 'fa-solid fa-circle-info'></i></a>  
                     
                    </td>";
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</body>

</html>