<?php 
	$c = oci_connect("hr", "hr", "localhost/XE");
	if (!$c) {		//username,password,local server
		$e = oci_error();
		trigger_error('Could not connect to database: '.$e['message'],E_USER_ERROR);
	}				//Oracle Connection
	$s = oci_parse($c, "select * from employees");
	if (!$s) {			//SQL Query
		$e = oci_error();
		trigger_error('Could not parse statement: '.$e[',message'],E_USER_ERROR);
	}
	$r = oci_execute($s);
	if (!$r) {
		$e = oci_error($s);
		trigger_error('Could not execute statement: '.$e['message'],E_USER_ERROR);
	}
	echo "<table border = '1'>\n";
	$ncols = oci_num_fields($s); //Fields == Columns
	echo "<tr>\n";
	for ($i=1; $i < $ncols; ++$i) { //$s = SQL, $i = Column
		$colname = oci_field_name($s, $i);
		echo "<th><b>".htmlentities($colname,ENT_QUOTES)."</b></th>\n";
	}
	echo "</tr>\n";				//$s = SQL
	while (($row = oci_fetch_array($s,OCI_ASSOC+OCI_RETURN_NULLS))!=FALSE) {
		echo "<tr>\n";
		foreach ($row as $item) {
			echo "<td>".($item!==null?htmlentities($item,ENT_QUOTES):"&nbsp;")."</td>\n";
		}
		echo "</tr>\n";
	}
	echo "</table>\n";
 ?>