<?php
namespace App\RestaurantScheduler;
//session_start();
//This class helps users log in
// done commenting out
class log {
    
    //Methods
    function user_login($user, $pass) {

       //Connect to db
        $conn = new \mysqli("localhost", "root", "", "SE");

        //SELECT EXISTS (SELECT * FROM Accounts WHERE username = 'username');
        $sql = "SELECT EXISTS (SELECT username FROM Accounts WHERE username = '$user');";
        $result = $conn->query($sql);
        $u = $result->fetch_array()[0] ?? '';

        //Redirect user if username not in db
        if ($u != 1) {
        //    header('Location: logError.html');
            return false;
        }

        //SELECT encryptedpassword FROM Accounts WHERE username = 'username';
        $sql = "SELECT encryptedpassword FROM Accounts WHERE username = '$user';";
        $result = $conn->query($sql);
        $encryption = $result->fetch_array()[0] ?? '';

        //Decrypt password, we got help with this part from https://www.geeksforgeeks.org/how-to-encrypt-and-decrypt-a-php-string/
        $ciphering = "AES-128-CTR";
        $decryption_iv = '1234567891011121';
        $decryption_key = "GeeksforGeeks";
        $options = 0;
        $decryption=openssl_decrypt ($encryption, $ciphering, $decryption_key, $options, $decryption_iv);

        if ($pass != $decryption) {
           // header('Location: logError.html');
            //exit();
			return false;
        }

        //If username and password are correct, go to info.html
        //header('Location: info.html');
       // exit();
	   return true;
        
    }
}



?>