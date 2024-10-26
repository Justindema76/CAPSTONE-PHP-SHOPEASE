<!DOCTYPE html>
<html>
   <head>
       <title>Contact Manager - Add Contact</title>
       <link rel="stylesheet" type="text/css" href="css/main.css" />       
   </head>
   <body>
       <?php include("../../view/header.php"); ?>
       <main>
        <h2>Add Contact</h2>

        <form action="add_customer.php" method="post" id="add_customer_form">
        <div id="data">
            <label>First Name:</label>
            <input type="text" name="first_name" /><br />

            <label>Last Name:</label>
            <input type="text" name="last_name" /><br />

            <label>Email Address:</label>
            <input type="text" name="email_address" /><br />

         
        </div>

        <div id="buttons">
            <label>&nbsp;</label>
            <input type="submit" value="Save Customer" /><br />
        </div>

        </form>
        
        <p><a href="../customers/customers.php">View Customer List</a></p>
       </main>
       <?php include("../../view/footer.php"); ?>
   </body>
</html>