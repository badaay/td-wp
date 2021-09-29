<?php
/**
 * VC template : Row
 */
$el_class = $disable_element = $bg_image = $bg_color = $bg_image_repeat = $font_color = $padding = $margin_bottom = $css = $full_width = $el_id = $parallax_image = $parallax = $css_animation = '';
extract( shortcode_atts( array(
	'el_class' 				=> '',
	'disable_element' 		=> false,
	'bg_image' 				=> '',
	'bg_color' 				=> '',
	'bg_image_repeat' 		=> '',
	'font_color' 			=> '',
	'padding' 				=> '',
	'margin_bottom' 		=> '',
	'full_width' 			=> false,
	'parallax' 				=> false,
	'parallax_image' 		=> false,
	'css' 					=> '',
	'css_animation' 		=> '',
	'el_id' 				=> '',
	'full_height' 			=> false,
	'tlg_background_style' 	=> 'bg-light',
	'tlg_padding' 			=> '',
	'tlg_enable_overlay' 	=> 'no',
	'tlg_bg_overlay' 		=> '',
	'tlg_bg_overlay_value'  => '',
	'tlg_bg_gradient_color' => '',
	'tlg_bg_gradient_type'  => '',
	'tlg_large_container'   => '',
	'tlg_equal_height' 		=> 'not-equal',
	'tlg_white_color' 		=> 'not-color',
	'tlg_text_align' 		=> '',
	'tlg_vertical_align' 	=> 'no',
	'tlg_parallax' 			=> 'overlay parallax',
	'tlg_bg_video_style' 	=> 'no',
	'tlg_bg_video_url' 		=> '',
	'tlg_bg_video_url_2' 	=> '',
	'tlg_bg_youtube_url' 	=> '',
), $atts ) );
wp_enqueue_script( 'wpb_composer_front_js' );
// ELEMENT CLASSES
$tlg_bg_overlay_value 	= ($tlg_bg_overlay_value != '' && $tlg_bg_overlay_value >= 0) ? $tlg_bg_overlay_value/10 : 0.85;
$tlg_bg_overlay 		= $tlg_bg_overlay ? $tlg_bg_overlay : '#000';
$tlg_padding 			= 'yes' == $full_height ? 'fullscreen' : $tlg_padding;
$video_class 			= 'video' == $tlg_bg_video_style || 'youtube' == $tlg_bg_video_style ? 'video-bg overlay z-index' : '';
$el_class 			   .= ' ' . $tlg_text_align . ' ' . $tlg_background_style . ' ' . $video_class . ' ' . $tlg_padding .' '.$tlg_equal_height.' '.$tlg_white_color . ' ' . $tlg_large_container;
$el_class 				= $this->getExtraClass( $el_class ) . $this->getCSSAnimation( $css_animation );
// ROW CLASSES
$css_classes = array(
	'vc_row',
	'wpb_row',
	//deprecated
	'vc_row-fluid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);
if ( 'yes' === $disable_element ) {
	if ( vc_is_page_editable() ) {
		$css_classes[] = 'vc_hidden-lg vc_hidden-xs vc_hidden-sm vc_hidden-md';
	} else {
		return '';
	}
}
if ( vc_shortcode_custom_css_has_property( $css, array( 'border', 'background', ) ) ) {
	$css_classes[] = 'vc_row-has-fill';
}
if ( ! empty( $atts['gap'] ) ) {
	$css_classes[] = 'vc_column-gap-' . $atts['gap'];
}
$style = $this->buildStyle( $bg_image, $bg_color, $bg_image_repeat, $font_color, $padding, $margin_bottom );
if ( ! empty( $style ) ) {
	$css_classes[] = $style;
}
preg_match_all( '#\bhttps?://[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/))#', $css, $image );
$image_class = isset($image[0][0]) ? 'image-bg z-index ' . $tlg_parallax : false;
if ( ! empty( $image_class ) ) {
	$css_classes[] = $image_class;
}
$wrapper_attributes = array();
if ( ! empty( $el_id ) ) {
	$wrapper_attributes[] = 'id="' . esc_attr( $el_id ) . '"';
}
$css_class = preg_replace( '/\s+/', ' ', apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, implode( ' ', array_filter( array_unique( $css_classes ) ) ), $this->settings['base'], $atts ) );
$wrapper_attributes[] = 'class="' . esc_attr( trim( $css_class ) ) . '"';
// BEGIN ROW
echo 'stretch_row' == $full_width ? '<div ' . implode( ' ', $wrapper_attributes ) . '>' : '<section ' . implode( ' ', $wrapper_attributes ) . '>';
// CUSTOM STYLE
$styles_overlay = '';
if( 'yes' == $tlg_enable_overlay ) {
	$styles_overlay .= 'display: block;background-color:'.$tlg_bg_overlay.';opacity:'.$tlg_bg_overlay_value.';';
	if ( $tlg_bg_gradient_color ) {
		if ('rotate' == $tlg_bg_gradient_type) {
			$styles_overlay .= 'background: linear-gradient(125deg,'.$tlg_bg_overlay.','.$tlg_bg_gradient_color.');';
		} else {
			$styles_overlay .= 'background: linear-gradient(to right,'.$tlg_bg_overlay.' 0%,'.$tlg_bg_gradient_color.' 100%);';
		}
	}
}
if ( ! empty( $styles_overlay ) ) {
	$style_overlay = 'style="' . esc_attr( $styles_overlay ) . '"';
} else {
	$style_overlay = '';
}
// CONTENT
echo 'youtube' == $tlg_bg_video_style ? '<div class="player" data-video-id="'. esc_attr($tlg_bg_youtube_url) .'" data-start-at="0"></div><div '.$style_overlay.' class="background-overlay"></div>' : '';
echo !empty($image_class) ? '<div class="background-content"><img alt="'.esc_attr( 'background' ).'" class="background-image" src="'. esc_url($image[0][0]) .'" /><div '.$style_overlay.' class="background-overlay"></div></div>' : '';
echo 'video' == $tlg_bg_video_style ? '<div class="video-background-content"><video autoplay muted loop playsinline><source src="'. esc_url($tlg_bg_video_url) .'" type="video/mp4"><source src="'. esc_url($tlg_bg_video_url_2) .'" type="video/webm"></video></div><div '.$style_overlay.' class="background-overlay"></div>' : '';
echo '<div class="'. ('stretch_row' == $full_width ? '' : ' container ') . ('fullscreen' == $tlg_padding ? ' vertical-alignment ' : '') .'"><div class="row '. ('yes' == $tlg_vertical_align ? ' vertical-flex ' : '') .'">';
echo wpb_js_remove_wpautop($content).'</div></div>';
// END ROW
echo 'stretch_row' == $full_width ? '</div>'.$this->endBlockComment('row') : '</section>'.$this->endBlockComment('row');