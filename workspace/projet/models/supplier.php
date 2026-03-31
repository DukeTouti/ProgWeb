<?php

class Supplier {

	// Attributs
	private int $id;
	private string $nom;
	private string $email;
	private string $telephone;
	private int $idUser;     // lien optionnel vers users (rôle fournisseur)

	// Constructeur
	public function __construct(string $nom, string $email = '', string $telephone = '', int $idUser = 0, int $id = 0) {
		$this->nom = $nom;
		$this->email = $email;
		$this->telephone = $telephone;
		$this->idUser = $idUser;
		$this->id = $id;
	}

	// Getters et Setters
	public function getId() {
		return $this->id;
	}
	
	public function getNom() {
		return $this->nom;
	}
	
	public function setNom(string $nom) {
		$this->nom = $nom;
	}
	
	public function getEmail() {
		return $this->email;
	}
	
	public function setEmail(string $email) {
		$this->email = $email;
	}
	
	public function getTelephone() {
		return $this->telephone;
	}
	
	public function setTelephone(string $tel) {
		$this->telephone = $tel;
	}
	
	public function getIdUser() {
		return $this->idUser;
	}

	public function setIdUser(int $idUser) {
		$this->idUser = $idUser;
	}

	// Méthodes PDO

	public function save(PDO $pdo) : bool {
		$sql = "INSERT INTO suppliers (nom, email, telephone, id_user) VALUES (?, ?, ?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->email, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->telephone, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->idUser > 0 ? $this->idUser : null, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function update(PDO $pdo) : bool {
		$sql = "UPDATE suppliers
			SET nom = ?, email = ?, telephone = ?, id_user = ?
			WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->email, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->telephone, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->idUser > 0 ? $this->idUser : null, PDO::PARAM_INT);
		$stmt->bindValue(5, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function delete(PDO $pdo, int $id) : bool {
		$sql = "DELETE FROM suppliers WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function getAll(PDO $pdo) : array {
		$sql  = "SELECT * FROM suppliers ORDER BY nom ASC";
		$stmt = $pdo->query($sql);

		$suppliers = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$suppliers[] = new Supplier($row['nom'], $row['email'], $row['telephone'], (int)$row['id_user'], $row['id']);
		}

		return $suppliers;
	}

	public function findById(PDO $pdo, int $id) : ?Supplier {
		$sql = "SELECT * FROM suppliers WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return new Supplier($row['nom'], $row['email'], $row['telephone'], (int)$row['id_user'], $row['id']);
	}

	// Utilisé pour le rôle fournisseur — voir uniquement ses produits
	public function findByUserId(PDO $pdo, int $idUser) : ?Supplier {
		$sql = "SELECT * FROM suppliers WHERE id_user = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $idUser, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		new Supplier($row['nom'], $row['email'], $row['telephone'], (int)$row['id_user'], $row['id']);
	}
}

?>
