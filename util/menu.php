<pre>
<?
	include("connect.php");

	$debug = true;

	$result = $mysqli -> query("select * from categories where parent is null");
	$total = mysqli_num_rows($result);
	$categories = array();

	for ($i = 0; $i < $total; $i++) {
		$row = mysqli_fetch_row($result);

		array_push($categories, array(
			"name" => $row[1],
			"id" => $row[0],
			"parent" => $row[2],
			"depth" => $depth,
			"children" => array()
		));
	}

	function organize($id) {
		global $mysqli;
		$result = $mysqli -> query("select * from categories where parent = {$id}");
		if ($result == false) {
			return array();
		}
		$row_count = mysqli_num_rows($result);
		$data = array();
		for ($i = 0; $i < $row_count; $i++) {
			$row = mysqli_fetch_row($result);

			array_push($data, array(
				"name" => $row[1],
				"id" => $row[0],
				"parent" => $row[2],
				"depth" => $depth,
				"children" => array()
			));
		}

		return $data;
	}

	function recurseOnCategory(array &$category) {
		$category["children"] = organize($category["id"]);
		$depth = 1;
		foreach ($category["children"] as $key => &$value) {
			$newDepth = recurseOnCategory($value) + 1;
			if ($newDepth > $depth) {
				$depth = $newDepth;
			}
		}

		$category["depth"] = $depth;
		return $depth;
	}

	foreach($categories as &$category) {
		recurseOnCategory($category);
	}

	if ($debug) {
		print_r($categories);
	}

	include("close.php");
?>
</pre>