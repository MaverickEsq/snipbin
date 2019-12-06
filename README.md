		   _       _     _
	 ___ _ __ (_)_ __ | |__ (_)_ __
	/ __| '_ \| | '_ \| '_ \| | '_ \
	\__ \ | | | | |_) | |_) | | | | |
	|___/_| |_|_| .__/|_.__/|_|_| |_|
		    |_|
*A bin for snippets. Put your shitty mirc scripts in ./scripts and then be amazed as your friends can look at them while you tell them you're the new owner of hawkee.com*

# About

I wanted somewhere I could easily dump my scripts that would highlight them, but I also wanted to index them rather than a blind pastebin. Partly as a sharing platform, partly to back things up. Also something easier than making a gist, just a copy and paste.  
So, simple directory tree-based script bin it is. Uses php and javascript and naught else. You just drop it somewhere and point a url at it or have it as a subdir, it cares not. `scripts/` is where you put what you want it to display. `scripts/` can be a symlink of course.

## Things worth mentioning
It scans directories recursively so don't put any symlink loops in it or things will probably break.

Syntax highlighting is provided by highlight.js which is probably BSD license.

Dependencies are I guess php and an httpd I guess. Its fuckin javascript, its done client side.

## How to use:
Put it in your web dir. Tha-that's it.

Seriously, clone it, point a domain at it or put a symlink in your webdir. Put scripts/directories in `./scripts/` and they'll show up. Its like magic.

# Example
https://faggotry.org/snippets/

## License

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
                    Version 2, December 2004

	 Copyright (C) 2013 Max <sloth@faggotry.org>

	 Everyone is permitted to copy and distribute verbatim or modified
	 copies of this license document, and changing it is allowed as long
	 as the name is changed.

            DO WHAT THE FUCK YOU WANT TO PUBLIC LICENSE
	    
	    TERMS AND CONDITIONS FOR COPYING, DISTRIBUTION AND MODIFICATION

	    0. You just DO WHAT THE FUCK YOU WANT TO.
