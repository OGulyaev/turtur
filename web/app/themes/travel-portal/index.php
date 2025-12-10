<?php
/**
 * Основной шаблон темы
 *
 * @package Travel Portal
 */
get_header(); ?>

<main id="main" class="site-main">
    <div class="container">
        
        <?php if (have_posts()) : ?>
            
            <div class="posts-grid">
                <?php while (have_posts()) : the_post(); ?>
                    
                    <article id="post-<?php the_ID(); ?>" <?php post_class('post-card'); ?>>
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="post-content">
                            <h2 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h2>
                            
                            <div class="post-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <a href="<?php the_permalink(); ?>" class="read-more">
                                Подробнее
                            </a>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
            
            <!-- Пагинация -->
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'mid_size'  => 2,
                    'prev_text' => '&larr; Назад',
                    'next_text' => 'Вперед &rarr;',
                ));
                ?>
            </div>
            
        <?php else : ?>
            
            <div class="no-content">
                <h2>Ничего не найдено</h2>
                <p>Попробуйте поискать снова.</p>
                <?php get_search_form(); ?>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<?php get_footer(); ?>