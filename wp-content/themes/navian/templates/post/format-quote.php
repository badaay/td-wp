<?php
$quote = get_the_content();
if ( !has_post_thumbnail() ) {
	$prefix = '<blockquote>'; 
	$sufix = '</blockquote>';
	if ( strpos($quote, 'blockquote') !== false ) $prefix = $sufix = '';
	echo wp_kses($prefix.$quote.$sufix, navian_allowed_tags());
} else {
	$prefix = '<blockquote class="blockquote blockquote-link blockquote-quote pb0 m0">'; 
	$sufix = '</blockquote>';
	if ( strpos($quote, 'blockquote') !== false ) {
		$prefix = $sufix = '';
		$quote = str_replace('<blockquote>', '<blockquote class="blockquote blockquote-quote pb0 m0">', $quote);
	}
	echo '<div class="shadow-caption mb16">';
	the_post_thumbnail( 'full', array( 'class' => 'mb0' ) );
	echo '<div class="shadow-caption-overlay"><div class="shadow-caption-inner">'.wp_kses($prefix.$quote.$sufix, navian_allowed_tags()).'</div></div></div>';
}