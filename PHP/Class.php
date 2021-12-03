<?php

//Start session
session_start();


//This class helps redirect users to different html pages
class redirect {

    //Methods
    function goto_login() {
        header('Location: login.html');
        exit();
    }

    function goto_registration() {
        header('Location: Registration.html');
        exit();
    }

    function goto_reservation() {
        header('Location: info.html');
        exit();
    }

    function goto_Guestreservation() {
        header('Location: Guestinfo.html');
        exit();
    }

    function goto_registration_card() {
        header('Location: card.html');
        exit();
    }

    function goto_registration_check() {
        header('Location: check.html');
        exit();
    }

    function goto_askguest() {
        header('Location: AskGuest.html');
        exit();
    }
    
}


//This class helps users log in
class log {
    
    //Methods
    function user_login($user, $pass) {

        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //SELECT EXISTS (SELECT * FROM Accounts WHERE username = 'username');
        $sql = "SELECT EXISTS (SELECT username FROM Accounts WHERE username = '$user');";
        $result = $conn->query($sql);
        $u = $result->fetch_array()[0] ?? '';

        //Redirect user if username not in db
        if ($u != 1) {
            header('Location: logError.html');
            exit();
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
            header('Location: logError.html');
            exit();
        }

        //If username and password are correct, go to info.html
        header('Location: info.html');
        exit();
        
    }
}

class tables {

    //Methods
    function get_tables($time, $day, $guestnum) {
        
        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Get user name from session
        $currentUser = $_SESSION["pass_user"];

        //Check if selected day is high traffic
        $sql = "SELECT hightraffic FROM Company WHERE daytype = '$day';";
        $result = $conn->query($sql);
        $check = $result->fetch_array()[0] ?? '';

        //If day is high traffic then check if user has a card on file
        if ($check == 1) {

            $sql = "SELECT onfile FROM Personal WHERE username = '$currentUser';";
            $result = $conn->query($sql);
            $hascard = $result->fetch_array()[0] ?? '';

            //If user does not have card on file, force them to add one
            if ($hascard == 0) {
                header('Location: forcedupdate.html');
                exit();
            }
        }

        //Lets start looking for tables, but for Algo to work we make num of ppl even
        $TotalPeolpe = $guestnum;
        if ($guestnum % 2 != 0) {
            $TotalPeolpe = $TotalPeolpe + 1;
        }
        
        //Important Var's to help find tables 
        $CurrentLeft = $TotalPeolpe; 
        $Fail = false;

        //Store all tables needed here
        $TableList = array();

        while($CurrentLeft > 0) {

            //This var tells us at end if everyone got a seat
            $Done = false;

            //Get the first group of ppl which is 8 max
            $CheckSeats = $CurrentLeft;
            if ($CurrentLeft >= 8) {
                $CheckSeats = 8; 
            }

            //Check tables of exact group size and below
            while($CheckSeats > 0) {

                //Check if tables for this time, day, and seating is not taken
                $sql = "SELECT EXISTS (SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0');";
                $result = $conn->query($sql);
                $r = $result->fetch_array()[0] ?? '';
                
                //If taken then check lower seats
                if ($r == 0) {
                    $CheckSeats = $CheckSeats - 2;
                    continue;
                }

                //If not taken, get the first avaible one
                $sql = "SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0';";
                $result = $conn->query($sql);
                $rr = $result->fetch_array()[0] ?? '';

                //Put table id into list, break out of while loop, make done = true
                array_push($TableList, $rr);
                $CurrentLeft = $CurrentLeft - $CheckSeats;
                $CheckSeats = 0;
                $Done = true;

                //Update sql for now
                $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$rr'";
                $result = $conn->query($sql);
            }

            //Check tables above
            if ($Done == false) {

                $CheckSeats = $CurrentLeft;
                if ($CurrentLeft >= 8) {
                    $CheckSeats = 8; 
                }

                while($CheckSeats != 10) {

                    //Check if tables for this time, day, and seating is not taken
                    $sql = "SELECT EXISTS (SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0');";
                    $result = $conn->query($sql);
                    $r = $result->fetch_array()[0] ?? '';
                    
                    //If taken then check upper seats
                    if ($r == 0) {
                        $CheckSeats = $CheckSeats + 2;
                        continue;
                    }

                    //If not taken, get the first avaible one
                    $sql = "SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0';";
                    $result = $conn->query($sql);
                    $rr = $result->fetch_array()[0] ?? '';

                    // Put table id into list, break out of while loop, make done = true
                    array_push($TableList, $rr);
                    $CurrentLeft = $CurrentLeft - $CheckSeats;
                    $CheckSeats = 10;
                    $Done = true;

                    // Update sql for now
                    $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$rr'";
                    $result = $conn->query($sql);

                }
            }

            //If no pssobile table then break and make fail = true
            if ($Done == false) {
                $Fail = true;
                break;
            }
            
        }

        //Since user hasnt offically finalized, lets update all tables back to not taken
        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "UPDATE Reservation SET taken = FALSE WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
        }

