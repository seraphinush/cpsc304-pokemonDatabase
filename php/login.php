<?php
include 'sqlutil.php'

$success = True; //keep track of errors so it redirects the page only if there are no errors
$db_conn = connectToDB("ora_l8o0b", "a33250151");

// Connect Oracle...
if ($db_conn) {

    if (array_key_exists('login', $_POST)) {
        $myUsername = $_POST['accUsername'];
        $myPassword = $_POST['accPassword'];
        $result = executePlainSQL("SELECT id FROM trainer WHERE name = $myUsername AND password = $myPassword")
        $row = OCI_Fetch_Array($result);
        if ($row) {
            echo "Login successful !"
        }
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
?>