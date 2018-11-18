<?php
/***
* Singleton Database Manager
*
*/

final class DBManager
{
	
	$UNIXUSER = "ora_l8o0b";
	$UNIXPASS = "a33250151";
	$db_conn;
	$success;
	/*
	* Call this method to access Singleton. Like this:
	* $yourVariable = DBManager::Instance();
	*/
	public static function Instance()
	{
		static $inst = null;
		if ($inst === null) {
			$inst = new DBManager();
		}
		return $inst;
	}

	/*
	* Privatized constructor so this remains a Singleton
	*/
	private function __construct() {}

	private function connect() {
		global $db_conn;
		$db_conn = OCILogon($UNIXUSER, $UNIXPASS, "dbhost.ugrad.cs.ubc.ca:1522/ug");
	}

	private function disconnect() {
		global $db_conn;
		OCILogoff($db_conn);
	}

	private function printErrors() {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}

	function executeBoundSQL($cmdstr, $list)
	{
		connect();
		global $db_conn, $success;
		if (db_conn) {
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
			OCICommit($db_conn);
			disconnect();
		} else {
			printErrors();
		}
	}

	function executePlainSQL($cmdstr)
	{
		connect();
		global $db_conn, $success;
		if ($db_conn) {
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
			OCICommit($db_conn);
			disconnect();
			return $statement;
		} else {
			printErrors();
		}
	}
}
?>