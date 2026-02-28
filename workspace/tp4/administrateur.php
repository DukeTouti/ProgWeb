<?php

include_once "utilisateur.php";

class Administrateur extends Utilisateur {
	private array $permissions;
	
	public function __construct($nom, $email, $genre, $login, $mdp, $preferences, $description, $permissions) {
		parent::__construct($nom, $email, $genre, $login, $mdp, $preferences, $description);
		$this->permissions = $permissions;
	}
	
	public function __toString () {
		return parent::__toString() . "<br> Admin attributes ===>> " . implode(" - ", $this->permissions) ;
	}
	
	public function getPermissions() {
		return $this->permissions;
	}
	
	public function setPermissions($permissions) {
		$this->permissions = $permissions;
	}
	
	public function afficherInfos($title) {
		parent::afficherInfos($title);
		echo "<ul>";
		echo "<li> Permissions : " . implode(" - ", $this->permissions) . "</li>";
		echo "</ul>";
	}
}

?>
