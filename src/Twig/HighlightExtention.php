<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class HighlightExtention extends AbstractExtension
{
	public function getFilters() {
		return array(
			new TwigFilter('highlight', array($this, 'highlightFilter'), array('is_safe' => array('html'))),
		);
	}

	public function highlightFilter($text, $words)
	{
		if (!is_array($words)) $words = [ $words, ];
		$highlight = array();
		foreach($words as $word) {
			$highlight[]= '<span class="bg-warning">'.$word.'</span>';
		}
		return str_ireplace($words, $highlight, $text);
	}

	public function getName() {
		return 'highlight_twig_extension';
	}

}
