<?php
declare(strict_types=1);

namespace app\models;

class ObjectModel
{
	public static function getMine($db, int $userId): array
	{
		return $db->fetchAll(
			'SELECT o.*, c.nom AS categorie_nom FROM objet_takalo o LEFT JOIN categorie_takalo c ON c.id = o.id_categorie WHERE o.id_owner = ? ORDER BY o.id DESC',
			[ $userId ]
		);
	}

	public static function getOthers($db, int $userId): array
	{
		return $db->fetchAll(
			'SELECT o.*, u.username, c.nom AS categorie_nom FROM objet_takalo o JOIN user_takalo u ON u.id = o.id_owner LEFT JOIN categorie_takalo c ON c.id = o.id_categorie WHERE o.id_owner <> ? ORDER BY o.id DESC',
			[ $userId ]
		);
	}

	public static function getAllWithOwner($db): array
	{
		return $db->fetchAll(
			'SELECT o.*, u.username, c.nom AS categorie_nom FROM objet_takalo o JOIN user_takalo u ON u.id = o.id_owner LEFT JOIN categorie_takalo c ON c.id = o.id_categorie ORDER BY o.id DESC'
		);
	}

	public static function find($db, int $id)
	{
		return $db->fetchRow('SELECT * FROM objet_takalo WHERE id = ?', [ $id ]);
	}

	public static function findWithOwner($db, int $id)
	{
		return $db->fetchRow(
			'SELECT o.*, u.username, u.email, c.nom AS categorie_nom FROM objet_takalo o JOIN user_takalo u ON u.id = o.id_owner LEFT JOIN categorie_takalo c ON c.id = o.id_categorie WHERE o.id = ?',
			[ $id ]
		);
	}

	public static function create($db, array $data): int
	{
		$db->runQuery(
			'INSERT INTO objet_takalo (id_owner, id_categorie, nom_objet, description, image, price) VALUES (?, ?, ?, ?, ?, ?)',
			[
				$data['owner_id'],
				$data['category_id'],
				$data['name'],
				$data['description'],
				$data['image'],
				$data['price'],
			]
		);

		return (int) $db->fetchField('SELECT LAST_INSERT_ID()');
	}

	public static function update($db, int $id, array $data): void
	{
		$db->runQuery(
			'UPDATE objet_takalo SET id_categorie = ?, nom_objet = ?, description = ?, image = ?, price = ? WHERE id = ?',
			[
				$data['category_id'],
				$data['name'],
				$data['description'],
				$data['image'],
				$data['price'],
				$id,
			]
		);
	}

	public static function delete($db, int $id): void
	{
		$db->runQuery('DELETE FROM objet_photo_takalo WHERE id_objet = ?', [ $id ]);
		$db->runQuery('DELETE FROM objet_takalo WHERE id = ?', [ $id ]);
	}

	public static function getPhotos($db, int $objectId): array
	{
		return $db->fetchAll('SELECT id, filename FROM objet_photo_takalo WHERE id_objet = ? ORDER BY id ASC', [ $objectId ]);
	}

	public static function addPhotos($db, int $objectId, array $files): void
	{
		foreach ($files as $file) {
			$db->runQuery(
				'INSERT INTO objet_photo_takalo (id_objet, filename) VALUES (?, ?)',
				[ $objectId, $file ]
			);
		}
	}
}
