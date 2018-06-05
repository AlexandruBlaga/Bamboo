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

	 		 <div class="posts-area"></div>
	 		 <img id="loading" src="assets/images/icons/loading.gif">
 	</div>

 	<script>
 		

 		$(document).ready(function() {

 			var userLoggedIn = '<?php echo $userLoggedIn; ?>';

 			$('#loading').show();

 			//original ajax request for loading first posts
 			$.ajax({
 				url: "includes/handlers/ajax-load-posts.php",
 				type: "POST",
 				data: "page=1&userLoggedIn=" + userLoggedIn, //request
 				cache: false,

 				success: function(data) {
 					$("#loading").hide();
 					$('.posts-area').html(data);
 				}
			});
			$(window).on('scroll', function() {
				var height = $('.posts-area').height(); //Div containing posts
				var scroll_top = $(this).scrollTop();
				var page = $('.posts-area').find('.nextPage').val();
				var noMorePosts = $('.posts-area').find('.noMorePosts').val();

				if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false')
			    {
					$('#loading').show();

					var ajaxReq = $.ajax({
						url: "includes/handlers/ajax-load-posts.php",
						type: "POST",
						data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
						cache: false,

						success: function(response) {
							$('.posts-area').find('.nextPage').remove(); //Removes current .nextpage 
							$('.posts-area').find('.noMorePosts').remove(); //Removes current .nextpage 

							$('#loading').hide();
							$('.posts-area').append(response);
						}
					});

				} //End if 

				//return false;

			}); //End (window).scroll(function())

 		});

 	</script>
 </div>
</body>
</html>