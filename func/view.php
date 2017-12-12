<?php

/**
 * This looks like a mess, and it is, but it's a powerful mess.
 * Auto-scoped $block('name') and template inheritance.
 *
 * "foo.php" child view:
 *
 * 		<?php $title = 'SEO Title'; ?>
 * 		<?php $nav = view('nav', array('links'=> $links_array))); ?>
 * 		This is the content of foo.php
 * 		<?php $extends = 'layout'; ?>
 *
 * "nav.php" view:
 *
 * 		<ul>
 * 		<?php foreach($links as $a => $link): ?>
 * 			<li><a href="<?= $a; ?>"><?= $link; ?></a></li>
 * 		<?php endif; ?>
 * 		</ul>
 *
 * Then inside 'layout.php':
 *
 * 		<?= $block('nav', '<ul>...</ul>'); ?>
 * 		<h1><?= $block('title', 'Hello World'); ?></h1>
 * 		<?= $block('content'); ?>
 * 		&copy; 2014 Company
 */
function view($file, $data = array())
{
	$__scope = $data;

	unset($data);
	$extends = $file;
	while(isset($extends)) {
		$__file = $extends;
		unset($extends, $content);

		$__v = $__scope = $__scope + array_diff_key(get_defined_vars(), array('__file'=>0, '__scope'=>0));

		$start = function($name) use(&$__v) {
			ob_start(function($buffer) use(&$name, &$__v) {
				if(empty($__v[$name])) {
					$__v[$name] = $buffer;
				}
				return $__v[$name];
			});
		};

		$end = function() {
			ob_end_flush();
		};

		$block = function($key, $default = null) use(&$__v) {
			return isset($__v[$key]) ? $__v[$key] : $default;
		};

		ob_start();
		require("templates/$__file.php");

		$content = trim(ob_get_contents());
		extract($__v, EXTR_SKIP);

		// $content is a funny variable (keep the original unless this is the last parent)
		if(isset($__v['content'])) {
			if(empty($__scope['content'])) {
				$__scope['content'] = $__v['content'];
			}
		}

		unset($__v, $__file, $block, $start, $end);
		ob_end_clean();
	}

	return $content;
}
