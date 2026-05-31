	<footer id="colophon" class="site-footer border-t py-12 mt-12">
		<div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h2 class="text-lg font-bold mb-4"><?php bloginfo( 'name' ); ?></h2>
                    <p class="text-sm text-muted-foreground">
                        <?php bloginfo( 'description' ); ?>
                    </p>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4"><?php esc_html_e( 'Links', 'devminimal' ); ?></h3>
                    <?php
                    wp_nav_menu(
                        array(
                            'theme_location' => 'menu-1',
                            'container'      => false,
                            'menu_class'     => 'space-y-2 text-sm',
                        )
                    );
                    ?>
                </div>
                <div>
                    <h3 class="text-sm font-semibold uppercase tracking-wider mb-4"><?php esc_html_e( 'SNS', 'devminimal' ); ?></h3>
                    <div id="footer-sns-root" class="flex gap-4"></div>
                </div>
            </div>
            <div class="mt-12 pt-8 border-t text-center text-sm text-muted-foreground">
                &copy; <?php echo date( 'Y' ); ?> <?php bloginfo( 'name' ); ?>. All rights reserved.
            </div>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<div id="fab-root"></div>

<?php wp_footer(); ?>

</body>
</html>
