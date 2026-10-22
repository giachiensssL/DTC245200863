<?php
/**
 * Template Name: Câu Hỏi Thường Gặp
 * FAQ page using FAQ custom post type
 *
 * @package techpro
 */

get_header();

$faqs = new WP_Query( [
    'post_type'      => 'faq',
    'posts_per_page' => -1,
    'post_status'    => 'publish',
    'orderby'        => 'menu_order',
    'order'          => 'ASC',
] );
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero page-hero--small">
    <div class="container">
        <h1>Câu hỏi <span class="highlight">thường gặp</span></h1>
        <p>Giải đáp những thắc mắc phổ biến từ khách hàng</p>
    </div>
</section>

<section class="faq-section">
    <div class="container">
        <div class="faq-container">
            <?php if ( $faqs->have_posts() ) : ?>
                <?php while ( $faqs->have_posts() ) : $faqs->the_post(); ?>
                <div class="faq-item">
                    <button class="faq-question" aria-expanded="false">
                        <span><?php the_title(); ?></span>
                        <span class="faq-toggle">+</span>
                    </button>
                    <div class="faq-answer" role="region">
                        <div class="faq-answer-inner">
                            <?php the_content(); ?>
                        </div>
                    </div>
                </div>
                <?php endwhile; wp_reset_postdata(); ?>
            <?php else : ?>
                <div class="no-results">
                    <div class="no-results-icon">❓</div>
                    <h3>Chưa có câu hỏi nào</h3>
                    <p>Các câu hỏi thường gặp đang được cập nhật.</p>
                </div>
            <?php endif; ?>
        </div>

        <div class="faq-contact-cta">
            <h3>Không tìm thấy câu trả lời?</h3>
            <p>Hãy liên hệ với chúng tôi, đội ngũ TechPro sẽ sẵn sàng giải đáp mọi thắc mắc của bạn.</p>
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-primary">📞 Liên hệ TechPro</a>
        </div>
    </div>
</section>

<?php get_footer(); ?>
