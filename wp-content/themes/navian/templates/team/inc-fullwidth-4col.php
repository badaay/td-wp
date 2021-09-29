<?php 
$team_url = get_post_meta( $post->ID, '_tlg_team_url', 1 );
$team_about = get_post_meta( $post->ID, '_tlg_team_about', 1 );
$team_position = get_post_meta( $post->ID, '_tlg_team_position', 1 );
?>
<div class="col-md-3 col-sm-6 p0 org-col team-member">
    <div class="single-member">
        <?php the_post_thumbnail('full'); ?>
        <div class="team-caption">
            <div class="team-inner">
                <h3 class="team-title">
                <?php 
                if( !filter_var( $team_url, FILTER_VALIDATE_URL ) === false || $team_url == '#' ) {
                    echo '<a class="link-light-title" href="'. esc_url($team_url) .'">'.get_the_title().'</a>';
                } else {
                    echo get_the_title();
                }
                ?>
                </h3>
                <?php echo !empty($team_position) ? '<span>'.$team_position.'</span>' : ''; ?>
                <?php echo !empty($team_about) ? '<div class="content">'.$team_about.'</div>' : ''; ?>
                <?php get_template_part( 'templates/team/inc', 'social' ); ?>
            </div>
        </div>
    </div>
</div>