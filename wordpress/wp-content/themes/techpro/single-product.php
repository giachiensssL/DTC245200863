<?php
/**
 * Single Product Template
 * Displays detailed product information with gallery, specs, related products
 *
 * @package techpro
 */

get_header();
?>

<?php techpro_breadcrumb(); ?>

<?php while ( have_posts() ) : the_post();
    $price     = get_post_meta( get_the_ID(), '_product_price', true );
    $old_price = get_post_meta( get_the_ID(), '_product_old_price', true );
    $badge     = get_post_meta( get_the_ID(), '_product_badge', true );
    $features  = get_post_meta( get_the_ID(), '_product_features', true );
    $specs     = get_post_meta( get_the_ID(), '_product_specs', true );
    $gallery   = get_post_meta( get_the_ID(), '_product_gallery', true );
    $sku       = get_post_meta( get_the_ID(), '_product_sku', true );
    $stock     = get_post_meta( get_the_ID(), '_product_stock_status', true );
    $image     = sanitize_file_name( get_post_meta( get_the_ID(), '_product_image', true ) );
    $image_url = $image ? get_theme_file_uri( '/assets/products/' . $image ) : '';
    $gallery_ids = $gallery ? array_filter( array_map('intval', explode(',', $gallery)) ) : [];
    $cats      = wp_get_post_terms( get_the_ID(), 'product_cat' );
?>

