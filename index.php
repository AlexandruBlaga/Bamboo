<?php 
	include("includes/header.php");
	include("includes/classes/User.php");
	include("includes/classes/Post.php");

	if(isset($_POST['post']))
	{
		$post = new Post($con, $userLoggedIn);
		$post->submitPost($_POST['post-text'], 'none');
	}
 ?>
 	<div class="user-details column">
 		<a href="<?php echo $userLoggedIn; ?>">
 			<img src="<?php echo $user['profile_pic']; ?>">
 		</a>
 		<div class="user-details-left-right">
	 		<a href="<?php echo $userLoggedIn; ?>">
		 		<?php 
		 			echo $user['first_name'] . " " . $user['last_name'];
		 	    ?>
	 	    </a>
	 	    <br>
	 	    <?php echo "Posts: " . $user['num_posts'] . "<br>"; 
	 	    	  echo "Likes: " . $user['num_likes'];
	 	    ?>
 	    </div>
 	</div>
 	<div class="main-column column">
		<form class="post-form" action="index.php" method="POST">
			<textarea name="post-text" id="post-text" placeholder="Got something to say?"></textarea>
			<input type="submit" name="post" id="post-button" value="Post">
			<hr>
		</form>
		<div id="posts-area">
			
		</div>
		<img id="loading" src="assets/images/icons/loading.gif">
 	</div>
 	<script src="assets/js/getPosts.js"></script>
 	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.1/js/bootstrap.min.js"></script>
 </div>
</body>
</html>