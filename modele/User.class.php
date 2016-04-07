<?php

class User {

	private $user_id;
	private $user_login;
	private $user_actif;
	private $user_status;
	private $user_pass;

	function __construct($user_id, $user_login, $user_actif, $user_status, $user_pass) {
		$this->user_id		 = $user_id;
		$this->user_login	 = $user_login;
		$this->user_actif	 = $user_actif;
		$this->user_status	 = $user_status;
		$this->user_pass	 = $user_pass;
	}

	function getUser_id() {
		return $this->user_id;
	}

	function getUser_login() {
		return $this->user_login;
	}

	function getUser_actif() {
		return $this->user_actif;
	}

	function getUser_status() {
		return $this->user_status;
	}

	function getUser_pass() {
		return $this->user_pass;
	}

	function setUser_id($user_id) {
		$this->user_id = $user_id;
	}

	function setUser_login($user_login) {
		$this->user_login = $user_login;
	}

	function setUser_actif($user_actif) {
		$this->user_actif = $user_actif;
	}

	function setUser_status($user_status) {
		$this->user_status = $user_status;
	}

	function setUser_pass($user_pass) {
		$this->user_pass = $user_pass;
	}

}
