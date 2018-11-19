<?php
	ini_set('session.save_path', getcwd() . "/../../../public_html_sessions");
    $start = session_start();
    
    include 'dbmanager.php';
    $manager = DBManager::Instance();

    // this is some random function
    function printResult($result) { //prints results from a select statement
        echo "<table>";
        echo "<tr><th>ID</th><th>Name</th></tr>";
    
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["ID"] . "</td><td>" . $row["NICKNAME"] . "</td></tr>"; //or just use "echo $row[0]" 
        }
        echo "</table>";
    
    }
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../css/mypokemon.css">

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
            <div id="mypokemon-container">
                <?php if (isset($_SESSION['ID'])) { ?>
                    <div id="form">
                        <form method="POST" name="addForm" target="_self">
                            <p>POKEMON SPECIES : <input type="text" name="addSpecies" size="10"></p>
                            <p>POKEMON NICKNAME : <input type="text" name="addNickname" size="10"></p>
                            <p>LEVEL : <input type="text" name="addLevel" size="10"></p>
                            <p>WEIGHT : <input type="text" name="addWeight" size="10"></p>
                            <p>HEIGHT : <input type="text" name="addHeight" size="10"></p>
                            <p>EXPERIENCE : <input type="text" name="addExperience" size="10"></p>
                            <input type="submit" value="ADD NEW POKEMON" name="addAction">
                            <br/><br/>
                            <p>POKEMON ID TO : <input type="text" name="pokemonID" size="10"></p>
                            <!--<input type="submit" value="SIMULATE BATTLE" name="simulate"><br/>
                            <input type="submit" value="LEVEL UP" name="levelup"><br/>
                            <input type="submit" value="EVOLVE" name="evolve"><br/>-->
                            <input type="submit" value="STORE" name="store"><br/>
                            <input type="submit" value="DELETE" name="delete"><br/>
                        </form>
                    </div>
                    <div id="mypokemon-info">
                        <?php
                        // ---- PHP HERE ----
                        if (array_key_exists('addAction', $_POST)) {
                            $tmpSpecies = $_POST["addSpecies"];
                            $tmpExp = $_POST["addExperience"];
                            $tmpLevel = $_POST["addLevel"];
                            $tmpWeight = $_POST["addWeight"];
                            $tmpHeight = $_POST["addHeight"];
                            $tmpNickname = $_POST["addNickname"];
                            $maxId = $manager->executePlainSQL("SELECT MAX(id) FROM pokemonInstance"); // force-make unique id
                            $maxId = OCI_Fetch_Array($maxId, OCI_BOTH);
                            $maxId = $maxId[0];
                            if (is_nan($maxId) || $maxId === 0) {
                                $maxId = 0;
                            } else {
                                $maxId++;
                            }
                            $tmpid = $maxId;
                            $tmpTid = $_SESSION['ID'];
                            $manager->executePlainSQL("INSERT INTO pokemonInstance (id, Species_name, exp, pokelevel, Weight, Height, Nickname) Values ('$tmpid','$tmpSpecies','$tmpExp','$tmpLevel','$tmpWeight','$tmpHeight','$tmpNickname')");
                            $manager->executePlainSQL("INSERT INTO pokemonOwnership (Pokemon_id, Trainer_id, is_Stored) Values ('$tmpid','$tmpTid',0)");
                        //} else if (array_key_exists('simluate', $_POST)) {
                            //$tmpid = $_POST['pokemonID'];
                            //$manager->executePlainSQL("UPDATE pokemonOwnership SET is_stored = 1 WHERE pokemon_id = '$tmpid'");
                        //} else if (array_key_exists('levelup', $_POST)) {
                            //$tmpid = $_POST['pokemonID'];
                            //$manager->executePlainSQL("UPDATE pokemonOwnership SET is_stored = 1 WHERE pokemon_id = '$tmpid'");
                        //} else if (array_key_exists('evolve', $_POST)) {
                            //$tmpid = $_POST['pokemonID'];
                            //$manager->executePlainSQL("UPDATE pokemonOwnership SET is_stored = 1 WHERE pokemon_id = '$tmpid'");
                        } else if (array_key_exists('store', $_POST)) {
                            $tmpid = $_POST['pokemonID'];
                            $manager->executePlainSQL("UPDATE pokemonOwnership SET is_stored = 1 WHERE pokemon_id = '$tmpid'");
                        } else if (array_key_exists('delete', $_POST)) {
                            $tmpid = $_POST['pokemonID'];
                            $manager->executePlainSQL("DELETE FROM pokemonInstance WHERE id = '$tmpid'");
                        }
                            if (isset($_SESSION['ID'])) {
                            try {
                                $tmpid = $_SESSION['ID'];
                                $result = $manager->executePlainSQL("SELECT I.ID, I.nickname FROM PokemonInstance I, PokemonOwnership O WHERE I.id = O.Pokemon_id AND O.Trainer_id = '$tmpid' AND O.is_stored = 0");
                                if ($result) {
                                    printResult($result);
                                } else {
                                    echo "<font color='E69F00'>Unsuccessful.</font>";
                                }
                                OCICommit($db_conn);
                            } catch (Exception $e) {
                                echo htmlentities($e['message']);
                            }
                        }
                    } else {
                    echo "Please sign in or create an account to see your pokemon!";
                    } 
                        ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
