<?php
/**
 * Title: Card Post
 * Slug: macrosbysara/card-post
 * Categories: content
 * Description: Card style post preview with featured image, title, date, categories, and excerpt.
 *
 * @package MacrosBySara
 */

?>
<!-- wp:group {"metadata":{"name":"Card"},"className":"h-100 overflow-hidden","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"blockGap":"0"},"border":{"radius":"10px","width":"2px"},"elements":{"link":{"color":{"text":"var:preset|color|primary"},":hover":{"color":{"text":"var:preset|color|primary-light"}}}}},"backgroundColor":"white","borderColor":"contrast","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch"}} -->
<div class="wp-block-group h-100 overflow-hidden has-border-color has-contrast-border-color has-white-background-color has-background has-link-color" style="border-width:2px;border-radius:10px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:post-featured-image {"isLink":true,"aspectRatio":"1","width":"","height":"","sizeSlug":"full","style":{"border":{"radius":"0px"},"spacing":{"margin":{"top":"0","bottom":"0"}}}} /-->

<!-- wp:group {"metadata":{"name":"Card Body"},"className":"flex-grow-1 flex-shrink-1","style":{"spacing":{"padding":{"top":"var:preset|spacing|base","bottom":"var:preset|spacing|base","left":"var:preset|spacing|base","right":"var:preset|spacing|base"}}},"layout":{"type":"flex","orientation":"vertical","flexWrap":"nowrap","justifyContent":"left"}} -->
<div class="wp-block-group flex-grow-1 flex-shrink-1" style="padding-top:var(--wp--preset--spacing--base);padding-right:var(--wp--preset--spacing--base);padding-bottom:var(--wp--preset--spacing--base);padding-left:var(--wp--preset--spacing--base)"><!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|xs"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:post-title {"level":3,"isLink":true,"fontSize":"lg"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|sm"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
<div class="wp-block-group"><!-- wp:post-date {"style":{"border":{"radius":"5px"}},"fontSize":"root"} /-->

<!-- wp:paragraph -->
<p>in</p>
<!-- /wp:paragraph -->

<!-- wp:post-terms {"term":"category"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->

<!-- wp:post-excerpt {"moreText":"Read More","excerptLength":30,"className":"flex-grow-1","style":{"elements":{"link":{"color":{"text":"var:preset|color|contrast"}}}},"fontSize":"root"} /--></div>
<!-- /wp:group --></div>
<!-- /wp:group -->
