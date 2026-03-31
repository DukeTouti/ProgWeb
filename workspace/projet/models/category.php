<?php

class Category {

	// Attributs
	private int $id;
	private string $nom;

	// -- Constructeur ----------------------------------------------------
	public function __construct(string $nom, int $id = 0) {
		$this->nom = $nom;
		$this->id  = $id;
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

	// Méthodes PDO

	public function save(PDO $pdo) : bool {
		$sql = "INSERT INTO categories (nom) VALUES (?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public function update(PDO $pdo) : bool {
		$sql = "UPDATE categories SET nom = ? WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function delete(PDO $pdo, int $id) : bool {
		$sql = "DELETE FROM categories WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function getAll(PDO $pdo) : array {
		$sql  = "SELECT * FROM categories ORDER BY nom ASC";
		$stmt = $pdo->query($sql);

		$cats = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$cats[] = new Category($row['nom'], $row['id']);
		}

		return $cats;
	}

	public function findById(PDO $pdo, int $id) : ?Category {
		$sql = "SELECT * FROM categories WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return new Category($row['nom'], $row['id']);
	}
}

?>
