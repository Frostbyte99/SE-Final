<?php
namespace App\RestaurantScheduler;
//session_start();
class redirect {

    // Methods

    function goto_login() {
        //header('Location: login.html');
        return("header('Location: login.html');");
    }

    function goto_registration() {
        //header('Location: registration.html');
        return("header('Location: registration.html');");
    }

    function goto_registration_card() {
       // header('Location: card.html');
        return("header('Location: card.html');");
    }

    function goto_registration_check() {
       // header('Location: check.html');
        return("header('Location: check.html');");
    }

}

?>