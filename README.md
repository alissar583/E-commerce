# E-commerce app
## Introduction
app is a simple E-market application where you can offer your own products online.
But those products should be something that has an expiration date and you can add your own discounts depending on how much time this product still has before it expires.
This app offers many services where you can sign up or log in then you can add the product(s) you want to sell.
You can browse other users' products and contact them to buy something from them.
You can also add your own products and others can contact you in case they want to buy anything from you.
We also added likes, views and comments so users can give their reviews and thoughts on the products they bought freely and easily.
You can search for anything you want, depending on the name or the expiration date.
You can sort the products depending on many factors:  price, views, name or quantity left,descending or ascending.
In case you wat to see your info, products and comments log; just visit your profile page and you will find them all.
Finally, you can log out from this app easily and log in again or use a new account, and if you are done selling your products you can just delete your account and any trace of you would be totally cleared from our database.
<hr> 

### Here is a list of the packages installed:
- [laravel passport](https://laravel.com/docs/9.x/passport).

# Getting started
### Installation
<hr> 


- Clone this repository.
```
git clone https://github.com/alissar583/E-commerce.git
```

- copy this command to terminal for install the composer.
```
composer install
```
- copy this command for generate <code>.env</code> file .
```
cp .env.example .env 
```
### Don't forget to create a database with the same name in <code>.env</code> file
- run this commands .
``` 
php artisan migrate
php artisan passport:install
```
- Generate a new application key.
```
php artisan key:generate
```
- Start the local server.
```
php artisan serve 
```
#### You can download the front end side (flutter) from here : [E-commerce](https://github.com/Bisher01/E-commerce)
<hr>

## Now You Can Use This App 


