<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre-or</title>
</head>
    <body>
        <header>
            <nav>
                <section class="Embed">
                    <a href="index.php"><img src="./Images/logo.png" alt=""></a>
                </section>
                <section class="Navigation">
                    <?php
                    session_start(); // Make sure to start the session
                    if (!empty($_SESSION['prenom'])) {
                        $prenom = $_SESSION['prenom'];
                        echo "<a href='profil.php'>" . htmlspecialchars($prenom) . "</a>";
                    } else {
                        echo '
                            <img src="#" alt=""><a href="connexion.php">Connexion</a>
                            <img src="#" alt=""><a href="register.php">Register</a>
                            <img src="#" alt=""><a href="#">Admin</a>';
                    }
                    ?>
                </section>
            </nav>
        </header>
    </body>
</html>