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
		$objects = ObjectModel::getAllWithOwner($db);
		$categories = CategoryModel::all($db);

		$this->app->render('home', [
			'user' => $user,
			'objects' => $objects,
			'categories' => $categories,
		]);
	}
}