        //If no tables were found, then redirect user to sorry page
        if ($Fail == true) {
            header('Location: sorry.html');
            exit();
        }

        //If everything is good then lets echo an html finalize screen
        $_SESSION["table_list"] = $TableList;
        $_SESSION["day"] = $day;
        $_SESSION["time"] = $time;
        $_SESSION["num"] = $guestnum;


        echo "<link rel='stylesheet' href='styles.css'>";
        echo "<h2>We Found Available Tables!</h2>";
        echo "<h3>Click 'Finalize' To Complete Your Reservation And Return To Login Page</h3>";
        echo "<h4>Your Tables Are:</h4>";

        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "SELECT tablenumber FROM Reservation WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
            $whattable = $result->fetch_array()[0] ?? '';
            echo "Table ";
            echo (string)$whattable;
            echo "<br>";
            echo "<br>";
        }

        if ($check == 1) {
            echo "<h3>A Reservation Holding Fee Of 10$ Is Required</h3>";
            echo "<br>";
        }

        echo "<form id='Finalize' action='finalize.php' method='POST'>";
        echo "<div id='final'>";
            echo "<input type='submit' value='Finalize'>";
            echo "</div>";
        echo "</form>";

        echo "<form id='cancel' action='cancelReservation.php' method='POST'>";
        echo "<div id='cancel'>";
            echo "<input type='submit' value='Cancel'>";
            echo "</div>";
        echo "</form>";
    }

    //Methods
    function get_Guesttables($time, $day, $guestnum) {
        
        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Check if selected day is high traffic
        $sql = "SELECT hightraffic FROM Company WHERE daytype = '$day';";
        $result = $conn->query($sql);
        $check = $result->fetch_array()[0] ?? '';

        //If day is high traffic then force guest to make account
        if ($check == 1) {
            header('Location: noguest.html');
            exit();
        }

        //Lets start looking for tables, but for Algo to work we make num of ppl even
        $TotalPeolpe = $guestnum;
        if ($guestnum % 2 != 0) {
            $TotalPeolpe = $TotalPeolpe + 1;
        }
        
        //Important Var's to help find tables 
        $CurrentLeft = $TotalPeolpe; 
        $Fail = false;

        //Store all tables needed here
        $TableList = array();

        while($CurrentLeft > 0) {

            //This var tells us at end if everyone got a seat
            $Done = false;

            //Get the first group of ppl which is 8 max
            $CheckSeats = $CurrentLeft;
            if ($CurrentLeft >= 8) {
                $CheckSeats = 8; 
            }

            //Check tables of exact group size and below
            while($CheckSeats > 0) {

                //Check if tables for this time, day, and seating is not taken
                $sql = "SELECT EXISTS (SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0');";
                $result = $conn->query($sql);
                $r = $result->fetch_array()[0] ?? '';
                
                //If taken then check lower seats
                if ($r == 0) {
                    $CheckSeats = $CheckSeats - 2;
                    continue;
                }

                //If not taken, get the first avaible one
                $sql = "SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0';";
                $result = $conn->query($sql);
                $rr = $result->fetch_array()[0] ?? '';

                //Put table id into list, break out of while loop, make done = true
                array_push($TableList, $rr);
                $CurrentLeft = $CurrentLeft - $CheckSeats;
                $CheckSeats = 0;
                $Done = true;

                //Update sql for now
                $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$rr'";
                $result = $conn->query($sql);
            }

            //Check tables above
            if ($Done == false) {

                $CheckSeats = $CurrentLeft;
                if ($CurrentLeft >= 8) {
                    $CheckSeats = 8; 
                }

                while($CheckSeats != 10) {

                    //Check if tables for this time, day, and seating is not taken
                    $sql = "SELECT EXISTS (SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0');";
                    $result = $conn->query($sql);
                    $r = $result->fetch_array()[0] ?? '';
                    
                    //If taken then check upper seats
                    if ($r == 0) {
                        $CheckSeats = $CheckSeats + 2;
                        continue;
                    }

                    //If not taken, get the first avaible one
                    $sql = "SELECT id FROM Reservation WHERE selectday = '$day' AND selecttime = '$time' AND seating = '$CheckSeats' AND taken = '0';";
                    $result = $conn->query($sql);
                    $rr = $result->fetch_array()[0] ?? '';

                    // Put table id into list, break out of while loop, make done = true
                    array_push($TableList, $rr);
                    $CurrentLeft = $CurrentLeft - $CheckSeats;
                    $CheckSeats = 10;
                    $Done = true;

                    // Update sql for now
                    $sql = "UPDATE Reservation SET taken = TRUE WHERE id = '$rr'";
                    $result = $conn->query($sql);

                }
            }

            //If no pssobile table then break and make fail = true
            if ($Done == false) {
                $Fail = true;
                break;
            }
            
        }

        //Since user hasnt offically finalized, lets update all tables back to not taken
        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "UPDATE Reservation SET taken = FALSE WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
        }

        //If no tables were found, then redirect user to sorry page
        if ($Fail == true) {
            header('Location: sorryGuest.html');
            exit();
        }

        //If everything is good then lets echo an html finalize screen
        $_SESSION["table_list"] = $TableList;
        $_SESSION["day"] = $day;
        $_SESSION["time"] = $time;
        $_SESSION["num"] = $guestnum;


        echo "<link rel='stylesheet' href='styles.css'>";
        echo "<h2>We Found Available Tables!</h2>";
        echo "<h3>Click 'Finalize' To Complete Your Reservation And Return To Login Page</h3>";
        echo "<h4>Your Tables Are:</h4>";

        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "SELECT tablenumber FROM Reservation WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
            $whattable = $result->fetch_array()[0] ?? '';
            echo "Table ";
            echo (string)$whattable;
            echo "<br>";
            echo "<br>";
        }

        if ($check == 1) {
            echo "<h3>A Reservation Holding Fee Of 10$ Is Required</h3>";
            echo "<br>";
        }

        echo "<form id='Finalize' action='finalizeGuest.php' method='POST'>";
        echo "<div id='final'>";
            echo "<input type='submit' value='Finalize'>";
            echo "</div>";
        echo "</form>";

        echo "<form id='cancel' action='continue.php' method='POST'>";
        echo "<div id='cancel'>";
            echo "<input type='submit' value='Cancel'>";
            echo "</div>";
        echo "</form>";
    }
}

