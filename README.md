# Food Delivery API

**For trainers:** The API is deployed at https://food-delivery-api.dev.io-academy.uk/, use this when deploying student-built front-end applications.

<details>
<summary>Run the API locally</summary>

Clone this repo:

```bash
git clone git@github.com:iO-Academy/food-delivery-api.git
```

Once cloned, move into the `food-delivery-api` directory:

```bash
cd food-delivery-api
```

Then you must install the slim components by running:

```bash
composer install
```

To run the application locally:
```bash
composer start
```
**Do not close this terminal tab, it is a running process.**

The API will now be accessible at `http://localhost:8080/`.

That's it! Now go build something cool.
</details>

## API Docs

### Return all restaurants available to order from

* **URL**

  /restaurants

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

  **Example:**

  `/restaurants`

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  [
    {
      "name": "Chipotle",
      "id": 1
    },
    {
      "name": "Panera",
      "id": 2
    },
    {
      "name": "Burger King",
      "id": 3
    }
  ]
  ```

* **Error Response:**

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error"}`

### Return all food items for a given restaurant

* **URL**

  /restaurants/{id}

* **Method:**

  `GET`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

  **Example:**

  `/restaurants/3`

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
  {
    "restaurant":"Burger King",
    "foodItems":[
      {
        "foodName":"Whopper",
        "foodType":"Burger",
        "calories":660,
        "price":4.89
      },
      {
        "foodName":"Whopper Sandwich",
        "calories":660,
        "price":3.76
      }
    ]
  }
  ```

* **Error Response:**

    * **Code:** 400 INVALID REQUEST <br />
      **Content:** `{"message":"Invalid restaurant ID"}`

    * **Code:** 500 SERVER ERROR <br />
      **Content:** `{"message": "Unexpected error"}`

### Create a new order

* **URL**

  /orders

* **Method:**

  `POST`

* **URL Params**

  **Required:**

  There are no required URL Params

  **Optional:**

  There are no optional URL Params

  **Example:**

  `/orders`

* **Body Data**

```json
{
    "items": [
        {"name": "example", "price": 12.49, "qty": 1},
        {"name": "example 2", "price": 12.30, "qty": 1}
    ],
    "total": 24.79
}
```

`items` and `total` must not be empty.

* **Success Response:**

    * **Code:** 200 <br />
      **Content:** <br />

  ```json
    {
    "message": "Order saved successfully",
    "prepTime": 645,
    "deliveryTime": 926
    }
  ```
  `prepTime` and `deliveryTime` are in seconds, the combination of the 2 will give you the total time to delivery from when the order is placed.
  

* **Error Response:**

    * **Code:** 400 INVALID REQUEST <br />
      **Content:** `{"message":"Order must contain food items"}`
