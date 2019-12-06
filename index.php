<?php
// Uncomment if you're having caching issues
//clearstatcache();
// Webroot use / for blank or otherwise whatever is after
// the tld on your setup
$root = dirname($_SERVER['SCRIPT_NAME']) . '/';

$path = substr($_SERVER['SCRIPT_FILENAME'], 0,
    strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
$path .= 'scripts/';
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
	</head>
	<body>
		<div id="wrapper">
			<div id="list">
				<span class="head">Snippets {}</span>
				<ul id="filelist">
					<?php
						$dirs = array();
						$files = array();

						$dir = dir($path);
						while ($entry = $dir->read()) {
						    if ($entry != '.' && $entry != '.htaccess') {
						        if (is_dir($path . $entry)) {
						            if ($entry != '..'){
						                $dirs[] = $entry;
						            }
						        } else {
						            $files[] = $entry;
						        }
						    }
						}
						$dir->close();
						unset($dir);

						sort($dirs);
						foreach ($dirs as $idir) {
							printf('<li class="dir"><img src="%s/assets/dir.png" class="diricon"/>%s<ul>', $root, $idir);
							$dir = dir($path . $idir);
							while ($entry = $dir->read()) {
								if (is_file($path . $idir . '/' . $entry)) {
									printf('<li class="snippet" href="%sscripts/%s">&#8627;%s<a href="%sscripts/%s" download><img id="download" src="%sassets/download.png" /></a></li>' . "\n", $root, $idir . '/' . $entry, $entry, $root, $idir . '/' . $entry, $root);
								}
							}
							$dir->close();
							print('</ul></li>');
						}
						sort($files);
						foreach ($files as $file) {
						    printf('<li class="snippet" href="%sscripts/%s">%s<a href="%sscripts/%s" download><img id="download" src="%sassets/download.png" /></a></li>' . "\n", $root, $file, $file, $root, $file, $root);
						}
						?>
				</ul>
			</div>
			<div id="code"><pre><code><?php
				if ($_GET['s']  != '') {
					if (file_exists('./scripts/' . $_GET['s'])) {
						$file = file_get_contents('./scripts/'.$_GET['s']);
						print str_replace('	', '  ', str_replace('<', '&lt;', $file));
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
							snippet.innerHTML = text.replace(/</g, '&lt;').replace(/	/g, '  ') + "\n\n";
							snippet.removeAttribute("class");
							hljs.highlightBlock(snippet);
							window.history.pushState('script change', 'Snippets', e.target.getAttribute("href").replace('/scripts', ''));
						});
			        }
		    	}
		    }
		</script>
	</body>
</html>
