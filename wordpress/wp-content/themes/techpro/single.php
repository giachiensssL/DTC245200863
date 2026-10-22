<?php
/**
 * TechPro Single Product/Post Template
 * @package techpro
 */
get_header();
?>

<section style="background:#fff; padding: 4rem 0;">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
        <div style="max-width:900px; margin:0 auto;">
            <?php
            $cats = wp_get_post_terms( get_the_ID(), 'product_cat' );
            if ($cats && !is_wp_error($cats)) {
                echo '<div class="product-category" style="font-size:1rem; margin-bottom:0.5rem;">' . esc_html($cats[0]->name) . '</div>';
            }
            ?>
            <h1 style="margin-bottom:1.5rem;"><?php the_title(); ?></h1>
            <?php
            $price    = get_post_meta( get_the_ID(), '_product_price', true );
            $old_p    = get_post_meta( get_the_ID(), '_product_old_price', true );
            $badge    = get_post_meta( get_the_ID(), '_product_badge', true );
            $feats    = get_post_meta( get_the_ID(), '_product_features', true );
            $specs    = get_post_meta( get_the_ID(), '_product_specs', true );
            ?>
            <?php if ($badge) echo '<span class="product-badge" style="position:static; display:inline-block; margin-bottom:1rem;">' . esc_html($badge) . '</span>'; ?>
            <?php if ($price) {
                echo '<div class="product-price" style="font-size:1.8rem; margin:1rem 0;">' . esc_html($price) . '₫';
                if ($old_p) echo '<span class="original" style="font-size:1.1rem; margin-left:0.5rem;">' . esc_html($old_p) . '₫</span>';
                echo '</div>';
            } ?>
            <div class="entry-content"><?php the_content(); ?></div>
            <?php if ($feats) : ?>
            <div style="margin-top:2rem;">
                <h3>✨ Tính năng nổi bật</h3>
                <ul style="list-style:none; padding:0; margin-top:1rem;">
                    <?php foreach(explode("\n", $feats) as $feat): if(trim($feat)): ?>
                    <li style="padding:0.5rem 0; border-bottom:1px solid #eee; display:flex; gap:0.5rem;">
                        <span style="color:var(--accent);">✓</span> <?php echo esc_html(trim($feat)); ?>
                    </li>
                    <?php endif; endforeach; ?>
                </ul>
            </div>
            <?php endif; ?>
            <?php if ($specs) : ?>
            <div style="margin-top:2rem;">
                <h3>📋 Thông số kỹ thuật</h3>
                <table style="width:100%; margin-top:1rem; border-collapse:collapse;">
                    <?php foreach(explode("\n", $specs) as $spec): if(trim($spec)):
                        $parts = explode(':', $spec, 2);
                    ?>
                    <tr>
                        <td style="padding:0.6rem; border:1px solid #eee; font-weight:600; width:35%; background:#f8f9fa;"><?php echo esc_html(trim($parts[0] ?? '')); ?></td>
                        <td style="padding:0.6rem; border:1px solid #eee;"><?php echo esc_html(trim($parts[1] ?? '')); ?></td>
                    </tr>
                    <?php endif; endforeach; ?>
                </table>
            </div>
            <?php endif; ?>
            <div style="margin-top:2.5rem; display:flex; gap:1rem; flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-primary">📞 Đặt hàng ngay</a>
                <a href="javascript:history.back()" class="btn btn-outline">← Quay lại</a>
            </div>
        </div>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
