<?php
/**
 * Title: Linktree Link
 * Slug: macrosbysara/linktree-link
 * Categories: content
 * Description: A Linktree style link component.
 *
 * @package MacrosBySara
 */

?>
<!-- wp:group {"metadata":{"name":"Link"},"className":"linktree-link","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"border":{"width":"2px","color":"rgb(60, 28, 18)","radius":"50px"},"spacing":{"padding":{"top":"var:preset|spacing|sm","bottom":"var:preset|spacing|sm","left":"var:preset|spacing|lg","right":"var:preset|spacing|lg"},"blockGap":"0"}},"textColor":"primary","fontSize":"x-large","layout":{"type":"constrained"}} -->
<div class="wp-block-group linktree-link has-border-color has-primary-color has-text-color has-link-color has-x-large-font-size"
	style="border-color:rgb(60, 28, 18);border-width:2px;border-radius:50px;padding-top:var(--wp--preset--spacing--sm);padding-right:var(--wp--preset--spacing--lg);padding-bottom:var(--wp--preset--spacing--sm);padding-left:var(--wp--preset--spacing--lg)">
	<!-- wp:heading {"fontSize":"lg"} -->
	<h2 class="wp-block-heading has-lg-font-size"><a href="#" target="_blank" rel="noreferrer noopener">Link Text</a></h2>
	<!-- /wp:heading -->

	<!-- wp:paragraph -->
	<p>Optional second line</p>
	<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
