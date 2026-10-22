<?php
/**
 * Single Post Template (Blog/News articles)
 *
 * @package techpro
 */

get_header();
?>

<?php techpro_breadcrumb(); ?>

<section class="single-post-section">
    <div class="container">
        <?php while ( have_posts() ) : the_post(); ?>
        <article class="single-post">
            <div class="single-post-header">
                <?php
                $categories = get_the_category();
                if ( $categories ) :
                ?>
                <a href="<?php echo esc_url(get_category_link($categories[0]->term_id)); ?>" class="single-post-cat">
                    <?php echo esc_html($categories[0]->name); ?>
                </a>
                <?php endif; ?>

                <h1 class="single-post-title"><?php the_title(); ?></h1>

                <div class="single-post-meta">
                    <span class="meta-author">✍️ <?php the_author(); ?></span>
                    <span class="meta-sep">•</span>
                    <time class="meta-date" datetime="<?php echo get_the_date('c'); ?>">📅 <?php echo get_the_date('d/m/Y'); ?></time>
                    <?php if ( has_tag() ) : ?>
                    <span class="meta-sep">•</span>
                    <span class="meta-tags">🏷️ <?php the_tags('', ', ', ''); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ( has_post_thumbnail() ) : ?>
            <div class="single-post-featured-image">
                <?php the_post_thumbnail( 'large', [ 'alt' => esc_attr(get_the_title()), 'class' => 'featured-image' ] ); ?>
            </div>
            <?php endif; ?>

            <div class="single-post-content entry-content">
                <?php the_content(); ?>
            </div>

            <!-- Share -->
            <div class="single-post-share">
                <span class="share-label">Chia sẻ bài viết:</span>
                <button class="btn btn-outline btn-sm" id="share-product" data-url="<?php echo esc_url(get_permalink()); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>">
                    🔗 Sao chép liên kết
                </button>
                <div id="share-toast" class="share-toast" style="display:none;">
                    ✅ Đã sao chép liên kết!
                </div>
            </div>

            <!-- Post Navigation -->
            <div class="single-post-nav">
                <?php
                $prev = get_previous_post();
                $next = get_next_post();
                ?>
                <?php if ( $prev ) : ?>
                <a href="<?php echo esc_url(get_permalink($prev->ID)); ?>" class="post-nav-link post-nav-prev">
                    <span class="post-nav-label">« Bài trước</span>
                    <span class="post-nav-title"><?php echo esc_html($prev->post_title); ?></span>
                </a>
                <?php endif; ?>
                <?php if ( $next ) : ?>
                <a href="<?php echo esc_url(get_permalink($next->ID)); ?>" class="post-nav-link post-nav-next">
                    <span class="post-nav-label">Bài sau »</span>
                    <span class="post-nav-title"><?php echo esc_html($next->post_title); ?></span>
                </a>
                <?php endif; ?>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
</section>

<?php get_footer(); ?>
