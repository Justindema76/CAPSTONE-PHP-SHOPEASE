<?php
    session_start();
    // get the data from the form
    $first_name = filter_input(INPUT_POST, 'first_name');
    $last_name = filter_input(INPUT_POST, 'last_name');    

   

    // code to save to MySQL Database goes here
    // Validate inputs

    require_once("../../database.php");
    $queryContacts = 'SELECT * FROM customers';
    $statement1 = $db->prepare($queryContacts);
    $statement1->execute();
    $contacts = $statement1->fetchAll();
    $statement1->closeCursor();

    foreach ($customers as $customer)
    {
        if ($email_address == $customer["emailAddress"])
        {
            $_SESSION["add_error"] = "Invalid data, Duplicate Email Address. Try again.";

            $url = "../../error.php";
            header("Location: " . $url);
            die();
        }
    }

    if ($first_name == null || $last_name == null ||
        $email_address == null)
        {
            $_SESSION["add_error"] = "Invalid contact data. Check all
                fields and try again.";

            $url = "error.php";
            header("Location: " . $url);
            die();
        }
        else{
            require_once('../../database.php');

            // Add the contact to the database
            $query = 'INSERT INTO contacts
                (firstName, lastName, emailAddress)
                VALUES
                (:firstName, :lastName, :emailAddress)';

            $statement = $db->prepare($query);
            $statement->bindValue(':firstName', $first_name);
            $statement->bindValue(':lastName', $last_name);
            $statement->bindValue(':emailAddress', $email_address);
            
        

            $statement->execute();
            $statement->closeCursor();
        }

        $_SESSION["fullName"] = $first_name . " " . $last_name;
        // redirect to confirmation page

        // $url = "confirmation.php";
        header("Location: " . $url);
        die();

?>