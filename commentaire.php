<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="comment.css">
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

<?php


if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];


    if (isset($_POST['comment']) && !empty($_POST['comment'])) {
        $comment = $_POST['comment'];
        $db = new mysqli('localhost', 'root', '', 'livreor');

        if ($db->connect_error) {
            die("Connection failed: " . $db->connect_error);
        }

        echo "Connected to database<br>";

        $stmt = $db->prepare('INSERT INTO commentaires (commentaire, id_utilisateur, date) VALUES (?, ?, NOW())');

        if ($stmt === false) {
            die("Prepare failed: " . htmlspecialchars($db->error));
        }

        $stmt->bind_param('si', $comment, $id);

        if ($stmt->execute()) {
            echo 'Success';
            header("Location: livre-or.php");
            exit();
        } else {
            echo "Execute failed: " . htmlspecialchars($stmt->error);
        }

        $stmt->close();
        $db->close();
    } else {
        echo "Comment is missing";
    }
} else {
    echo "Unauthorized access.";
}
?>

<form action="commentaire.php" method="post">
    <label for="comment">Comment:</label>
    <textarea id="comment" name="comment" required></textarea>
    <input type="submit" value="Submit">
</form>