class update {

    //Methods
    function updateActiveUserCard($cardnum, $ccv, $month, $year) {

        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Get user name from session
        $currentUser = $_SESSION["pass_user"];

        //Update user card info
        $sql = "UPDATE Personal SET cardnumber = '$cardnum' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        $sql = "UPDATE Personal SET csc = '$ccv' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        $sql = "UPDATE Personal SET cardmonth = '$month' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        $sql = "UPDATE Personal SET cardyear = '$year' WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        $sql = "UPDATE Personal SET onfile = TRUE WHERE username = '$currentUser'";
        $result = $conn->query($sql);

        header('Location: info.html');
        exit();
    }

    function updateReservationTable() {

        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Get user name and table list from session
        $currentUser = $_SESSION["pass_user"];
        $list = $_SESSION["table_list"];

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
        
        $u = $_SESSION["pass_user"];
        $d = $_SESSION["day"];
        $t = $_SESSION["time"];

        $sql = "SELECT lastname FROM Personal WHERE username = '$u'";
        $result = $conn->query($sql);
        $last = $result->fetch_array()[0] ?? '';

        $sql = "SELECT email FROM Personal WHERE username = '$u'";
        $result = $conn->query($sql);
        $ee = $result->fetch_array()[0] ?? '';

        $sql = "SELECT phone FROM Personal WHERE username = '$u'";
        $result = $conn->query($sql);
        $pp = $result->fetch_array()[0] ?? '';

        $sql = "INSERT INTO History(id, lastname, phone, email, whichday, whichtime, tablestaken) VALUES ('$maxid', '$last', '$pp', '$ee', '$d', '$t', '$stringList');";
        $result = $conn->query($sql);

        //Update user points
        $sql = "SELECT points FROM Personal WHERE username = '$u'";
        $result = $conn->query($sql);
        $add = $result->fetch_array()[0] ?? '';
        $add = $add + (10 * $_SESSION["num"]);

        $sql = "UPDATE Personal SET points = '$add' WHERE username = '$u'";
        $result = $conn->query($sql);
        
        //Send user to thanks you html
        header('Location: thanks.html');
        exit();

    }

