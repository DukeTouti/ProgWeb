<?php

class User {

	// Attributs
	private int $id;
	private string $nom;
	private string $prenom;
	private string $login;
	private string $password;
	private string $role;
	private string $createdAt;

	// Constructeur
	public function __construct(string $nom, string $prenom, string $login,	string $password, string $role = 'vendeur', int $id = 0,
				    string $createdAt  = '') {
				    
		$this->nom = $nom;
		$this->prenom = $prenom;
		$this->login = $login;
		$this->password = $password;
		$this->role = $role;
		$this->id = $id;
		$this->createdAt = $createdAt;
	}

	// Getters et SETTERS
	public function getId() {
		return $this->id;
	}
	
	public function getNom() { 
		return $this->nom;
	}
	
	public function setNom(string $nom) {
		$this->nom = $nom;
	}
	
	public function getPrenom() {
		return $this->prenom;
	}
	
	public function setPrenom(string $prenom) {
		$this->prenom = $prenom;
	}
	
	public function getLogin() {
		return $this->login;
	}
	
	public function setLogin(string $login) {
		$this->login = $login;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setPassword(string $password) {
		$this->password = $password;
	}
	
	public function getRole() {
		return $this->role;
	}
	
	public function setRole(string $role) {
		$this->role = $role;
	}
	
	public function getCreatedAt() {
		return $this->createdAt;
	}

	// Méthodes PDO

	public function save(PDO $pdo) : bool {
		$sql = "INSERT INTO users (nom, prenom, login, password, role) VALUES (?, ?, ?, ?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->prenom, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->login, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->password, PDO::PARAM_STR);
		$stmt->bindValue(5, $this->role, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public function update(PDO $pdo) : bool {
		$sql = "UPDATE users
			SET nom = ?, prenom = ?, login = ?, role = ?
			WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->prenom, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->login, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->role, PDO::PARAM_STR);
		$stmt->bindValue(5, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function updatePassword(PDO $pdo, string $newHash) : bool {
		$sql = "UPDATE users SET password = ? WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $newHash, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function delete(PDO $pdo, int $id) : bool {
		$sql = "DELETE FROM users WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function getAll(PDO $pdo) : array {
		$sql  = "SELECT * FROM users ORDER BY nom ASC";
		$stmt = $pdo->query($sql);

		$users = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$users[] = new User($row['nom'], $row['prenom'], $row['login'],	$row['password'], $row['role'],	$row['id'],
					    $row['created_at']);
		}

		return $users;
	}

	public function findById(PDO $pdo, int $id) : ?User {
		$sql = "SELECT * FROM users WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return new User($row['nom'], $row['prenom'], $row['login'], $row['password'], $row['role'], $row['id'],	$row['created_at']);
	}

	public function findByLogin(PDO $pdo, string $login) : ?User {
		$sql = "SELECT * FROM users WHERE login = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $login, PDO::PARAM_STR);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return new User($row['nom'], $row['prenom'], $row['login'], $row['password'], $row['role'], $row['id'], $row['created_at']);
	}
}

?>
