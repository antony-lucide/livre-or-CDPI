<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="livre-or.css">
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
                    if (!empty($_SESSION['login'])) {
                        $login = $_SESSION['login'];
                        echo "<a href='profil.php'>" . htmlspecialchars($login) . "</a>";
                        echo "<a href='logout.php'>" . "Logout" . "</a>";
                        echo "<a href='commentaire.php'>" . "New". "Comment" . "</a>";
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
    $db = new mysqli('localhost', 'root', '', 'livreor');

    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }

    $stmt = $db->prepare("SELECT utilisateurs.login, commentaires.date, commentaires.commentaire FROM utilisateurs INNER JOIN commentaires ON utilisateurs.id = commentaires.id_utilisateur ORDER BY commentaires.date DESC");

    if ($stmt->execute()) {
        $stmt->bind_result($user_login, $comment_date, $comment_text);
        echo '<ul>';
        while ($stmt->fetch()) {
            echo '<li>' . htmlspecialchars($user_login) . ' - ' . htmlspecialchars($comment_date) . ' - ' . htmlspecialchars($comment_text) . '</li>';
        }
        echo '</ul>';
    } else {
        echo "Error fetching comments: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $db->close();
} else {
    echo "Unauthorized access.";
}
?>