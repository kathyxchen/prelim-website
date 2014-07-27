<?php
	function check($n, $a) {
		if (!$n || $n =='') {
			return $a;
		}
		else {
			return '<a href="mailto:' . $n .'">' . $a . '</a>';
		}
	}
?>