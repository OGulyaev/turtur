<?php
/**
 * Functions and definitions для темы Travel Portal
 */

// Безопасность - запрещаем прямой доступ
if (!defined('ABSPATH')) {
    exit;
}

// Настройка темы после активации
function travel_portal_setup() {
    // Поддержка переводов
    load_theme_textdomain('travel-portal', get_template_directory() . '/languages');
    
    // Поддержка миниатюр
    add_theme_support('post-thumbnails');
    
    // Поддержка title тега
    add_theme_support('title-tag');
    
    // Поддержка HTML5 разметки
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
        'style',
        'script',
    ));
    
    // Кастомный логотип
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));
    
    // Регистрация меню
    register_nav_menus(array(
        'primary' => __('Основное меню', 'travel-portal'),
        'footer'  => __('Меню в подвале', 'travel-portal'),
        'mobile'  => __('Мобильное меню', 'travel-portal'),
    ));
    
    // Кастомные размеры изображений
    add_image_size('listing-thumb', 400, 300, true);      // Миниатюра объявления
    add_image_size('listing-large', 1200, 800, true);     // Большое фото объявления
    add_image_size('article-thumb', 600, 400, true);      // Миниатюра статьи
}
add_action('after_setup_theme', 'travel_portal_setup');

// Подключение стилей и скриптов
function travel_portal_scripts() {
    // Основной стиль темы
    wp_enqueue_style('travel-portal-style', get_stylesheet_uri(), array(), '1.0.0');
    
    // Дополнительные стили
    wp_enqueue_style('travel-portal-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
    
    // Подключение Bootstrap CSS (если используете)
    wp_enqueue_style('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css', array(), '5.3.0');
    
    // Основной скрипт
    wp_enqueue_script('travel-portal-script', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
    
    // Bootstrap JS
    wp_enqueue_script('bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js', array(), '5.3.0', true);
    
    // Для комментариев на single страницах
    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'travel_portal_scripts');

// Регистрация сайдбаров (областей для виджетов)
function travel_portal_widgets_init() {
    register_sidebar(array(
        'name'          => __('Сайдбар блога', 'travel-portal'),
        'id'            => 'sidebar-blog',
        'description'   => __('Виджеты в сайдбаре блога', 'travel-portal'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    register_sidebar(array(
        'name'          => __('Подвал - Колонка 1', 'travel-portal'),
        'id'            => 'footer-1',
        'description'   => __('Первая колонка в подвале', 'travel-portal'),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Добавьте другие сайдбары по необходимости
}
add_action('widgets_init', 'travel_portal_widgets_init');

// Кастомные функции для портала
function travel_portal_listing_price($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $price = get_field('price', $post_id);
    if ($price) {
        return number_format($price, 0, '', ' ') . ' ₽/ночь';
    }
    
    return 'Цена не указана';
}

// Шорткод для вывода популярных направлений
function travel_portal_popular_destinations_shortcode() {
    ob_start();
    ?>
    <div class="popular-destinations-shortcode">
        <h3>Популярные направления</h3>
        <?php
        $terms = get_terms(array(
            'taxonomy' => 'listing_country',
            'hide_empty' => false,
            'number' => 5,
            'orderby' => 'count',
            'order' => 'DESC'
        ));
        
        if ($terms) {
            echo '<ul>';
            foreach ($terms as $term) {
                echo '<li><a href="' . get_term_link($term) . '">' . $term->name . ' (' . $term->count . ')</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('popular_destinations', 'travel_portal_popular_destinations_shortcode');