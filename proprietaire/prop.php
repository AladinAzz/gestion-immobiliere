<?php
session_start();
//if (isset($_SESSION["connected"]) && $_SESSION["connected"]==true){

   
    $host = 'localhost:3306';  // Replace with your database host
    $dbname = 'gestion_immobiliere';  // Replace with your database name
    $username = 'root';  // Replace with your MySQL username
    $password = 'Aladdinazz22';  // Replace with your MySQL password
    
    try {
        // Create a PDO instance (connect to the database)
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        
        // Set error mode to exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        echo "<script>alert (\"Welcome owner\")</script>";
    } catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
    
try {
    $stmt = $pdo->prepare("SELECT * FROM vente");
    $stmt->execute();
    
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC); 
    
} catch (PDOException $e) {
    echo "<script>alert (\"query \")</script>"  ;
}


/*}else
    header("Location: index.php");
*/

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
            <a href="index.html"><img src="pic.png" alt="aadl 2.0"></a>
           </div>
        <ul class="nav-links">
            <li><a href="index.html">Accueil</a></li>
            <li><a href="list.html">Nos Propriétés</a></li>
            <li><a href="test3.html">Connexion</a></li>
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
      <div class="col col-3">agent</div>
      <div class="col col-4">date vente</div>
      <div class="col col-5">prix</div>
      <div class="col col-6">montant payé</div>
    </li>
    <?php
    foreach ($users as $user) {
    echo "<li class=\"table-row\">
      <div class=\"col col-1\" data-label=\" \">" .$user["id_vente"]. "</div>
      <div class=\"col col-2\" data-label=\"\">" .$user["id_bien"]. "</div>
      <div class=\"col col-3\" data-label=\"\">" .$user["id_agent"]. "</div>
      <div class=\"col col-4\" data-label=\"\">" .$user["date_vente"]. "</div>
      <div class=\"col col-5\" data-label=\"\">" .$user["prix"]. "</div>
      <div class=\"col col-6\" data-label=\"\">" .$user["montant_paye"]. "</div>
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
