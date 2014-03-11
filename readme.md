# A personal Home Page
----------------------
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

#### Making it easier to collect your favourite links.

A home page listing all your collected links, displaying them with an image. You can set a descriptive name which will appear as a tooltip when hovering the link. The links are categorised by your chosen names and ordered by a specified order number. At the top of the page, a best of section appears, listing the ten most clicked links.

Yes, it's ~~horribly~~ not brilliantly coded and full of bad practices at the moment, but that will get better with every commit. Right now it's just here for some friends to play with. I made it to learn html and css at first and now using it to get better with php, mysql, javascript and whatever else I might think of. Plus it's kinda useful to have all my links in one convenient place.

## Requires
-----------

For now, this requires a localhost server to work. I have a [WAMP server](http://www.wampserver.com/en/) setup to handle the PHP. It was originaly meant to run locally (it used to be a flat html file), but I will eventually make it safe enough to run on a web server. As it is, it should definitely not be put online.


## Set Up
---------

1. Install WAMP/LAMP/MAMP.
2. Clone this repo in the localhost rootfolder or download and place it there
3. Create an images folder in your cloned folder. Call it 'images'
4. Start your server
5. Go to phpMyAdmin and create a database
6. Import the sql into that db
7. Open scripts/db/db-config.php and set your hostname, username, dbname and password
8. Go to localhost/yourfoldername (or the LAMP/MAMP equivalent)
9. You should see an empty page with two little plusses. The left plus is for adding a link, the right plus is for adding a category. You can also use the hotkeys: ALT + q for a new link and Alt + c for a new category.
10. Start by adding a category. It needs a name and an order
11. Now you have one or more categories, you can start adding links
12. Don't forget to make it your homepage in your favourite browser('s) !

### Adding links
---------------

The add link form has 5 input fields. First the link. This should be the complete link (including http(s)), it's easiest to just copy the url from the address bar.

Next the image name. This should be the full name (including extension), but without the folder name (unless you're using subfolders). If you hover over the image name input, you should see the image appear next to your pointer. The category can be selected from a dropdown, containing all categories in the db. You can add more by hitting the 'add category' button.

Finally you need to give the link an order. This can be an integer (whole number) or a float (decimal number). The links will appear sorted by their order number.


## TODO
-------

- Refactor code. This will be ongoing.
- Automate setting up the db
- Collect all files needed to run the app in dist folder
- Build a drag and drop ordering interface for the links and the categories
- Add a range selector to select the number of links in the Best Of
- Hook up all the js through require
- Make subcategories that will have their own page ?
- Find or make a quirky and loveable drawing to be my logo
- Get a cool sounding name that's missing a vowel

## License
----------

&copy; 2014 Tim Doppenberg (handyCAPS)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.