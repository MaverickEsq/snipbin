<?php
$show_path = 1;
$show_dotdirs = 1;

$path = substr($_SERVER['SCRIPT_FILENAME'], 0,
    strrpos($_SERVER['SCRIPT_FILENAME'], '/') + 1);
$path .= 'scripts/';
?>
<html ml-update="aware">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1">
		<link href="assets/favicon.png" type="image/png" rel="icon">
		<title>Snippets</title>
		<link rel="stylesheet" href="assets/monokai-sublime.min.css">
		<script charset="UTF-8" src="assets/highlight.pack.js"></script>
		<script>hljs.initHighlightingOnLoad();</script>
		<link rel="stylesheet" href="assets/style.css">
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
						    if ($entry != '.') {
						        if (is_dir($entry)) {
						            if (($entry != '..') or $show_dotdirs){
						                $dirs[] = $entry;
						            }
						        } else {
						            $files[] = $entry;
						        }
						    }
						}
						$dir->close();

						sort($files);
						foreach ($files as $file) {
						    printf('<li class="snippet" href="scripts/%s">%s<a href="scripts/%s" download><img id="download" src="assets/download.png" /></a></li>' . "\n", $file, $file, $file);
						}
					?>
				</ul>
			</div>
			<div id="code"><pre><code><?php
				if ($_GET['s']  != '') {
					if (file_exists('scripts/' . $_GET['s'])) {
						$file = file_get_contents('scripts/'.$_GET['s']);
						print str_replace('<', '&lt;', $file);
					}
				} else { print 'print "hello world";'; }
				?></code></pre>
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
		            console.log(e.target.textContent + " was clicked");
		        	fetch(e.target.getAttribute("href"), {headers: new Headers({'X-Requested-With': 'XMLHttpRequest'})})
					.then(response => response.text()).then(text => {
						snippet.innerHTML = text.replace(/</g, '&lt;');
						snippet.removeAttribute("class");
						hljs.highlightBlock(snippet);
						window.history.pushState('script change', 'Snippets', '/snippets/' + e.target.textContent);
					});
		        }
		    }

		    function getUrlParam(parameter, defaultvalue){
			    var urlparameter = defaultvalue;
			    if(window.location.href.indexOf(parameter) > -1){
			        urlparameter = getUrlVars()[parameter];
			        }
			    return urlparameter;
			}

		</script>
	</body>
</html>