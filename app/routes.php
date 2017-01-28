<?php
use Symfony\Component\HttpFoundation\Request;
use ProduitsApi\Produits;

// Get all users
$app->get('/api/produits', function () use ($app) {

	$produits = $app['dao.produits']->findAll();
	$responseData = array();
	foreach ($produits as $produit) {
		$responseData[] = array(
			'id' => $produit->getId(),
			'code_barre' => $produit->getCodeBarre(),
			'nom' => $produit->getNom()
		);
	}

	return $app->json($responseData);
})->bind('api_produits');

// Get on user
$app->get('/api/produit/{id}', function ($id, Request $request) use ($app) {
	$produit = $app['dao.produits']->find($id);
	if (!isset($produit)) {
		$app->abort(404, 'Produit not exist');
	}

	$responseData = array(
		'id' => $produit->getId(),
		'firstname' => $produit->getCodeBarre(),
		'lastname' => $produit->getNom()
	);

	return $app->json($responseData);
})->bind('api_produit');

$app->get('/api/produitInfo/{codeBarre}', function($codeBarre) use ($app){
    
    $retour = json_decode(file_get_contents("http://fr.openfoodfacts.org/api/v0/produit/$codeBarre.json"));
    
    if($retour->status == 0){
        return $app->json('barre Code not found', 404);
    }else{
        $tabProduct = array(
            'nom' => $retour->product->generic_name_fr,
            'marque' => $retour->product->brands,
            'code_barre' => $retour->product->id
        );
        return $app->json($tabProduct, 200);
    }
})->bind('api_produit_code_barre');

// Create user
$app->post('/api/produit/create', function (Request $request) use ($app) {
	if (!$request->request->has('code_barre')) {
		return $app->json('Missing parameter: code_barre', 400);
	}
	if (!$request->request->has('nom')) {
		return $app->json('Missing parameter: nom', 400);
	}

	$produit = new Produits();
	$produit->setCodeBarre($request->request->get('code_barre'));
	$produit->setNom($request->request->get('nom'));
        $produit->setDuree($request->request->get('duree'));
	$app['dao.produits']->save($produit);

	$responseData = array(
		'id' => $produit->getId(),
		'code_barre' => $produit->getCodeBarre(),
		'nom' => $produit->getNom()
	);

	return $app->json($responseData, 201);
})->bind('api_produit_add');

// Delete user
$app->delete('/api/produit/delete/{id}', function ($id, Request $request) use ($app) {
	$app['dao.produits']->delete($id);

	return $app->json('No content', 204);
})->bind('api_produit_delete');

// Update user
$app->put('/api/produit/update/{id}', function ($id, Request $request) use ($app) {
	$produit = $app['dao.produits']->find($id);

	$produit->setCodeBarre($request->request->get('code_barre'));
	$produit->setNom($request->request->get('nom'));
        $produit->setDuree($request->request->get('duree'));
	$app['dao.produits']->save($produit);

	$responseData = array(
		'id' => $produit->getId(),
		'code_barre' => $produit->getCodeBarre(),
		'nom' => $produit->getNom()
	);

	return $app->json($responseData, 202);
})->bind('api_produit_update');

