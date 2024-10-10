<?php
include "controller.php";
// Start the session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(isset($_POST['method']) && ($_POST['method'] == "setSession"))
    {
        if (isset($_POST['setSession'])) {
            foreach($_POST['setSession'] as $key => $value)
                $_SESSION[$key] = $value;
            echo "Session value set successfully";
        } else {
            echo "No session value provided";
        }
    }elseif(isset($_POST['method']) && ($_POST['method'] == "unsetSession")){

        if (isset($_POST['method'])) {
                session_unset();
            echo "Session value set successfully";
        } else {
            echo "No session value provided";
        }

    }
} else {
    echo "Invalid request method";
}
?>
