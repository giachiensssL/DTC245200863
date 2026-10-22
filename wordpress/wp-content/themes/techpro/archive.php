<?php
/**
 * TechPro Archive Template (Products, Blog)
 * @package techpro
 */
get_header();
$archive_title = is_post_type_archive( 'product' ) ? 'Sản phẩm TechPro' : get_the_archive_title();
?>

<section class="about-hero" style="padding:3rem 0;">
    <div class="container">
        <h1><?php echo esc_html($archive_title); ?></h1>
        <p><?php the_archive_description(); ?></p>
    </div>
</section>

<section style="background:#f8f9fa; padding: 4rem 0;">
    <div class="container">
        <div class="products-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post();
                get_template_part( 'template-parts/product', 'card' );
            endwhile; else: ?>
            <p style="text-align:center; grid-column:1/-1; padding:3rem;">Chưa có sản phẩm nào.</p>
            <?php endif; ?>
        </div>
        <div style="margin-top:3rem; text-align:center;">
            <?php the_posts_pagination( ['prev_text' => '« Trang trước', 'next_text' => 'Trang sau »'] ); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
