<?php
	ini_set('session.save_path', getcwd() . "/../../../public_html_sessions");
    $start = session_start(); 
    
    
    include 'dbmanager.php';
    $manager = DBManager::Instance();

    function printTypeResult($typeResult) {
        if ($typeResult) {
            while ($row = OCI_Fetch_Array($typeResult, OCI_BOTH)) {
                $temp;
                $temp = $row[0];
                $temp = trim($temp);
                echo '<div class="type-list-item" onclick="searchQuery(`'.$temp.'`)"><span>'.$temp.'</span></div>';
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
                    if (isset($_SESSION['ID'])) {
                        try {
                            $tmpid = $_SESSION['ID'];
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
                    } else {
                        echo "Please sign in or create an account to see your stored pokemon!";
                    }
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
                        $result = $manager->executePlainSQL("SELECT * FROM pType");
                        printTypeResult($result);
                    ?>
                </div>
            </div>
        </div>

    </div>



</body>

</html>
