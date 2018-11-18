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
            } else if (myPass.length < 5) {
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
$success = true; // error flag
$db_conn = OCILogon("ora_v9m8", "a38134110", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executeBoundSQL($cmdstr, $list)
{
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);
    if (!$statement) {
        $e = OCI_Error($db_conn); // handle error in $statement
        $success = false;
        new Exception("<br/>Cannot parse the following command: ".$cmdstr."<br/>".$e['message']);
    }
    foreach ($list as $tuple) {
        foreach ($tuple as $bind => $val) {
            OCIBindByName($statement, $bind, $val);
            unset($val);
        }
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            $e = OCI_Error($statement); // handle error in $statement
            $success = false;
            new Exception("<br/>Cannot execute the following command: ".$cmdstr."<br/>".$e['message']);
        }
    }

}

function executePlainSQL($cmdstr)
{
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);
    if (!$statement) {
        $e = OCI_Error($db_conn); // handle error in $statement
        $success = false;
        new Exception("<br/>Cannot parse the following command: ".$cmdstr."<br/>".$e['message']);
    }
    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        $e = OCI_Error($statement); // handle error in $statement
        $success = false;
        new Exception("<br/>Cannot execute the following command: ".$cmdstr."<br/>".$e['message']);
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
            $result = executePlainSQL("SELECT id, name, password FROM Trainer WHERE name = ':bind1' AND password = ':bind2'");
            echo "test : ".$result."<br/>";
            $result = OCI_Fetch_Array($result, OCI_ASSOC);
            echo "test : ".$result."<br/>";
            echo "test : ".$result["id"]."<br/>";
            echo "test : ".$result["ID"]."<br/>";
            $result = $result[0];
            echo "test : ".$result."<br/>";
            OCICommit($db_conn);
            if ($result && $success) {
                echo "HOORAY";
            } else {
                echo "KMS";
            }  
        } catch (Exception $e) {
            echo $e['message'];
        }
        OCILogoff($db_conn);
    // ---- signup ----
    } else if (array_key_exists('signup', $_POST)) {
        $maxId = executePlainSQL("SELECT MAX(id) FROM Trainer"); // force-make unique id
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
        OCICommit($db_conn);
    }
    OCILogoff($db_conn);
} else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
}

?>