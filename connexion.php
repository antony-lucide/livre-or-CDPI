<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="connexion.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
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
            <main>
                <?php
                include 'function.php';
                // if(!empty($_SESSION['prenom'])){
                //     $prenom = $_SESSION['prenom'];
                //     echo htmlspecialchars($prenom);
                // }
                if ($_SERVER['REQUEST_METHOD'] != 'POST') {
                    echo '
                    <form action="connexion.php" method="post">
                        <label> Login </label>         
                        <input type="text" name="login" size="15"/> <br> <br>  
                        <label> Password </label>         
                        <input type="password" name="password" size="15"/> <br> <br>
                        <button type="submit" name="submit">Login</button>
                    </form>';
                } else {
                    $login = $_POST['login'];
                    $password = $_POST['password'];

                    // Si c'est vide, alors il faut remplir
                    if (empty($login) || empty($password)) {
                        die('Login and password are required.');
                    }

                    $db = new mysqli('localhost', 'root', '', 'livreor');

                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    }

                    $stmt = $db->prepare('SELECT id, login, password FROM utilisateurs WHERE login=?');

                    if ($stmt === false) {
                        die('Prepare failed: ' . $db->error);
                    }

                    $stmt->bind_param('s', $login);
                    $stmt->execute();
                    $stmt->bind_result($id,$login,$hashed_password);

                    if ($stmt->fetch()) {
                        //Mon Admin était un utilisateur non crypté donc la condition ne marcher point
                        if (password_verify($password, $hashed_password)) {
                            $_SESSION['id'] = $id;
                            $_SESSION['login'] = $login;
                            echo "Login successful";

                            // Si mon users est admin, alors redirection sur cette page
                            if ($id === 1) {
                                echo "Login successful for Admin";
                                header('Location: commentaire.php');
                            } else {
                                header('Location: commentaire.php');
                            }
                            exit();
                        } else {
                            echo 'Error: Invalid login or password';
                        }
                    } else {
                        echo 'Error: Invalid login or password';
                    }

                    $stmt->close();
                    $db->close();
                }
                ?>
            </main>
    </body>
</html>