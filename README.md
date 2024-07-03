
## Product Packaging Selector

This project aims to find the smallest possible box (or set of boxes) to fit a given set of products, optimizing packing efficiency based on specific constraints.

Features
- Product Input: Allows users to input a list of products with dimensions.
- Box Selection: Automatically selects the smallest possible box (or combination of boxes) to fit all input products.
- Constraints Handling: Handles constraints such as weight limits, volume restrictions, and other packaging requirements.
- Optimization: Uses algorithms to optimize packing efficiency and minimize wasted space.
- Output: Provides details of the selected box(es) and how products are packed within them.





## Setup/Installation

```
git clone https://github.com/strifeserver/machship-packaging
```

```
cd machship-packaging
```

```
composer install
```

```
php artisan serve
```

you have the option to acesss http://127.0.0.1:8000/products for user input or running php artisan test


## The Task

Determine the smallest box that fits all of the products submitted together hence the combined box.

Conditions:
- Ensure that the total volume of products is smaller than the total volume of the box.
- No dimension of any product can be greater than any dimension of the box.
- Ensure that the total weight of products is less than the total box weight limit.

IF product won't fit, take the largest product off the product list and allocate to its own box with accordance to the conditions. Throw an Error if unable to find the box for the product. 

