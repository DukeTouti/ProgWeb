<?php

class Utilisateur {
	public string $nom;
	public string $email;
	public string $genre;
	
	protected string $login;
	protected string $mdp;
	protected array $preferences;
	protected string $description;
	
	public function __construct($nom, $email, $genre, $login, $mdp, $preferences, $description) {
		$this->nom = $nom ;
		$this->email = $email;
		$this->genre = $genre;
		$this->login = $login;
		$this->mdp = $mdp;
		$this->preferences = $preferences;
		$this->description = $description;
	}
	
	public function __toString () {
		return " Utilisateur " . $this->nom . " - " . $this->email . " - " . $this->genre . " - " . $this->login . " - " . $this->mdp . 
		       " - " . implode(" , ", $this->preferences) . " - " . $this->description ;
	}
	
	public function afficherInfos(string $title) {
		echo "<h2> $title</h2>";
		echo "<ul>";
		echo "<li> Nom : " . $this->nom . "</li>";
		echo "<li> Email : " . $this->email . "</li>";
		echo "<li> Genre : " . $this->genre . "</li>";
		echo "<li> Login : " . $this->login . "</li>";
		echo "<li> Mot de Passe : " . $this->mdp . "</li>";
		echo "<li> Mot de Passe MD5 : " . md5($this->mdp) . "</li>";
		echo "<li> Préférences : " . implode(", ", $this->preferences) . "</li>";
		echo "<li> Description : " . $this->description . "</li>";
		echo "</ul>";
	}
}

?>
