<?php

namespace Helpers;

// Надеюсь, это никто и никогда не увидит.
class Flashes {

	public static function generate(String $type, $msg): String {
		$tpl = "<div class='msg-{$type}'>";
		$tpl .= "<span class='msg-body'>{$msg}</span>";
		$tpl .= "</div>";

		return $tpl;
	}

}
