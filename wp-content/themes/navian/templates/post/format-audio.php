<?php
if (has_post_thumbnail()) {
	the_post_thumbnail( 'full', array( 'class' => 'mb0' ) );
}
$reg = preg_match('#^(<p>)?.*(https?://.*/.*\.mp3).*(</p>|<br />)?#im', get_the_content(), $matches );
if (isset($matches[2])) {
	echo '<div class="clearfix mt--30">'.wp_audio_shortcode( array( 'src' => $matches[2], 'loop' => '', 'autoplay' => '', 'preload' => 'auto' ) ).'</div>';
}