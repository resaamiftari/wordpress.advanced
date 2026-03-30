<?php
/*
Template Name: Movies Page
*/
get_header();
?>

<div class="movies-page">
    <h1>My Movies</h1>

    <?php
    // Array of movies (you can edit/add here)
    $movies = [
        [
            "title" => "Inception",
            "year" => "2010",
            "description" => "A mind-bending thriller about dreams within dreams."
        ],
        [
            "title" => "The Dark Knight",
            "year" => "2008",
            "description" => "Batman faces the Joker in Gotham City."
        ],
        [
            "title" => "Interstellar",
            "year" => "2014",
            "description" => "A journey through space and time to save humanity."
        ]
    ];

    foreach ($movies as $movie) {
        echo "<div class='movie'>";
        echo "<h2>" . esc_html($movie['title']) . " (" . esc_html($movie['year']) . ")</h2>";
        echo "<p>" . esc_html($movie['description']) . "</p>";
        echo "</div>";
    }
    ?>

</div>

<?php get_footer(); ?>

<h1>My Movies</h1>

<?php for ($i = 1; $i <= 3; $i++) : ?>
    <div class="movie">
        <h2><?php the_field("movie_{$i}_title"); ?> (<?php the_field("movie_{$i}_year"); ?>)</h2>
        <p><?php the_field("movie_{$i}_description"); ?></p>
    </div>
<?php endfor; ?>

