<html>

<head>

    <link rel="stylesheet" type="text/css" href="../main.css">

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
                <form method="POST" name="accForm" onsubmit="return validateAccForm()" target="_self">
                    <span>USERNAME</span>
                    <input type="text" name="accUsername" size="10">
                    <br />
                    <span>PASSWORD</span>
                    <input type="text" name="accPassword" size="10">
                    <br /><br />
                    <input type="submit" value="Login" name="login">&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="submit" value="Sign up" name="signup">
                </form>
                <br />
                <p id="loginresult">
                    &nbsp;
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
                                new Exception("<br/>Cannot parse the following command: " . $cmdstr . "<br/>" . $e['message']);
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
                                    new Exception("<br/>Cannot execute the following command: " . $cmdstr . "<br/>" . $e['message']);
                                }
                            }
                            return $statement;

                        }

                        function executePlainSQL($cmdstr)
                        {
                            global $db_conn, $success;
                            $statement = OCIParse($db_conn, $cmdstr);
                            if (!$statement) {
                                $e = OCI_Error($db_conn); // handle error in $statement
                                $success = false;
                                new Exception("<br/>Cannot parse the following command: " . $cmdstr . "<br/>" . $e['message']);
                            }
                            $r = OCIExecute($statement, OCI_DEFAULT);
                            if (!$r) {
                                $e = OCI_Error($statement); // handle error in $statement
                                $success = false;
                                new Exception("<br/>Cannot execute the following command: " . $cmdstr . "<br/>" . $e['message']);
                            } else {
                            }
                            return $statement;

                        }

                        if ($db_conn) {
                            // ---- login ----
                            if (array_key_exists('login', $_POST)) {
                                $name = $_POST['accUsername'];
                                $pass = $_POST['accPassword'];
                                $result;
                                try {
                                    $result = executePlainSQL("SELECT id, name, password FROM Trainer WHERE name='$name' AND password='$pass'");
                                    if ($result && $success) {
                                        echo "<font color='56B4E9'>Successful.</font>";
                                    } else {
                                        echo "<font color='E69F00'>Unsuccessful.</font>";;
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
                                    $result = executeBoundSQL("insert into Trainer values (:bind1, :bind2, :bind3)", $alltuples);
                                    if ($result && $success) {
                                        echo "<font color='56B4E9'>Successful.</font>";
                                    } else {
                                        echo "<font color='E69F00'>Name is already taken.</font>";;
                                    }
                                    OCICommit($db_conn);
                                } catch (Exception $e) {
                                    echo htmlentities($e['message']);
                                }
                            }
                            OCILogoff($db_conn);
                        } else {
                            echo "cannot connect";
                            $e = OCI_Error(); // For OCILogon errors pass no handle
                            echo htmlentities($e['message']);
                        }
                    ?>
                </p>
            </div>
        </div>
    </div>
</body>
</html>