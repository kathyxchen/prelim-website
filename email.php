<?php
	function check($n, $a) {
		if (!$n || $n =='') {
			return $a;
		}
		else {
			return '<a class="mlink" href="mailto:' . $n .'">' . $a . '</a>';
		}
	}
?>
