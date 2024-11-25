<?php

$host = 'localhost:3306';
$dbname = 'gestion_immobiliere';
$username = 'admin';
$dbPassword = 'admin';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $dbPassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

if (isset($_POST['butt'])) {
    $name = $_POST['nom'];
    $lname=$_POST['prenom'];
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $mot_de_passe = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $phone =$POST['phone'];
    $role ="visit";


    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    if ($stmt->fetch()) {
        die("Cet email est déjà utilisé !");
    }

    $requete = $bdd ->prepare("INSERT INTO utilisateur (nom,prenom,email,mot_de_passe,role,telephone) VALUES (:nom, :prenom,:email,:mot_de_passe,:role,:phone)");
    $requete->execute(
        array(
            "nom" => $nom,
            "prenom"=>$prenom,
            "email"=>$email,
            "mot_de_passe"=>$mot_de_passe,
            "role"=>$role,
            "phone"=>$phone
        )
        );
        $reponse = $requete->fetchAll(PDO::FETCH_ASSOC);
        var_dump($reponse);
}

?>
