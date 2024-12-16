<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>listcart</title> 
    <!-- <link rel="stylesheet" href="../Style/style.css">  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
  <style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    background-color: #f4f4f4;
}

#container {
    width: 95%;
    max-width: 1200px;
    margin: 20px auto;
    padding: 20px;
    background-color: white;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

h1 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 1.3rem;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 15px;
}

.button {
    text-decoration: none;
    padding: 8px 15px;
    border-radius: 5px;
    transition: all 0.3s ease;
}

.button5 {
    background-color: #4CAF50;
    color: white;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: center;
}

table th {
    background-color: #f2f2f2;
    font-weight: bold;
}

.button2, .button3 {
    display: inline-block;
    padding: 5px 10px;
    margin: 0 5px;
    background-color: #007bff;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}

form {
    display: flex;
    flex-direction: column;
    gap: 15px;
    max-width: 500px;
    margin: 0 auto;
}

form label {
    font-weight: bold;
}

form input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
}

form input[type="submit"] {
    background-color: green;
    color: white;
    border: none;
    cursor: pointer;
    transition: all 0.3s ease;
}

form input[type="submit"]:hover {
    opacity: 0.9;
}

/* Responsive Adjustments */
@media screen and (max-width: 768px) {
    #container {
        width: 98%;
        padding: 10px;
    }

    h1 {
        flex-direction: column;
        gap: 10px;
    }

    table {
        font-size: 0.9rem;
    }

    table td, table th {
        padding: 8px;
    }

    .button5 {
        margin-top: 10px;
    }
}

@media screen and (max-width: 480px) {
    table {
        font-size: 0.8rem;
    }

    table td, table th {
        padding: 5px;
    }

    form {
        width: 100%;
        padding: 0 10px;
    }

    form input {
        padding: 8px;
    }
}

/* Icons */
.fa-trash {
    color: red;
}

.fa-solid {
    margin-right: 5px;
}
  </style>
</head> 
<body> 
<div id="container"> 
    <h1>List order in Your cart  <a href="../Client/Cart.php" class="button button5">Buy More ?</a></h1> 
    <table border="1"> 
        <tr> 
            <th>Option</th> 
            <th>product id</th> 
            <th>product name</th> 
            <th>price</th> 
            <th>qty</th> 
            <th>amount</th> 
        </tr> 
    <?php 
        session_start(); 
        $total =  0; 
        if(isset($_SESSION['cart'])){ 
          // echo("<p class=''>Item have been exist</p>"); 
            $cart = $_SESSION['cart']; 
            for($r=0;$r<count($cart);$r++){ 
                echo("<tr>"); 
                echo("<td><a  href='deletecart.php?index=" . $r . "' class='button button3' onclick='return 
confirm(\"Sure?\");'><i class='fa-solid fa-trash'></i></a></td>"); 

                echo "<td>" .$cart[$r][0]. "</td>"; 
                echo "<td>" . $cart[$r][1] . "</td>"; 
                echo "<td>" . $cart[$r][2] . "</td>"; 
                echo "<td><a href='editcart.php?index=" . $r . "&oper=sub' class='button button3'>-</a>" . 
                     "<span>".$cart[$r][3]."</span>" .  
                     "<a href='editcart.php?index=" . $r . "&oper=sum' class='button button2'>+</a></td>"; 
                echo "<td>$ " . ($cart[$r][2] * $cart[$r][3]) . "</td>"; 
                echo("</tr>"); 
                $total += $cart[$r][2] * $cart[$r][3]; 
            } 
        }else{ 
            echo("<p>No Item</p>"); 
        }    
        echo("<tr><td colspan='5'>Total Amount : </td><td>$ $total</td></tr>"); 
    ?> 
    </table> 
  <h1>Customer Info</h1> 
  <form method="post" enctype="multipart/form-data"> 
    <label for="custname">Customer Name :</label> 
    <input type="text" id="custname" name="custname" >  
    <label for="phone">Phone :</label> 
    <input type="text" id="phone" name="phone"> 
    <label for="location">Location :</label>
    <input type="text" name="location" id="location"> 
    <input type="submit" name="btnsubmit" value="Order now" class="button" style="background-color:green;"> 
  </form>
  <?php   
  if(isset($_POST['btnsubmit']))
  { 
    require "../DB/db.php"; 
    $custname = $_POST["custname"]; 
    $phone = $_POST["phone"]; 
    $location = $_POST["location"];
    if(empty($custname) || empty($phone) || empty($location))
    {
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo '<script>
              Swal.fire({
                  icon: "error",
                  title: "Invalid",
                  text: "Please input your information before click pay now, Thank you.",
                  confirmButtonText: "OK" 
                  
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "listcart.php";
                  }
              });
            </script>';
    }
    else
    {
      date_default_timezone_set("Asia/Phnom_Penh"); 
    $orderdate = date("Y-m-d");
    $sql = "INSERT INTO tblorder(orderdate,custname,phone ,location) VALUES(?,?,?,?);"; 
    $stmt = $conn->prepare($sql); 
    $stmt->bind_param("ssss",$orderdate,$custname,$phone ,$location); 
    if($stmt->execute()==true){ 
      $orderid = $conn->insert_id; 
      for($r=0;$r<count($cart);$r++){ 
        $productid = $cart[$r][0]; 
        $price = $cart[$r][2]; 
        $qty = $cart[$r][3];
        $conn->query("INSERT into tblorderproduct(orderid,productid,price,qty) values($orderid,$productid,$price,$qty)"); 
      } 
      unset($_SESSION['cart']); 
      echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
      echo '<script>
              Swal.fire({
                  icon: "success",
                  title: "Successful",
                  text: "Paying Successful",
                  confirmButtonText: "OK"
              }).then((result) => {
                  if (result.isConfirmed) {
                      window.location.href = "cart.php";
                  }
              });
            </script>';
    }else{ 
      echo "Error: " . $sql . "<br>" . $conn->error; 
    } 
    }
  } 
?> 
</div> 
</body> 
</html> 
