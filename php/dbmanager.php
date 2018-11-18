<?php
/***
* Singleton Database Manager
*
*/

final class DBManager
{
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
		$db_conn = OCILogon("ora_l8o0b", "a33250151", "dbhost.ugrad.cs.ubc.ca:1522/ug");
		return $db_conn;
	}

	private function disconnect($db_conn) {
		OCILogoff($db_conn);
	}

	private function printErrors() {
		echo "cannot connect";
		$e = OCI_Error(); // For OCILogon errors pass no handle
		echo htmlentities($e['message']);
	}

	function executeBoundSQL($cmdstr, $list)
	{
		$db_conn = $this->connect();
		$success = true;
		if ($db_conn) {
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
			$this->disconnect($db_conn);
		} else {
			$this->printErrors();
		}
	}

	function executePlainSQL($cmdstr)
	{
		$db_conn = $this->connect();
		$success = true;
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
			$this->disconnect($db_conn);
			return $statement;
		} else {
			$this->printErrors();
		}
	}
}
?>
