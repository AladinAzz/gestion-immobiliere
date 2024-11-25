<?php
session_start();
if (isset($_SESSION["connected"]) && $_SESSION["connected"]==true){

   
    $host = 'localhost:3306';  // Replace with your database host
    $dbname = 'gestion_immobiliere';  // Replace with your database name
    $username = 'admin';  // Replace with your MySQL username
    $password = 'admin';  // Replace with your MySQL password
    
    try {
        // Create a PDO instance (connect to the database)
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        
        // Set error mode to exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
       
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    
try {
    $stmt = $pdo->prepare("SELECT * FROM vente");
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
} catch (PDOException $e) {
    echo "<script>alert(\"Query error: " . addslashes($e->getMessage()) . "\")</script>";
}

foreach ($users as &$user) { 
    try {
        // Use a prepared statement to avoid SQL injection
        $stmt = $pdo->prepare("SELECT adresse FROM bien WHERE id_bien = :id_bien;");
        $stmt->bindParam(':id_bien',  $user['id_bien'], PDO::PARAM_INT); // Bind parameter safely
        $stmt->execute();
    
        // Fetch the result as an associative array
        $adress = $stmt->fetch(PDO::FETCH_ASSOC); 
        
        if ($adress) {
            // Merge the new address into the $user array
            $user = array_merge($user, ['adress' => $adress['adresse']]);

        } else {
            $user = array_merge($user, ['adress' => null]);
 // Handle cases where no address is found
        }
    } catch (PDOException $e) {
        // Properly format the error message
        echo "<script>alert(\"Query error: " . addslashes($e->getMessage()) . "\")</script>";
    }
    
}




}else
    header("Location: ../visiteur/list.html");


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="pic.png" />
    <link rel="stylesheet" href="prop.css">
    <title>Propriétés à Vendre</title>

</head>
<body>
    <header>
    <nav class="navbar">
        <div class="logo">
            <a href="accueil.html"><img src="pic.png" alt="aadl 2.0"></a>
           </div>
        <ul class="nav-links">
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="list.html">Nos Propriétés</a></li>
            <li><a href="log.html">Connexion</a></li>
        </ul>
    </nav>
</header>

<main>
<div>
<div class="container">
  <h2>Votre Biens </h2>
  <ul class="responsive-table">
    <li class="table-header">
      <div class="col col-1">Id vente</div>
      <div class="col col-2">id Bien</div>
      <div class="col col-6">Adress</div>
      <div class="col col-3">agent</div>
      <div class="col col-4">date vente</div>
      <div class="col col-5">prix</div>
      <div class="col col-6">montant payé</div>
    </li>
    <?php
    foreach ($users as $user) {
    echo "<li class=\"table-row\">
      <div class=\"col col-1\" >" .$user["id_vente"]. "</div>
      <div class=\"col col-2\" >" .$user["id_bien"]. "</div>
      <div class=\"col col-6\" >" .$user["adress"]. "</div>
      <div class=\"col col-3\" > <a href=\"\">" .$user["id_agent"]. "</a></div>
      <div class=\"col col-4\" >" .$user["date_vente"]. "</div>
      <div class=\"col col-5\" >" .$user["prix"]. "</div>
      <div class=\"col col-6\" >" .$user["montant_paye"]. "</div>
    </li>";}
    ?>
  </ul>
</div>
</div>
</main>

<footer class="footer">
        <p>&copy; 2024 AADL 2.0. Tous droits réservés.</p>
</footer>
</body>
</html>
