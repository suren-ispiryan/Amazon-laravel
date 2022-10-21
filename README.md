Amazon

// ========Project setup======== \\
1) clone
2) composer install
3) create .env file
4) php artisan key:generate
   
// ========Database set up======== \\
5) connect db ()
6) php artisan config:cache
7) php artisan migrate
8) php artisan db:seed or php artisan migrate:refresh --seed

// ========Mail system mailtrap.io setup======== \\
9) set in env -> QUEUE_CONNECTION=database
10) php artisan queue:listen + php artisan users:send_products -> for manual testing
11) php artisan queue:listen + php artisan schedule:work -> for automate working
12) set configs for Mailtrao.io
   email for mailtrap: suren.ispiryan2016@gmail.com
   password for mailtrap: testMailtrap96
   for SMTP set ->
   ----------------
   Host: smtp.mailtrap.io
   Port: 25 or 465 or 587 or 2525
   Username: db82213896d04a
   Password: 724e1bcd7e85b5
   Auth: PLAIN, LOGIN and CRAM-MD5
   TLS: Optional (STARTTLS on all ports)
   for POP3 set ->
   ----------------
   Host: pop3.mailtrap.io
   Port: 1100 or 9950
   Username: db82213896d04a
   Password: 724e1bcd7e85b5
   Auth: USER/PASS, PLAIN, LOGIN, APOP and CRAM-MD5
   TLS: Optional (STARTTLS on all ports)

//========Captcha========\\
13) 13.1 Captcha site-key for connecting frontend and backend
         REACT_APP_SITE_KEY=6LdnJnYiAAAAAHtXqZf7ZQOkceIB72wuWgPei7yR
    13.2 Captcha secret-key for connecting backend and google profile
         RECAPTCHA_KEY=6LdnJnYiAAAAABZS3vOtysSp-_j0uKmnNo6nFe1O
    13.3 Recaptcha verify api link
         RECAPTCHA_SITE_VERIFY=https://www.google.com/recaptcha/api/siteverify

//=======Pusher=======\\
14) 14.1 Run in terminal "composer require pusher/pusher-php-server" command
    set global variables in .env
    14.2 PUSHER_APP_ID=1495258
    14.3 PUSHER_APP_KEY=6014ac3bdb98a5b9f8c9
    14.4 PUSHER_APP_SECRET=a706d53303217cc5939a
    14.5 PUSHER_APP_CLUSTER=mt1

//========Run project========\\
15) php artisan serve

//=========Login========\\
16) for admin login go to "/login-admin" page
    for user login  go to "/login" page



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
+ must see all products comments.

Registration
+ First Name
+ Last Name
+ Email
+ Password
+ Re-enter password
+ Confirm email
+ Captcha v3

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
+ Automatically send emails to users about added products in past 24 hours.
+ Product comment crud, like, unlike.
+ Product like, unlike.
- Realtime chat.

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
+ Publish/UnPublish Product (not available in products for guests if unpublished).
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
