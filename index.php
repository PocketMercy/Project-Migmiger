<?php
session_start();
require('connect_mysql.php');
unset($_SESSION["postid"]);
?>
<html>
	<head>
		<title>GemmeGag</title>
		<link rel="stylesheet" type="text/css" href="stylesheet.css">
	</head>
	<body>
		<div class="header">
			<div class="logo">
				<p>GemmeGag</p>
			</div>
			
			<div class="loginspot">
				<?php
				if(isset($_SESSION['username']))
				{
					$username = $_SESSION['username'];
					echo "Welcome " .$username. "";
				}
				?>
			</div>
		</div>
			
		<div class="divider"></div>
		
		<div class="navbar">
			<ul>
				<li><a class="active" href="index.php">Frontpage</a></li>
				<li><a href="createpostpage.php">Create post</a></li>
				<?php
				if(isset($_SESSION['username']))
				{
					$username = $_SESSION['username'];
					echo "<li><a href='profile.php'>Profile</a></li>";
					echo "<li><a href='logout.php'>Logout</a></li>";
				} else {
					echo "<li><a href='loginpage.php'>Login</a></li>";
				}
				?>
			</ul>
		</div>	
			
			
			
		<div class="content">
			<?php
			$results = $conn->query("SELECT * FROM posts ORDER BY id DESC");
			if($results){ 
			$post = '<ul class="posts">';
			//fetch results set as object and output HTML
			while($obj = $results->fetch_object())
			{
			$post .= <<<EOT
				<li class="post">
				<form action="showpost.php" method="POST">
				<input type="hidden" name="id" value="{$obj->id}">
				<div class='post_title'><h2>{$obj->title}</h2></div>
				<div class="post_img"><img src="uploads/{$obj->billede}"></div>
				
				<div class="buttom_container">
					<div class="comment_button"><input type="submit" value="Comments"></div>
					</form>
					<form action="vote.php" method="POST">
						<div class="VoteContainer">
							<input type="hidden" name="id" value="{$obj->id}">
							<div class="votes_up"><input type="submit" name="1" value=""></div>
							<div class="post_votes">{$obj->votes}</div>
							<div class="votes_down"><input type="submit" name="0" value=""></div>
						</div>
					</form>
				</div>
				</li>
EOT;
			}
			$post .= '</ul>';
			echo $post;
			}
			
			
			?>
		</div>
	</body>
</html>