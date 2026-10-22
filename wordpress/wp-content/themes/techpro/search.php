<?php
/**
 * Search Results Template
 *
 * @package techpro
 */

get_header();
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero page-hero--small">
    <div class="container">
        <h1>Kết quả tìm kiếm</h1>
        <p>
            <?php if ( have_posts() ) : ?>
                Tìm thấy <strong><?php echo $wp_query->found_posts; ?></strong> kết quả cho "<strong><?php echo esc_html(get_search_query()); ?></strong>"
            <?php else : ?>
                Không tìm thấy kết quả cho "<strong><?php echo esc_html(get_search_query()); ?></strong>"
            <?php endif; ?>
        </p>
    </div>
</section>

<section class="search-results-section">
    <div class="container">
        <!-- Search Again -->
        <div class="search-again-form">
            <form role="search" method="get" action="<?php echo esc_url(home_url('/')); ?>">
                <div class="search-input-group search-input-group--large">
                    <input type="text" name="s" class="products-search-input" placeholder="Nhập từ khóa tìm kiếm..." value="<?php echo esc_attr(get_search_query()); ?>" aria-label="Tìm kiếm">
                    <button type="submit" class="products-search-btn" aria-label="Tìm kiếm">🔍</button>
                </div>
            </form>
        </div>

        <?php if ( have_posts() ) : ?>
        <div class="search-results-list">
            <?php while ( have_posts() ) : the_post(); ?>
            <article class="search-result-item">
                <?php if ( has_post_thumbnail() ) : ?>
                <a href="<?php the_permalink(); ?>" class="search-result-thumb">
                    <?php the_post_thumbnail( 'thumbnail', [ 'alt' => esc_attr(get_the_title()), 'loading' => 'lazy' ] ); ?>
                </a>
                <?php endif; ?>
                <div class="search-result-content">
                    <span class="search-result-type">
                        <?php
                        $type = get_post_type();
                        $type_labels = [ 'product' => '📦 Sản phẩm', 'post' => '📰 Bài viết', 'page' => '📄 Trang', 'faq' => '❓ FAQ' ];
                        echo $type_labels[$type] ?? '📄 ' . get_post_type_object($type)->labels->singular_name;
                        ?>
                    </span>
                    <h3 class="search-result-title">
                        <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                    </h3>
                    <p class="search-result-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 30, '...'); ?></p>
                    <div class="search-result-meta">
                        <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/Y'); ?></time>
                        <?php if ( $type === 'product' ) :
                            $price = get_post_meta(get_the_ID(), '_product_price', true);
                            if ($price) echo ' • <strong class="text-primary">' . esc_html($price) . '₫</strong>';
                        endif; ?>
                    </div>
                </div>
            </article>
            <?php endwhile; ?>
        </div>

        <div class="pagination-wrap">
            <?php echo paginate_links( [
                'prev_text' => '« Trước',
                'next_text' => 'Sau »',
                'type'      => 'list',
            ] ); ?>
        </div>

        <?php else : ?>
        <div class="no-results">
            <div class="no-results-icon">🔍</div>
            <h3>Không tìm thấy kết quả</h3>
            <p>Không có nội dung nào phù hợp với từ khóa "<strong><?php echo esc_html(get_search_query()); ?></strong>".<br>Hãy thử tìm với từ khóa khác hoặc duyệt sản phẩm.</p>
            <div style="display:flex;gap:1rem;justify-content:center;margin-top:1.5rem;flex-wrap:wrap;">
                <a href="<?php echo esc_url(home_url('/san-pham')); ?>" class="btn btn-primary">Xem sản phẩm</a>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-outline">Về trang chủ</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
