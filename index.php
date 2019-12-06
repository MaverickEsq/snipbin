<?php
// Uncomment if you're having caching issues
//clearstatcache();
?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<link href="<?= $root ?>assets/favicon.png" type="image/png" rel="icon">
		<title>Snippets</title>
		<link rel="stylesheet" href="<?= $root ?>assets/monokai-sublime.min.css">
		<script charset="UTF-8" src="<?= $root ?>assets/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad();</script>
		<link rel="stylesheet" href="<?= $root ?>assets/style.css">
		<script>
			function toggle(e) {
			  if (e.getElementsByTagName("UL")[0].style.display === "none") {
			    e.getElementsByTagName("UL")[0].style.display = "block";
			  } else {
			    e.getElementsByTagName("UL")[0].style.display = "none";
			  }
			}
		</script>
	</head>
	<body>
		<div id="wrapper">
			<div id="list">
				<span class="head">Snippets {}</span>
				<ul id="filelist">
					<?php
						function dirlist($path) {
							$root = dirname($_SERVER['SCRIPT_NAME']) . '/';
							$entries = array_slice(scandir($path), 2);
							foreach ($entries as $entry) {
							    if (is_dir($path . $entry) && $entry != '..' && $entry != '.') {
							    	printf('<li class="dir" onclick="toggle(this)"><img src="%sassets/dir.png" class="diricon"/>%s<ul>', $root, $entry);
							    	dirlist($path . $entry . '/');
							    	print('</ul></li>');
							    }
							}
							foreach ($entries as $entry) {
								if (is_file($path . $entry)) {
						        	if ($entry != '.htaccess') {
						            	printf('<li class="snippet" href="%s">%s<a href="%s" download><img id="download" src="%sassets/download.png" /></a></li>' . "\n", $root . $path . $entry, $entry, $root . $path . $entry, $root);
						            }
							    }
							}
						}
						dirlist('scripts/');

						?>
				</ul>
				<span class="brand"><a href="https://github.com/MaverickEsq/snipbin">snipbin by <img src="<?= $root ?>assets/favicon.ico"></a></span>
			</div>
			<div id="code"><pre><code><?php
				if ($_GET['s']  != '') {
					if (file_exists('./scripts/' . $_GET['s'])) {
						$file = file_get_contents('./scripts/'.$_GET['s']);
						print str_replace('	', '  ', str_replace('<', '&lt;', $file));
					} else {
						print "File not found";
					}
				} else { print 'print "hello world";'; }
				?>
				</code>

				</pre>
			</div>
		</div>
		<script type="text/javascript">
			// set 'snippet' as the pre in code in div with class code
			let snippet = document.querySelector('#code pre code');
		    // locate your element and add the Click Event Listener
		    document.getElementById('filelist').addEventListener("click", changeScript);
		    function changeScript(e) {
		        // e.target is our targetted element.
		        // try doing console.log(e.target.nodeName), it will result LI
		        if(e.target && e.target.nodeName == "LI") {
		        	if (e.target.getAttribute("class") != 'dir') {
			            console.log(e.target.textContent + " was clicked");
			        	fetch(e.target.getAttribute("href"), {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})})
						.then(response => response.text()).then(text => {
							snippet.innerHTML = text.replace(/</g, '&lt;').replace(/	/g, '  ') + "\n\n\n";
							snippet.removeAttribute("class");
							hljs.highlightBlock(snippet);
							window.history.pushState('script change', 'Snippets', e.target.getAttribute("href").replace('scripts/', ''));
						});
			        }
		    	}
		    }
		</script>
	</body>
</html>
