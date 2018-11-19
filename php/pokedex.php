<?php
    include './dbmanager.php';
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

    function printDexResult($dexResult) {
        if ($dexResult) {
            while ($row = OCI_Fetch_Array($dexResult, OCI_BOTH)) {
                $temp;
                $temp = $row[0];
                $temp = trim($temp);
                echo '<div class="pokedex-list-item" onclick="searchQuery(`'.$temp.'`)"><span>'.$row[0].'</span></div>';
            }
        }
    }

    function printTypeInfoResult($result) {
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<p>".$row[0]."</p><br/>";
        }
    }

    function printPokemonInfoResult($result) {
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<p>NAME : ".$row["NAME"]."</p><br/>";
            echo "<p>RARITY : ";
            if ($row["RARITY"] == 0) {
                echo "Common";
            } else if ($row["RARITY"] == 1) {
                echo "Uncommon";
            } else if ($row["RARITY"] == 2) {
                echo "Legendary";
            } else if ($row["RARITY"] == 3) {
                echo "Mythical";
            } else { // error check
                echo "Error";
            }
            echo "</p><br/>";
            echo "<p>DESCRIPTION : ".$row["DESCRIPTION"]."</p><br/>";
            echo "<p>HEIGHT : ".$row["MINHEIGHT"]."~".$row["MAXHEIGHT"]."m</p><br/>";
            echo "<p>WEIGHT : ".$row["MINWEIGHT"]."~".$row["MAXWEIGHT"]."g</p><br/>";
        }

    }
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../css/pokedex.css">

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
            <div id="pokedex-container">
                <div id="type-list">
                    <?php
                        $result;
                        $result = $manager->executePlainSQL("SELECT * FROM pType");
                        printTypeResult($result);
                    ?>
                </div>
                <div id="pokedex-list">
                    <?php
                        $result;
                        $result = $manager->executePlainSQL("SELECT name FROM Species");
                        printDexResult($result);
                    ?>
                </div>
                <div id="info-right">
                    <div id="forms">
                        <form method="GET" id="search" name="searchForm" target="_self">
                            <input type="text" name="searchName" size="10">
                            <input type="submit" value="SEARCH TYPE" name="submittname">
                            <input type="submit" value="SEARCH POKEMON" name="submitsname">
                        </form>
                    </div>
                    <div id="pokedex-info">
                        <?php
                            $name;
                            $querySpecies = false;
                            if (array_key_exists('submittname', $_GET)) {
                                $name = $_GET["searchName"];
                                $name = ucfirst($name);
                                $result = $manager->executePlainSQL("SELECT * FROM Species_Type where type_name='$name'");
                                printTypeInfoResult($result);

                            } else if (array_key_exists('submitsname', $_GET)) {
                                $querySpecies = true;
                                $name = $_GET['searchName'];
                                $name = ucfirst($name);
                                $result = $manager->executePlainSQL("SELECT * FROM Species WHERE name='$name'");
                                if ($result && $querySpecies) {
                                    printPokemonInfoResult($result);
                                    echo "<p>HABITAT BIOME(S) : ";
                                    $result_2 = $manager->executePlainSQL("SELECT B.name FROM Biome B, Type_Biome TB, Species_Type ST WHERE B.name=TB.Biome_name AND TB.Type_name=ST.Type_name AND ST.Species_name='$name'");
                                    $row = OCI_Fetch_Array($result_2, OCI_BOTH);
                                    echo $row["NAME"];
                                    while ($row = OCI_Fetch_Array($result_2, OCI_BOTH)) {
                                        echo " | ".$row["NAME"];
                                    }
                                    echo "</p><br/>";
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>

