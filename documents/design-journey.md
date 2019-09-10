# Project 2: Design Journey

Your Name: Anthony Sheehi

**All images must be visible in Markdown Preview. No credit will be provided for images in your repository that are not properly linked in Markdown. Assume all file paths are case sensitive!**

# Project 2, Milestone 1 - Design, Plan, & Draft Website

## Describe your Catalog

[What will your collection be about? What types of attributes will you keep track of for the *things* in your collection? 1-2 sentences.]

My collection is about video games, particularly used games at a game store called "GameBase". I will be using attributes of games that gamers usually look for when searching for and purchasing games (i.e. genre).


## Target Audiences

[Tell us about your target audience(s).]

My target audience is local gamers who desire to purchase games. Or rather, the company "GameBase" requires a website to run their store and compete with rivaling establishments in the local game-selling industry, so it is as if I am tasked with this assignment (real-world application).

## Design Process

[Document your design process. Show us the evolution of your design from your first idea (sketch) to design you wish to implement (sketch). Show us the process you used to organize content and plan the navigation (card sorting).]

[Label all images. All labels must be visible in Markdown Preview.]


## Final Design Plan

[Include sketches of your final design here.]

![Ideas/Home Page Sketch](sketch1.png)
![Game Database Page & About Page Sketch](sketch2.png)
![Add a Game (form) Page Sketch](sketch3.png)

**Ended up combining "Add a Game" page with the "Game Database" page for simplicity purposes**

## Templates

[Identify the templates you will use on your site.]

Templates to be used

    * Header
        * Containing the website title, website header, artwork/logo, address info, etc. (everything in the top box of the design sketches)
    * Navigation Bar
        * Containing links to all four web pages of the site (with a current page indicator)
    *Footer
        * This would include social media links, address again, brief contact info for the store, maybe manager name... copyright/legal information


## Database Schema Design

[Describe the structure of your database. You may use words or a picture. A bulleted list is probably the simplest way to do this. Make sure you include constraints for each field.]

Table: gamebase
* field 1: id, INTEGER, NOT NULL, Primary Key, Auto Incrementing, Unique
* field 2: game_title, TEXT, NOT NULL, Unique
* field 3: platform, TEXT, NOT NULL
* field 4: genre, TEXT, NOT NULL
* field 5: players, TEXT, NOT NULL

## Database Query Plan

[Plan your database queries. You may use natural language, pseudocode, or SQL.]

1. All records

SELECT * FROM gamebase;

2. Search records

SELECT * FROM gamebase WHERE (game_title LIKE user-input);

3. Insert record

INSERT INTO gamebase (game_title, platform, price, rating, genre, players)
VALUES (userIn_title, userIn_plat, userIN_price, userIN_rating, userIn_genre, userIN_players)

## Code Planning

[Plan any PHP code you'll need here.]

* Will need PHP to make the TABLE
    * function print_record($record) {
            This function will echo htmlspecialchars of the outputs of the records found in the database
        }
    *   "PHP Code:
            $sql = "SELECT * FROM gamebase";
            $params = array();
            $result = exec_sql_query($db, $sql, $params);
        "
    * ALL VERY SIMILAR TO LAB 05

* Will also need PHP to make the templates for the header, nav bar, and footer


# Final Submission: Complete & Polished Website

## Reflection

[Take this time to reflect on what you learned during this assignment. How have you improved since Project 1? What things did you have trouble with?]

I have definitely grown as a website developer from the time I finished project 1 to now. I feel a lot more comfortable with the content and syntax of PHP and HTML, and now I feel comfortable using databases because I realize how they work. I had so much trouble trying to implement the database into the website (to the point where I had to create a gameBase2.php and start over), but now I think I understand what was giving me trouble. The website itself is sleeker, and I was able to create it faster compared to project 1. Seeing my growth is exciting, and I enjoy doing these projects.
