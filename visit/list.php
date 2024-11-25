<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="pic.png" />
    <link rel="stylesheet" href="list.css">
    <title>Propriétés à Vendre</title>

</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <a href="visit.php"><img src="pic.png" alt="aadl 2.0"></a>
           </div>
        <ul class="nav-links">
            <li><a href="visit.php">Accueil</a></li>
            <li><a href="list.php">Nos Propriétés</a></li>
            <li><a href="../login/log.php">Connexion</a></li>
        </ul>
    </nav>

    <header class="hero">
        <div class="hero-content">
            <h1>Découvrez Nos Propriétés</h1>
            <p>Trouvez la maison ou l'appartement de vos rêves parmi notre sélection exclusive.</p>
        </div>
    </header>
   
    <section class="property-carousel">
        <h2>Maisons</h2>
        <div class="carousel-container">
            <button class="prev" onclick="scrollLeft('maisons')">&#10094;</button>
            <div class="carousel" id="maisons">
                <div class="carousel-item">
                    <img src="images/maison1.jpg" alt="Maison 1">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/maison2.jpg" alt="Maison 2">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/maison3.jpg" alt="Maison 3">
                    <button class="btn-details">Voir Détails</button>
                </div>
            </div>
            <button class="next" onclick="scrollRight('maisons')">&#10095;</button>
        </div>
    </section>

    <section class="property-carousel">
        <h2>Appartements</h2>
        <div class="carousel-container">
            <button class="prev" onclick="scrollLeft('appartements')">&#10094;</button>
            <div class="carousel" id="appartements">
                <div class="carousel-item">
                    <img src="images/appartement1.jpg" alt="Appartement 1">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/appartement2.jpg" alt="Appartement 2">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/appartement3.jpg" alt="Appartement 3">
                    <button class="btn-details">Voir Détails</button>
                </div>
            </div>
            <button class="next" onclick="scrollRight('appartements')">&#10095;</button>
        </div>
    </section>

    
    <section class="property-carousel">
        <h2>Villas</h2>
        <div class="carousel-container">
            <button class="prev" onclick="scrollLeft('villas')">&#10094;</button>
            <div class="carousel" id="villas">
                <div class="carousel-item">
                    <img src="images/villa1.jpg" alt="Villa 1">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/villa2.jpg" alt="Villa 2">
                    <button class="btn-details">Voir Détails</button>
                </div>
                <div class="carousel-item">
                    <img src="images/villa3.jpg" alt="Villa 3">
                    <button class="btn-details">Voir Détails</button>
                </div>
            </div>
            <button class="next" onclick="scrollRight('villas')">&#10095;</button>
        </div>
    </section>


    <footer class="footer">
        <p>&copy; 2024 AADL 2.0. Tous droits réservés.</p>
    </footer>
</body>
</html>
