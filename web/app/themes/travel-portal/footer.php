<footer id="colophon" class="site-footer">
        <div class="container">
            <div class="footer-widgets">
                <div class="footer-column">
                    <?php if (is_active_sidebar('footer-1')) : ?>
                        <?php dynamic_sidebar('footer-1'); ?>
                    <?php endif; ?>
                </div>
                
                <div class="footer-column">
                    <h3>Быстрые ссылки</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer',
                        'menu_id'        => 'footer-menu',
                        'container'      => false,
                        'depth'          => 1,
                    ));
                    ?>
                </div>
                
                <div class="footer-column">
                    <h3>Контакты</h3>
                    <p>Email: info@site.info</p>
                    <p>Телефон: +7 (999) 123-45-67</p>
                </div>
            </div>
            
            <div class="site-info">
                <div class="copyright">
                    &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. Все права защищены.
                </div>
                <div class="footer-links">
                    <a href="<?php echo home_url('/privacy-policy'); ?>">Политика конфиденциальности</a>
                    <a href="<?php echo home_url('/terms'); ?>">Условия использования</a>
                </div>
            </div>
        </div>
    </footer>
</div>

<?php wp_footer(); ?>
</body>
</html>