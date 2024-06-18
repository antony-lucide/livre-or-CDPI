<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="register.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&display=swap" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
            if (!isset($_POST['submit'])) {
                echo '
                <form action="register.php" method="post">
                    <label> Login</label>         
                    <input type="text" name="Login" size="15"/> <br> <br>  
                    <label> Firstname </label>         
                    <input type="text" name="firstname" size="15"/> <br> <br>  
                    <label> Lastname: </label>         
                    <input type="text" name="lastname" size="15"/> <br> <br>
                    <label> Password </label>         
                    <input type="password" name="password" size="15"/> <br> <br>
                    <button type="submit" name="submit">Apply</button>
                </form>';
            } else {
                $login = $_POST['Login'];
                $prenom = $_POST['firstname'];
                $nom = $_POST['lastname'];
                $password = $_POST['password'];

                if (verifypassword($password)) {
                    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                    $db = new mysqli('localhost', 'root', '', 'livreor');

                    if ($db->connect_error) {
                        die("Connection failed: " . $db->connect_error);
                    }

                    $stmt = $db->prepare('INSERT INTO utilisateurs (login, password) VALUES (?, ?)');
                    
                    if ($stmt === false) {
                        die('Prepare failed: ' . $db->error);
                    }

                    $stmt->bind_param('ss',$login, $hashed_password);

                    if ($stmt->execute()) {
                        echo "Success";
                        header('Location: connexion.php');
                        exit();
                    } else {
                        echo 'Error: ' . $stmt->error;
                    }

                    $stmt->close();
                    $db->close();
                } else {
                    echo 'Error: Invalid password';
                }
                // var_dump($login);
                // var_dump($prenom);
                // var_dump($nom);
                // var_dump($password);
            }

            function verifypassword($password){
                if (strlen($password) >= 8) {
                    return true;
                } else {
                    echo "Your Password is too short";
                    return false;
                }
            }
            ?>
        </main>
    </body>
</html>