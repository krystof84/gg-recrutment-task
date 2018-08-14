<footer>
    <div class="container">
        <?php 
        if(is_active_sidebar('bb-footer-widget-1')): 
            dynamic_sidebar('bb-footer-widget-1');
        endif; 

        if(is_active_sidebar('bb-footer-widget-2')): 
            dynamic_sidebar('bb-footer-widget-2');
        endif; 

        if(is_active_sidebar('bb-footer-widget-3')): 
            dynamic_sidebar('bb-footer-widget-3');
        endif; 
        ?>
    </div>
    <?php wp_footer(); ?>
</footer>
</body>
</html>