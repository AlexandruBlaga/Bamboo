<?php 
	class Post 
	{
		private $user_obj;
		private $con;

		public function __construct($con, $user)
		{
			$this->con = $con;
			$this->user_obj = new User($con, $user);
		}

		public function submitPost($body, $user_to)
		{
			$body = strip_tags($body); // removes html tags
			$body = mysqli_real_escape_string($this->con, $body);
			$check_empty = preg_replace('/\s+/', "", $body); //replace spaces with nothing

			if($check_empty != "")
			{
				// current date and time

				$date_added = date("Y-m-d H:i:s");
				// get username
				$added_by = $this->user_obj->getUsername();

				//if user is on own profile, user_to is 'none'
				if($user_to == $added_by)
				{
					$user_to = 'none';
				}

				//insert post to db
				$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
				$returned_id = mysqli_insert_id($this->con);

				//Insert notification

				//Update post count for user
				$num_posts = $this->user_obj->getNumPosts();
				$num_posts++;
				$update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");

			}
		}

		public function loadPostsFriends($data, $limit)
		{
			$page = $data['page'];
			$userLoggedIn = $this->user_obj->getUsername();

			if($page == 1)
			{
				$start = 0; // start at the first item of the table
			}
			else 
			{
				$start = ($page - 1) * $limit;
			}

			$str = ""; //string to return;
			$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

			if(mysqli_num_rows($data_query) > 0)
			{

				$num_iterations = 0; //number of results checked (not necasserily posted)
				$count = 1;

				while($row = mysqli_fetch_array($data_query))
				{
					$id = $row['id'];
					$body = $row['body'];
					$added_by = $row['added_by'];
					$date_time = $row['date_added'];

					//prepare user_to string so it can be included even if not posted to a user
					if($row['user_to'] == 'none')
					{
						$user_to = "";
					} 
					else {
						$user_to_obj = new User($this->con, $row['user_to']);
						$user_to_name = $user_to_obj->getFirstAndLastName();
						$user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
					}

					//check if the user who posted has their account closed
					$added_by_obj = new User($this->con, $added_by);
					if($added_by_obj->isClosed())
					{
						continue;
					}

					if($num_iterations++ < $start)
					{
						continue;
					}

					//once 10 posts have been loaded break
					if($count > $limit)
					{
						break;
					}
					else
					{
						$count++;
					}

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];

					//timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //time of post
					$end_date = new DateTime($date_time_now);//current time
					$interval = $start_date->diff($end_date);//difference between dates

					if($interval->y >= 1) //1year over
					{
						if($interval == 1)
						{
							$time_message = $interval->y . " year ago"; //1year ago
						}
						else
						{
							$time_message = $interval->y . " years ago"; //1+ years ago
						}
					}
					else if($interval->m >= 1) 
					{
						if($interval->d == 0)
						{
							$days = " ago"; // 1month ago
						}
						else if($interval->d == 1)
						{
							$days = $interval->d . " day ago"; // 1 month 1 day ago
						}
						else 
						{
							$days = $interval->d . " days ago"; // 1 month x days ago
						}

						if($interval->m == 1)
						{
							$time_message = $interval->m . " month". $days; // 1 month ago
						}
						else 
						{
							$time_message = $interval->m . " months". $days; // x monhs ago
						}

					}

					else if($interval->d >= 1)
					{
						if($interval->d == 1)
						{
							$time_message = "Yesterday"; //yesterday
						}
						else 
						{
							$time_message = $interval->d . " days ago"; // x days ago
						}
					}
					else if($interval->h >= 1)
					{
						if($interval->h == 1)
						{
							$time_message = $interval->h . " hour ago"; // 1 hour ago
						}
						else 
						{
							$time_message= $interval->h . " hours ago"; // x hours ago
						}
					}
					else if($interval->i >= 1)
					{
						if($interval->i == 1)
						{
							$time_message = $interval->i . " minute ago"; // 1 minute ago
						}
						else 
						{
							$time_message= $interval->i . " minutes ago"; // x minutes ago
						}
					}
					else
					{
						if($interval->s < 30)
						{
							$time_message = "Just now"; // less than 30s
						}
						else 
						{
							$time_message= $interval->s . " seconds ago"; // x seconds ago
						}
					}

					$str .= "<div class='status-post'>
								<div class='post-profile-pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted-by' style='color:#ACACAC;'>
									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
								</div>

								<div id='post-body'>
									$body
									<br>
								</div>
							</div>
							<hr>";
			    }

			    if($count>$limit)
			    {
			    	$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
			    				<input type='hidden' class='noMorePosts' value='false'>";
			    }
			    else
			    {
			    	$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align:center;>No more posts to show!</p>";
			    }
			}
		    echo $str;
		}
	}
 ?>