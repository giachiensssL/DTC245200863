<?php
/**
 * Template Name: Trang Sản Phẩm
 * Product listing page with search, filter, sort and pagination
 *
 * @package techpro
 */

get_header();

// Get filter parameters from URL
$current_cat   = sanitize_text_field( $_GET['danh-muc'] ?? '' );
$current_search = sanitize_text_field( $_GET['s'] ?? '' );
$current_order  = sanitize_text_field( $_GET['sap-xep'] ?? 'date-desc' );
$paged = max( 1, get_query_var('paged') );

// Build query
$args = [
    'post_type'      => 'product',
    'posts_per_page' => 9,
    'paged'          => $paged,
    'post_status'    => 'publish',
];

if ( $current_cat ) {
    $args['tax_query'] = [ [
        'taxonomy' => 'product_cat',
        'field'    => 'slug',
        'terms'    => $current_cat,
    ] ];
}

if ( $current_search ) {
    $args['s'] = $current_search;
}

switch ( $current_order ) {
    case 'title-asc':
        $args['orderby'] = 'title';
        $args['order']   = 'ASC';
        break;
    case 'title-desc':
        $args['orderby'] = 'title';
        $args['order']   = 'DESC';
        break;
    case 'date-asc':
        $args['orderby'] = 'date';
        $args['order']   = 'ASC';
        break;
    case 'date-desc':
    default:
        $args['orderby'] = 'date';
        $args['order']   = 'DESC';
        break;
}

$products_query = new WP_Query( $args );
$categories = get_terms( [
    'taxonomy'   => 'product_cat',
    'hide_empty' => false,
] );
?>

<?php techpro_breadcrumb(); ?>

<section class="page-hero">
    <div class="container">
        <h1>Sản phẩm <span class="highlight">TechPro</span></h1>
        <p>Khám phá bộ sưu tập thiết bị công nghệ chất lượng cao</p>
    </div>
</section>

<section class="products-listing">
    <div class="container">
        <!-- Search & Filter Bar -->
        <div class="products-toolbar">
            <form class="products-search-form" method="GET" action="<?php echo esc_url(get_permalink()); ?>" role="search">
                <div class="search-input-group">
                    <input type="text"
                           name="s"
                           class="products-search-input"
                           placeholder="Tìm kiếm sản phẩm..."
                           value="<?php echo esc_attr($current_search); ?>"
                           aria-label="Tìm kiếm sản phẩm">
                    <button type="submit" class="products-search-btn" aria-label="Tìm kiếm">🔍</button>
                </div>
                <?php if ($current_cat) : ?>
                    <input type="hidden" name="danh-muc" value="<?php echo esc_attr($current_cat); ?>">
                <?php endif; ?>
                <?php if ($current_order && $current_order !== 'date-desc') : ?>
                    <input type="hidden" name="sap-xep" value="<?php echo esc_attr($current_order); ?>">
                <?php endif; ?>
            </form>

            <div class="products-filters">
                <div class="filter-group">
                    <label for="filter-category" class="filter-label">Danh mục:</label>
                    <select id="filter-category" class="filter-select" onchange="techproFilterRedirect()">
                        <option value="">Tất cả</option>
                        <?php if ( $categories && ! is_wp_error($categories) ) :
                            foreach ( $categories as $cat ) : ?>
                            <option value="<?php echo esc_attr($cat->slug); ?>" <?php selected($current_cat, $cat->slug); ?>>
                                <?php echo esc_html($cat->name); ?> (<?php echo intval($cat->count); ?>)
                            </option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>

                <div class="filter-group">
                    <label for="filter-sort" class="filter-label">Sắp xếp:</label>
                    <select id="filter-sort" class="filter-select" onchange="techproFilterRedirect()">
                        <option value="date-desc" <?php selected($current_order, 'date-desc'); ?>>Mới nhất</option>
                        <option value="date-asc" <?php selected($current_order, 'date-asc'); ?>>Cũ nhất</option>
                        <option value="title-asc" <?php selected($current_order, 'title-asc'); ?>>Tên A–Z</option>
                        <option value="title-desc" <?php selected($current_order, 'title-desc'); ?>>Tên Z–A</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Active Filters -->
        <?php if ( $current_search || $current_cat ) : ?>
        <div class="active-filters">
            <span class="active-filters-label">Đang lọc:</span>
            <?php if ( $current_search ) : ?>
                <span class="active-filter-tag">
                    Từ khóa: "<?php echo esc_html($current_search); ?>"
                    <a href="<?php echo esc_url(remove_query_arg('s')); ?>" class="remove-filter" aria-label="Xóa bộ lọc tìm kiếm">×</a>
                </span>
            <?php endif; ?>
            <?php if ( $current_cat ) :
                $cat_obj = get_term_by('slug', $current_cat, 'product_cat');
            ?>
                <span class="active-filter-tag">
                    Danh mục: <?php echo $cat_obj ? esc_html($cat_obj->name) : esc_html($current_cat); ?>
                    <a href="<?php echo esc_url(remove_query_arg('danh-muc')); ?>" class="remove-filter" aria-label="Xóa bộ lọc danh mục">×</a>
                </span>
            <?php endif; ?>
            <a href="<?php echo esc_url(get_permalink()); ?>" class="clear-all-filters">Xóa tất cả bộ lọc</a>
        </div>
        <?php endif; ?>

        <!-- Results Count -->
        <div class="results-count">
            <?php if ( $products_query->found_posts > 0 ) : ?>
                Hiển thị <strong><?php echo $products_query->found_posts; ?></strong> sản phẩm
                <?php if ( $products_query->max_num_pages > 1 ) : ?>
                    — Trang <?php echo $paged; ?>/<?php echo $products_query->max_num_pages; ?>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <!-- Product Grid -->
        <div class="products-grid" id="products-grid">
            <?php if ( $products_query->have_posts() ) : ?>
                <?php while ( $products_query->have_posts() ) : $products_query->the_post();
                    get_template_part( 'template-parts/product', 'card' );
                endwhile; ?>
            <?php else : ?>
                <div class="no-results">
                    <div class="no-results-icon">🔍</div>
                    <h3>Không tìm thấy sản phẩm</h3>
                    <p>Không có sản phẩm nào phù hợp với tiêu chí tìm kiếm của bạn.</p>
                    <a href="<?php echo esc_url(get_permalink()); ?>" class="btn btn-primary">Xem tất cả sản phẩm</a>
                </div>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <?php if ( $products_query->max_num_pages > 1 ) : ?>
        <div class="pagination-wrap">
            <?php
            echo paginate_links( [
                'total'     => $products_query->max_num_pages,
                'current'   => $paged,
                'prev_text' => '« Trước',
                'next_text' => 'Sau »',
                'type'      => 'list',
                'mid_size'  => 2,
            ] );
            ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<script>
function techproFilterRedirect() {
    var baseUrl = '<?php echo esc_url(get_permalink()); ?>';
    var params = new URLSearchParams(window.location.search);
    var cat = document.getElementById('filter-category').value;
    var sort = document.getElementById('filter-sort').value;

    if (cat) params.set('danh-muc', cat); else params.delete('danh-muc');
    if (sort && sort !== 'date-desc') params.set('sap-xep', sort); else params.delete('sap-xep');

    window.location.href = baseUrl + (params.toString() ? '?' + params.toString() : '');
}
</script>

<?php wp_reset_postdata(); ?>
<?php get_footer(); ?>
