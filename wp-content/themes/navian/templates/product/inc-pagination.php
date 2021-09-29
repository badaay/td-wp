<?php
global $wp_query;
if ( $wp_query->max_num_pages <= 1 ) return;
echo navian_pagination( $wp_query->max_num_pages );