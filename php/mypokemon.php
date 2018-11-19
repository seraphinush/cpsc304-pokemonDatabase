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
                <div id="form">
                    <form method="POST" name="addForm" onsubmit="return validateAccForm()" target="_self">
                        <p>POKEMON NAME : <input type="text" name="addSpecies" size="10"></p>
                        <p>POKEMON NICKNAME : <input type="text" name="addNickname" size="10"></p>
                        <p>LEVEL : <input type="text" name="addLevel" size="10"></p>
                        <p>WEIGHT : <input type="text" name="addWeight" size="10"></p>
                        <p>HEIGHT : <input type="text" name="addHeight" size="10"></p>
                        <p>EXPERIENCE : <input type="text" name="addExperience" size="10"></p>
                        <input type="submit" value="ADD NEW POKEMON" name="add"><br/>
                        <p>POKEMON NICKNAME TO STORE : <input type="text" name="store" size="10"></p>
                        <input type="submit" value="STORE" name="store"><br/>
                        <p>POKEMON NICKNAME TO DELETE : <input type="text" name="delete" size="10"></p>
                        <input type="submit" value="STORE" name="store"><br/>
                    </form>
                </div>
                <div id="mypokemon-info">
                    <?php
                        // ---- PHP HERE ----
                        echo "<p>CONTENT STUB</p>";
                    ?>
                </div>
            </div>
        </div>

    </div>
</body>
</html>
