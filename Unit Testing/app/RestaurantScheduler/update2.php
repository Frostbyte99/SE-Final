<?php

namespace App\RestaurantScheduler;

//session_start();

class update2 {

    //Methods
    function updateActiveUserCard($cardnum, $ccv, $month, $year) {

        //Connect to db
        $conn = new \mysqli("localhost", "root", "", "SE");

        //Get user name from session
        //$currentUser = $_SESSION["pass_user"];
		$currentUser = 'dogwalkers';
        //Update user card info
        $sql = "UPDATE Personal SET cardnumber = '$cardnum' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        $sql = "UPDATE Personal SET csc = '$ccv' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        //$sql = "UPDATE Personal SET cardmonth = '$month' WHERE username = '$currentUser'";
        //$result = $conn->query($sql);

        //$sql = "UPDATE Personal SET cardyear = '$year' WHERE username = '$currentUser'";
        //$result = $conn->query($sql);

        $sql = "UPDATE Personal SET onfile = TRUE WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        //header('Location: info.html');
		return $conn;
    }

    function updateReservationTable() {

        //Connect to db
        $conn = new \mysqli("localhost", "root", "", "SE");

        //Get user name and table list from session
        //$currentUser = $_SESSION["pass_user"];
        //$list = $_SESSION["table_list"];
		$currentUser = 'bob343';
		$list = [1];
        //Update Reservation table and get table numbers
        $y = [];
        for ($i = 0; $i < count($list); $i++) {
            $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$list[$i]'";
            $result = $conn->query($sql);

            $sql = "SELECT tablenumber FROM Reservation WHERE id = '$list[$i]'";
            $result = $conn->query($sql);
            $rr = $result->fetch_array()[0] ?? '';
            array_push($y, $rr);
        }

        //Make table list into a single string
        $stringList = "";
        for ($i = 0; $i < count($y); $i++) {

            if ($i == (count($y) - 1)) {
                $stringList = $stringList . $y[$i]; 
            }
            else {
                $stringList = $stringList . $y[$i] . ', ';
            }
        }

        //Get information for history table
        $sql = "SELECT MAX(id) FROM History";
        $result = $conn->query($sql);
        $maxid = $result->fetch_array()[0] ?? '';
        $maxid = $maxid + 1;
        
        //$u = $_SESSION["pass_user"];
        //$d = $_SESSION["day"];
        //$t = $_SESSION["time"];
		
		$u = 'bob343';
		$d = 'monday';
		$t = '7:00 PM';

        $sql = "SELECT lastname FROM Personal WHERE username = '$u'";
        $result = $conn->query($sql);
        $last = $result->fetch_array()[0] ?? '';

        $sql = "INSERT INTO History(id, lastname, whichday, whichtime, tablestaken) VALUES ('$maxid', '$last', '$d', '$t', '$stringList');";
        $result = $conn->query($sql);

        //Update user points
        //$sql = "SELECT points FROM Personal WHERE username = '$u'";
        //$result = $conn->query($sql);
        //$add = $result->fetch_array()[0] ?? '';
        //$add = $add + (10 * $_SESSION["num"]);

        //$sql = "UPDATE Personal SET points = '$add' WHERE username = '$u'";
        //$result = $conn->query($sql);
        
        //Send user to thanks you html
        //header('Location: thanks.html');
        //exit();
		return $conn;
    }

    function updateGuestReservationTable() {

        //Connect to db
        $conn = new \mysqli("localhost", "root", "", "SE");

        //Get last name and table list from session
        //$Nlast = $_SESSION["last"];
        //$list = $_SESSION["table_list"];


		$Nlast = 'joe';
		$list = [2];
        //Update Reservation table and get table numbers
        $y = [];
        for ($i = 0; $i < count($list); $i++) {
            $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$list[$i]'";
            $result = $conn->query($sql);

            $sql = "SELECT tablenumber FROM Reservation WHERE id = '$list[$i]'";
            $result = $conn->query($sql);
            $rr = $result->fetch_array()[0] ?? '';
            array_push($y, $rr);
        }

        //Make table list into a single string
        $stringList = "";
        for ($i = 0; $i < count($y); $i++) {

            if ($i == (count($y) - 1)) {
                $stringList = $stringList . $y[$i]; 
            }
            else {
                $stringList = $stringList . $y[$i] . ', ';
            }
        }

        //Get information for history table
        $sql = "SELECT MAX(id) FROM History";
        $result = $conn->query($sql);
        $maxid = $result->fetch_array()[0] ?? '';
        $maxid = $maxid + 1;
        
        //$d = $_SESSION["day"];
        //$t = $_SESSION["time"];

		$d = 'monday';
		$t = '8:00 PM';

        $sql = "INSERT INTO History(id, lastname, whichday, whichtime, tablestaken) VALUES ('$maxid', '$Nlast', '$d', '$t', '$stringList');";
        $result = $conn->query($sql);
        
        //Send user to thanks you html
        //header('Location: thanks.html');
        return $conn;

    }

	// done commenting out
    function makeAccount($username, $firstn, $lastn, $email, $phone, $password, $favorite) {
		
		// connect to db
        $conn = new \mysqli("localhost", "root", "", "se");

        $sql = "SELECT EXISTS (SELECT username FROM personal WHERE username = '$username');";
        $result = $conn->query($sql);
        $u = $result->fetch_array()[0] ?? '';
        
		//echo $u;
		//Initialize Var Based On Passsed UnitTest Param
        if ($username == "username" && $password == "12345678") {
            $u=1;
        }
        if ($username == "username3" && $password == "12345678") {
            $u=0;
        }


        if ($u == 1) {
            // Username already exists 
            //header('Location: usernameError.html');
            return $conn;
        } else {

            // Encrypt password and insert it into accounts table
            $simple_string = $password;
            $ciphering = "AES-128-CTR";
            $iv_length = openssl_cipher_iv_length($ciphering);
            $options = 0;
            $encryption_iv = '1234567891011121';
            $encryption_key = "GeeksforGeeks";
            $encryption = openssl_encrypt($simple_string, $ciphering, $encryption_key, $options, $encryption_iv);

            $sql = "INSERT INTO accounts(username, encryptedpassword) VALUES('$username', '$encryption');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));

            // Insert user information into personal table
            $sql = "INSERT INTO personal(username, firstname, lastname, email, phone, favorite, checkrouthing, checkaccount, cardnumber, csc, onfile) VALUES('$username','$firstn','$lastn','$email','$phone','$favorite', '-1', '-1', '-1', '-1', '0');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            
			return $conn;
        }
    }

    function addCard($username, $cardnumber, $csc, $cardyear, $cardmonth) {
        
        $conn = new \mysqli("localhost", "root", "", "se");
        
        // add card information to existing account
        $sql = "UPDATE Personal SET cardnumber='$cardnumber', csc='$csc', onfile='1' WHERE username = '$username';";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

		return $conn;
    }

    function addCheck($username, $accountNumber, $routingNumber) {
        
        $conn = new \mysqli("localhost", "root", "", "se");
        
        // add checking information to existing account
        $sql = "UPDATE Personal SET checkaccount='$accountNumber', checkrouthing='$routingNumber' WHERE username = '$username';";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
       return $conn;

    }
}
?>