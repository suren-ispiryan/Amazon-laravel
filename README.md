Amazon

Project setup
1) clone
2) composer install
3) php artisan key:generate
4) php artisan config:cache
5) php artisan migrate
6) php artisan serve
7) create .env file
8) connect db ()
9) php artisan db:seed or php artisan migrate:refresh --seed


Description

Project setup
1) clone
2) composer install
3) php artisan key:generate
4) php artisan config:cache
5) php artisan migrate
6) php artisan serve
7) create .env file
8) connect db ()
9) change manually status from user to admin

All users
+ loading spinner.
+ Should see a list of all products (cards view).
+ See product details by clicking on product.
+ Can Search products.
+ Add products to cart.
+ Remove products from cart.

Guests
+ Can filter the list by product categories.
+ Can add the product to the cart.(localStorage).
+ Can remove the product from the cart.
+ Once clicked on “Proceed to checkout” should be redirected to the login/register page.
+ Note: Once registered data from localStorage should be stored in DB.

Registration
+ First Name
+ Last Name
+ Email
+ Password
+ Re-enter password
+ Confirm email

Logged In User
+ Form validations.
+ Should be able to see all orders.
+ Change password.
+ Page “Your Addresses” (user can have multiple addresses).
+ Set address as default.
+ Buy products.
+ show Added on cart products, available addresses.
+ Ability set default one from available addresses before buying products.
+ Show ordered list.
+ Adding and reducing product count form cart-products and ready-to-buy pages.
+ Can save the product from the cart into the “Save for later” list.

My Store
+ Product CRUD.
+ Name.
+ Description.
+ Brand.
+ Price.
+ In stock.
+ Choose colors.
+ Choose sizes.
+ Choose Category.
+ Images.
+ Delete product image
+ Publish/Unpublish Product (not available in products for guests if unpublished).
+ Ability to see how many times users bought each product.
+ Ability to choose products subcategories while creating a product.
- Ability to choose a main image.
- Ability to see total earnings for each product.

Admin
+ Form validations.
+ Categories CRUD.
+ Subcategories CRUD.
+ Sizes CRUD.
+ Users crud.
+ Products crud.
+ Must see all orders.
+ Have a seed to import default categories with their subcategories, users, categories and sizes.
+ Category CRUD (categories can have subcategories).