    function updateGuestReservationTable() {

        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Get last name and table list from session
        $Nlast = $_SESSION["last"];
        $list = $_SESSION["table_list"];

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
        
        $d = $_SESSION["day"];
        $t = $_SESSION["time"];
        $pp = $_SESSION["Gphone"];
        $gg = $_SESSION["Gemail"];

        $sql = "INSERT INTO History(id, lastname, phone, email, whichday, whichtime, tablestaken) VALUES ('$maxid', '$Nlast', '$pp', '$gg', '$d', '$t', '$stringList');";
        $result = $conn->query($sql);
        
        //Send user to thanks you html
        header('Location: thanks.html');
        exit();

    }

    function makeAccount($username, $firstn, $lastn, $email, $phone, $password, $favorite) {

        $conn = new mysqli("localhost", "root", "", "se");

        $sql = "SELECT EXISTS (SELECT username FROM personal WHERE username = '$username');";
        $result = $conn->query($sql);
        $u = $result->fetch_array()[0] ?? '';
        echo $u;
        if ($u == 1) {
            // Username already exists 
            header('Location: usernameError.html');
            exit();
        } else {

            $MA = $_SESSION["MA"];
            $BA = $_SESSION["BA"];

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
            $sql = "INSERT INTO personal(username, firstname, lastname, email, phone, mailing, billing, favorite, checkrouthing, checkaccount, cardnumber, cardmonth, cardyear, csc, onfile, points) VALUES('$username','$firstn','$lastn','$email','$phone', '$MA', '$BA','$favorite', '-1', '-1', '-1', '-1', '-1', '-1', '0', '0');";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            
        }
    }

    function addCard($username, $cardnumber, $csc, $cardyear, $cardmonth) {
        
        $conn = new mysqli("localhost", "root", "", "se");
        
        // add card information to existing account
        $sql = "UPDATE Personal SET cardnumber='$cardnumber', cardmonth='$cardmonth', cardyear='$cardyear', csc='$csc', onfile='1' WHERE username = '$username';";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));

    }

    function addCheck($username, $accountNumber, $routingNumber) {
        
        $conn = new mysqli("localhost", "root", "", "se");
        
        // add checking information to existing account
        $sql = "UPDATE Personal SET checkaccount='$accountNumber', checkrouthing='$routingNumber' WHERE username = '$username';";
        mysqli_query($conn, $sql) or die(mysqli_error($conn));
        
    }

}


?>