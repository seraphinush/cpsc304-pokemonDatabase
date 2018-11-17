<?php
$success = true; //keep track of errors so it redirects the page only if there are no errors
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
            //echo $val;
            //echo "<br>".$bind."<br>";
            OCIBindByName($statement, $bind, $val);
            unset($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype
        }
        $r = OCIExecute($statement, OCI_DEFAULT);
        if (!$r) {
            echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
            $e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
            echo htmlentities($e['message']);
            echo "<br>";
            $success = false;
        }
    }
}

function executePlainSQL($cmdstr)
{ //takes a plain (no bound variables) SQL command and executes it
    //echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
        echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($db_conn); // For OCIParse errors pass the
        // connection handle
        echo htmlentities($e['message']);
        $success = false;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
        echo htmlentities($e['message']);
        $success = false;
    } else {

    }
    return $statement;

}

if ($db_conn) {
    if (array_key_exists('login', $_POST)) {
        $tuple = array(
            ":bind1" => $_POST['accUsername'],
            ":bind2" => $_POST['accPassword']
        );
        $alltuples = array(
            $tuple,
        );
        $result = executePlainSQL("SELECT id FROM Trainer WHERE name = ':bind1' AND password = ':bind2'");
        OCICommit($db_conn);
        if ($result && $success) {
            echo "HOORAY";
        } else {
            echo "KMS";
        }
    } else if (array_key_exists('signup', $_POST)) {
        //Getting the values from user and insert data into the table
        $maxId = executePlainSQL("SELECT MAX(id) FROM Trainer");
        
        echo "current : " . $maxId . " <br/>";
        $maxId = OCI_Fetch_Array($maxId, OCI_BOTH);
        
        echo "current : " . $maxId . " <br/>";
        echo "see if they are the same : " . $maxId[0] . "and" . $maxId["ID"];
        $maxId = $maxId[0];
        echo "current : " . $maxId;
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