<?php
/**
 * The main template file
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

	<?php
	if ( have_posts() ) :
		?>
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
            <div>
                <?php if ( is_home() && ! is_front_page() ) : ?>
                    <h1 class="text-3xl font-bold mb-4"><?php single_post_title(); ?></h1>
                <?php else : ?>
                    <h1 class="text-3xl font-bold mb-4"><?php esc_html_e( 'Latest Posts', 'devminimal' ); ?></h1>
                <?php endif; ?>

                <div class="flex flex-wrap gap-2">
                    <?php
                    $current_type = isset($_GET['type']) ? sanitize_text_field($_GET['type']) : 'all';
                    $types = array(
                        'all' => __('All', 'devminimal'),
                        'normal' => __('Normal', 'devminimal'),
                        'app' => __('Apps', 'devminimal'),
                        'release' => __('Releases', 'devminimal'),
                        'devlog' => __('Dev Logs', 'devminimal'),
                    );
                    foreach ($types as $slug => $label) {
                        $url = ($slug === 'all') ? remove_query_arg('type') : add_query_arg('type', $slug);
                        $active = ($current_type === $slug) ? 'bg-primary text-primary-foreground' : 'bg-muted hover:bg-muted/80';
                        echo '<a href="' . esc_url($url) . '" class="px-3 py-1 rounded-full text-xs font-bold transition-colors ' . $active . '">' . esc_html($label) . '</a>';
                    }
                    ?>
                </div>
            </div>

            <div id="layout-switcher-root"></div>
        </div>

        <div id="post-grid" class="grid grid-cols-1 md:grid-cols-2 gap-6 transition-all duration-300">
            <?php
            /* Start the Loop */
            while ( have_posts() ) :
                the_post();
                get_template_part( 'template-parts/content', get_post_type() );
            endwhile;
            ?>
        </div>

        <div class="mt-12">
            <?php
            the_posts_pagination( array(
                'mid_size'  => 2,
                'prev_text' => __( 'Previous', 'devminimal' ),
                'next_text' => __( 'Next', 'devminimal' ),
                'class'     => 'flex justify-center gap-2',
            ) );
            ?>
        </div>

	<?php
	else :
		get_template_part( 'template-parts/content', 'none' );
	endif;
	?>

</main><!-- #main -->

<?php
get_footer();
