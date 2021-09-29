<?php
/**
 * Theme shortcodes
 *
 * @package TLG Framework
 *
 */

if (! function_exists('tlg_framework_shortcode_dropcap')) {
	function tlg_framework_shortcode_dropcap($atts) 
	{
		extract(shortcode_atts(array(
			'text' => '',
			'background' => '',
			'color' => '',
			'border' => '',
			'round' => '',
		), $atts ));
		$dropcap_css = 'yes' == $round ? 'border-radius:50%;' : '';
		$dropcap_css .= $color ? 'color:'.$color.';' : '';
		$dropcap_css .= $border ? 'border:1px solid '.$border.';' : '';
		$dropcap_css .= $background ? 'background:'.$background.';font-size: 200%;width: 2em;height: 2em;line-height: 2;' : '';
		return '<span class="tlg_dropcap" style="'.esc_attr($dropcap_css).'">'. $text .'</span>';
	}
	add_shortcode( 'tlg_dropcap', 'tlg_framework_shortcode_dropcap' );
}

if (! function_exists('tlg_framework_shortcode_highlight')) {
	function tlg_framework_shortcode_highlight($atts) 
	{
		extract(shortcode_atts(array(
			'text' => '',
			'background' => '#1e1e1e',
			'color' => '#fff',
		), $atts ));
		return '<span style="padding: 3px 6px;border-radius: 4px;background:'.esc_attr($background).';color:'.esc_attr($color) .'">'. $text .'</span>';
	}
	add_shortcode( 'tlg_highlight', 'tlg_framework_shortcode_highlight' );
}

if (! function_exists('tlg_framework_shortcode_block')) {
	function tlg_framework_shortcode_block($atts) 
	{
		extract(shortcode_atts(array(
			'text' => '',
			'background' => '#bbb',
			'color' => '#565656',
			'caption' => '',
			'style' => '',
		), $atts ));
		if ( 'legend' == $style ) {
			$output = '<div style="border: 4px double '.esc_attr($background).';color:'.esc_attr($color) .';margin: 3em 0;padding: 30px;"><h4 class="legend" style="font-size: 16px;color:'.esc_attr($background).';float: left;left: 11px; line-height: 18px; margin: 0 0 -9px !important; padding: 0 10px; position: relative; text-transform: uppercase; top: -41px;">'.$caption.'</h4><p style="clear: both;margin: 7px;">'. $text .'</p></div>';
		} else {
			$output = '<div class="mb16" style="padding: 30px;background:'.esc_attr($background).';color:'.esc_attr($color) .'"><h5 style="color:'.esc_attr($color) .';margin-bottom:8px;">'.$caption.'</h5>'. $text .'</div>';
		}
		return $output;
	}
	add_shortcode( 'tlg_block', 'tlg_framework_shortcode_block' );
}

if (! function_exists('tlg_framework_shortcode_counttime')) 
{
	function tlg_framework_shortcode_counttime($atts) 
	{
		extract(shortcode_atts(array(
			'date' => '',
			'caption_day' => esc_html__( 'days', 'tlg_framework' ),
		), $atts ));
		return '<div class="countdown" data-date="'. esc_attr($date) . '" data-day="'. esc_attr($caption_day) .'"></div>';
	}
	add_shortcode( 'tlg_counttime', 'tlg_framework_shortcode_counttime' );
}