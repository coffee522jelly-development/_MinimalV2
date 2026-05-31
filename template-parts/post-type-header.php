<?php
$post_type = get_post_meta( get_the_ID(), '_devminimal_post_type', true );

if ( 'app' === $post_type ) :
    $app_name = get_post_meta( get_the_ID(), '_devminimal_app_name', true );
    $app_subtitle = get_post_meta( get_the_ID(), '_devminimal_app_subtitle', true );
    $app_website = get_post_meta( get_the_ID(), '_devminimal_app_website', true );
    $app_github = get_post_meta( get_the_ID(), '_devminimal_app_github', true );
    $app_stack = get_post_meta( get_the_ID(), '_devminimal_app_stack', true );
    ?>
    <section class="mb-12 p-8 bg-muted rounded-2xl border flex flex-col md:flex-row gap-8 items-center md:items-start">
        <?php if ( has_post_thumbnail() ) : ?>
            <div class="w-32 h-32 rounded-3xl overflow-hidden shadow-lg flex-shrink-0">
                <?php the_post_thumbnail( 'thumbnail', array( 'class' => 'w-full h-full object-cover' ) ); ?>
            </div>
        <?php endif; ?>

        <div class="flex-grow text-center md:text-left">
            <h2 class="text-3xl font-bold mb-2"><?php echo esc_html( $app_name ?: get_the_title() ); ?></h2>
            <?php if ( $app_subtitle ) : ?>
                <p class="text-lg text-muted-foreground mb-4"><?php echo esc_html( $app_subtitle ); ?></p>
            <?php endif; ?>

            <?php if ( $app_stack ) : ?>
                <div class="flex flex-wrap justify-center md:justify-start gap-2 mb-6">
                    <?php
                    $stacks = explode(',', $app_stack);
                    foreach ($stacks as $stack) {
                        echo '<span class="px-2 py-0.5 bg-background border rounded text-xs font-mono">' . esc_html(trim($stack)) . '</span>';
                    }
                    ?>
                </div>
            <?php endif; ?>

            <div class="flex flex-wrap justify-center md:justify-start gap-4">
                <?php if ( $app_website ) : ?>
                    <a href="<?php echo esc_url( $app_website ); ?>" target="_blank" rel="noopener noreferrer" class="px-6 py-2 bg-primary text-primary-foreground rounded-full font-bold hover:opacity-90 transition-opacity"><?php _e('Visit Website', 'devminimal'); ?></a>
                <?php endif; ?>
                <?php if ( $app_github ) : ?>
                    <a href="<?php echo esc_url( $app_github ); ?>" target="_blank" rel="noopener noreferrer" class="px-6 py-2 bg-secondary text-secondary-foreground border rounded-full font-bold hover:bg-secondary/80 transition-colors">GitHub</a>
                <?php endif; ?>
            </div>
        </div>
    </section>

<?php elseif ( 'release' === $post_type ) :
    $version = get_post_meta( get_the_ID(), '_devminimal_release_version', true );
    $date = get_post_meta( get_the_ID(), '_devminimal_release_date', true );
    ?>
    <section class="mb-12 p-8 bg-primary text-primary-foreground rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
        <div>
            <span class="text-sm font-bold uppercase tracking-widest opacity-80"><?php _e('Release Note', 'devminimal'); ?></span>
            <h2 class="text-5xl font-black mt-2">v<?php echo esc_html( $version ?: '1.0.0' ); ?></h2>
        </div>
        <?php if ( $date ) : ?>
            <div class="text-right">
                <p class="text-lg opacity-90"><?php echo date_i18n(get_option('date_format'), strtotime($date)); ?></p>
            </div>
        <?php endif; ?>
    </section>

<?php elseif ( 'devlog' === $post_type ) :
    $date = get_post_meta( get_the_ID(), '_devminimal_devlog_date', true );
    $hours = get_post_meta( get_the_ID(), '_devminimal_devlog_hours', true );
    ?>
    <section class="mb-12 p-6 border-l-4 border-primary bg-muted rounded-r-xl flex flex-wrap items-center gap-8">
        <div>
            <span class="text-xs font-bold uppercase text-muted-foreground"><?php _e('Work Date', 'devminimal'); ?></span>
            <p class="text-xl font-bold"><?php echo $date ? date_i18n(get_option('date_format'), strtotime($date)) : get_the_date(); ?></p>
        </div>
        <?php if ( $hours ) : ?>
            <div>
                <span class="text-xs font-bold uppercase text-muted-foreground"><?php _e('Time Spent', 'devminimal'); ?></span>
                <p class="text-xl font-bold"><?php printf( _n( '%s hour', '%s hours', $hours, 'devminimal' ), $hours ); ?></p>
            </div>
        <?php endif; ?>
    </section>
<?php endif; ?>
