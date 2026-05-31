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
                    <h1 class="text-3xl font-bold"><?php single_post_title(); ?></h1>
                <?php else : ?>
                    <h1 class="text-3xl font-bold"><?php esc_html_e( 'Latest Posts', 'devminimal' ); ?></h1>
                <?php endif; ?>
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
