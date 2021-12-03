<?php

class LogTest extends \PHPUnit\Framework\TestCase
{
		/** @test */
		public function testUserLogin(){
			$log = new \App\RestaurantScheduler\log;
			$this->assertEquals(false,$log->user_login('user','123456789'));
			$this->assertEquals(true,$log->user_login('dogwalkers','dumbdog'));
		}

}