<?php
declare(strict_types=1);

namespace app\models;

class CategoryModel
{
	public static function all($db): array
	{
		return $db->fetchAll('SELECT id, nom FROM categorie_takalo ORDER BY nom');
	}

	public static function find($db, int $id)
	{
		return $db->fetchRow('SELECT id, nom FROM categorie_takalo WHERE id = ?', [ $id ]);
	}

	public static function create($db, string $name): void
	{
		$db->runQuery('INSERT INTO categorie_takalo (nom) VALUES (?)', [ $name ]);
	}

	public static function update($db, int $id, string $name): void
	{
		$db->runQuery('UPDATE categorie_takalo SET nom = ? WHERE id = ?', [ $name, $id ]);
	}

	public static function delete($db, int $id): void
	{
		$db->runQuery('DELETE FROM categorie_takalo WHERE id = ?', [ $id ]);
	}
}
