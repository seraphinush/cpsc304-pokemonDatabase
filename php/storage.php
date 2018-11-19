<?php
	ini_set('session.save_path', getcwd() . "/../../../public_html_sessions");
    $start = session_start(); 
    
    include 'dbmanager.php';
    $manager = DBManager::Instance();

    function printTypeResult($typeResult) {
        if ($typeResult) {
            while ($row = OCI_Fetch_Array($typeResult, OCI_BOTH)) {
                $temp_1;
                $temp_1 = $row["NAME"];
                $temp_2 = $row["COUNTED"];
                echo '<div class="type-list-item" onclick="searchQuery(`'.$temp_1.'`)"><span>'.$temp_1.' ('.$temp_2.')</span></div>';
            }
        }
    }

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
    <link rel="stylesheet" type="text/css" href="../css/storage.css">

    <script>
        function searchQuery(name) {
            name = name.trim();
            document.forms.searchForm.searchName.value = name;
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
            <div id="storage-container">
                <?php
                    if (isset($_SESSION['ID']) && !array_key_exists('submittname', $_GET)) {
                        try {
                            $tmpid = $_SESSION['ID'];
                            $result = $manager->executePlainSQL("SELECT COUNT(*) FROM PokemonInstance I, PokemonOwnership O WHERE I.id = O.Pokemon_id AND O.Trainer_id = '$tmpid' AND O.is_stored = 1");
				            $result = OCI_Fetch_Array($result, OCI_BOTH);
                            echo "Total Pokemon in Storage: " . $result[0] . "</br></br>";
                            $result = $manager->executePlainSQL("SELECT I.ID, I.nickname FROM PokemonInstance I, PokemonOwnership O WHERE I.id = O.Pokemon_id AND O.Trainer_id = '$tmpid' AND O.is_stored = 1");
                            if ($result) {
                                printResult($result);
                            } else {
                                echo "<font color='E69F00'>Unsuccessful.</font>";
                            }
                            OCICommit($db_conn);
                        } catch (Exception $e) {
                            echo htmlentities($e['message']);
                        }
                    } else if (isset($_SESSION['ID']) && array_key_exists('submittname', $_GET)) {
                        $type = $_GET["searchName"];
                        $type = ucfirst($type);
                        $tmpid = $_SESSION['ID'];
                        $result = $manager->executePlainSQL("SELECT COUNT(*) FROM PokemonInstance I, PokemonOwnership O, Species_type T WHERE I.id = O.Pokemon_id AND I.Species_name = T.Species_name AND O.Trainer_id = '$tmpid' AND O.is_stored = 1 AND T.Type_name = '$type'");
                        $result = OCI_Fetch_Array($result, OCI_BOTH);
                        echo "Total Pokemon of this Type: " . $result[0] . "</br></br>";
                        $result = $manager->executePlainSQL("SELECT I.ID, I.nickname FROM PokemonInstance I, PokemonOwnership O, Species_type T WHERE I.id = O.Pokemon_id AND I.Species_name = T.Species_name AND O.Trainer_id = '$tmpid' AND O.is_stored = 1 AND T.Type_name = '$type'");
                        printResult($result);
		            } else {
                        echo "Please sign in or create an account to see your stored pokemon!";
                    }
			        if (isset($_SESSION['ID'])) {
                ?>
                        <div id="forms">
                            <form method="GET" id="search" name="searchForm" target="_self">
                                <input type="text" name="searchName" size="10">
                                <input type="submit" value="SEARCH TYPE" name="submittname">
                            </form>
                        </div>
                        <div id="type-list">
                            <?php
                                $result;
                                $tmpid = $_SESSION['ID'];
                                $result = $manager->executePlainSQL("SELECT name, COALESCE (num,0) AS COUNTED From pType LEFT JOIN (SELECT ST.Type_name, COUNT(*) as num FROM PokemonOwnership O, PokemonInstance I, Species_Type ST WHERE O.Pokemon_id = I.id AND O.is_stored = 1 AND I.Species_name = ST.Species_name AND O.Trainer_id = $tmpid GROUP BY ST.Type_name) ON Type_name = name");
                                printTypeResult($result);
                            ?>
                        </div>
                <?php
                    }
                ?>
            </div>
        </div>

    </div>



</body>

</html>
