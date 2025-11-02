<?php
/**
 * Basic Header Template
 *
 * @package ChoctawNation
 */


use MacrosBySara\Navwalker;

?>

<!DOCTYPE html>
<html lang="<?php bloginfo( 'language' ); ?>">

<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<header class="d-flex text-bg-primary" id="site-header">
		<div class="container">
			<nav class="navbar navbar-expand-lg py-0">
				<a class="navbar-brand my-2 align-items-md-center" href="<?php echo esc_url( site_url() ); ?>" class="logo" aria-label="to Home Page">
					<?php echo bloginfo( 'title' ); ?>
				</a>
				<button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#navbar-nav" aria-controls="navbar-nav" aria-expanded="false"
						aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>
				<div class="offcanvas offcanvas-end ms-auto flex-grow-0" id='navbar-nav' tabindex="-1">
					<div class="offcanvas-header mt-5">
						<button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
					</div>
					<?php
					if ( has_nav_menu( 'primary_menu' ) ) {
						wp_nav_menu(
							array(
								'theme_location'  => 'primary_menu',
								'menu_class'      => 'navbar-nav header-nav',
								'container'       => 'div',
								'container_class' => 'offcanvas-body',
								'walker'          => new Navwalker(),
							)
						);
					}
					?>
				</div>
			</nav>
		</div>
	</header>
