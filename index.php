<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel = "stylesheet" href = "style.css">
        <!-- prjDBF.php - Display information from a database
        Michael Vineyard
        vineyarm@csp.edu
        prjDBF - for assignment 2
        11/10/2021
        -->
        <title>Product Information</title>
    </head>
    <body>
        <?php 
        //connect to the database
            $db = mysqli_connect('ec2-34-224-239-147.compute-1.amazonaws.com', 'bzfjyvhtwlsdpj', '9da1c0d6c745d9b69785b60408678690ccaeac71e2322ecc346d96e902d79b0c', 'd7uufd6rh6c8kl');
            //add information for the products
            class postgresSQLCreateTable {
                private $pdo;

                public function __construct($pdo) {
                    $this->pdo = $pdo;
                }
                public function createTables() {
                    $sqlList = ["CREATE TABLE IF NOT EXISTS product (
                        product_ID INT PRIMARY KEY,
                        product_name VARCHAR(25) NOT NULL,
                        color VARCHAR(10) NOT NULL,
                        price VARCHAR(10) NOT NULL,
                        on_hand_quantity INT NOT NULL,
                        product_page TEXT NOT NULL);",
                    "CREATE TABLE IF NOT EXISTS manager (
                        manager_ID INT PRIMARY KEY,
                        product_ID INT NOT NULL,
                        department VARCHAR(15) NOT NULL,
                        managerName VARCHAR(30) NOT NULL);",
                    "CREATE TABLE IF NOT EXISTS manufacturer (
                        manufacturer_ID INT PRIMARY KEY,
                        product_ID INT NOT NULL,
                        manufacturer VARCHAR(20) NOT NULL,
                        website TEXT NOT NULL);"];
                    
                    foreach($sqlList as $sql) {
                        $this->pdo->exec($sql);
                    }
                    return $this;
                }
            }
            
            $dbP = "INSERT INTO product ( product_ID, product_name, color, price, on_hand_quantity, product_page) VALUES 
                ('1', 'Bath Towel', 'Black', '$5.75', '75', 'http://MyStore.com/bathtowel.php'),
                ('2', 'Wash Cloth', 'White', '$0.99', '225', 'http://MyStore.com/washcloth.php'),
                ('3', 'Shower Curtain', 'White', '$11.99', '73', 'http://MyStore.com/showercurtain.php'),
                ('4', 'Pantry Organizer', 'Clear', '$3.99', '52', 'http://MyStore.com/pantryorganizer.php'),
                ('5', 'Storage Jar', 'Clear', '$5.99', '18', 'http://MyStore.com/storagejar.php'),
                ('6', 'Firm Pillow', 'White', '$12.99', '24', 'http://MyStore.com/pillow.php'),
                ('7', 'Comforter', 'White', '$34.99', '12', 'http://MyStore.com/comforter.php'),
                ('8', 'Rollaway Bed', 'Black', '$249.99', '3', 'http://MyStore.com/rollaway.php')";
            //add information for the managers
            $dbMan = "INSERT INTO manager (manager_ID, product_ID, department, managerName) VALUES
                ('1', '1', 'Bath', 'Michael Howard'),
                ('2', '2', 'Bath', 'Michael Howard'),
                ('3', '3', 'Bath', 'Michael Howard'),
                ('4', '4', 'Kitchen', 'John Fritz'),
                ('5', '5', 'Kitchen', 'John Fritz'),
                ('6', '6', 'Bedroom', 'Liz Tabor'),
                ('7', '7', 'Bedroom', 'Liz Tabor'),
                ('8', '8', 'Bedroom', 'Liz Tabor')";
            //add information for the manufacturers
            $dbM = "INSERT INTO manufacturer (manufacturer_ID, product_ID, manufacturer, website) VALUES
                ('1', '1', 'Cannon', 'http://wwww.cannonhome.com/'),
                ('2', '2', 'Cannon', 'http://wwww.cannonhome.com/'),
                ('3', '3', 'InterDesign', 'http://wwww.interdesignusa.com/'),
                ('4', '4', 'InterDesign', 'http://wwww.interdesignusa.com/'),
                ('5', '5', 'InterDesign', 'http://wwww.interdesignusa.com/'),
                ('6', '6', 'Cannon', 'http://wwww.cannonhome.com/'),
                ('7', '7', 'LinenSpa', 'http://wwww.linenspa.com/'),
                ('8', '8', 'LinenSpa', 'http://wwww.linenspa.com/');";
            //execute the above database commands
            $db->query($dbMan);
            $db->query($dbP);
            $db->query($dbM);
            //query the database to gather the information
            $product = mysqli_query($db, "SELECT * FROM product");
            $manager = mysqli_query($db, "SELECT * FROM manager");
            $manufacturer = mysqli_query($db, "SELECT * FROM manufacturer");
            //convert the information so I can display it easily.  products left out intentially as it will be used for the while loop
            $managerArray = $manager->fetch_assoc();
            $manufacturerArray = $manufacturer->fetch_assoc();
            
            
        ?>
        <!-- create the drop down menu -->
        <form name = "table" method="POST" action="">
            Table: <select name="tableName" onchange="this.form.submit()">
                <optgroup>
                    <option value="" selected disabled hidden>Select</option>
                    <option value="all">All</option>
                    <option value="product">Product</option>
                    <option value="manager">Manager</option>
                    <option value="manufacturer">Manufacturer</option>
                </optgroup>
            </select>

        <?php 
        //set a default value and get the variable from the drop down menu
            $selected = "all";
            if(isset($_POST['tableName'])) {
                $selected = $_POST['tableName'];
            }
        ?>

        <?php 
        //check the variable and display the default information as well as the "all" if selected
        if($selected == "all") { 
        echo "<table>";
            echo "<tr>";
                echo "<td class = 'top'>Product Name</td>";
                echo "<td class = 'top'>Color</td>";
                echo "<td class = 'top'>Price</td>";
                echo "<td class = 'top'>On Hand Quantity</td>";
                echo "<td class = 'top'>Product page</td>";
                echo "<td class = 'top'>Department</td>";
                echo "<td class = 'top'>Department Manager</td>";
                echo "<td class = 'top'>Manufacturer</td>";
                echo "<td class = 'top'>Manufacturer Website</td>";
            echo "</tr>";
                while($productArray = $product->fetch_assoc()){
               echo "<tr>";
                echo    "<td>" .$productArray["product_name"] ."</td>";
                echo    "<td>" .$productArray["color"] ."</td>";
                echo    "<td>" .$productArray["price"] ."</td>";
                echo    "<td>" .$productArray["on_hand_quantity"] ."</td>";
                echo    "<td>" .$productArray["product_page"] ."</td>";
                echo    "<td>" .$managerArray["department"] ."</td>";
                echo    "<td>" .$managerArray["managerName"] ."</td>";
                echo    "<td>" .$manufacturerArray["manufacturer"] ."</td>";
                echo    "<td>" .$manufacturerArray["website"] ."</td>";
                echo "</tr>";
                }
                echo "</table>";
            
          } 
        //display only product information
        else if ($selected == 'product') {

            echo "<table>";
                echo "<tr>";
                    echo "<td>Product Name</td>";
                    echo "<td>Color</td>";
                    echo "<td>Price</td>";
                    echo "<td>On Hand Quantity</td>";
                    echo "<td>Product page</td>"; 
                    while($productArray = $product->fetch_assoc()){
                echo "<tr>";
                    echo    "<td>" .$productArray["product_name"] ."</td>";
                    echo    "<td>" .$productArray["color"] ."</td>";
                    echo    "<td>" .$productArray["price"] ."</td>";
                    echo    "<td>" .$productArray["on_hand_quantity"] ."</td>";
                    echo    "<td>" .$productArray["product_page"] ."</td>";
                echo "</tr>";
                    }
                echo "</table>";
              }
              //display only manager information
        else if ($selected == 'manager') { 
            echo "<table>";
            echo "<tr>";
                echo "<td>Department</td>";
                echo "<td>Department Manager</td>";
            echo "</tr>";
            
                while($managerArray2 = $manager->fetch_array()) {
                    echo "<tr>";
                        echo    "<td>" .$managerArray["department"] ."</td>";
                        echo    "<td>" .$managerArray["managerName"] ."</td>";
                    echo "</tr>";    
                }
               echo "</table>";
              }
              //display only manufacturer information
        else if ($selected = 'manufacturer') {
            echo "<table>";
                echo "<tr>";
                    echo "<td>Manufacturer</td>";
                    echo "<td>Manufacturer Website</td>";
                echo "</tr>";
                    while($manufacturerArray2 = $manufacturer->fetch_array()) {
                        echo "<tr>";
                            echo    "<td>" .$manufacturerArray["manufacturer"] ."</td>";
                            echo    "<td>" .$manufacturerArray["website"] ."</td>";
                        echo "</tr>";
                    }
            echo "</table>";        
                
     } ?>
    <!-- explain myself -->
     <p>The first thing I did with this project was read through the expectations and attempted to visualize the final product.  Once I felt like I had a general understanding of
         what was expected I began creating the database model.  I complete the 1NF version and continued to the next step and assigned primary/foreign keys.  Once that was completed
         I created the database in phpmyadmin.  After creating the database I began writing the PHP code to populate the database.  My next step was to display all of the information 
         from the database in a simple table.  After that was complete I added the dropdown menu to be able to view the different tables individually.  Once that was complete I noticed that 
         I needed a way to go back to showing all the data so I added an "all" option to display the full table again without having to close and reload the page.  I was testing every phase 
         of my code as I was writing it by using the localhost server to view each step of the table as I would write each part of it.  Once everything was completed, I went back and 
         added comments to my code now that it was complete and while everything was still fresh in my mind.
     </p>
    </body>
</html>