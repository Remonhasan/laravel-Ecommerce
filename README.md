![nDolish](ndolish.png)

## About nDolish

An innovative laravel ecommerce example that offers a seamless shopping experience using laravel 10x. Features : 

- Multiple Authentication [Laratrust](https://laratrust.santigarcor.me/docs/8.x/).
- Category, Subcategory and Products.
- Search Products by Category.
- Cart and Checkout.
- [Stripe Payment gateway](https://stripe.com/).
- [sslEcommerce Payment gateway](https://sslcommerz.com/)
- Reports.
- User and admin panel.

## Installation

1. Clone the repository, install the dependencies and start the application

```bash
git clone https://github.com/Remonhasan/nDolish.git
```
2. Install Composer

```bash
composer install
```
3. Rename or copy `.env.example` file to `.env`
4. Generate key

```bash
php artisan key:generate
```

5. Set your database credentials in your `.env` file
6. Set your Stripe credentials in your `.env` file. Specifically `STRIPE_KEY` and `STRIPE_SECRET`
7. Run migrations

```bash
php artisan migrate
```

8. Run `db::seed` 

```bash
php artisan db::seed 
```

9. use the laravel `pagination` for using pagination.

```bash
php artisan vendor:publish --tag=laravel-pagination
```

10. Run dev dependencies 

```bash
npm install 
npm run dev
```

11. Run project

```bash
php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

Made with 💙 for Laravel and JavaScript !
