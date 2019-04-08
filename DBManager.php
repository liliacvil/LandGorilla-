<?php

	function connection()
	{
    	global  $dbpdo;
        try {
        	$hostname = "localhost";
            $port = 3306;
            $dbname = "datos";
            $username = "lilia";
            $pw = "yhmj157a2";
            $dbpdo = new PDO("mysql:host=$hostname;dbname=$dbname","$username","$pw");
            $dbpdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $dbpdo;
		}
        catch (PDOException $e) {
             echo "Failed to get DB handle: " . $e->getMessage() . "\n";
             exit;
		}

	}

	
	function close($sql)
	{
		unset($dbpdo);
		unset($sql);
	}
	
	
	function selectsql($sql,$arr) {
		$dbpdo = connection();
		try{
			$q = $dbpdo->prepare($sql);
			$q->execute($arr);
		}
		catch (PDOException $e) {
			$e->getMessage();
		}
		$r = $q->fetchAll(PDO::FETCH_ASSOC);
		close($q);
		if($r) return $r[0];
	}

	
	function insertsql($sql) {
		//checktime($sql);
		$dbpdo = connection();
		try{
			$dbpdo->query($sql);
			return true;
		}
		catch (PDOException $e) {
			$e->getMessage();
		}
		$r = $dbpdo->lastInsertId();
		close($dbpdo);
		return $r;
	}

	
?>
