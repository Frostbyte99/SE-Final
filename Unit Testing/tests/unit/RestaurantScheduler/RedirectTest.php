<?php

class RedirectTest extends \PHPUnit\Framework\TestCase
{
		/** @test */
		public function testGoToLogin(){
			$redirect = new \App\RestaurantScheduler\redirect;
			$this->assertEquals("header('Location: login.html');",$redirect->goto_login());
		}

		/** @test */
		public function testGoToRegistration(){
			$redirect = new \App\RestaurantScheduler\redirect;
			$this->assertEquals("header('Location: registration.html');",$redirect->goto_registration());
		}

		/** @test */
		public function testGoToRegistrationCard(){
			$redirect = new \App\RestaurantScheduler\redirect;
			$this->assertEquals("header('Location: card.html');",$redirect->goto_registration_card());
		}

		/** @test */
		public function testGoToRegistrationCheck(){
			$redirect = new \App\RestaurantScheduler\redirect;
			$this->assertEquals("header('Location: check.html');",$redirect->goto_registration_check());
		}
}