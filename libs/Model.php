<?php

class Model {

	var $DB = null;

	public function __construct()
	{
		try {
			$this->DB = new PDO("mysql:dbname=defi_noviussound;host=mysql1.lyon.novius.fr","nos_base","novius");
		} catch (PDOException $e) {
			echo 'Connexion échouée : ' . $e->getMessage();
		}
	}

	public function getAuthor($name)
	{
		$pdost = $this->DB->query("SELECT * FROM author WHERE auth_pseudo = '$name'");
		return $pdost->fetch();
	}

	public function add($data, $table)
	{
		$fields = $values = $tmp = [];
		foreach ($data as $k => $v) {
			$fields[] = $k;
			$tmp[] = ':' . $k;
			$values[':' . $k] = htmlentities($v,ENT_QUOTES, "UTF-8");
		}
		$fields = "(" . implode(',', $fields) . ")";
		$tmp = "(" . implode(',', $tmp) . ")";

		$sql = 'INSERT INTO ' . $table . ' ' . $fields . ' VALUES ' . $tmp;
		$pdost = $this->DB->prepare($sql);

		try {
			$pdost->execute($values);
			return true;
		} catch (\PDOException $e) {
			die($e->getMessage());
		}
	}

	public function getTopAuthors()
	{
		$pdost = $this->DB->query("SELECT COUNT(sound_id) as total, auth_pseudo FROM author JOIN sound ON sound_auth_id = auth_id GROUP BY auth_pseudo LIMIT 5");
		return $pdost->fetchAll();
	}

	public function getTopCat()
	{
		$pdost = $this->DB->query("SELECT COUNT(sound_id) as total, cat_label FROM sound JOIN category ON cat_id = sound_cat_id GROUP BY cat_label LIMIT 3");
		return $pdost->fetchAll();
	}

	public function getDurations()
	{
		$pdost = $this->DB->query("SELECT sound_duration_seconds as duration FROM sound LIMIT 10");
		return $pdost->fetchAll();
	}


}