<?php
/**
 * Template Name: Sitemap Template
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-12 max-w-4xl">
    <header class="mb-12">
        <h1 class="text-4xl font-extrabold mb-4"><?php the_title(); ?></h1>
    </header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
        <section>
            <h2 class="text-xl font-bold mb-6 border-b pb-2">Pages</h2>
            <ul class="space-y-2">
                <?php
                wp_list_pages(array(
                    'title_li' => '',
                ));
                ?>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-6 border-b pb-2">Categories</h2>
            <ul class="space-y-2">
                <?php
                wp_list_categories(array(
                    'title_li' => '',
                ));
                ?>
            </ul>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-6 border-b pb-2">Tags</h2>
            <div class="flex flex-wrap gap-2">
                <?php
                $tags = get_tags();
                foreach ($tags as $tag) {
                    echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="px-3 py-1 bg-muted rounded-full text-sm">#' . esc_html($tag->name) . '</a>';
                }
                ?>
            </div>
        </section>

        <section>
            <h2 class="text-xl font-bold mb-6 border-b pb-2">Latest Posts (20)</h2>
            <ul class="space-y-2">
                <?php
                $latest_posts = get_posts(array('numberposts' => 20));
                foreach ($latest_posts as $post) : setup_postdata($post);
                ?>
                    <li><a href="<?php the_permalink(); ?>" class="hover:text-primary transition-colors"><?php the_title(); ?></a></li>
                <?php endforeach; wp_reset_postdata(); ?>
            </ul>
        </section>
    </div>
</main>

<?php
get_footer();
