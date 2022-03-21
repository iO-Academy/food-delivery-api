<?php
declare(strict_types=1);

use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface as Group;

return function (App $app) {
    $container = $app->getContainer();

    $app->get('/', function ($request, $response, $args) use ($container) {
        $renderer = $container->get('renderer');
        return $renderer->render($response, "index.php", $args);
    });

    $app->get('/restaurants', function ($request, $response) {
        try {
            $food = json_decode(file_get_contents('../public/food.json'), true);
            $restaurants = [];
            foreach ($food as $id => $restaurant) {
                $restaurants[] = [
                    'name' => $restaurant['restaurant'],
                    'id' => ++$id
                ];
            }

            $response->getBody()->write(json_encode($restaurants));
            return $response->withHeader('Content-type', 'application/json')->withStatus(200);
        } catch(Exception $exception) {
            $response->getBody()->write(json_encode(['message' => 'Unexpected error']));
            return $response->withHeader('Content-type', 'application/json')->withStatus(500);
        }
    });

    $app->get('/restaurants/{id}', function ($request, $response, $args) {
        try {
            $food = json_decode(file_get_contents('../public/food.json'), true);
            $chosenRestaurant = [];
            foreach($food as $id => $restaurant) {
                ++$id;
                if ($id == $args['id']) {
                    $chosenRestaurant = $restaurant;
                    break;
                }
            }
            if (empty($chosenRestaurant)) {
                $response->getBody()->write(json_encode(['message' => 'Invalid restaurant ID']));
                return $response->withHeader('Content-type', 'application/json')->withStatus(400);
            }

            $response->getBody()->write(json_encode($restaurant));
            return $response->withHeader('Content-type', 'application/json')->withStatus(200);
        } catch(Exception $exception) {
            $response->getBody()->write(json_encode(['message' => 'Unexpected error']));
            return $response->withHeader('Content-type', 'application/json')->withStatus(500);
        }
    });

    $app->post('/orders', function ($request, $response, $args) use ($container) {
        $order = $request->getParsedBody();

        if (empty($order['items']) || empty($order['total'])) {
            $response->getBody()->write(json_encode(['message' => 'Order must contain food items']));
            return $response->withHeader('Content-type', 'application/json')->withStatus(400);
        }

        $totalTime = round($order['total'] * 60);
        $prepTime = ($totalTime < 1200 ? 1200 : $totalTime - 900) + random_int(0, 120);
        $deliveryTime = 900 + random_int(0, 120); // 15 mins + 0-2 mins

        $responseData = [
            'message' => 'Order saved successfully',
            'prepTime' => $prepTime,
            'deliveryTime' => $deliveryTime
        ];

        $response->getBody()->write(json_encode($responseData));
        return $response->withHeader('Content-type', 'application/json')->withStatus(200);
    });

};
