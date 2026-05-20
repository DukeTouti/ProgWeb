<?php
class Film {
 
    // -- Attributs -------------------------------------------------------
    private int    $id;
    private string $titre;
    private string $realisateur;
    private int    $annee;      // YEAR stocke en entier
    private string $genre;
    private float  $note;       // DECIMAL(3,1)
 
    // -- Constructeur ----------------------------------------------------
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
 
    // -- Accesseurs ------------------------------------------------------
    public function getId()          : int    { return $this->id; }
    public function getTitre()       : string { return $this->titre; }
    public function getRealisateur() : string { return $this->realisateur; }
    public function getAnnee()       : int    { return $this->annee; }
    public function getGenre()       : string { return $this->genre; }
    public function getNote()        : float  { return $this->note; }
 
    // -- Modificateurs (a completer) -------------------------------------
    public function setTitre(string $titre)             : void { $this->titre = $titre; }
    public function setRealisateur(string $realisateur) : void { $this->realisateur = $realisateur; }
    public function setAnnee(int $annee)                : void { $this->annee = $annee; }
    public function setGenre(string $genre)             : void { $this->genre = $genre; }
    public function setNote(float $note)                : void { $this->note = $note; }
 
    // -- Methodes PDO a implementer --------------------------------------
 
    public function save(PDO $pdo): bool {
        // TODO : inserer $this dans la table films
        $sql = "INSERT INTO films (titre, realisateur, annee, genre, note) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $this->titre, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->realisateur, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->annee, PDO::PARAM_INT);
        $stmt->bindValue(4, $this->genre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->note, PDO::PARAM_STR);
        return $stmt->execute();
    }
 
    public static function getAll(PDO $pdo): array {
        // TODO : retourner un tableau d'objets Film tries par note desc
        //        utiliser PDO::FETCH_ASSOC pour eviter les doublons d'index
        $sql = 'SELECT * FROM films ORDER BY note DESC';
        $resultSet = $pdo->query($sql);
        $films = [];
        while($ligne = $resultSet->fetch(PDO::FETCH_ASSOC) ) {
            $films[] = new Film(
                titre: $ligne['titre'],
                realisateur: $ligne['realisateur'],
                annee: $ligne['annee'],
                genre: $ligne['genre'],
                note: $ligne['note'],
                id: $ligne['id']
            );
        }
        return $films;
    }
 
    // public static function getByGenre(PDO $pdo, string $genre): array {
    //     // TODO : retourner les films du genre donne (requete preparee)
    //     //        tries par note decroissante
    //     $sql = 'SELECT * FROM films WHERE genre = ? ORDER BY note DESC';
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->bindValue(1, $genre, PDO::PARAM_STR);
    //     $stmt->execute();
    //     $films = [];
    //     while($ligne = $stmt->fetch(PDO::FETCH_ASSOC) ) {
    //         $films[] = new Film(
    //             titre: $ligne['titre'],
    //             realisateur: $ligne['realisateur'],
    //             annee: $ligne['annee'],
    //             genre: $ligne['genre'],
    //             note: $ligne['note'],
    //             id: $ligne['id']
    //         );
    //     }
    //     return $films;

    // }
 
    public static function findById(PDO $pdo, int $id): ?Film {
        // TODO : retourner l'objet Film ou null si inexistant
        $sql = 'SELECT * FROM films WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($ligne === false) {
            return null;
        }
        return new Film(
            titre: $ligne['titre'],
            realisateur: $ligne['realisateur'],
            annee: $ligne['annee'],
            genre: $ligne['genre'],
            note: $ligne['note'],
            id: $ligne['id']
        );

    }
 
    public function update(PDO $pdo): bool {
        // TODO : mettre a jour tous les champs de $this (sauf id)
        $sql = "UPDATE films SET titre = ?, realisateur = ?, annee = ?, genre = ?, note = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $this->titre, PDO::PARAM_STR);
        $stmt->bindValue(2, $this->realisateur, PDO::PARAM_STR);
        $stmt->bindValue(3, $this->annee, PDO::PARAM_INT);
        $stmt->bindValue(4, $this->genre, PDO::PARAM_STR);
        $stmt->bindValue(5, $this->note, PDO::PARAM_STR);
        $stmt->bindValue(6, $this->id, PDO::PARAM_INT);
        return $stmt->execute();

    }
 
    public static function delete(PDO $pdo, int $id): bool {
        // TODO : supprimer le film dont l'id est $id
        $sql = 'DELETE FROM films WHERE id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        return $stmt->execute();

    }
 
    // -- Devoir ------------------------------------------------------------
    public static function getStats(PDO $pdo): array {
        // TODO : retourner ['total', 'note_moyenne', 'meilleur_film']
        //        en une seule requete SQL
        // Exple of return value :
        return [
            'total' => 0,
            'note_moyenne' => 0.0,
            'meilleur_film' => null
        ];
    }
}