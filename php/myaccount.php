<?php 
ini_set('session.save_path', getcwd() . "/../../public_html_sessions");
$start = session_start(); 
if ($_GET['logout']) {
	$_SESSION = array();
	if ($_COOKIE[session_name()]) {
		setcookie(session_name(), '', time()-42000, '/');
	}
	session_destroy();
	header('refresh:5; Location:./myaccount.php');
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../css/myaccount.css">

    <script>
        function validateAccForm() {
            let myName = document.forms["accForm"]["accUsername"].value;
            let myPass = document.forms["accForm"]["accPassword"].value;
            if (myName === "" || myPass === "") {
                alert("Fields cannot be empty.");
                document.getElementById("loginresult").innerHTML = "<font color='E69F00'>Fields cannot be empty.</font>";
                return false;
            } else if (myPass.length < 1) {
                alert("Passwords must be longer than 4 characters.");
                document.getElementById("loginresult").innerHTML = "<font color='E69F00'>Passwords must be longer than 4 characters.</font>";
                return false;
            } else {
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
            <div id="user_container">
                <img src="../default_profile.jpg" style="width:100px;height:100px;"/>
                <p>&nbsp;</p>
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
            <div id="myaccount">
				<?php if (isset($_SESSION['NAME'])) { ?>
					<p> You are currently logged in as: </p>
					<?php echo "<p>" . $_SESSION['NAME'] . "</p>";?>
					<br/><br/>
					<a href="myaccount.php?logout=1">Logout</a>
                </form>
				<?php } else { ?>
                <form method="POST" name="accForm" onsubmit="return validateAccForm()" target="_self">
                    <p>USERNAME</p>
                    <input type="text" name="accUsername" size="10">
                    <br/>
                    <p>PASSWORD</p>
                    <input type="text" name="accPassword" size="10">
                    <br/><br/>
                    <input type="submit" value="LOGIN" name="login">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="SIGN UP" name="signup">
                </form>
				<?php } ?>
                <br />
                <p id="loginresult">
                    &nbsp;
                    <?php
                        include './dbmanager.php';
                        $manager = DBManager::Instance();
                        
                        // ---- login ----
                        if (array_key_exists('login', $_POST)) {
                            $name = $_POST['accUsername'];
                            $pass = $_POST['accPassword'];
                            $result;
                            try {
                                $result = $manager->executePlainSQL("SELECT id, name, password FROM Trainer WHERE name='$name' AND password='$pass'");
                                if ($result) {
                                    echo "<font color='56B4E9'>Successful.</font>";
									$result = OCI_Fetch_Array($result, OCI_BOTH);
									$_SESSION['ID'] = $result["ID"];
									$_SESSION['NAME'] = $result["NAME"];
	                                header('refresh:5; Location:./myaccount.php');
                                } else {
                                    echo "<font color='E69F00'>Unsuccessful.</font>";
                                }
                                OCICommit($db_conn);
                            } catch (Exception $e) {
                                echo htmlentities($e['message']);
                            }
                            // ---- signup ----
                        } else if (array_key_exists('signup', $_POST)) {
                            $maxId;
                            $result;
                            try {
                                $maxId = $manager->executePlainSQL("SELECT MAX(id) FROM Trainer"); // force-make unique id
                                $maxId = OCI_Fetch_Array($maxId, OCI_BOTH);
                                $maxId = $maxId[0];
                                if (is_nan($maxId) || $maxId === 0) {
                                    $maxId = 0;
                                } else {
                                    $maxId++;
                                }
                                $tmpid = $maxId;
                                $tmpUsername = $_POST['accUsername'];
                                $tmpPassword = $_POST['accPassword'];
                                $result = $manager->executePlainSQL("insert into Trainer values ('$tmpid','$tmpUsername','$tmpPassword')");
                                if ($result) {
                                    echo "<font color='56B4E9'>Successful.</font>";
                                } else {
                                    echo "<font color='E69F00'>Name is already taken.</font>";
                                }
                            } catch (Exception $e) {
                                echo htmlentities($e['message']);
                            }
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
