<form class="search-form" method="get" id="searchform" action="<?php echo esc_url(home_url('/')); ?>">
	<input type="text" id="s2" class="mb0" name="s" value="<?php echo trim( get_search_query() ) ?>" placeholder="<?php esc_attr_e( 'Search...', 'navian' ); ?>" autocomplete="off" autocapitalize="off" spellcheck="false" />
	<input type="submit" value="<?php esc_attr_e( 'Search', 'navian' ); ?>" class="btn">
	<span class="search__info"><?php esc_attr_e( 'Type and hit enter to search', 'navian' ); ?></span>
</form>