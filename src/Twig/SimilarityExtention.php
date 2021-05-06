<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class SimilarityExtention extends AbstractExtension
{
	public function getFilters() {
		return array(
			new TwigFilter('similarity', array($this, 'similarityFilter'), array('is_safe' => array('html'))),
		);
	}

	public function similarityFilter($text, $input)
	{
		$terms = explode(' ', $text);
        $words = explode(' ', $input);

		foreach($terms as $i => $term) {
            foreach($words as $word){
                similar_text(strtolower($word), strtolower($term), $percent);
                if($percent >= 75 && $percent <= 85) {
                    $terms[$i] = '<span class="bg-orange text-white">'.$term.'</span>';
                } else if($percent > 85 && $percent <= 95) {
                    $terms[$i] = '<span class="bg-yellow">'.$term.'</span>';
                } else if ($percent > 95) {
                    $terms[$i] = '<span class="bg-success text-white">'.$term.'</span>';
                }
            }
		}
		$str = implode(' ', $terms);

		return $str;
	}

	public function getName() {
		return 'similarity_twig_extension';
	}

}
