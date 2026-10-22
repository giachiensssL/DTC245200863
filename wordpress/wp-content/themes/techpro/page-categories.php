<?php
/**
 * Template Name: Trang Danh Mục
 * Displays all product categories with images and product counts
 *
 * @package techpro
 */

get_header();

$categories = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
    'orderby'    => 'name',
    'order'      => 'ASC',
] );
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero">
    <div class="container">
        <h1>Danh mục <span class="highlight">sản phẩm</span></h1>
        <p>Khám phá sản phẩm theo từng danh mục</p>
    </div>
</section>

<section class="categories-section">
    <div class="container">
        <?php if ( $categories && ! is_wp_error($categories) && count($categories) > 0 ) : ?>
        <div class="categories-grid">
            <?php foreach ( $categories as $cat ) :
                $image_id  = get_term_meta( $cat->term_id, '_category_image', true );
                $image_url = $image_id ? wp_get_attachment_image_url( $image_id, 'product-card' ) : '';
                $cat_link  = get_term_link( $cat );
                $icons = [
                    'laptop'     => '💻',
                    'smartphone' => '📱',
                    'tablet'     => '📟',
                    'phu-kien'   => '⌨️',
                    'am-thanh'   => '🎧',
                    'man-hinh'   => '🖥️',
                ];
                $icon = $icons[$cat->slug] ?? '📦';
            ?>
            <a href="<?php echo esc_url($cat_link); ?>" class="category-card">
                <div class="category-image">
                    <?php if ( $image_url ) : ?>
                        <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr($cat->name); ?>" loading="lazy">
                    <?php else : ?>
                        <span class="category-icon"><?php echo $icon; ?></span>
                    <?php endif; ?>
                </div>
                <div class="category-info">
                    <h3 class="category-name"><?php echo esc_html($cat->name); ?></h3>
                    <?php if ( $cat->description ) : ?>
                        <p class="category-desc"><?php echo esc_html($cat->description); ?></p>
                    <?php endif; ?>
                    <span class="category-count"><?php echo intval($cat->count); ?> sản phẩm</span>
                </div>
                <span class="category-arrow">→</span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else : ?>
        <div class="no-results">
            <div class="no-results-icon">📂</div>
            <h3>Chưa có danh mục nào</h3>
            <p>Các danh mục sản phẩm đang được cập nhật. Vui lòng quay lại sau.</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Về trang chủ</a>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
