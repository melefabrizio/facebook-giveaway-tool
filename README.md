# The Facebook Giveaway Tool

No more manual cross-checking between likes and comments! 
I wrote small (and not pretentious at all) web app to quickly check a giveaway I organized. Just install it, visit it, and profit.

***Development in progress, not "world ready" at all***

##Installing
Basically, clone the repo or download the zip, launch composer:
  `composer.phar update`
  
Then rename `conf-example.php` to `conf.php` and insert you Facebook App keys.

Create a Facebook App via the developers dashboard, insert the full homepage url into the allowed login callbacks.

##Usage
Visit the root, you will get a little messy homepage with a login prompt, and after the login a simple form.
Insert post ID and page (or profile) ID, in the first two fields, click the button and see the magic ... kidding, no magic, the result page is just a `print_r()` that will display comments (and their author) by people who liked the commented post.

####Contributors welcome!
