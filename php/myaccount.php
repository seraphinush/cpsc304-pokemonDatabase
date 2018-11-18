<html>

<head>

    <link rel="stylesheet" type="text/css" href="../main.css">
    <link rel="stylesheet" type="text/css" href="../css/pokedex.css">

    <script>
        function validateAccForm() {
            let myName = document.forms["accForm"]["accUsername"].value;
            let myPass = document.forms["accForm"]["accPassword"].value;
            if (myName === "" || myPass === "") {
                alert("Fields cannot be empty.");
                return false;
            } else if (myPassword.length < 5) {
                alert("Passwords must be longer than 4 characters.");
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
                <form method="POST" name="accForm" onsubmit="return validiateAccForm()" target="_self"> <!-- LOGIN -->
                    <font>USERNAME</font>
                    <input type="text" name="accUsername" size="10">
                    <br />
                    <font>PASSWORD</font>
                    <input type="text" name="accPassword" size="10">
                    <br /><br />
                    <input type="submit" value="Login" name="login">&nbsp;&nbsp; &nbsp; &nbsp;
                    <input type="submit" value="Sign up" name="signup">
                </form>
                <br />
                <p id="loginresult"></p>
            </div>
        </div>

    </div>



</body>

</html>

<?php
$success = true; // error flag
$db_conn = OCILogon("ora_v9m8", "a38134110", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executeBoundSQL($cmdstr, $list)
{
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);
    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = false;
    }
    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            echo $val."<br>";
            echo $bind."<br>";
            OCIBindByName($statement, $bind, $val);
            unset($val);
        }
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // handle error in $statement
            echo htmlentities($e['message']);
            echo "<br>";
            $success = false;
        }
    }

}
function executePlainSQL($cmdstr)
{
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);
    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn);
        echo htmlentities($e['message']);
        $success = false;
    }
    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // handle error in $statement
        echo htmlentities($e['message']);
        $success = false;
    } else {
    }
    return $statement;

}

if ($db_conn) {
    // ---- login ----
    if (array_key_exists('login', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['accUsername'],
            ":bind2" => $_POST['accPassword'],
        );
        $alltuples = array(
            $tuple,
        );
        $result;
        try {
            $result = executePlainSQL("SELECT id FROM Trainer WHERE name = ':bind1' AND password = ':bind2'");
            OCICommit($db_conn);
            if ($result && $success) {
                echo "HOORAY";
            }
        } catch {
            echo "KMS";
        }        
    // ---- signup ----
    } else if (array_key_exists('signup', $_POST)) {
        $maxId = executePlainSQL("SELECT MAX(id) FROM Trainer"); // force-make unique id
        echo "raw executePlainSQL : ".$maxId."<br/>";
        $maxId = OCI_Fetch_Array($maxId, OCI_BOTH);
        echo "OCI_Fetch_array($maxId) : ".$maxId."<br/>";
        echo "maxId[0] : ".$maxId[0]."<br/>";
        echo "maxId[\"ID\"] : ".$maxId["id"]."<br/>";
        echo "and use maxId[0]."."<br/>";
        echo "cehck maxId[0] + 1".$maxId[0]+1;
        $maxId = $maxId[0];
        if (is_nan($maxId)) {
            $maxId = 0;
        } else {
            $maxId++;
        }
        echo "post : " . $maxId;
        $tuple = array(
            ":bind1" => $maxId,
            ":bind2" => $_POST['accUsername'],
            ":bind3" => $_POST['accPassword'],
        );
        $alltuples = array(
            $tuple,
        );
        executeBoundSQL("insert into Trainer values (:bind1, :bind2, :bind3)", $alltuples);
        OCICommit($db_conn);
    }
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}
?>