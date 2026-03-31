<?php
declare(strict_types=1);

namespace app\controllers;

use app\models\ExchangeModel;

class ExchangeController extends BaseController
{
	public function index(): void
	{
		$user = $this->requireLogin();
		$db = $this->app->db();
		$exchanges = ExchangeModel::listForUser($db, (int) $user['id']);
		$flash = $this->consumeFlash();

		$this->app->render('exchanges/index', $flash + [
			'exchanges' => $exchanges,
			'user_id' => (int) $user['id'],
		]);
	}

	public function accept(int $id): void
	{
		$user = $this->requireLogin();
		$db = $this->app->db();
		$exchange = ExchangeModel::findWithOwners($db, $id);
		if ($exchange === null) {
			$this->setFlash([ 'error' => 'Proposition introuvable.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		if ((int) $exchange->demande_owner_id !== (int) $user['id']) {
			$this->setFlash([ 'error' => 'Action non autorisee.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		if ((string) $exchange->status !== 'pending') {
			$this->setFlash([ 'error' => 'Proposition deja traitee.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		ExchangeModel::updateStatus($db, $id, 'accepted');
		$this->setFlash([ 'success' => 'Proposition acceptee.' ]);
		$this->app->redirect('/exchanges');
	}

	public function refuse(int $id): void
	{
		$user = $this->requireLogin();
		$db = $this->app->db();
		$exchange = ExchangeModel::findWithOwners($db, $id);
		if ($exchange === null) {
			$this->setFlash([ 'error' => 'Proposition introuvable.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		if ((int) $exchange->demande_owner_id !== (int) $user['id']) {
			$this->setFlash([ 'error' => 'Action non autorisee.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		if ((string) $exchange->status !== 'pending') {
			$this->setFlash([ 'error' => 'Proposition deja traitee.' ]);
			$this->app->redirect('/exchanges');
			return;
		}

		ExchangeModel::updateStatus($db, $id, 'refused');
		$this->setFlash([ 'success' => 'Proposition refusee.' ]);
		$this->app->redirect('/exchanges');
	}
}
