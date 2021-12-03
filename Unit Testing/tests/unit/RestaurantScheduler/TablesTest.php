<?php

class TablesTest extends \PHPUnit\Framework\TestCase
{
		/** @test */
		public function testGetTables(){
			$tables = new \App\RestaurantScheduler\tables;
			$mysqli = $tables->get_tables('7:00 PM','monday','2');
			$result = $mysqli->query("SELECT taken FROM Reservation");
			$this->assertEquals(true,$result->fetch_row()[0]);
		}
		/** @test */
		public function testGetGuestTables(){
			$tables = new \App\RestaurantScheduler\tables;
			$mysqli = $tables->get_tables('7:00 PM','monday','2');
			$result = $mysqli->query("SELECT taken FROM Reservation");
			$this->assertEquals(true,$result->fetch_row()[0]);
		}
}