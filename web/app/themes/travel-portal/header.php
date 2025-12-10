<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary">
        <?php esc_html_e('Перейти к основному контенту', 'travel-portal'); ?>
    </a>

    <header id="masthead" class="site-header">
        <div class="container">
            <div class="header-inner">
                
                <!-- Логотип -->
                <div class="site-branding">
                    <?php if (has_custom_logo()) : ?>
                        <div class="site-logo">
                            <?php the_custom_logo(); ?>
                        </div>
                    <?php else : ?>
                        <h1 class="site-title">
                            <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                <?php bloginfo('name'); ?>
                            </a>
                        </h1>
                        <?php
                        $travel_portal_description = get_bloginfo('description', 'display');
                        if ($travel_portal_description || is_customize_preview()) :
                        ?>
                            <p class="site-description"><?php echo $travel_portal_description; ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>

                <!-- Основное меню -->
                <nav id="site-navigation" class="main-navigation">
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'primary',
                        'menu_id'        => 'primary-menu',
                        'container'      => false,
                        'fallback_cb'    => false,
                    ));
                    ?>
                </nav>

                <!-- Переключатель языков (если Polylang активирован) -->
                <?php if (function_exists('pll_the_languages')) : ?>
                    <div class="language-switcher">
                        <?php pll_the_languages(array('show_flags' => 1, 'show_names' => 0)); ?>
                    </div>
                <?php endif; ?>

                <!-- Кнопки входа/регистрации -->
                <div class="header-actions">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="btn btn-outline">
                            Выйти
                        </a>
                        <a href="<?php echo admin_url('profile.php'); ?>" class="btn">
                            Личный кабинет
                        </a>
                    <?php else : ?>
                        <a href="<?php echo wp_login_url(); ?>" class="btn btn-outline">
                            Войти
                        </a>
                        <a href="<?php echo home_url('/registration'); ?>" class="btn">
                            Регистрация
                        </a>
                    <?php endif; ?>
                </div>

                <!-- Мобильное меню (бургер) -->
                <button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false">
                    <span class="screen-reader-text"><?php esc_html_e('Меню', 'travel-portal'); ?></span>
                    <span class="hamburger"></span>
                </button>

            </div>
        </div>
    </header>