<?php
/**
 * Template Name: Contact Template
 */

get_header();
?>

<main id="primary" class="site-main container mx-auto px-4 py-12 max-w-2xl">
    <header class="mb-12 text-center">
        <h1 class="text-4xl font-extrabold mb-4"><?php the_title(); ?></h1>
        <?php the_content(); ?>
    </header>

    <form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" class="space-y-6">
        <input type="hidden" name="action" value="devminimal_contact_form">
        <?php wp_nonce_field( 'devminimal_contact_form_verify' ); ?>

        <div>
            <label for="name" class="block text-sm font-medium mb-2">Name</label>
            <input type="text" id="name" name="name" required class="w-full px-4 py-2 rounded-md border bg-background focus:ring-2 focus:ring-primary outline-none transition-all">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2">Email Address</label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-2 rounded-md border bg-background focus:ring-2 focus:ring-primary outline-none transition-all">
        </div>

        <div>
            <label for="subject" class="block text-sm font-medium mb-2">Subject</label>
            <input type="text" id="subject" name="subject" required class="w-full px-4 py-2 rounded-md border bg-background focus:ring-2 focus:ring-primary outline-none transition-all">
        </div>

        <div>
            <label for="message" class="block text-sm font-medium mb-2">Message</label>
            <textarea id="message" name="message" rows="5" required class="w-full px-4 py-2 rounded-md border bg-background focus:ring-2 focus:ring-primary outline-none transition-all"></textarea>
        </div>

        <button type="submit" class="w-full py-3 bg-primary text-primary-foreground font-bold rounded-md hover:opacity-90 transition-opacity">
            Send Message
        </button>
    </form>
</main>

<?php
get_footer();
