<?php

class Film {

	// -- Attributs -------------------------------------------------------
	private int    $id;
	private string $titre;
	private string $realisateur;
	private int    $annee;        // YEAR stocke en entier
	private string $genre;
	private float  $note;         // DECIMAL(3,1)

	// -- Constructeur ----------------------------------------------------
	public function __construct(string $titre, string $realisateur, int $annee, string $genre, float $note, int $id = 0) {
		$this->titre       = $titre;
		$this->realisateur = $realisateur;
		$this->annee       = $annee;
		$this->genre       = $genre;
		$this->note        = $note;
		$this->id          = $id;
	}

	// -- Accesseurs ------------------------------------------------------
	public function getId() {
		return $this->id;
	}

	public function getTitre() {
		return $this->titre;
	}

	public function getRealisateur() {
		return $this->realisateur;
	}

	public function getAnnee() {
		return $this->annee;
	}

	public function getGenre() {
		return $this->genre;
	}

	public function getNote() {
		return $this->note;
	}

	// -- Modificateurs ---------------------------------------------------
	public function setTitre(string $titre) {
		$this->titre = $titre;
	}

	public function setRealisateur(string $realisateur) {
		$this->realisateur = $realisateur;
	}

	public function setAnnee(int $annee) {
		$this->annee = $annee;
	}

	public function setGenre(string $genre) {
		$this->genre = $genre;
	}

	public function setNote(float $note) {
		$this->note = $note;
	}

	// -- Methodes PDO ----------------------------------------------------

	public function save(PDO $pdo) {
		$sql = "INSERT INTO films (titre, realisateur, annee, genre, note) VALUES (?, ?, ?, ?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->titre,       PDO::PARAM_STR);
		$stmt->bindValue(2, $this->realisateur, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->annee,       PDO::PARAM_INT);
		$stmt->bindValue(4, $this->genre,       PDO::PARAM_STR);
		$stmt->bindValue(5, $this->note,        PDO::PARAM_STR);

		return $stmt->execute();
	}

	// $parPage = 0 => pas de LIMIT (tous les films)
	public function getAll(PDO $pdo, int $parPage = 0) {
		$sql = "SELECT * FROM films ORDER BY note DESC";

		if ($parPage > 0) {
			$sql .= " LIMIT " . (int)$parPage;
		}

		$stmt = $pdo->query($sql);

		$films = [];

		while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$films[] = new Film(
				$ligne['titre'],
				$ligne['realisateur'],
				$ligne['annee'],
				$ligne['genre'],
				$ligne['note'],
				$ligne['id']
			);
		}

		return $films;
	}

	public function findById(PDO $pdo, int $id) {
		$sql = "SELECT * FROM films WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$ligne = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($ligne === false) {
			return null;
		}

		return new Film(
			$ligne['titre'],
			$ligne['realisateur'],
			$ligne['annee'],
			$ligne['genre'],
			$ligne['note'],
			$ligne['id']
		);
	}

	public function update(PDO $pdo) {
		$sql = "UPDATE films SET titre = ?, realisateur = ?, annee = ?, genre = ?, note = ? WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->titre,       PDO::PARAM_STR);
		$stmt->bindValue(2, $this->realisateur, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->annee,       PDO::PARAM_INT);
		$stmt->bindValue(4, $this->genre,       PDO::PARAM_STR);
		$stmt->bindValue(5, $this->note,        PDO::PARAM_STR);
		$stmt->bindValue(6, $this->id,          PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function delete(PDO $pdo, int $id) {
		$sql = "DELETE FROM films WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	// -- Devoir TP5 ------------------------------------------------------
	public static function getByGenre(PDO $pdo, string $genre) {
		$sql = "SELECT * FROM films WHERE genre = ? ORDER BY note DESC";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $genre, PDO::PARAM_STR);
		$stmt->execute();

		$films = [];

		while ($ligne = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$films[] = new Film(
				$ligne['titre'],
				$ligne['realisateur'],
				$ligne['annee'],
				$ligne['genre'],
				$ligne['note'],
				$ligne['id']
			);
		}

		return $films;
	}

	public function getStats(PDO $pdo) {
		$sql = "SELECT
					COUNT(*)                                        AS total,
					ROUND(AVG(note), 1)                             AS note_moyenne,
					(SELECT titre FROM films ORDER BY note DESC LIMIT 1) AS meilleur_film
				FROM films";

		$stmt = $pdo->query($sql);
		$ligne = $stmt->fetch(PDO::FETCH_ASSOC);

		return [
			'total'         => (int)$ligne['total'],
			'note_moyenne'  => (float)$ligne['note_moyenne'],
			'meilleur_film' => $ligne['meilleur_film']
		];
	}
}
