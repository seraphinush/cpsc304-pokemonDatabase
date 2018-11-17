<html>

<head>

    <link rel="stylesheet" type="text/css" href="main.css">
    <link rel="stylesheet" type="text/css" href="./css/pokedex.css">

    <script>
        function showMyAccount(navName) {
            var div = document.getElementsByClassName(navName)[0];
            if (div.style.display == "inherit") {
                return;
            } else {
                let navNames = [
                    "welcome",
                    "myaccount",
                    "mypokemon",
                    "storage",
                    "pokedex"
                ];
                for (let i = 0, n = navNames.length; i < n; i++) {
                    let div = document.getElementsByClassName(navNames[i])[0];
                    if (navNames[i] == navName) {
                        div.style.display = "inherit";
                    } else {
                        div.style.display = "none";
                    }
                }
            }
        }
    </script>

</head>

<body>

    <div id="container">

        <!-- HEADER -->
        <div onclick="location.href='./index.php'" id="header">
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
            <div class="mypokemon">
                <p>MYPOKEMON STUB</p>
            </div>
        </div>

    </div>



</body>

</html>

<?php
$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_l8o0b", "a33250151", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executeBoundSQL($cmdstr, $list) {

	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	foreach ($list as $tuple) {
		foreach ($tuple as $bind => $val) {
			//echo $val;
			//echo "<br>".$bind."<br>";
			OCIBindByName($statement, $bind, $val);
			unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
		}
		$r = OCIExecute($statement, OCI_DEFAULT);
		if (!$r) {
			echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
			$e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
			echo htmlentities($e['message']);
			echo "<br>";
			$success = False;
		}
	}
}

function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
	//echo "<br>running ".$cmdstr."<br>";
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn); // For OCIParse errors pass the       
		// connection handle
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement); // For OCIExecute errors pass the statementhandle
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}

if ($db_conn) {
	if (array_key_exists('signup', $_POST)) {
		//Getting the values from user and insert data into the table
			$maxID = executePlainSQL("SELECT MAX(id) FROM Trainer");
			$tuple = array (
				":bind1" => $_POST['accUsername'],
				":bind2" => $_POST['accPassword'],
				":bind3" => $maxID + 1
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into Trainer values (:bind3, :bind1, :bind2)", $alltuples);
			OCICommit($db_conn);
		echo "test";
	}
}
?>
