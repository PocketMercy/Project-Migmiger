<?php
session_start();
require('connect_mysql.php');
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
					echo "Welcome " .$username. "<br> <a href='logout.php'>Logout?</a>";
				} else {
					echo "<a href='loginpage.php'>Login</a><br>Dont have an account? <a href='registerpage.php'>Signup</a>";
				}
				?>
			</div>
		</div>
		
		<div class="divider"></div>
		
		<div class="navbar">
			<ul>
				<li><a class="active" href="index.php">Frontpage</a></li>
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
				<div class="post_title"><h1>{$obj->title}</h1></div>
				<div class="post_img"><img src="uploads/{$obj->billede}"></div>
				<div class="post_votes">{$obj->votes}</div>
				<div class="comment_button">
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