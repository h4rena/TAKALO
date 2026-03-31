<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\CategoryModel;

class CategoryController extends BaseController
{
	public function index(): void
	{
		$this->requireAdmin();
		$flash = $this->consumeFlash('admin_flash');

		$db = $this->app->db();
		$categories = CategoryModel::all($db);

		$this->app->render('admin/categories', $flash + [
			'categories' => $categories,
		]);
	}

	public function store(): void
	{
		$this->requireAdmin();
		$request = $this->app->request();
		$name = trim((string) ($request->data->name ?? ''));

		if ($name === '') {
			$this->setFlash([ 'error' => 'Nom requis.' ], 'admin_flash');
			$this->app->redirect('/admin/categories');
			return;
		}

		try {
			$db = $this->app->db();
			CategoryModel::create($db, $name);
		} catch (\Throwable $e) {
			$this->setFlash([ 'error' => 'Erreur lors de la creation.' ], 'admin_flash');
			$this->app->redirect('/admin/categories');
			return;
		}

		$this->setFlash([ 'success' => 'Categorie ajoutee.' ], 'admin_flash');
		$this->app->redirect('/admin/categories');
	}

	public function edit(int $id): void
	{
		$this->requireAdmin();
		$db = $this->app->db();
		$category = CategoryModel::find($db, $id);
		if ($category === null) {
			$this->setFlash([ 'error' => 'Categorie introuvable.' ], 'admin_flash');
			$this->app->redirect('/admin/categories');
			return;
		}

		$flash = $this->consumeFlash('admin_flash');
		$this->app->render('admin/category_edit', $flash + [
			'category' => $category,
		]);
	}

	public function update(int $id): void
	{
		$this->requireAdmin();
		$request = $this->app->request();
		$name = trim((string) ($request->data->name ?? ''));

		if ($name === '') {
			$this->setFlash([ 'error' => 'Nom requis.' ], 'admin_flash');
			$this->app->redirect('/admin/categories/' . $id . '/edit');
			return;
		}

		try {
			$db = $this->app->db();
			CategoryModel::update($db, $id, $name);
		} catch (\Throwable $e) {
			$this->setFlash([ 'error' => 'Erreur lors de la mise a jour.' ], 'admin_flash');
			$this->app->redirect('/admin/categories/' . $id . '/edit');
			return;
		}

		$this->setFlash([ 'success' => 'Categorie mise a jour.' ], 'admin_flash');
		$this->app->redirect('/admin/categories');
	}

	public function delete(int $id): void
	{
		$this->requireAdmin();

		try {
			$db = $this->app->db();
			CategoryModel::delete($db, $id);
		} catch (\Throwable $e) {
			$this->setFlash([ 'error' => 'Impossible de supprimer.' ], 'admin_flash');
			$this->app->redirect('/admin/categories');
			return;
		}

		$this->setFlash([ 'success' => 'Categorie supprimee.' ], 'admin_flash');
		$this->app->redirect('/admin/categories');
	}
}
