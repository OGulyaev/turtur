<?php
/**
 * Шаблон для отображения отдельного объявления (listing)
 */
get_header(); ?>

<main id="primary" class="site-main">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class('listing-single'); ?>>
                
                <!-- Хлебные крошки -->
                <div class="breadcrumbs">
                    <?php
                    if (function_exists('bcn_display')) {
                        bcn_display();
                    } else {
                        echo '<a href="' . home_url() . '">Главная</a> &raquo; ';
                        echo '<a href="' . home_url('/listings') . '">Объявления</a> &raquo; ';
                        echo '<span>' . get_the_title() . '</span>';
                    }
                    ?>
                </div>
                
                <!-- Заголовок и мета-информация -->
                <header class="listing-header">
                    <h1 class="listing-title"><?php the_title(); ?></h1>
                    
                    <div class="listing-meta">
                        <?php if ($price = get_field('price')) : ?>
                            <div class="listing-price"><?php echo number_format($price, 0, '', ' '); ?> ₽/ночь</div>
                        <?php endif; ?>
                        
                        <?php if ($address = get_field('address')) : ?>
                            <div class="listing-address">📍 <?php echo esc_html($address); ?></div>
                        <?php endif; ?>
                        
                        <div class="listing-stats">
                            <?php if ($guests = get_field('guests')) : ?>
                                <span class="stat">
                                    <span class="stat-icon">👥</span>
                                    <span class="stat-value"><?php echo $guests; ?> гостей</span>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($bedrooms = get_field('bedrooms')) : ?>
                                <span class="stat">
                                    <span class="stat-icon">🛏️</span>
                                    <span class="stat-value"><?php echo $bedrooms; ?> спален</span>
                                </span>
                            <?php endif; ?>
                            
                            <?php if ($bathrooms = get_field('bathrooms')) : ?>
                                <span class="stat">
                                    <span class="stat-icon">🚿</span>
                                    <span class="stat-value"><?php echo $bathrooms; ?> ванных</span>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>
                </header>
                
                <!-- Галерея изображений -->
                <?php if ($gallery = get_field('gallery')) : ?>
                    <div class="listing-gallery">
                        <div class="gallery-main">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('listing-large', array('class' => 'main-image')); ?>
                            <?php else : ?>
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/images/default-listing.jpg" alt="<?php the_title(); ?>" class="main-image">
                            <?php endif; ?>
                        </div>
                        
                        <?php if (count($gallery) > 0) : ?>
                            <div class="gallery-thumbs">
                                <?php foreach ($gallery as $image) : ?>
                                    <div class="thumb">
                                        <img src="<?php echo $image['sizes']['thumbnail']; ?>" 
                                             alt="<?php echo esc_attr($image['alt']); ?>" 
                                             data-full="<?php echo $image['url']; ?>">
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <div class="listing-content-wrapper">
                    <!-- Основной контент -->
                    <div class="listing-content">
                        <h2>Описание</h2>
                        <?php the_content(); ?>
                        
                        <!-- Удобства -->
                        <?php if ($amenities = get_field('amenities')) : ?>
                            <div class="listing-amenities">
                                <h3>Удобства</h3>
                                <ul class="amenities-list">
                                    <?php foreach ($amenities as $amenity) : ?>
                                        <li><?php echo $amenity; ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Карта -->
                        <?php if ($location = get_field('location')) : ?>
                            <div class="listing-map">
                                <h3>Расположение</h3>
                                <div class="acf-map" data-zoom="16">
                                    <div class="marker" 
                                         data-lat="<?php echo esc_attr($location['lat']); ?>" 
                                         data-lng="<?php echo esc_attr($location['lng']); ?>">
                                        <h4><?php the_title(); ?></h4>
                                        <p><?php echo esc_html($location['address']); ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Сайдбар с формой бронирования -->
                    <aside class="listing-sidebar">
                        <div class="booking-widget">
                            <h3>Забронировать</h3>
                            
                            <div class="booking-price">
                                <span class="price"><?php echo number_format(get_field('price'), 0, '', ' '); ?> ₽</span>
                                <span class="period">/ ночь</span>
                            </div>
                            
                            <form class="booking-form">
                                <div class="form-group">
                                    <label for="checkin">Заезд</label>
                                    <input type="date" id="checkin" name="checkin" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="checkout">Выезд</label>
                                    <input type="date" id="checkout" name="checkout" required>
                                </div>
                                
                                <div class="form-group">
                                    <label for="guests">Гости</label>
                                    <select id="guests" name="guests">
                                        <?php
                                        $max_guests = get_field('guests') ?: 4;
                                        for ($i = 1; $i <= $max_guests; $i++) {
                                            echo '<option value="' . $i . '">' . $i . ' ' . _n('гость', 'гостей', $i, 'travel-portal') . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                
                                <button type="submit" class="btn btn-primary btn-block">
                                    Забронировать
                                </button>
                            </form>
                            
                            <div class="contact-owner">
                                <h4>Связаться с владельцем</h4>
                                <?php
                                $author_id = get_the_author_meta('ID');
                                $author_email = get_the_author_meta('user_email');
                                ?>
                                <a href="mailto:<?php echo antispambot($author_email); ?>" class="btn btn-outline btn-block">
                                    Написать сообщение
                                </a>
                            </div>
                        </div>
                    </aside>
                </div>
                
                <!-- Владелец объявления -->
                <div class="listing-author">
                    <div class="author-avatar">
                        <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                    </div>
                    <div class="author-info">
                        <h4>Владелец: <?php echo get_the_author_meta('display_name'); ?></h4>
                        <p>На сайте с <?php echo date('d.m.Y', strtotime(get_the_author_meta('user_registered'))); ?></p>
                    </div>
                </div>
                
            </article>
            
        <?php endwhile; ?>
        
    </div>
</main>

<?php get_footer(); ?>