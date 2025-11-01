<?php
/**
 * The main template file
 *
 * @package MacrosBySara
 */

get_header();
?>
<div <?php post_class( 'alignfull is-layout-constrained has-global-padding' ); ?>>
	<?php the_content(); ?>
</div>
<?php
get_footer();
