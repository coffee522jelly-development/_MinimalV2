<?php
/**
 * DevMinimal functions and definitions
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Switch language based on query var
 */
function devminimal_switch_locale( $locale ) {
    if ( isset( $_GET['lang'] ) ) {
        if ( $_GET['lang'] == 'ja' ) {
            return 'ja';
        } elseif ( $_GET['lang'] == 'en' ) {
            return 'en_US';
        }
    }
    return $locale;
}
add_filter( 'locale', 'devminimal_switch_locale' );

function devminimal_setup() {
    /*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'devminimal', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus(
		array(
			'menu-1' => esc_html__( 'Primary', 'devminimal' ),
		)
	);

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support( 'customize-selective-refresh-widgets' );
}
add_action( 'after_setup_theme', 'devminimal_setup' );

/**
 * Enqueue scripts and styles.
 */
function devminimal_scripts() {
	wp_enqueue_style( 'devminimal-style', get_stylesheet_uri(), array(), '1.0.0' );

    if ( file_exists( get_template_directory() . '/build/index.css' ) ) {
        wp_enqueue_style( 'devminimal-tailwind', get_template_directory_uri() . '/build/index.css', array(), '1.0.0' );
    }

    if ( file_exists( get_template_directory() . '/build/index.js' ) ) {
        wp_enqueue_script( 'devminimal-js', get_template_directory_uri() . '/build/index.js', array(), '1.0.0', true );

        // Pass dynamic data to JS
        $locations = get_nav_menu_locations();
        $menu_items = array();
        if ( isset( $locations['menu-1'] ) ) {
            $menu_items = wp_get_nav_menu_items( $locations['menu-1'] );
        }
        $menu_data = array();
        if ($menu_items) {
            foreach ($menu_items as $item) {
                $menu_data[] = array(
                    'title' => $item->title,
                    'url'   => $item->url,
                );
            }
        }

        $sns_data = array(
            'github'  => get_theme_mod( 'devminimal_sns_github' ),
            'twitter' => get_theme_mod( 'devminimal_sns_twitter' ),
            'qiita'   => get_theme_mod( 'devminimal_sns_qiita' ),
            'zenn'    => get_theme_mod( 'devminimal_sns_zenn' ),
        );

        wp_localize_script( 'devminimal-js', 'devminimalData', array(
            'menu' => $menu_data,
            'sns'  => $sns_data,
            'home' => home_url('/'),
        ) );
    }
}
add_action( 'wp_enqueue_scripts', 'devminimal_scripts' );

/**
 * Breadcrumb function.
 */
function devminimal_breadcrumb() {
	if ( is_front_page() ) {
		return;
	}

	echo '<nav class="flex text-sm text-muted-foreground" aria-label="Breadcrumb">';
	echo '<ol class="inline-flex items-center space-x-1 md:space-x-3">';
	echo '<li class="inline-flex items-center"><a href="' . esc_url( home_url( '/' ) ) . '" class="hover:text-foreground">Home</a></li>';

	if ( is_category() || is_single() ) {
		echo '<li><div class="flex items-center"><span class="mx-2">/</span>';
		$category = get_the_category();
		if ( $category ) {
			echo '<a href="' . esc_url( get_category_link( $category[0]->term_id ) ) . '" class="hover:text-foreground">' . esc_html( $category[0]->name ) . '</a>';
		}
		echo '</div></li>';
	}

	if ( is_single() ) {
		echo '<li aria-current="page"><div class="flex items-center"><span class="mx-2">/</span><span class="font-medium text-foreground line-clamp-1">' . get_the_title() . '</span></div></li>';
	} elseif ( is_page() ) {
		echo '<li aria-current="page"><div class="flex items-center"><span class="mx-2">/</span><span class="font-medium text-foreground">' . get_the_title() . '</span></div></li>';
	}

	echo '</ol></nav>';
}

/**
 * Add Meta Boxes for Custom Post Templates
 */
function devminimal_add_meta_boxes() {
    add_meta_box(
        'devminimal_post_template',
        'Post Template Type',
        'devminimal_post_template_callback',
        'post',
        'side'
    );
    add_meta_box(
        'devminimal_app_info',
        'App Information',
        'devminimal_app_info_callback',
        'post',
        'normal'
    );
    add_meta_box(
        'devminimal_release_info',
        'Release Note Information',
        'devminimal_release_info_callback',
        'post',
        'normal'
    );
    add_meta_box(
        'devminimal_devlog_info',
        'Dev Log Information',
        'devminimal_devlog_info_callback',
        'post',
        'normal'
    );
}
add_action( 'add_meta_boxes', 'devminimal_add_meta_boxes' );

function devminimal_post_template_callback( $post ) {
    wp_nonce_field( 'devminimal_save_postdata', 'devminimal_meta_box_nonce' );
    $value = get_post_meta( $post->ID, '_devminimal_post_type', true );
    ?>
    <select name="devminimal_post_type" class="postbox-container">
        <option value="normal" <?php selected( $value, 'normal' ); ?>>Normal Article</option>
        <option value="app" <?php selected( $value, 'app' ); ?>>App Introduction</option>
        <option value="release" <?php selected( $value, 'release' ); ?>>Release Note</option>
        <option value="devlog" <?php selected( $value, 'devlog' ); ?>>Dev Log</option>
    </select>
    <?php
}

function devminimal_app_info_callback( $post ) {
    $app_name = get_post_meta( $post->ID, '_devminimal_app_name', true );
    $app_subtitle = get_post_meta( $post->ID, '_devminimal_app_subtitle', true );
    $app_website = get_post_meta( $post->ID, '_devminimal_app_website', true );
    $app_github = get_post_meta( $post->ID, '_devminimal_app_github', true );
    $app_stack = get_post_meta( $post->ID, '_devminimal_app_stack', true );
    ?>
    <p>
        <label for="devminimal_app_name">App Name</label><br>
        <input type="text" name="devminimal_app_name" value="<?php echo esc_attr( $app_name ); ?>" class="widefat">
    </p>
    <p>
        <label for="devminimal_app_subtitle">Subtitle</label><br>
        <input type="text" name="devminimal_app_subtitle" value="<?php echo esc_attr( $app_subtitle ); ?>" class="widefat">
    </p>
    <p>
        <label for="devminimal_app_website">Website URL</label><br>
        <input type="url" name="devminimal_app_website" value="<?php echo esc_url( $app_website ); ?>" class="widefat">
    </p>
    <p>
        <label for="devminimal_app_github">GitHub URL</label><br>
        <input type="url" name="devminimal_app_github" value="<?php echo esc_url( $app_github ); ?>" class="widefat">
    </p>
    <p>
        <label for="devminimal_app_stack">Tech Stack (comma separated)</label><br>
        <input type="text" name="devminimal_app_stack" value="<?php echo esc_attr( $app_stack ); ?>" class="widefat" placeholder="React, Tailwind, WordPress">
    </p>
    <?php
}

function devminimal_release_info_callback( $post ) {
    $version = get_post_meta( $post->ID, '_devminimal_release_version', true );
    $date = get_post_meta( $post->ID, '_devminimal_release_date', true );
    ?>
    <p>
        <label for="devminimal_release_version">Version Number</label><br>
        <input type="text" name="devminimal_release_version" value="<?php echo esc_attr( $version ); ?>" class="widefat" placeholder="1.0.0">
    </p>
    <p>
        <label for="devminimal_release_date">Release Date</label><br>
        <input type="date" name="devminimal_release_date" value="<?php echo esc_attr( $date ); ?>" class="widefat">
    </p>
    <?php
}

function devminimal_devlog_info_callback( $post ) {
    $date = get_post_meta( $post->ID, '_devminimal_devlog_date', true );
    $hours = get_post_meta( $post->ID, '_devminimal_devlog_hours', true );
    ?>
    <p>
        <label for="devminimal_devlog_date">Working Date</label><br>
        <input type="date" name="devminimal_devlog_date" value="<?php echo esc_attr( $date ); ?>" class="widefat">
    </p>
    <p>
        <label for="devminimal_devlog_hours">Working Hours</label><br>
        <input type="number" step="0.5" name="devminimal_devlog_hours" value="<?php echo esc_attr( $hours ); ?>" class="widefat">
    </p>
    <?php
}

function devminimal_save_postdata( $post_id ) {
    if ( ! isset( $_POST['devminimal_meta_box_nonce'] ) || ! wp_verify_nonce( $_POST['devminimal_meta_box_nonce'], 'devminimal_save_postdata' ) ) {
        return;
    }
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }
    if ( ! current_user_can( 'edit_post', $post_id ) ) {
        return;
    }

    if ( array_key_exists( 'devminimal_post_type', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_post_type', sanitize_text_field( $_POST['devminimal_post_type'] ) );
    }
    if ( array_key_exists( 'devminimal_app_name', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_app_name', sanitize_text_field( $_POST['devminimal_app_name'] ) );
    }
    if ( array_key_exists( 'devminimal_app_subtitle', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_app_subtitle', sanitize_text_field( $_POST['devminimal_app_subtitle'] ) );
    }
    if ( array_key_exists( 'devminimal_app_website', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_app_website', esc_url_raw( $_POST['devminimal_app_website'] ) );
    }
    if ( array_key_exists( 'devminimal_app_github', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_app_github', esc_url_raw( $_POST['devminimal_app_github'] ) );
    }
    if ( array_key_exists( 'devminimal_app_stack', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_app_stack', sanitize_text_field( $_POST['devminimal_app_stack'] ) );
    }
    if ( array_key_exists( 'devminimal_release_version', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_release_version', sanitize_text_field( $_POST['devminimal_release_version'] ) );
    }
    if ( array_key_exists( 'devminimal_release_date', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_release_date', sanitize_text_field( $_POST['devminimal_release_date'] ) );
    }
    if ( array_key_exists( 'devminimal_devlog_date', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_devlog_date', sanitize_text_field( $_POST['devminimal_devlog_date'] ) );
    }
    if ( array_key_exists( 'devminimal_devlog_hours', $_POST ) ) {
        update_post_meta( $post_id, '_devminimal_devlog_hours', sanitize_text_field( $_POST['devminimal_devlog_hours'] ) );
    }
}
add_action( 'save_post', 'devminimal_save_postdata' );

/**
 * Add SEO Meta Tags to Head
 */
function devminimal_seo_meta() {
    if ( is_single() || is_page() ) {
        $description = get_the_excerpt();
        $title = get_the_title() . ' - ' . get_bloginfo('name');
        $url = get_permalink();
        $image = get_the_post_thumbnail_url(get_the_ID(), 'large');
    } else {
        $description = get_bloginfo('description');
        $title = get_bloginfo('name');
        $url = home_url('/');
        $image = ''; // Default OGP image could be added here
    }

    echo '<meta name="description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:title" content="' . esc_attr($title) . '">' . "\n";
    echo '<meta property="og:description" content="' . esc_attr($description) . '">' . "\n";
    echo '<meta property="og:url" content="' . esc_url($url) . '">' . "\n";
    echo '<meta property="og:type" content="' . (is_single() ? 'article' : 'website') . '">' . "\n";
    if ($image) {
        echo '<meta property="og:image" content="' . esc_url($image) . '">' . "\n";
    }
    echo '<meta name="twitter:card" content="summary_large_image">' . "\n";
}
add_action( 'wp_head', 'devminimal_seo_meta' );

/**
 * JSON-LD Structured Data
 */
function devminimal_json_ld() {
    $schema = array(
        '@context' => 'https://schema.org',
    );

    if ( is_single() ) {
        $schema['@type'] = 'BlogPosting';
        $schema['headline'] = get_the_title();
        $schema['datePublished'] = get_the_date('c');
        $schema['dateModified'] = get_the_modified_date('c');
        $schema['author'] = array(
            '@type' => 'Person',
            'name' => get_the_author(),
        );
    } else {
        $schema['@type'] = 'WebSite';
        $schema['name'] = get_bloginfo('name');
        $schema['url'] = home_url('/');
    }

    echo '<script type="application/ld+json">' . json_encode($schema) . '</script>' . "\n";
}
add_action( 'wp_head', 'devminimal_json_ld' );

/**
 * Helper to convert Hex to HSL string for Tailwind
 */
function devminimal_hex2hsl($hex) {
    $hex = str_replace('#', '', $hex);
    if(strlen($hex) == 3) {
        $r = hexdec(substr($hex,0,1).substr($hex,0,1));
        $g = hexdec(substr($hex,1,1).substr($hex,1,1));
        $b = hexdec(substr($hex,2,1).substr($hex,2,1));
    } else {
        $r = hexdec(substr($hex,0,2));
        $g = hexdec(substr($hex,2,2));
        $b = hexdec(substr($hex,4,2));
    }
    $r /= 255; $g /= 255; $b /= 255;
    $max = max($r, $g, $b); $min = min($r, $g, $b);
    $h; $s; $l = ($max + $min) / 2;
    if($max == $min){ $h = $s = 0; }
    else{
        $d = $max - $min;
        $s = $l > 0.5 ? $d / (2 - $max - $min) : $d / ($max + $min);
        switch($max){
            case $r: $h = ($g - $b) / $d + ($g < $b ? 6 : 0); break;
            case $g: $h = ($b - $r) / $d + 2; break;
            case $b: $h = ($r - $g) / $d + 4; break;
        }
        $h /= 6;
    }
    return round($h * 360) . ' ' . round($s * 100) . '% ' . round($l * 100) . '%';
}

/**
 * Custom CSS from Customizer
 */
function devminimal_custom_css() {
    $primary = get_theme_mod( 'devminimal_primary_color', '#0f172a' );
    $accent = get_theme_mod( 'devminimal_accent_color', '#3b82f6' );
    $code_bg = get_theme_mod( 'devminimal_code_bg_color', '#1d1f21' );
    $code_font_size = get_theme_mod( 'devminimal_code_font_size', '14' );

    $primary_hsl = devminimal_hex2hsl($primary);
    $accent_hsl = devminimal_hex2hsl($accent);
    ?>
    <style type="text/css">
        :root {
            --primary: <?php echo esc_html($primary_hsl); ?>;
            --accent: <?php echo esc_html($accent_hsl); ?>;
            --code-bg-custom: <?php echo esc_html($code_bg); ?>;
            --code-font-size-custom: <?php echo esc_html($code_font_size); ?>px;
        }
        pre code { font-size: var(--code-font-size-custom) !important; }
    </style>
    <?php
}
add_action( 'wp_head', 'devminimal_custom_css' );

/**
 * Handle Contact Form Submission
 */
function devminimal_handle_contact_form() {
    if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'devminimal_contact_form_verify' ) ) {
        wp_die( 'Security check failed' );
    }

    $name = sanitize_text_field( $_POST['name'] );
    $email = sanitize_email( $_POST['email'] );
    $subject = sanitize_text_field( $_POST['subject'] );
    $message = sanitize_textarea_field( $_POST['message'] );

    $to = get_option( 'admin_email' );
    $body = "Name: $name \nEmail: $email \n\nMessage: \n$message";
    $headers = array( 'Content-Type: text/plain; charset=UTF-8', 'Reply-To: ' . $name . ' <' . $email . '>' );

    wp_mail( $to, $subject, $body, $headers );

    wp_redirect( home_url( '/contact?status=success' ) );
    exit;
}
add_action( 'admin_post_nopriv_devminimal_contact_form', 'devminimal_handle_contact_form' );
add_action( 'admin_post_devminimal_contact_form', 'devminimal_handle_contact_form' );

/**
 * Customizer settings
 */
function devminimal_customize_register( $wp_customize ) {
    // SNS Links Section
    $wp_customize->add_section( 'devminimal_sns', array(
        'title'    => 'SNS Links',
        'priority' => 30,
    ) );

    $sns_services = array( 'github', 'twitter', 'qiita', 'zenn' );
    foreach ( $sns_services as $service ) {
        $wp_customize->add_setting( "devminimal_sns_$service", array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ) );
        $wp_customize->add_control( "devminimal_sns_$service", array(
            'label'    => ucfirst($service) . ' URL',
            'section'  => 'devminimal_sns',
            'type'     => 'url',
        ) );
    }

    // Colors
    $wp_customize->add_setting( 'devminimal_primary_color', array(
        'default'           => '#0f172a',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'refresh',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'devminimal_primary_color', array(
        'label'    => 'Primary Color',
        'section'  => 'colors',
    ) ) );

    $wp_customize->add_setting( 'devminimal_accent_color', array(
        'default'           => '#3b82f6',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'devminimal_accent_color', array(
        'label'    => 'Accent Color',
        'section'  => 'colors',
    ) ) );

    // Code Block Section
    $wp_customize->add_section( 'devminimal_code_block', array(
        'title'    => 'Code Blocks',
        'priority' => 35,
    ) );

    $wp_customize->add_setting( 'devminimal_code_bg_color', array(
        'default'           => '#1d1f21',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'devminimal_code_bg_color', array(
        'label'    => 'Background Color',
        'section'  => 'devminimal_code_block',
    ) ) );

    $wp_customize->add_setting( 'devminimal_code_font_size', array(
        'default'           => '14',
        'sanitize_callback' => 'absint',
    ) );
    $wp_customize->add_control( 'devminimal_code_font_size', array(
        'label'    => 'Font Size (px)',
        'section'  => 'devminimal_code_block',
        'type'     => 'number',
    ) );
}
add_action( 'customize_register', 'devminimal_customize_register' );
