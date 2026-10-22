<?php
/**
 * Template Name: Trang Tin Tức
 * Blog/News listing page
 *
 * @package techpro
 */

get_header();

$paged = max( 1, get_query_var('paged') );
$news_query = new WP_Query( [
    'post_type'      => 'post',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
] );
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero page-hero--small">
    <div class="container">
        <h1>Tin tức & <span class="highlight">Khuyến mãi</span></h1>
        <p>Cập nhật tin tức công nghệ mới nhất và chương trình khuyến mãi hấp dẫn</p>
    </div>
</section>

<section class="news-section">
    <div class="container">
        <?php if ( $news_query->have_posts() ) : ?>
        <div class="news-grid">
            <?php while ( $news_query->have_posts() ) : $news_query->the_post(); ?>
            <article class="news-card">
                <a href="<?php the_permalink(); ?>" class="news-card-link">
                    <div class="news-card-image">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <?php the_post_thumbnail( 'product-card', [ 'alt' => esc_attr(get_the_title()), 'loading' => 'lazy' ] ); ?>
                        <?php else : ?>
                            <span class="news-card-placeholder">📰</span>
                        <?php endif; ?>
                        <?php
                        $categories = get_the_category();
                        if ( $categories ) :
                        ?>
                        <span class="news-card-cat"><?php echo esc_html($categories[0]->name); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="news-card-content">
                        <div class="news-card-meta">
                            <time datetime="<?php echo get_the_date('c'); ?>"><?php echo get_the_date('d/m/Y'); ?></time>
                            <span>•</span>
                            <span><?php echo get_the_author(); ?></span>
                        </div>
                        <h3 class="news-card-title"><?php the_title(); ?></h3>
                        <p class="news-card-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?></p>
                        <span class="news-card-readmore">Đọc thêm →</span>
                    </div>
                </a>
            </article>
            <?php endwhile; ?>
        </div>

        <?php if ( $news_query->max_num_pages > 1 ) : ?>
        <div class="pagination-wrap">
            <?php echo paginate_links( [
                'total'     => $news_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '« Trước',
                'next_text' => 'Sau »',
                'type'      => 'list',
            ] ); ?>
        </div>
        <?php endif; ?>

        <?php else : ?>
        <div class="no-results">
            <div class="no-results-icon">📰</div>
            <h3>Chưa có bài viết nào</h3>
            <p>Tin tức và bài viết đang được cập nhật. Hãy quay lại sau nhé!</p>
            <a href="<?php echo esc_url(home_url('/')); ?>" class="btn btn-primary">Về trang chủ</a>
        </div>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</section>

<?php get_footer(); ?>
