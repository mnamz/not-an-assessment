# README #

Food ordering system - an assessment for something

# Setup
After cloning this repository run this following command first

```
composer install
npm install
cp .env.example .env
php artisan migrate:fresh --seed
``` 

After that, you're set with dummy data. Should be enough to get started.

Paypal sandbox account (.env.example has API credentials attached)

```
sb-466az22297623@personal.example.com
2mZ!dyj9
```
```
sb-p6dt123457630@business.example.com
If"&oM0h
```
# Features

### Simple interface
Main site presents very simple interface of restaurants and menu avaialble. Categories and query are handled by vue.

## For customer
Use the homepage to find items, you can select pickup or delivery (different charge). Pay by cash (boot to success page) or paypal (both order will send to backend regardless)

### Restaurant
Newly registered user are assigned to manager role - each of them will have an individual restaurant

## Dashboard 

### Role based
Admin and manager role. Some items are limited to respective restaurants (manager role)

### Admin functionality
- Able to approve/reject user (to deactive simply change user status)
- Oversees order, products and users within the system

### Manager functionality
- Able to handle incoming orders (and reject them)
- Simple table reporting on the dashboard and orders page

## Opinion
Frontend part uses some API. Just basic stuff such as

`POST /api/process-order` - sends order to backend

`GET /api/restaurants` - retrieves all restaurants

`GET /api/items` - retrieves all items (didn't do much)

Sample response for restaurants endpoint
```
{
	"data": {
		"id": 2,
		"name": "Ledner, Orn and Gottlieb",
		"categories": [
			"doloribus",
			"voluptatem"
		],
		"location": "8608 Erich Harbor Suite 336\nSouth Ora, OR 64735-3146",
		"user_id": 4,
		"created_at": "2024-05-19T10:36:39.000000Z",
		"updated_at": "2024-05-19T10:36:39.000000Z",
		"items": [
			{
				"id": 11,
				"name": "unde",
				"restaurant_id": 2,
				"price": "10.92",
				"image": "https:\/\/via.placeholder.com\/640x480.png\/00bb00?text=est",
				"details": "blanditiis",
				"created_at": "2024-05-19T10:36:39.000000Z",
				"updated_at": "2024-05-19T10:36:39.000000Z"
			},
            ... and more
            
```
Most dashboard APIs are handled by Inertia.js for CRUD stuff

## Concerns

mnamz101@gmail.com

____
Here's bober. Cheers.

![](https://media1.tenor.com/m/fF4sTbrZvnsAAAAd/bober-kurwa.gif)


