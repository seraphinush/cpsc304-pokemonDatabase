<html>

<head>

    <link rel="stylesheet" type="text/css" href="../main.css">

    <script>
        function validateAccForm() {
            let myName = document.forms["accForm"]["accUsername"].value;
            let myPass = document.forms["accForm"]["accPassword"].value;
            if (myName === "" || myPass === "") {
                alert("Fields cannot be empty.");
                document.getElementById("loginresult").innerHTML = "Fields cannot be empty.";
                return false;
            } else if (myPass.length < 1) {
                alert("Passwords must be longer than 4 characters.");
                document.getElementById("loginresult").innerHTML = "Passwords must be longer than 4 characters.";
                return false;
            } else {
                document.getElementById("loginresult").innerHTML = "Login successful.";
                return true;
            }
        }
    </script>

</head>

<body>

    <div id="container">

        <!-- HEADER -->
        <div onclick="location.href='../index.php'" id="header">
            <p>CPSC304-G13's PC</p>
        </div>

        <!-- NAVIGATION -->
        <div id="nav">
            <div class="user_container">
                <div>test</div>
            </div>
            <div onclick="location.href='./myaccount.php'" class="nav-item">
                <p>MY ACCOUNT</p>
            </div>
            <div onclick="location.href='./mypokemon.php'" class="nav-item">
                <p>MY POKEMON</p>
            </div>
            <div onclick="location.href='./storage.php'" class="nav-item">
                <p>STORAGE</p>
            </div>
            <div onclick="location.href='./pokedex.php'" class="nav-item">
                <p>POKEDEX</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div id="content">
            <div class="myaccount">
                <form method="POST" name="accForm" onsubmit="return validateAccForm()" target="_self">
                    <span>USERNAME</span>
                    <input type="text" name="accUsername" size="10">
                    <br />
                    <span>PASSWORD</span>
                    <input type="text" name="accPassword" size="10">
                    <br /><br />
                    <input type="submit" value="Login" name="login">&nbsp;&nbsp; &nbsp; &nbsp;
                    <input type="submit" value="Sign up" name="signup">
                </form>
                <br />
                <p id="loginresult">&nbsp;</p>
            </div>
        </div>

    </div>



</body>

</html>

<?php
include './dbmanager.php';


$manager = DBManager::Instance();
    // ---- login ----
    if (array_key_exists('login', $_POST)) {
	$user = $_POST['accUsername'];
        $pass = $_POST['accPassword'];
        $result;
        try {
            $result = $manager->executePlainSQL("SELECT id, name, password FROM Trainer WHERE name = '" . $user . "' AND password = '" . $pass . "'");
            while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {;
				echo "test : " . $row["ID"] . "<br/>";
				echo "test : " . $row["NAME"] . "<br/>";
				echo "test : " . $row["PASSWORD"] . "<br/>";
			}
            if ($result && $success) {
                echo "HOORAY";
            } else {
                echo "KMS";
            }  
        } catch (Exception $e) {
            echo $e['message'];
        }
    // ---- signup ----
    } else if (array_key_exists('signup', $_POST)) {
        /*$maxId = executePlainSQL("SELECT MAX(id) FROM Trainer"); // force-make unique id
        $maxId = OCI_Fetch_Array($maxId, OCI_BOTH);
        $maxId = $maxId[0];
        if (is_nan($maxId) || $maxId === 0) {
            $maxId = 0;
        } else {
            $maxId++;
        }
        $tuple = array(
            ":bind1" => $maxId,
            ":bind2" => $_POST['accUsername'],
            ":bind3" => $_POST['accPassword'],
        );
        $alltuples = array(
            $tuple,
        );
        executeBoundSQL("insert into Trainer values (:bind1, :bind2, :bind3)", $alltuples);
        OCICommit($db_conn);*/
    }
 /*   OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}*/

?>
