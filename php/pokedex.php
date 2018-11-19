<?php
    include './dbmanager.php';
    $manager = DBManager::Instance();

    function printTypeResult($typeResult) {
        if ($typeResult) {
            while ($row = OCI_Fetch_Array($typeResult, OCI_BOTH)) {
                $tempType;
                $tempType = $row[0];
                $tempType = trim($tempType);
                echo '<div class="type-list-item" onclick="makeTypeQuery(`'.$tempType.'`)"><span>'.$tempType.'</span></div>';
            }
        }
    }

    function printDexResult($dexResult) {
        if ($dexResult) {
            while ($row = OCI_Fetch_Array($dexResult, OCI_BOTH)) {
                echo '<div class="pokedex-list-item"><span>'.$row[0].'</span></div>';
            }
        }
    }

    function printResult($result) {
        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo $row[0];
        }
    }
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../css/pokedex.css">

    <script>
        function makeTypeQuery(pName) {
            name = pName.trim();
            document.forms.typeForm.typeName.value = name;
            document.forms.typeForm.submit();
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
                <div id="pokedex-left">
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
                </div>
                <div id="pokedex-right">
                    <div class="hidden">
                        <form method="GET" name="typeForm" target="_self">
                            <input type="text" name="typeName" size="10">
                            <input type="submit" value="" name="submittname">
                        </form>
                    </div>
                    <div id="pokedex-entry">
                        <?php
                            echo "run";
                            if (array_key_exists('submittname', $_GET)) {
                                $name = $_GET["typeName"];
                                $result = $manager->executePlainSQL("select * from Species_Type where type_name='$name'");
		                        printResult($result);
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

</html>

