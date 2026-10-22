<?php
/**
 * Template Part: Product Card
 * Used in product listings, archive, search results, and AJAX responses
 *
 * @package techpro
 */

if ( ! defined( 'ABSPATH' ) ) exit;

$price     = get_post_meta( get_the_ID(), '_product_price', true );
$old_price = get_post_meta( get_the_ID(), '_product_old_price', true );
$badge     = get_post_meta( get_the_ID(), '_product_badge', true );
$cats      = wp_get_post_terms( get_the_ID(), 'product_cat' );
$cat_name  = ( $cats && ! is_wp_error($cats) ) ? $cats[0]->name : '';
?>
<div class="product-card" data-category="<?php echo $cats && !is_wp_error($cats) ? esc_attr($cats[0]->slug) : ''; ?>">
    <a href="<?php the_permalink(); ?>" class="product-card-link" aria-label="<?php echo esc_attr('Xem chi tiết: ' . get_the_title()); ?>">
        <div class="product-image">
            <?php if ( has_post_thumbnail() ) : ?>
                <?php the_post_thumbnail( 'product-card', [ 'alt' => esc_attr(get_the_title()), 'loading' => 'lazy' ] ); ?>
            <?php else : ?>
                <span class="product-image-placeholder">📦</span>
            <?php endif; ?>
            <?php if ( $badge ) : ?>
                <span class="product-badge<?php echo ($badge === 'Mới' ? ' new' : ''); ?>"><?php echo esc_html($badge); ?></span>
            <?php endif; ?>
        </div>
        <div class="product-info">
            <?php if ( $cat_name ) : ?>
                <div class="product-category"><?php echo esc_html($cat_name); ?></div>
            <?php endif; ?>
            <h3 class="product-name"><?php the_title(); ?></h3>
            <div class="product-desc"><?php echo wp_trim_words( get_the_excerpt(), 15, '...' ); ?></div>
            <div class="product-footer">
                <?php if ( $price ) : ?>
                    <div class="product-price">
                        <?php echo esc_html($price); ?>₫
                        <?php if ( $old_price ) : ?>
                            <span class="original"><?php echo esc_html($old_price); ?>₫</span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <span class="product-btn">Xem chi tiết</span>
            </div>
        </div>
    </a>
</div>