<section class="product-detail-section">
    <div class="container">
        <div class="product-detail-grid">
            <!-- Product Gallery -->
            <div class="product-gallery">
                <div class="gallery-main" id="gallery-main">
                    <?php if ( $image_url ) : ?>
                        <img class="gallery-main-image" id="main-product-image" src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" width="640" height="480">
                    <?php elseif ( has_post_thumbnail() ) : ?>
                        <?php the_post_thumbnail( 'product-detail', [
                            'class' => 'gallery-main-image',
                            'id'    => 'main-product-image',
                            'alt'   => esc_attr(get_the_title()),
                        ] ); ?>
                    <?php else : ?>
                        <div class="gallery-placeholder">📦</div>
                    <?php endif; ?>
                    <?php if ( $badge ) : ?>
                        <span class="product-badge product-badge--detail<?php echo ($badge === 'Mới' ? ' new' : ''); ?>"><?php echo esc_html($badge); ?></span>
                    <?php endif; ?>
                </div>
                <?php if ( ! empty($gallery_ids) || has_post_thumbnail() ) : ?>
                <div class="gallery-thumbs">
                    <?php if ( has_post_thumbnail() ) :
                        $main_thumb = get_the_post_thumbnail_url( get_the_ID(), 'product-gallery-thumb' );
                        $main_full  = get_the_post_thumbnail_url( get_the_ID(), 'product-detail' );
                    ?>
                        <button class="gallery-thumb active" data-full="<?php echo esc_url($main_full); ?>" aria-label="Ảnh chính">
                            <img src="<?php echo esc_url($main_thumb); ?>" alt="Ảnh chính" loading="lazy">
                        </button>
                    <?php endif; ?>
                    <?php foreach ( $gallery_ids as $img_id ) :
                        $thumb = wp_get_attachment_image_url( $img_id, 'product-gallery-thumb' );
                        $full  = wp_get_attachment_image_url( $img_id, 'product-detail' );
                        if ( $thumb && $full ) :
                    ?>
                        <button class="gallery-thumb" data-full="<?php echo esc_url($full); ?>" aria-label="Ảnh sản phẩm">
                            <img src="<?php echo esc_url($thumb); ?>" alt="<?php echo esc_attr(get_the_title()); ?>" loading="lazy">
                        </button>
                    <?php endif; endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Product Info -->
            <div class="product-detail-info">
                <?php if ( $cats && ! is_wp_error($cats) ) : ?>
                    <a href="<?php echo esc_url(get_term_link($cats[0])); ?>" class="product-detail-category">
                        <?php echo esc_html($cats[0]->name); ?>
                    </a>
                <?php endif; ?>

                <h1 class="product-detail-title"><?php the_title(); ?></h1>

                <?php if ( $sku || $stock ) : ?>
                <div class="product-detail-meta">
                    <?php if ( $sku ) : ?><span>Mã sản phẩm: <strong><?php echo esc_html($sku); ?></strong></span><?php endif; ?>
                    <?php if ( $stock ) : ?>
                        <span class="product-stock<?php echo $stock === 'instock' ? ' is-in-stock' : ' is-out-of-stock'; ?>">
                            <?php echo $stock === 'instock' ? 'Còn hàng' : 'Tạm hết hàng'; ?>
                        </span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ( $price ) : ?>
                <div class="product-detail-price">
                    <span class="price-current"><?php echo esc_html($price); ?>₫</span>
                    <?php if ( $old_price ) : ?>
                        <span class="price-original"><?php echo esc_html($old_price); ?>₫</span>
                    <?php endif; ?>
                </div>
                <?php endif; ?>

                <?php if ( has_excerpt() ) : ?>
                <div class="product-detail-excerpt">
                    <?php the_excerpt(); ?>
                </div>
                <?php endif; ?>

                <?php if ( $features ) : ?>
                <div class="product-detail-features">
                    <h3>✨ Tính năng nổi bật</h3>
                    <ul>
                        <?php foreach( explode("\n", $features) as $feat ) :
                            $feat = trim($feat);
                            if ( $feat ) :
                        ?>
                        <li><span class="feature-check">✓</span> <?php echo esc_html($feat); ?></li>
                        <?php endif; endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="product-detail-actions">
                    <a href="<?php echo esc_url(home_url('/lien-he?product=' . urlencode(get_the_title()))); ?>" class="btn btn-primary btn-lg">
                        📞 Liên hệ tư vấn
                    </a>
                    <button class="btn btn-outline btn-lg" id="share-product" data-url="<?php echo esc_url(get_permalink()); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" aria-label="Chia sẻ sản phẩm">
                        🔗 Chia sẻ
                    </button>
                </div>
                <div id="share-toast" class="share-toast" style="display:none;">
                    ✅ Đã sao chép liên kết vào clipboard!
                </div>
            </div>
        </div>

        <!-- Product Content Tabs -->
        <div class="product-detail-content">
            <div class="detail-tabs">
                <button class="detail-tab active" data-tab="description">Mô tả chi tiết</button>
                <?php if ( $specs ) : ?>
                    <button class="detail-tab" data-tab="specs">Thông số kỹ thuật</button>
                <?php endif; ?>
            </div>

            <div class="detail-tab-content" id="tab-description">
                <div class="entry-content">
                    <?php the_content(); ?>
                    <?php if ( ! get_the_content() ) : ?>
                        <p class="no-content">Thông tin chi tiết sản phẩm đang được cập nhật.</p>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( $specs ) : ?>
            <div class="detail-tab-content" id="tab-specs" style="display:none;">
                <table class="specs-table">
                    <tbody>
                    <?php foreach( explode("\n", $specs) as $spec ) :
                        $spec = trim($spec);
                        if ( $spec ) :
                            $parts = explode(':', $spec, 2);
                    ?>
                    <tr>
                        <th><?php echo esc_html(trim($parts[0] ?? '')); ?></th>
                        <td><?php echo esc_html(trim($parts[1] ?? '')); ?></td>
                    </tr>
                    <?php endif; endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <!-- Related Products -->
        <?php
        $related_args = [
            'post_type'      => 'product',
            'posts_per_page' => 4,
            'post__not_in'   => [ get_the_ID() ],
            'post_status'    => 'publish',
        ];
        if ( $cats && ! is_wp_error($cats) ) {
            $related_args['tax_query'] = [ [
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $cats[0]->term_id,
            ] ];
        }
        $related = new WP_Query( $related_args );
        if ( $related->have_posts() ) :
        ?>
        <div class="related-products">
            <h2 class="section-title">Sản phẩm <span class="highlight">liên quan</span></h2>
            <div class="products-grid products-grid--4">
                <?php while ( $related->have_posts() ) : $related->the_post();
                    get_template_part( 'template-parts/product', 'card' );
                endwhile; ?>
            </div>
        </div>
        <?php wp_reset_postdata(); endif; ?>
    </div>
</section>

<?php endwhile; ?>

<?php get_footer(); ?>
