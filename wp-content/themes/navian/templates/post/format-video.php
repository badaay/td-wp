<?php
global $shortcode_tags;
$theme_shortcode_tags = $shortcode_tags;
$shortcode_tags = array(
    'video' => $theme_shortcode_tags['video'],
    'embed' => $theme_shortcode_tags['embed']
);
$video_regex = '#' . get_shortcode_regex() . '#i';
$shortcode_tags = $theme_shortcode_tags;
$pattern_array = array( $video_regex );
if ( ! function_exists( '_wp_oembed_get_object' ) ) {
    include ABSPATH . WPINC . '/class-oembed.php';
}
$oembed = _wp_oembed_get_object();
$pattern_array = array_merge( $pattern_array, array_keys( $oembed->providers ) );
$pattern = '#(' . array_reduce( $pattern_array, function ( $carry, $item ) {
    if ( strpos( $item, '#' ) === 0 ) {
        $item = substr( $item, 1, -2 );
    } else {
        $item = str_replace( '*', '(.+)', $item );
    }
    return $carry ? $carry . ')|('  . $item : $item;
} ) . ')#is';
$lines = explode( "\n", get_the_content() );
foreach ( $lines as $line ) {
    $line = trim( $line );
    if ( preg_match( $pattern, $line, $matches ) ) {
        echo '<div class="clearfix video-embed-container">';
        if ( strpos( $matches[0], '[' ) === 0 ) {
            echo do_shortcode( $matches[0] );
        } else {
            echo wp_oembed_get( $matches[0] );
        }
        echo '</div>';
    }
}