<?php
//include "Affichable.php";
class Utilisateur  {
    public string $nom;
    public string $email;
    public string $genre;
    protected string $login;
    protected string $pwd;
    protected array $preferences;
    protected string $description;

    public function __construct(string $nom, string $email, string $genre, string $login, string $pwd, array $preferences, string $description) {
        $this->nom = $nom;
        $this->email = $email;
        $this->genre = $genre;
        $this->login = $login;
        $this->pwd = $pwd;
        $this->preferences = $preferences;
        $this->description = $description;
    }
    // litérateur d'affichage
    public function __toString(): string{
        return " User " . $this->nom . " - " . $this->email . " - " . $this->genre . " - " . $this->login . " - " .
        $this->pwd . " - " . implode( " , ", $this->preferences ). " - " . $this->description;
    }

    public function afficherInfos(string $title): void {
        echo "<h2> $title</h2>";
        echo "<ul>";
        echo "<li> Nom : " . $this->nom . "</li>";
        echo "<li> Email : " .$this->email . "</li>";
        echo "<li> Genre : " . $this->genre . "</li>";
        echo "<li> login : ". $this->login . "</li>";
        echo "<li> password : ". $this->pwd . "</li>";
        echo "<li> passwordMD5 : ". md5($this->pwd ). "</li>";
        echo "<li> Préférences : " . implode(", ",  $this->preferences) . "</li>";
        echo "<li> Description : " . $this->description . "</li>";
        echo "</ul>";
    }

}
