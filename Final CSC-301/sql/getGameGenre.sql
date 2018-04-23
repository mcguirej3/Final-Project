SELECT game_genre.G_ID, genre.genreid, genre.Name
FROM game_genre
JOIN genre on game_genre.genreid = genre.genreid;