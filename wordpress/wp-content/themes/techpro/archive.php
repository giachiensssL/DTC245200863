<?php
/**
 * TechPro Archive Template (Products, Blog)
 * @package techpro
 */
get_header();
?>

<section class="about-hero" style="padding:3rem 0;">
    <div class="container">
        <h1><?php the_archive_title(); ?></h1>
        <p><?php the_archive_description(); ?></p>
    </div>
</section>

<section style="background:#f8f9fa; padding: 4rem 0;">
    <div class="container">
        <div class="products-grid">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
            <div class="product-card">
                <div class="product-image">
                    <?php if ( has_post_thumbnail() ) { the_post_thumbnail('medium'); } else { echo '<span>📦</span>'; } ?>
                    <?php
                    $badge = get_post_meta( get_the_ID(), '_product_badge', true );
                    if ($badge) echo '<span class="product-badge">' . esc_html($badge) . '</span>';
                    ?>
                </div>
                <div class="product-info">
                    <?php
                    $cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
                    if ($cats && !is_wp_error($cats)) {
                        echo '<div class="product-category">' . esc_html($cats[0]->name) . '</div>';
                    }
                    ?>
                    <div class="product-name"><?php the_title(); ?></div>
                    <div class="product-desc"><?php the_excerpt(); ?></div>
                    <div class="product-footer">
                        <?php
                        $price = get_post_meta( get_the_ID(), '_product_price', true );
                        if ($price) {
                            $old_price = get_post_meta( get_the_ID(), '_product_old_price', true );
                            echo '<div class="product-price">' . esc_html($price) . '₫';
                            if ($old_price) echo '<span class="original">' . esc_html($old_price) . '₫</span>';
                            echo '</div>';
                        }
                        ?>
                        <a href="<?php the_permalink(); ?>" class="product-btn">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <p style="text-align:center; grid-column:1/-1; padding:3rem;">Chưa có sản phẩm nào.</p>
            <?php endif; ?>
        </div>
        <div style="margin-top:3rem; text-align:center;">
            <?php the_posts_pagination( ['prev_text' => '« Trang trước', 'next_text' => 'Trang sau »'] ); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>
