# A personal Home Page
----------------------
[![Built with Grunt](https://cdn.gruntjs.com/builtwith.png)](http://gruntjs.com/)

#### Making it easier to collect your favourite links.

A home page listing all your collected links, displaying them with an image. You can add a description for each link which will appear when your hover over the image. The links are categorised by your chosen names and ordered by a specified order number. At the top of the page, a best of section appears, listing the most clicked links. You can set the amount of bestofs with a little slider. Just because that's cool.


## Requires
-----------

A running server, php 5.3 or higher and mysql. I have it running on WAMP server. At the moment it's not safe enough to go online.

## Set Up
---------

1. Download all the files in the dist/ folder, found at https://github.com/handyCAPS/handystartpage/tree/master/dist .
2. Place the files in a folder in your server root.
3. Create a database table in mysql.
4. Navigate your browser to the folder containing the files.
5. Fill out the form with your db credentials.
6. You should be taken to a screen with two plusses. Hit the right one to create your first category.
7. Start adding links !

### Adding links
---------------

The add link form has 6 input fields. First the link. This should be the complete link (including http(s)), it's easiest to just copy the url from the address bar.

Next the image. You can upload any image in the .gif, .jp(e)g or .png format. The image should not be larger than 500 kb. Your image gets uploaded as soon as the file input field looses focus.

The name should be short and descriptive, this appears as a title (tooltip) when hovered over the link. It also gets set as the alt text for the image.

The category can be selected from a dropdown, containing all categories in the db. You can add more by hitting the 'add category' button.

The description can be up to 100 characters long, but try to fit it in the box provided, as this is the same size as the place where your description will be shown.

Finally you need to give the link an order. This can be an integer (whole number) or a float (decimal number). The links will appear sorted by their order number.


## TODO
-------

- Refactor code. This will be ongoing.
- Build a drag and drop ordering interface for the links and the categories
- Make subcategories that will have their own page ?
- Find or make a quirky and loveable drawing to be my logo
- Get a cool sounding name that's missing a vowel

## License
----------

&copy; 2014 Tim Doppenberg (handyCAPS)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.