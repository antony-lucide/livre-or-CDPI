<?php function verifypassword($password){
    if (strlen($password) >= 8) {
        return true;
    } else {
        echo "Your Password is too short";
        return false;
    }
}

?>