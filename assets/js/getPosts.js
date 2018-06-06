(function(){
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';

	document.getElementById('loading').style.display = 'block';

	//original ajax request for loading first posts
	let ajax = new XMLHttpRequest(),
		data = "page=1&userLoggedIn="+userLoggedIn,
		method = 'POST',
		url = 'includes/handlers/ajax-load-posts.php';

	ajax.open(method, url, true);
	ajax.onreadystatechange = function(){
		if(ajax.readyState === 4 && ajax.status === 200){
			document.getElementById('loading').style.display = 'none';
			document.getElementById('posts-area').innerHTML = ajax.responseText;
		}
	};
	ajax.send(`page=1&userLoggedIn=${userLoggedIn}`);

	window.onscroll = function(){
		
		let height = document.getElementById('posts-area').outerHeight,
			scrollTop = this.scrollY,
			page = document.getElementsByClassName('nextPage')[0].innerHTML,
			noMorePosts = document.getElementsByClassName('noMorePosts')[0].innerHTML;
		
		if((document.body.scrollHeight === document.body.scrollTop + window.innerHeight) && noMorePosts === false){
			document.getElementById('loading').style.display = 'block';
			let ajax = new XMLHttpRequest(),
				method = 'POST',
				url = 'includes/handlers/ajax-load-posts.php';
			ajax.open(method, url, true);
			ajax.onreadystatechange = function(){
				if(ajax.readyState === 4 && ajax.status === 200){
					
					document.getElementById('loading').style.display = 'none';
					
					let elem1 = document.getElementsByClassName('nextPage')[0],
						elem2 = document.getElementsByClassName('noMorePosts')[0];
					
					elem1.parentNode.removeChild(elem1);
					elem2.parentNode.removeChild(elem2);
					
					document.getElementById('posts-area').appendChild(ajax.responseText);
					
				}
			}
			ajax.send(`page=${page}&userLoggedIn=${userLoggedIn}`);
		}
	}
})();