<?php
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use ProduitsApi\ProduitsDAO;

ErrorHandler::register();
ExceptionHandler::register();

$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app['dao.produits'] = function ($app) {
	return new ProduitsDAO($app['db']);
};

// Register JSON data decoder for JSON requests
$app->before(function (Request $request) use ($app) {
        //if($request->request->get('key') == 'aaaaaa'){
            if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
                    $data = json_decode($request->getContent(), true);
                    $request->request->replace(is_array($data) ? $data : array());
            }
        /*}else{
            return $app->json('Error api key ', 404);
        }*/
});

$app->after(function(Request $request, Response $response){
    $response->headers->set('Access-Control-Allow-Origin', '*');
});

