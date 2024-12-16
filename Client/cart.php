<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../Style/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <title>Menu Lists</title>

</head>
<?php $Product_name  = isset($_POST['Proname']) ? $_POST['Proname'] : null;
 $brandName = isset($_POST["brand"]) ? isset($_POST["brand"]) : "";
?>
<?php
$count = 0;
session_start();
if (isset($_SESSION['cart'])) {
    $cart = $_SESSION['cart'];
    $count = count($cart);
}
// <!-- btn's name store in array -->
$search = array("Razer");
$gategory = array( "All", "Monitor", "Controller", "Keyboard", "Mouse", "Headset", "Microphone", "Webcam", "Chair");
// 1st field of footer store in array -->
$footer1 = [
    "Shop", "RazerStores", "RazerCafe", "Store Locator", "Purchase Programs",
    "Bulk Order Program", "Education", "Only at Razer", "RazerStore Rewards"
];
// 2nd field of footer store in array -->
$footer2 = array('Explore', "Technology", "Chroma RGB", "Concepts", "Esports", "Collabs");
// 3rd field of footer store in array -->
$footer3 = array("Support", "Get Help", "Registeration", "RazerStore Support", "RazerCare", "Manage Razer ID", 'Support Video', 'Recycling', 'Accessibility');
 // 4 th field of footer store in array -->
$footer4 = array('Company', 'About', 'Careers', 'Newsrooms', 'zVenture', 'Contact Us') ;
// 5 th field of footer store in array -->
$footer5 = array('Follow Us','fa-facebook','fa-instagram','fa-threads','fa-x-twitter','fa-youtube','fa-tiktok','fa-discord'); 


?>
<body>

<form method="post">
    <h2 class="big-text">Gaming Accessories</h2>
    <div  class="profile"><a href="login.php"><i title="log out " class="fa-solid fa-right-from-bracket"></i></a>
        <div id="cart"><a href="listcart.php"> <?php echo ($count) ?> </a><img  src="../Images/cart.png" /></div>
    </div>

    <main class="container">

        <div class="btn-container">
                <?php foreach ($gategory as $button) : ?>
                    <button type="submit" class="btn" id="<? $button ?>" name="<?= $button ?>"> <?php echo $button ?></button>
                <?php endforeach; ?>
            </form>

        </div>
    </main>
    <div class="table-container">
        <?php
        require("../DB/db.php");

        // Check which button is pressed
        $selectedBtn = null;
        foreach ($gategory as $button) {
            if (isset($_POST[$button])) {
                $selectedBtn = $button;
                break;
            }
        }
        // SQL query based on selected button
        if ($selectedBtn === "All" || $selectedBtn === null) {
            $sql = "SELECT * FROM tblproduct";
            $stmt = $conn->prepare($sql);
        } else {
            $sql = "SELECT * FROM tblproduct WHERE productname LIKE ?";
            $Product_name = '%' . $selectedBtn . '%';
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $Product_name);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // Loop to show products
        while ($row = $result->fetch_assoc()) {
            $productId = htmlspecialchars($row["productid"]);
            $brandName = htmlspecialchars($row["brandname"]);
            $productName = htmlspecialchars($row["productname"]);
            $productPrice = htmlspecialchars($row["price"]);
            $productDescription = htmlspecialchars($row["description"]);
            $productPicture = htmlspecialchars($row["picture"]);
            echo "<div class='gallery'>" .
                "<a target='_blank' href='../Images/" . $productPicture . "'>" .
                "<img src='../Images/" . $productPicture . "'>" .
                "</a>" .
                "<div class='desc' id='desc-$productId'>".
                "<h1 id='product-name-$productId'>" . $brandName . "</h1><br>" .
                "<span id='product-name-$productId'>" . $productName . "</span><br>" .
                " <span id='product-price-$productId'> Price:" . $productPrice . "$</span>" .
                // btn click for show more detail 
                "<br><a href='addcart.php?productid=" . $productId . "&productname=" . $productName . "&price=" . $productPrice . "' class='buttonBuy'   >Add To Cart</a>" .
                "</div>" .
                "<a href='javascript:void(0)' class='buttonDetail' onclick='showDetails(\"$productName\", \"$productPrice\", \"$productDescription\", \"$productPicture\")'><i class= 'fa-solid fa-circle-info'></i></a>".
                "</div>";
        }
        $stmt->close();
        ?>
        
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
         
            <div class="container-des">
               <span class="close">&times;</span>
                <h2 id="modalProductName"></h2>
                <img id="modalProductImage" src="" alt="Product Image" style="width:50%; height:auto;">
                <p id="modalProductPrice"></p>
            </div>
            <div class="detail">
            <details id="modalProductDescription">
                <ul>
                    <li></li>
                </ul>
            </details>
            </div>
        </div>
    </div>
        
    <?php include("../footer.php") ?>
    <h3 style="background-color: #343434; color:white;text-align:center;padding-bottom:10px;">Copyright ©2024 Build Bright University 111A</h3>
    <script>

        // Get the modal
        const modal = document.getElementById("myModal");

           
        // Get the <span> element that closes the modal
        const span = document.getElementsByClassName("close")[0];
        const detail = document.getElementById("modalProductDescription")

        function changeColor()
        {
            detail.style.color = "green";
            detail.style.clearColor = "green";
            detail.style.backgroundColor = "white";
            detail.style.overflow = "hidden";
        }
        
        detail.addEventListener("click",changeColor);
        // Function to show the modal with product details
        function showDetails(name, price, description, picture) {
            document.getElementById("modalProductName").textContent = name;
            document.getElementById("modalProductPrice").textContent = "Price: " + price + "$";
            document.getElementById("modalProductDescription").textContent = description;
            document.getElementById("modalProductImage").src = "../Images/" + picture;
            modal.style.display = "block";
            modal.classList.add("fade-in");
            modal.classList.remove("fade-out");
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
    if (event.target == modal) {
        
        modal.classList.remove("fade-in");
        modal.classList.add("fade-out");
        setTimeout(function() {
            modal.style.display = "none";
        }, 400); // Match this duration to the animation duration in CSS
    }
}

    </script>
</body>
</html>
