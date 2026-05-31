<?php
/**
 * The template for displaying all single posts
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-8">

	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<article id="post-<?php the_ID(); ?>" <?php post_class('max-w-4xl mx-auto'); ?>>
			<header class="entry-header mb-8">
				<?php
				if ( 'post' === get_post_type() ) :
					?>
					<div class="flex flex-wrap items-center gap-2 mb-4">
						<?php
						$categories = get_the_category();
						if ( ! empty( $categories ) ) {
							foreach ( $categories as $category ) {
								echo '<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary">🏷 ' . esc_html( $category->name ) . '</span>';
							}
						}

                        $tags = get_the_tags();
                        if ( ! empty( $tags ) ) {
                            foreach ( $tags as $tag ) {
                                echo '<span class="text-xs text-muted-foreground">#' . esc_html( $tag->name ) . '</span>';
                            }
                        }
						?>
					</div>
					<?php
				endif;

				the_title( '<h1 class="text-4xl font-extrabold mb-4">', '</h1>' );
				?>

				<div class="flex flex-wrap items-center gap-4 text-sm text-muted-foreground">
					<div class="flex items-center gap-1">
						<time datetime="<?php echo get_the_date( 'c' ); ?>">Posted: <?php echo get_the_date(); ?></time>
					</div>
					<?php if ( get_the_modified_date() !== get_the_date() ) : ?>
						<div class="flex items-center gap-1">
							<time datetime="<?php echo get_the_modified_date( 'c' ); ?>">Updated: <?php echo get_the_modified_date(); ?></time>
						</div>
					<?php endif; ?>
					<div class="flex items-center gap-1">
						<span>
                            <?php
                            $content = get_the_content();
                            $word_count = mb_strlen( strip_tags( $content ) );
                            $reading_time = ceil( $word_count / 500 );
                            printf( esc_html__( 'Read: %d min', 'devminimal' ), $reading_time );
                            ?>
                        </span>
					</div>
				</div>

                <div class="mt-6">
                    <?php devminimal_breadcrumb(); ?>
                </div>
			</header>

            <?php get_template_part( 'template-parts/post-type-header' ); ?>

			<?php if ( has_post_thumbnail() && 'app' !== get_post_meta( get_the_ID(), '_devminimal_post_type', true ) ) : ?>
				<div class="mb-12 rounded-xl overflow-hidden border shadow-lg">
					<?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-auto' ) ); ?>
				</div>
			<?php endif; ?>

            <div class="grid grid-cols-1 lg:grid-cols-[1fr_250px] gap-12">
                <div class="entry-content prose prose-slate dark:prose-invert max-w-none">
                    <div id="toc-mobile" class="lg:hidden mb-8 p-4 bg-muted rounded-lg">
                        <h2 class="text-lg font-bold mb-2">Table of Contents</h2>
                        <div id="toc-content-mobile"></div>
                    </div>
                    <?php
                    the_content();
                    ?>
                </div>

                <aside class="hidden lg:block">
                    <div class="sticky top-24">
                        <h2 class="text-sm font-bold uppercase tracking-wider mb-4">Table of Contents</h2>
                        <nav id="toc-content" class="space-y-1 text-sm"></nav>
                    </div>
                </aside>
            </div>

		</article><!-- #post-<?php the_ID(); ?> -->

		<?php
		// If comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile; // End of the loop.
	?>

</main><!-- #main -->

<?php
get_footer();
