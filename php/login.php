<?php

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = OCILogon("ora_v9m8", "a38134110", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executePlainSQL($cmdstr) {
	global $db_conn, $success;
	$statement = OCIParse($db_conn, $cmdstr);

	if (!$statement) {
		echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
		$e = OCI_Error($db_conn);
		echo htmlentities($e['message']);
		$success = False;
	}

	$r = OCIExecute($statement, OCI_DEFAULT);
	if (!$r) {
		echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
		$e = oci_error($statement);
		echo htmlentities($e['message']);
		$success = False;
	} else {

	}
	return $statement;

}

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
			OCIBindByName($statement, $bind, $val);
			unset ($val);
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

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Name</th><th>Age</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] . "</td><td>" . $row["AGE"] . "</td></tr>"; //or just use "echo $row[0]" 
	}
	echo "</table>";

}

// Connect Oracle...
if ($db_conn) {

	if (array_key_exists('reset', $_POST)) {
		// Drop old table...
		echo "<br> dropping table <br>";
		executePlainSQL("Drop table tab1");

		// Create new table...
		echo "<br> creating new table <br>";
		executePlainSQL("create table tab1 (nid number, name varchar2(30), age number, primary key (nid))");
		OCICommit($db_conn);

	} else
		if (array_key_exists('insertsubmit', $_POST)) {
			//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['insNo'],
                ":bind2" => $_POST['insName'],
                ":bind3" => $_POST['insAge']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into tab1 values (:bind1, :bind2, :bind3)", $alltuples);
			OCICommit($db_conn);

		} else if (array_key_exists('updatename', $_POST)) {
			// Update tuple using data from user
			$tuple = array (
				":bind1" => $_POST['oldName'],
				":bind2" => $_POST['newName']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
			OCICommit($db_conn);
		// ---- ---- ---- ---- ---- ---- ---- ----
		// STUDENT CODE FOR CPSC304-T8, STEP 4
		// ---- ---- ---- ---- ---- ---- ---- ----
        } else if (array_key_exists('updateage', $_POST)) {
			// Update tuple using data from user
			$tuple = array (
				":bind1" => $_POST['name'],
				":bind2" => $_POST['newAge']
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("UPDATE tab1 SET age=:bind2 WHERE name=:bind1", $alltuples);
			OCICommit($db_conn);
		// ---- ---- ---- ---- ---- ---- ---- ----
		// STUDENT CODE FOR CPSC304-T8, STEP 4
		// ---- ---- ---- ---- ---- ---- ---- ----
		} else if (array_key_exists('deleteid', $_POST)) {
			$myId = $_POST['id'];
			executePlainSQL("DELETE FROM tab1 WHERE nid=$myId");
			OCICommit($db_conn);
		} else if (array_key_exists('dostuff', $_POST)) {
			// Insert data into table...
			executePlainSQL("insert into tab1 values (10, 'Frank', 20)");
			// Inserting data into table using bound variables
			$list1 = array (
				":bind1" => 6,
				":bind2" => "All",
				":bind3" => 21
			);
			$list2 = array (
				":bind1" => 7,
				":bind2" => "John",
				":bind3" => 22
			);
			$allrows = array (
				$list1,
				$list2
			);
			executeBoundSQL("insert into tab1 values (:bind1, :bind2, :bind3)", $allrows); //the function takes a list of lists
			// Update data...
			//executePlainSQL("update tab1 set nid=10 where nid=2");
			// Delete data...
			//executePlainSQL("delete from tab1 where nid=1");
			OCICommit($db_conn);
		}

	if ($_POST && $success) {
		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
		header("location: oracle-test-t8-4.php");
	} else {
		// Select data...
		$result = executePlainSQL("select * from tab1");
		printResult($result);
	}

	//Commit to save changes...
	OCILogoff($db_conn);
} else {
	echo "cannot connect";
	$e = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($e['message']);
}

/* OCILogon() allows you to log onto the Oracle database
     The three arguments are the username, password, and database.
     You will need to replace "username" and "password" for this to
     to work. 
     all strings that start with "$" are variables; they are created
     implicitly by appearing on the left hand side of an assignment 
     statement */
/* OCIParse() Prepares Oracle statement for execution
      The two arguments are the connection and SQL query. */
/* OCIExecute() executes a previously parsed statement
      The two arguments are the statement which is a valid OCI
      statement identifier, and the mode. 
      default mode is OCI_COMMIT_ON_SUCCESS. Statement is
      automatically committed after OCIExecute() call when using this
      mode.
      Here we use OCI_DEFAULT. Statement is not committed
      automatically when using this mode. */
/* OCI_Fetch_Array() Returns the next row from the result data as an  
     associative or numeric array, or both.
     The two arguments are a valid OCI statement identifier, and an 
     optinal second parameter which can be any combination of the 
     following constants:

     OCI_BOTH - return an array with both associative and numeric 
     indices (the same as OCI_ASSOC + OCI_NUM). This is the default 
     behavior.  
     OCI_ASSOC - return an associative array (as OCI_Fetch_Assoc() 
     works).  
     OCI_NUM - return a numeric array, (as OCI_Fetch_Row() works).  
     OCI_RETURN_NULLS - create empty elements for the NULL fields.  
     OCI_RETURN_LOBS - return the value of a LOB of the descriptor.  
     Default mode is OCI_BOTH.  */
?>