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

        <nav class="main-nav" id="main-nav" aria-label="<?php esc_attr_e('Primary Menu', 'techpro'); ?>">
            <?php
            wp_nav_menu( [
                'theme_location' => 'primary',
                'container'      => false,
                'menu_class'     => 'main-nav-menu',
                'fallback_cb'    => false,
                'depth'          => 1,
            ] );
            ?>
        </nav>

        <div class="header-cta">
            <a href="<?php echo esc_url(home_url('/lien-he')); ?>" class="btn btn-primary">
                📞 Tư vấn ngay
            </a>
        </div>

        <button class="nav-toggle" id="nav-toggle" aria-label="Mở menu điều hướng" aria-controls="main-nav" aria-expanded="false">
            <span></span>
            <span></span>
            <span></span>
        </button>
    </div>
</header>
