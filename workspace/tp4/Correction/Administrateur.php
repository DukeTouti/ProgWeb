<?php
include_once "Utilisateur.php";
class Administrateur extends Utilisateur {
    private array $permissions;

    public function __construct(string $nom, string $email, string $genre, string $login, string $pwd,
                                array $preferences, string $description, array $permissions) {

        parent::__construct($nom, $email, $genre, $login, $pwd, $preferences, $description);
        $this->permissions = $permissions;
    }

    public function __toString(): string
    {
        return parent::__toString() .
            " <br> Admin attributes ===>> " . implode(" - ", $this->permissions);
    }
    public function getPermissions(): array
    {
        return $this->permissions;
    }

    public function setPermissions($permissions): void
    {
        $this->permissions = $permissions;
    }

    public function afficherInfos(string $title) : void{
        parent::afficherInfos($title);

        echo " <h4>Permissions : </h4>" . implode (" , " , $this->permissions) . " <br>";
    }
}