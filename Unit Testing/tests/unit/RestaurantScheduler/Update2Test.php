<?php


class Update2Test extends \PHPUnit\Framework\TestCase
{
		
		/** @test */
		public function testUpdateActiveUserCard(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->updateActiveUserCard('123456789','123','12','2021');

			$result = $mysqli->query("SELECT cardnumber FROM Personal WHERE username ='dogwalkers' ");
			$this->assertEquals('123456789',$result->fetch_row()[0]);
		}

		/** @test */
		public function testUpdateReservationTable(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->updateReservationTable();

			$result = $mysqli->query("SELECT taken FROM Reservation");
			$this->assertEquals(true,$result->fetch_row()[0]);
		}

		/** @test */
		public function testUpdateGuestReservationTable(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->updateGuestReservationTable();
			$result = $mysqli->query("SELECT taken FROM Reservation");
			$arr = $result->fetch_array();
			$this->assertEquals(true,$arr[0]);
			
		}

		/** @test */
		public function testMakeAccount(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->makeAccount('dogwalkers','john','jameson','john@gmail.com','755-444-2222','dumbdog','1');
			$result = $mysqli->query("SELECT username FROM Accounts");
			
			$this->assertEquals(2,$result->num_rows);
		}

		/** @test */
		public function testAddCard(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->addCard('bob343','7777 7777 7777 7778','123','2021','12');
			$result = $mysqli->query("SELECT cardnumber FROM Personal");
			
			$this->assertEquals('7777 7777 7777 7778',$result->fetch_row()[0]);
		}

		/** @test */
		public function testAddCheck(){
			$update = new \App\RestaurantScheduler\update2;
			$mysqli = $update->addCheck('bob343',1,1);
			$result = $mysqli->query("SELECT checkaccount FROM Personal");
			
			$this->assertEquals(1,$result->fetch_row()[0]);
		}
}
