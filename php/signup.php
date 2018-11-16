<?php
include 'sqlutil.php'

$db_conn = connectToDB("ora_l8o0b", "a33250151");

if ($db_conn) {
	if (array_key_exists('insertuser', $_POST)) {
		//Getting the values from user and insert data into the table
			$tuple = array (
				":bind1" => $_POST['accName'],
				":bind2" => $_POST['accPassword'],
			);
			$alltuples = array (
				$tuple
			);
			executeBoundSQL("insert into Trainers values (:bind1, :bind2)", $alltuples);
			OCICommit($db_conn);
	}
}
>