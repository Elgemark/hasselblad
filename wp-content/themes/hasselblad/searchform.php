<form action="/wp" method="get">
        <label for="search"></label>
    <fieldset>
        <input type="text" placeholder='Sök'  name="s" id="search" value="<?php the_search_query(); ?>" />
        <input type="image" id="image" alt="Search" src="<?php echo get_stylesheet_directory_uri(); ?>/images/search.png" />
    </fieldset>
</form>