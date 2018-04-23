SELECT *
FROM game_genre
JOIN genre on game_genre.genreid = genre.genreid
WHERE G_ID = :G_ID