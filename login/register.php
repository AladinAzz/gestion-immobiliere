<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['txt']); 
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $telephone =
    $role="visit";

    $sql = "SELECT * FROM utilisateur WHERE email = :email";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':email' => $email]);

    if ($stmt->fetch()) {
        die("Cet email est déjà utilisé !");
    }

    $sql = "INSERT INTO utilisateur (nom, email, mot_de_passe,telephone) VALUES (:name, :email, :password)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([':name' => $name, ':email' => $email, ':password' => $password] ,':$telephone' => $telephone);
        echo "Compte créé avec succès !";
    } catch (PDOException $e) {
        die("Erreur lors de l'inscription : " . $e->getMessage());
    }
}

?>
