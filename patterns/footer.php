<?php
/**
 * Title: Footer
 * Slug: macrosbysara/footer
 * Categories: footer
 * Block Types: core/template-part/footer
 * Description: Footer columns with logo, title, tagline and links.
 *
 * @package MacrosBySara
 */

?>
<!-- wp:group {"tagName":"footer","style":{"elements":{"link":{"color":{"text":"var:preset|color|white"},":hover":{"color":{"text":"var:preset|color|secondary-light"}}}},"spacing":{"padding":{"top":"var:preset|spacing|60","bottom":"var:preset|spacing|60"},"blockGap":"var:preset|spacing|70"}},"backgroundColor":"primary","textColor":"white","layout":{"type":"flex","orientation":"vertical","justifyContent":"stretch","verticalAlignment":"center"}} -->
<footer class="wp-block-group has-white-color has-primary-background-color has-text-color has-background has-link-color" style="padding-top:var(--wp--preset--spacing--60);padding-bottom:var(--wp--preset--spacing--60);flex-direction:column">
	<!-- wp:navigation {"ref":606,"overlayMenu":"never","icon":"menu","style":{"spacing":{"blockGap":"var:preset|spacing|50"},"layout":{"selfStretch":"fit","flexSize":null}},"fontSize":"root","layout":{"type":"flex","justifyContent":"center"}} /-->
	<!-- wp:group {"style":{"spacing":{"padding":{"right":"var:preset|spacing|30","left":"var:preset|spacing|30","top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}}},"layout":{"type":"constrained"}} -->
	<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--30);padding-right:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30);padding-left:var(--wp--preset--spacing--30)">
		<!-- wp:paragraph {"align":"center","fontSize":"root"} -->
		<p class="has-text-align-center has-root-font-size" id="copyright">© Macros By Sara, LLC</p>
		<!-- /wp:paragraph -->
		</div><!-- /wp:group -->
</footer>
<!-- /wp:group -->
