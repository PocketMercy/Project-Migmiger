<?php
session_start();
unset($_SESSION["postid"]);
include("connect_mysql.php");


if(isset($_SESSION['username']))
{
	$postid = $_POST["id"];
	$brugerid = $_SESSION["id"];
	$vote1 = 1;
	$vote2 = -1;
	
	$sql = "SELECT vote FROM votes WHERE post_id = '$postid' AND bruger_id = '$brugerid'";
    $result = mysqli_query($conn, $sql);

	if($stmt = $conn->prepare("SELECT votes FROM posts WHERE id=?"))
	{
		$stmt->bind_param("i", $postid);
		$stmt->execute();
		$stmt->bind_result($votes);
		$stmt->fetch();
		$stmt->close();
	}else{
		echo "Could not prepare sql statement 3";
	}
	
	if(isset($_POST["1"]))
	{
		if (mysqli_num_rows($result) == 1)
		{
			$row = mysqli_fetch_assoc($result);
			if($row["vote"] == 1)
			{
				if($stmt = $conn->prepare("DELETE FROM votes WHERE post_id=? AND bruger_id=?"))
				{
					$stmt->bind_param("ii", $postid, $brugerid);
					$stmt->execute();
					$stmt->close();
					$votes = $votes - 1;
				} else {
					echo "Could not prepare sql statement 5";
				}
			}
			elseif($row["vote"] == -1)
			{
				if($stmt = $conn->prepare("UPDATE votes SET vote=? WHERE post_id=? AND bruger_id=?"))
				{
					$stmt->bind_param("iii", $vote1, $postid, $brugerid);
					$stmt->execute();
					$stmt->close();
					$votes = $votes + 2;
				} else {
					echo "Could not prepare sql statement 6";
				}
			}
		}else{
			if($stmt = $conn->prepare("INSERT INTO votes (post_id, bruger_id, vote) VALUES (?,?,?)"))
			{
				$stmt->bind_param("iii", $postid, $brugerid, $vote1);
				$stmt->execute();
				$stmt->close();
				$votes = $votes + 1;
			} else {
				echo "Could not prepare sql statement 7";
			}
		}
		
	}
	elseif(isset($_POST["0"]))
	{
		if (mysqli_num_rows($result) == 1)
		{
			$row = mysqli_fetch_assoc($result);
			if($row["vote"] == -1)
			{
				if($stmt = $conn->prepare("DELETE FROM votes WHERE post_id=? AND bruger_id=?"))
				{
					$stmt->bind_param("ii", $postid, $brugerid);
					$stmt->execute();
					$stmt->close();
					$votes = $votes + 1;
				} else {
					echo "Could not prepare sql statement 8";
				}
			}
			elseif($row["vote"] == 1)
			{
				if($stmt = $conn->prepare("UPDATE votes SET vote=? WHERE post_id=? AND bruger_id=?"))
				{
					$stmt->bind_param("iii", $vote2, $postid, $brugerid);
					$stmt->execute();
					$stmt->close();
					$votes = $votes - 2;
				} else {
					echo "Could not prepare sql statement 9";
				}
			}
		}else{
			if($stmt = $conn->prepare("INSERT INTO votes (post_id, bruger_id, vote) VALUES (?,?,?)"))
				{
					$stmt->bind_param("iii", $postid, $brugerid, $vote2);
					$stmt->execute();
					$stmt->close();
					$votes = $votes - 1;
				} else {
					echo "Could not prepare sql statement 10";
				}
		}
		
	}
	if($stmt = $conn->prepare("UPDATE posts SET votes=? WHERE id=?"))
	{
		$stmt->bind_param("ii", $votes, $postid);
		$stmt->execute();
		$stmt->close();
		
		header("Location: index.php");
	} else {
		echo "Could not prepare sql statement 4";
	}
}
?>