<?php
declare(strict_types=1);

namespace app\controllers;

class HomeController extends BaseController
{
	public function index(): void
	{
		$user = $this->requireLogin();
		$this->app->render('home', [
			'user' => $user,
		]);
	}
}
