<?php
// Film.php - Classe complete (TP5 + adaptation TP6 pour LIMIT)
class Film
{
    // --- Attributs ---------------------------------------------------------
    private int    $id;
    private string $titre;
    private string $realisateur;
    private int    $annee;   // YEAR stocke en entier
    private string $genre;
    private float  $note;    // DECIMAL(3,1)

    // --- Constructeur ------------------------------------------------------
    public function __construct(
        string $titre,
        string $realisateur,
        int    $annee,
        string $genre,
        float  $note,
        int    $id = 0
    ) {
        $this->titre       = $titre;
        $this->realisateur = $realisateur;
        $this->annee       = $annee;
        $this->genre       = $genre;
        $this->note        = $note;
        $this->id          = $id;
    }

    // --- Accesseurs --------------------------------------------------------
    public function getId()          : int    { return $this->id;          }
    public function getTitre()       : string { return $this->titre;       }
    public function getRealisateur() : string { return $this->realisateur; }
    public function getAnnee()       : int    { return $this->annee;       }
    public function getGenre()       : string { return $this->genre;       }
    public function getNote()        : float  { return $this->note;        }

    // --- Modificateurs -----------------------------------------------------
    public function setTitre(string $titre)             : void { $this->titre       = $titre;       }
    public function setRealisateur(string $realisateur) : void { $this->realisateur = $realisateur; }
    public function setAnnee(int $annee)                : void { $this->annee       = $annee;       }
    public function setGenre(string $genre)             : void { $this->genre       = $genre;       }
    public function setNote(float $note)                : void { $this->note        = $note;        }

    // --- Methodes PDO ------------------------------------------------------

    /**
     * Insere $this dans la table films.
     * Retourne true si l'insertion reussit, false sinon.
     */
    public function save(PDO $pdo): bool
    {
        $sql  = "INSERT INTO films (titre, realisateur, annee, genre, note)
                 VALUES (:titre, :realisateur, :annee, :genre, :note)";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':titre',       $this->titre,       PDO::PARAM_STR);
        $stmt->bindValue(':realisateur', $this->realisateur, PDO::PARAM_STR);
        $stmt->bindValue(':annee',       $this->annee,       PDO::PARAM_INT);
        $stmt->bindValue(':genre',       $this->genre,       PDO::PARAM_STR);
        $stmt->bindValue(':note',        $this->note);       // DECIMAL : pas de PARAM_INT

        $ok = $stmt->execute();
        if ($ok) {
            $this->id = (int) $pdo->lastInsertId();
        }
        return $ok;
    }

    /**
     * Retourne un tableau d'objets Film tries par note decroissante.
     * $limit = 0  => pas de LIMIT (tous les films)
     * $limit > 0  => LIMIT $limit
     *
     * Signature TP5 conservee ; $limit est un parametre optionnel ajoute pour TP6.
     */
    public function getAll(PDO $pdo, int $limit = 0): array
    {
        $sql = "SELECT * FROM films ORDER BY note DESC";
        if ($limit > 0) {
            $sql .= " LIMIT " . (int) $limit;
        }
        $stmt = $pdo->query($sql);

        $films = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $films[] = new Film(
                $row['titre'],
                $row['realisateur'],
                (int)   $row['annee'],
                $row['genre'],
                (float) $row['note'],
                (int)   $row['id']
            );
        }
        return $films;
    }

    /**
     * Retourne l'objet Film dont l'id est $id, ou null si inexistant.
     */
    public function findById(PDO $pdo, int $id): ?Film
    {
        $stmt = $pdo->prepare("SELECT * FROM films WHERE id = ?");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }
        return new Film(
            $row['titre'],
            $row['realisateur'],
            (int)   $row['annee'],
            $row['genre'],
            (float) $row['note'],
            (int)   $row['id']
        );
    }

    /**
     * Met a jour tous les champs de $this en base (sauf id).
     */
    public function update(PDO $pdo): bool
    {
        $sql  = "UPDATE films
                 SET titre = :titre, realisateur = :realisateur,
                     annee = :annee, genre = :genre, note = :note
                 WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':titre',       $this->titre,       PDO::PARAM_STR);
        $stmt->bindValue(':realisateur', $this->realisateur, PDO::PARAM_STR);
        $stmt->bindValue(':annee',       $this->annee,       PDO::PARAM_INT);
        $stmt->bindValue(':genre',       $this->genre,       PDO::PARAM_STR);
        $stmt->bindValue(':note',        $this->note);
        $stmt->bindValue(':id',          $this->id,          PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * Supprime le film dont l'id est $id.
     */
    public function delete(PDO $pdo, int $id): bool
    {
        $stmt = $pdo->prepare("DELETE FROM films WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // --- Devoir TP5 --------------------------------------------------------

    /**
     * Retourne les films du genre donne, tries par note decroissante.
     */
    public static function getByGenre(PDO $pdo, string $genre): array
    {
        $stmt = $pdo->prepare(
            "SELECT * FROM films WHERE genre = ? ORDER BY note DESC"
        );
        $stmt->execute([$genre]);

        $films = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $films[] = new Film(
                $row['titre'],
                $row['realisateur'],
                (int)   $row['annee'],
                $row['genre'],
                (float) $row['note'],
                (int)   $row['id']
            );
        }
        return $films;
    }

    /**
     * Retourne ['total', 'note_moyenne', 'meilleur_film'] en une seule requete.
     */
    public function getStats(PDO $pdo): array
    {
        $sql = "SELECT
                    COUNT(*)  AS total,
                    ROUND(AVG(note), 1) AS note_moyenne,
                    (SELECT titre FROM films ORDER BY note DESC LIMIT 1)
                        AS meilleur_film
                FROM films";
        $stmt = $pdo->query($sql);
        $row  = $stmt->fetch(PDO::FETCH_ASSOC);

        return [
            'total'         => (int)   ($row['total']         ?? 0),
            'note_moyenne'  => (float) ($row['note_moyenne']  ?? 0),
            'meilleur_film' =>         ($row['meilleur_film'] ?? '—'),
        ];
    }
}
