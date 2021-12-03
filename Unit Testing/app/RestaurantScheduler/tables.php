<?php

namespace App\RestaurantScheduler;
//session_start();
class tables {

    //Methods
    function get_tables($time, $day, $guestnum) {
        
        //Connect to db
        $conn = new \mysqli("localhost", "root", "", "SE");

        //Get user name from session
        //$currentUser = $_SESSION["pass_user"];
		$currentUser = 'bob343';
        //Check if selected day is high traffic
        $sql = "SELECT hightraffic FROM Company WHERE daytype = '$day';";
        $result = $conn->query($sql);
        $check = $result->fetch_array()[0] ?? '';
		$hascard = 0;
        //If day is high traffic then check if user has a card on file
        if ($check == 1) {

            $sql = "SELECT onfile FROM Personal WHERE username = '$currentUser';";
            $result = $conn->query($sql);
            $hascard = $result->fetch_array()[0] ?? '';
			
            //If user does not have card on file, force them to add one
            if ($hascard == 0) {
                //header('Location: forcedupdate.html');
                return $conn;
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
                    $r=1;
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
                    //array_push($TableList, $rr);
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
                return $conn;
            }
        }

        //Since user hasnt offically finalized, lets update all tables back to not taken
        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "UPDATE Reservation SET taken = FALSE WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
        }

        //If no tables were found, then redirect user to sorry page
        if ($Fail == true) {
            //header('Location: sorry.html');
           // exit();
		   return $conn;
        }
		return $conn;

        //If everything is good then lets echo an html finalize screen
		/*
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
		*/
    }

    //Methods
    function get_Guesttables($time, $day, $guestnum) {
        
        //Connect to db
        $conn = new mysqli("localhost", "root", "", "SE");

        //Check if selected day is high traffic
        $sql = "SELECT hightraffic FROM Company WHERE daytype = '$day';";
        $result = $conn->query($sql);
        $check = $result->fetch_array()[0] ?? '';

		$check = 1;
        //If day is high traffic then force guest to make account
        if ($check == 1) {
            //header('Location: noguest.html');
            return $conn;
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
                return $conn;
            }
            
        }

        //Since user hasnt offically finalized, lets update all tables back to not taken
        for ($i = 0; $i < count($TableList); $i++) {
            $sql = "UPDATE Reservation SET taken = FALSE WHERE id = '$TableList[$i]'";
            $result = $conn->query($sql);
        }

        //If no tables were found, then redirect user to sorry page
        if ($Fail == true) {
            //header('Location: sorryGuest.html');
            return $conn;
        }
		return $conn;

        //If everything is good then lets echo an html finalize screen
        /*
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
		*/
    }
}
?>