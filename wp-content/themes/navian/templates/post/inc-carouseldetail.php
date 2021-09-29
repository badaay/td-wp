<?php
$format = get_post_format();
if( !has_post_thumbnail() || 'quote' == $format || 'link' == $format ) return false;
get_template_part( 'templates/post/inc', 'content-boxed' );