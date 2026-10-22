<?php
/**
 * TechPro Theme Header
 * @package techpro
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header" id="site-header">
    <div class="header-inner">
        <a href="<?php echo esc_url(home_url('/')); ?>" class="site-logo">
            <div class="logo-icon">T</div>
            <span class="logo-text">Tech<span>Pro</span></span>
        </a>

        <nav class="main-nav" id="main-nav" role="navigation" aria-label="<?php esc_attr_e('Primary Menu', 'techpro'); ?>">
            <ul>
                <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Trang chủ', 'techpro'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/san-pham')); ?>"><?php _e('Sản phẩm', 'techpro'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/danh-muc')); ?>"><?php _e('Danh mục', 'techpro'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/ve-chung-toi')); ?>"><?php _e('Về chúng tôi', 'techpro'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/tin-tuc')); ?>"><?php _e('Tin tức', 'techpro'); ?></a></li>
                <li><a href="<?php echo esc_url(home_url('/lien-he')); ?>"><?php _e('Liên hệ', 'techpro'); ?></a></li>
            </ul>
        </nav>

        <div class="header-cta">
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-primary">
                📞 Tư vấn ngay
            </a>
        </div>

        <button class="nav-toggle" id="nav-toggle" aria-label="Toggle navigation" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
