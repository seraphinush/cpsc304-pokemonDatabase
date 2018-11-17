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
        <div id="header">
            <p>CPSC304-G13's PC</p>
        </div>

        <!-- NAVIGATION -->
        <div id="nav">
            <div class="user_container">
                <div>test</div>
            </div>
            <div onclick="showMyAccount('myaccount')" class="nav-item">
                <p>MY ACCOUNT</p>
            </div>
            <div onclick="showMyAccount('mypokemon')" class="nav-item">
                <p>MY POKEMON</p>
            </div>
            <div onclick="showMyAccount('storage')" class="nav-item">
                <p>STORAGE</p>
            </div>
            <div onclick="showMyAccount('pokedex')" class="nav-item">
                <p>POKEDEX</p>
            </div>
        </div>

        <!-- CONTENT -->
        <div id="content">
            <div class="welcome">
                <p>Welcome trainer.</p>
            </div>
            <div class="myaccount"> 
                <form method="POST" target="_self"> <!-- LOGIN -->
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
            <div class="mypokemon">
                <p>MYPOKEMON STUB</p>
            </div>
            <div class="storage">
                <p>STORAGE STUB</p>
            </div>
            <div class="pokedex">
                <div id="pokedex-container">
                    <div id="pokedex-left">
                        test
                    </div>
                    <div id="pokedex-right">
                        test   
                    </div>
                </div>
            </div>
        </div>

    </div>



</body>

</html>

<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_l8o0b", "a33250151", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executeBoundSQL($cmdstr, $list) {
	/* Sometimes the same statement will be executed for several times ... only
	 the value of variables need to be changed.
	 In this case, you don't need to create the statement several times; 
	 using bind variables can make the statement be shared and just parsed once.
	 This is also very useful in protecting against SQL injection.  
      See the sample code below for how this functions is used */

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

if ($db_conn) {
	if (array_key_exists('signup', $_POST)) {
		//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['accUsername'],
				":bind2" => $_POST['accPassword'],
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into Trainer values (:bind1, :bind2)", $alltuples);
			OCICommit($db_conn);
	}
	echo "test"
}
?>