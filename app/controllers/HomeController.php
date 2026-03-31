<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\CategoryModel;
use app\models\ObjectModel;

class HomeController extends BaseController
{
	public function index(): void
	{
		$user = $this->requireLogin();
		$db = $this->app->db();
		$request = $this->app->request();
		
		$query = trim((string) ($request->query->q ?? $request->data->q ?? ''));
		$categoryId = (int) ($request->query->category_id ?? $request->data->category_id ?? 0);
		
		// If search parameters are provided, use search; otherwise show all
		if ($query !== '' || $categoryId > 0) {
			$objects = ObjectModel::search($db, $query, $categoryId);
		} else {
			$objects = ObjectModel::getAllWithOwner($db);
		}
		
		$categories = CategoryModel::all($db);

		$this->app->render('home', [
			'user' => $user,
			'objects' => $objects,
			'categories' => $categories,
			'query' => $query,
			'selected_category_id' => $categoryId,
		]);
	}
}
