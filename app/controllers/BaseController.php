<?php
declare(strict_types=1);

namespace app\controllers;

use flight\Engine;

abstract class BaseController
{
	protected Engine $app;

	public function __construct(Engine $app)
	{
		$this->app = $app;
	}

	protected function requireLogin(): array
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		if (empty($_SESSION['user'])) {
			$this->app->redirect('/login');
			exit;
		}

		return (array) $_SESSION['user'];
	}

	protected function requireAdmin(): array
	{
		$user = $this->requireLogin();
		if ((int) ($user['role_id'] ?? 0) !== 1) {
			$this->app->redirect('/home');
			exit;
		}

		return $user;
	}

	protected function setFlash(array $flash, string $key = 'flash'): void
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$_SESSION[$key] = $flash;
	}

	protected function consumeFlash(string $key = 'flash'): array
	{
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}

		$flash = $_SESSION[$key] ?? [];
		unset($_SESSION[$key]);

		return is_array($flash) ? $flash : [];
	}
}
