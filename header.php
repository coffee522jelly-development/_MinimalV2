<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'devminimal' ); ?></a>

	<header id="masthead" class="site-header border-b">
		<div class="container mx-auto px-4 h-16 flex items-center justify-between">
			<div class="site-branding">
				<?php
				the_custom_logo();
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title text-xl font-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title text-xl font-bold"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				?>
			</div><!-- .site-branding -->

			<nav id="site-navigation" class="main-navigation hidden md:block">
				<?php
				wp_nav_menu(
					array(
						'theme_location' => 'menu-1',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'menu_class'     => 'flex gap-6',
					)
				);
				?>
			</nav><!-- #site-navigation -->

            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 text-xs border rounded-md px-2 py-1 bg-muted">
                    <a href="?lang=en" class="<?php echo (get_locale() == 'en_US' || get_locale() == 'en') ? 'font-bold underline' : ''; ?>">EN</a>
                    <span class="opacity-20">|</span>
                    <a href="?lang=ja" class="<?php echo (get_locale() == 'ja') ? 'font-bold underline' : ''; ?>">JA</a>
                </div>
                <div id="theme-toggle-root"></div>
                <div id="mobile-menu-root" class="md:hidden"></div>
            </div>
		</div>
	</header><!-- #masthead -->
