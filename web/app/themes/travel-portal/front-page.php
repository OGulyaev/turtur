<?php
/**
 * Шаблон главной страницы
 * Template Name: Главная страница
 */
get_header(); ?>

<main id="primary" class="site-main">
    
    <!-- Hero секция -->
    <section class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">Найдите идеальное место для вашего путешествия</h1>
                <p class="hero-description">Тысячи проверенных вариантов размещения по всему миру</p>
                
                <!-- Форма поиска -->
                <div class="hero-search">
                    <form role="search" method="get" class="search-form" action="<?php echo home_url('/'); ?>">
                        <input type="hidden" name="post_type" value="listing">
                        <div class="search-fields">
                            <input type="text" name="s" placeholder="Куда хотите поехать?" value="<?php echo get_search_query(); ?>">
                            <select name="listing_country">
                                <option value="">Любая страна</option>
                                <?php
                                $countries = get_terms(array(
                                    'taxonomy' => 'listing_country',
                                    'hide_empty' => false,
                                ));
                                foreach ($countries as $country) {
                                    echo '<option value="' . $country->slug . '">' . $country->name . '</option>';
                                }
                                ?>
                            </select>
                            <button type="submit" class="search-submit">Найти</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Популярные категории -->
    <section class="categories-section">
        <div class="container">
            <h2 class="section-title">Популярные направления</h2>
            <div class="categories-grid">
                <?php
                $popular_countries = get_terms(array(
                    'taxonomy' => 'listing_country',
                    'hide_empty' => false,
                    'number' => 6,
                    'orderby' => 'count',
                    'order' => 'DESC',
                ));
                
                foreach ($popular_countries as $country) :
                    $image_id = get_term_meta($country->term_id, 'category_image', true);
                    $image_url = $image_id ? wp_get_attachment_url($image_id) : get_template_directory_uri() . '/assets/images/default-country.jpg';
                ?>
                    <a href="<?php echo get_term_link($country); ?>" class="category-card">
                        <div class="category-image" style="background-image: url('<?php echo $image_url; ?>');"></div>
                        <div class="category-content">
                            <h3><?php echo $country->name; ?></h3>
                            <span class="category-count"><?php echo $country->count; ?> объявлений</span>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    
    <!-- Последние объявления -->
    <section class="listings-section">
        <div class="container">
            <div class="section-header">
                <h2 class="section-title">Свежие объявления</h2>
                <a href="<?php echo home_url('/listings'); ?>" class="view-all">Смотреть все</a>
            </div>
            
            <div class="listings-grid">
                <?php
                // Запрос последних объявлений
                $listings_args = array(
                    'post_type'      => 'listing',
                    'posts_per_page' => 6,
                    'orderby'        => 'date',
                    'order'          => 'DESC',
                    'post_status'    => 'publish',
                );
                
                $listings_query = new WP_Query($listings_args);
                
                if ($listings_query->have_posts()) :
                    while ($listings_query->have_posts()) : $listings_query->the_post();
                        // Подключаем шаблон карточки объявления
                        get_template_part('template-parts/content', 'listing-card');
                    endwhile;
                    wp_reset_postdata();
                else :
                    echo '<p>Пока нет объявлений.</p>';
                endif;
                ?>
            </div>
        </div>
    </section>
    
    <!-- Преимущества -->
    <section class="features-section">
        <div class="container">
            <h2 class="section-title">Почему выбирают нас</h2>
            <div class="features-grid">
                <div class="feature">
                    <div class="feature-icon">🏆</div>
                    <h3>Проверенные объявления</h3>
                    <p>Все предложения проверяются перед публикацией</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">💰</div>
                    <h3>Лучшие цены</h3>
                    <p>Находите оптимальные варианты для любого бюджета</p>
                </div>
                <div class="feature">
                    <div class="feature-icon">📞</div>
                    <h3>Поддержка 24/7</h3>
                    <p>Наша служба поддержки всегда готова помочь</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA секция -->
    <section class="cta-section">
        <div class="container">
            <div class="cta-content">
                <h2>Хотите разместить свое объявление?</h2>
                <p>Добавьте ваше жилье и начните принимать гостей уже сегодня</p>
                <?php if (is_user_logged_in()) : ?>
                    <a href="<?php echo admin_url('post-new.php?post_type=listing'); ?>" class="btn btn-large">
                        Добавить объявление
                    </a>
                <?php else : ?>
                    <a href="<?php echo home_url('/registration'); ?>" class="btn btn-large">
                        Зарегистрироваться
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </section>

</main>

<?php get_footer(); ?>