<?php
declare(strict_types=1);

namespace app\controllers;

use flight\util\Collection;

class AdminController extends BaseController
{
	public function showLogin(): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (!empty($_SESSION['user']) && (int) ($_SESSION['user']['role_id'] ?? 0) === 1) {
			$this->app->redirect('/admin/stats');
			return;
		}

		$flash = $this->consumeFlash('admin_flash');
		$this->app->render('admin/login', $flash);
	}

	public function authenticate(): void
	{
		$request = $this->app->request();
		$email = trim((string) ($request->data->email ?? ''));
		$password = (string) ($request->data->password ?? '');

		if ($email === '' || $password === '') {
			$this->setFlash([ 'error' => 'Email et mot de passe requis.' ], 'admin_flash');
			$this->app->redirect('/admin/login');
			return;
		}

		try {
			$db = $this->app->db();
			$user = $db->fetchRow(
				'SELECT id, id_role, username, email, hashedpassword FROM user_takalo WHERE email = ?',
				[ $email ]
			);
		} catch (\Throwable $e) {
			$this->setFlash([ 'error' => 'Erreur de connexion a la base de donnees.' ], 'admin_flash');
			$this->app->redirect('/admin/login');
			return;
		}

		if (!($user instanceof Collection) || $user->id === null) {
			$this->setFlash([ 'error' => 'Identifiants invalides.' ], 'admin_flash');
			$this->app->redirect('/admin/login');
			return;
		}

		if (password_verify($password, (string) $user->hashedpassword) === false) {
			$this->setFlash([ 'error' => 'Identifiants invalides.' ], 'admin_flash');
			$this->app->redirect('/admin/login');
			return;
		}

		if ((int) $user->id_role !== 1) {
			$this->setFlash([ 'error' => 'Acces admin requis.' ], 'admin_flash');
			$this->app->redirect('/admin/login');
			return;
		}

		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$_SESSION['user'] = [
			'id' => (int) $user->id,
			'role_id' => (int) $user->id_role,
			'username' => (string) $user->username,
			'email' => (string) $user->email,
		];

		$this->app->redirect('/admin/stats');
	}

	public function stats(): void
	{
		$this->requireAdmin();
		$flash = $this->consumeFlash('admin_flash');

		$totalUsers = 0;
		try {
			$db = $this->app->db();
			$totalUsers = (int) $db->fetchField('SELECT COUNT(*) FROM user_takalo');
		} catch (\Throwable $e) {
			$flash = $flash + [ 'error' => 'Erreur lors du chargement des statistiques.' ];
		}

		$this->app->render('admin/stats', $flash + [
			'totalUsers' => $totalUsers,
		]);
	}

	public function logout(): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$_SESSION = [];
		if (ini_get('session.use_cookies')) {
			$params = session_get_cookie_params();
			setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
		}
		session_destroy();

		$this->app->redirect('/admin/login');
	}
}
