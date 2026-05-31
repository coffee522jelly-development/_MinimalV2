<aside id="secondary" class="widget-area lg:col-span-1">
	<section class="mb-8">
        <h2 class="text-sm font-bold uppercase tracking-wider mb-4">Categories</h2>
        <div class="space-y-1">
            <?php
            $categories = get_categories(array('hide_empty' => true));
            foreach ($categories as $category) :
                $children = get_categories(array('parent' => $category->term_id, 'hide_empty' => false));
                if ($category->parent == 0) :
                    if (!empty($children)) :
                    ?>
                        <div class="category-accordion">
                            <button class="w-full flex items-center justify-between py-2 text-sm hover:text-primary transition-colors text-left font-medium" onclick="this.nextElementSibling.classList.toggle('hidden'); this.querySelector('.chevron').classList.toggle('rotate-180')">
                                <span>🏷 <?php echo esc_html($category->name); ?></span>
                                <span class="chevron transition-transform duration-200">▼</span>
                            </button>
                            <div class="hidden pl-4 space-y-1 mt-1 border-l ml-2">
                                <?php foreach ($children as $child) : ?>
                                    <a href="<?php echo esc_url(get_category_link($child->term_id)); ?>" class="block py-1 text-sm text-muted-foreground hover:text-primary"><?php echo esc_html($child->name); ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="block py-2 text-sm hover:text-primary transition-colors font-medium">🏷 <?php echo esc_html($category->name); ?></a>
                    <?php
                    endif;
                endif;
            endforeach;
            ?>
        </div>
    </section>

    <section class="mb-8">
        <h2 class="text-sm font-bold uppercase tracking-wider mb-4">Tags</h2>
        <div class="flex flex-wrap gap-2">
            <?php
            $tags = get_tags();
            foreach ($tags as $tag) {
                echo '<a href="' . esc_url(get_tag_link($tag->term_id)) . '" class="px-2 py-1 bg-muted hover:bg-accent rounded text-xs transition-colors">#' . esc_html($tag->name) . '</a>';
            }
            ?>
        </div>
    </section>
</aside>
