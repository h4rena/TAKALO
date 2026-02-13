<?php
declare(strict_types=1);

namespace app\controllers;

use flight\Engine;
use flight\util\Collection;

class LoginController
{
	protected Engine $app;

	public function __construct(Engine $app)
	{
		$this->app = $app;
	}

	public function show(): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (!empty($_SESSION['user'])) {
			if ((int) ($_SESSION['user']['role_id'] ?? 0) === 1) {
				$this->app->redirect('/admin/categories');
				return;
			}

			$this->app->redirect('/home');
			return;
		}

		$flash = $_SESSION['flash'] ?? [];
		unset($_SESSION['flash']);

		$this->app->render('login', $flash + [
			'default_email' => 'admin@takalo.test',
		]);
	}

	public function authenticate(): void
	{
		$request = $this->app->request();
		$email = trim((string) ($request->data->email ?? ''));
		$password = (string) ($request->data->password ?? '');

		if ($email === '' || $password === '') {
			$this->setFlashAndRedirect([ 'error' => 'Email et mot de passe requis.' ], '/login');
			return;
		}

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$this->setFlashAndRedirect([ 'error' => 'Email invalide.' ], '/login');
			return;
		}

		if (mb_strlen($password) < 6) {
			$this->setFlashAndRedirect([ 'error' => 'Mot de passe trop court.' ], '/login');
			return;
		}

		try {
			$db = $this->app->db();
			$user = $db->fetchRow(
				'SELECT id, id_role, username, email, hashedpassword FROM user_takalo WHERE email = ?',
				[ $email ]
			);
		} catch (\Throwable $e) {
			$this->setFlashAndRedirect([ 'error' => 'Erreur de connexion à la base de données.' ], '/login');
			return;
		}

		if (!($user instanceof Collection) || $user->id === null) {
			$this->setFlashAndRedirect([ 'error' => 'Identifiants invalides.' ], '/login');
			return;
		}

		if (password_verify($password, (string) $user->hashedpassword) === false) {
			$this->setFlashAndRedirect([ 'error' => 'Identifiants invalides.' ], '/login');
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

		if ((int) $user->id_role === 1) {
			$this->app->redirect('/admin/categories');
			return;
		}

		$this->app->redirect('/home');
	}

	public function register(): void
	{
		$request = $this->app->request();
		$username = trim((string) ($request->data->username ?? ''));
		$email = trim((string) ($request->data->email ?? ''));
		$password = (string) ($request->data->password ?? '');

		if ($username === '' || $email === '' || $password === '') {
			$this->setFlashAndRedirect([ 'register_error' => 'Tous les champs sont requis.' ], '/login');
			return;
		}

		if (mb_strlen($username) < 3 || mb_strlen($username) > 50) {
			$this->setFlashAndRedirect([ 'register_error' => 'Nom invalide.' ], '/login');
			return;
		}

		if (preg_match('/^[\p{L}0-9 _.-]+$/u', $username) !== 1) {
			$this->setFlashAndRedirect([ 'register_error' => 'Nom invalide.' ], '/login');
			return;
		}

		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			$this->setFlashAndRedirect([ 'register_error' => 'Email invalide.' ], '/login');
			return;
		}

		if (mb_strlen($password) < 6) {
			$this->setFlashAndRedirect([ 'register_error' => 'Mot de passe trop court.' ], '/login');
			return;
		}

		try {
			$db = $this->app->db();
			$existing = $db->fetchRow('SELECT id FROM user_takalo WHERE email = ?', [ $email ]);
			if ($existing instanceof Collection && $existing->id !== null) {
				$this->setFlashAndRedirect([ 'register_error' => 'Email déjà utilisé.' ], '/login');
				return;
			}

			$roleId = (int) $db->fetchField("SELECT role_id FROM user_role_takalo WHERE role = 'user' LIMIT 1");
			if ($roleId <= 0) {
				$this->setFlashAndRedirect([ 'register_error' => 'Aucun rôle utilisateur disponible.' ], '/login');
				return;
			}

			$hash = password_hash($password, PASSWORD_DEFAULT);
			$db->runQuery(
				'INSERT INTO user_takalo (id_role, username, email, hashedpassword) VALUES (?, ?, ?, ?)',
				[ $roleId, $username, $email, $hash ]
			);
		} catch (\Throwable $e) {
			$this->setFlashAndRedirect([ 'register_error' => 'Erreur lors de l\'inscription.' ], '/login');
			return;
		}

		$this->setFlashAndRedirect([ 'register_success' => 'Compte créé. Connecte-toi.' ], '/login');
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

		$this->app->redirect('/login');
	}

	protected function setFlashAndRedirect(array $flash, string $path): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$_SESSION['flash'] = $flash;
		$this->app->redirect($path);
	}
}
