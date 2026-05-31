<article id="post-<?php the_ID(); ?>" <?php post_class('bg-card text-card-foreground rounded-lg border shadow-sm overflow-hidden'); ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<div class="aspect-video w-full overflow-hidden">
			<?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover transition-transform hover:scale-105' ) ); ?>
		</div>
	<?php endif; ?>

	<div class="p-6">
		<div class="flex items-center gap-2 mb-3">
			<?php
			$categories = get_the_category();
			if ( ! empty( $categories ) ) {
				foreach ( $categories as $category ) {
					echo '<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold bg-primary/10 text-primary">🏷 ' . esc_html( $category->name ) . '</span>';
				}
			}

            $post_type_label = get_post_meta( get_the_ID(), '_devminimal_post_type', true );
            if ( $post_type_label ) {
                echo '<span class="inline-flex items-center rounded-full border px-2.5 py-0.5 text-xs font-semibold">' . esc_html( $post_type_label ) . '</span>';
            }
			?>
		</div>

		<h2 class="text-xl font-bold mb-2 line-clamp-2">
			<a href="<?php the_permalink(); ?>" class="hover:underline"><?php the_title(); ?></a>
		</h2>

		<div class="text-sm text-muted-foreground mb-4 line-clamp-3">
			<?php the_excerpt(); ?>
		</div>

		<div class="flex items-center justify-between mt-auto text-xs text-muted-foreground">
			<time datetime="<?php echo get_the_date( 'c' ); ?>"><?php echo get_the_date(); ?></time>
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
</article>
