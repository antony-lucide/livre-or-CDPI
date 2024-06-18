<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commentaire</title>
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
                        echo "<a href='logout.php'>" . "Logout" . "</a>";
                        echo '<img src="#" alt=""><a href="#">Profil</a>';
                    } else {
                        echo '
                            <img src="#" alt=""><a href="connexion.php">Connexion</a>
                            <img src="#" alt=""><a href="register.php">Register</a>
                            ';
                    }
                    ?>
                </section>
            </nav>
        </header>
    </body>
</html>


<?php

$db = new mysqli('localhost', 'root', '', 'livreor');

// session_start();
// if(isset($_SESSION['id'])){
//     if(isset($_SESSION['login'])){
//         echo $_SESSION['login'];
//     }
// }
if(!empty($_POST)){
    $password = $_POST['password'];
    $login = $_POST['login'];
    $id = $_SESSION['id'];

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    $sql = $db->prepare('UPDATE utilisateurs SET login =  ?, prenom =  ?, nom =  ?, password =  ? WHERE id = ?');
    $sql->bind_param('ssi', $login,$hashed_password, $id);
    
    if ($sql->execute()) {
        $_SESSION['login'] = $login;
        echo 'Update successful. Monsieur ' . $_SESSION['login'];
    } else {
        echo 'Error executing the update query.';
    }

    $sql->close();

$db->close();
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="profil.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil</title>
</head>
<header>
        <nav>
            <section class="Embed">
                <a href="index.php"><img src="./Images/logo.png" alt=""></a>
            </section>
            <section class="Navigation">
                <img src="#" alt=""><a href="connexion.php">Connexion</a>
                <img src="#" alt=""><a href="register.php">Register</a>
                <img src="#" alt=""><a href="#">Admin</a>              
            </section>
        </nav>
</header>
<body>
    <form action="" method= "post">
    <label for="prenom">Prénom </label> 
    <input type="text" name="prenom"> <br>

    <label for="prenom">nom </label> 
    <input type="text" name="nom" placeholder="nom"> <br>

    <label for="prenom">password </label> 
    <input type="password" name="password" placerholder="password1"><br>
    
    <label for="prenom">login </label>
    <input type="text" name="login" placeholder="login"> <br>

    <button type="submit" name="envoyer" > Envoyer les Modifications </button>
    </form>
</body>
</html>