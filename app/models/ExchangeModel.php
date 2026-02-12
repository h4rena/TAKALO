<?php
declare(strict_types=1);

namespace app\models;

class ExchangeModel
{
	public static function createProposal($db, int $requestedId, int $proposedId): void
	{
		$existing = $db->fetchField(
			'SELECT id FROM echange_takalo WHERE id_objet_demande = ? AND id_objet_propose = ? AND status = "pending"',
			[ $requestedId, $proposedId ]
		);

		if ($existing) {
			return;
		}

		$db->runQuery(
			'INSERT INTO echange_takalo (id_objet_demande, id_objet_propose) VALUES (?, ?)',
			[ $requestedId, $proposedId ]
		);
	}

	public static function listForUser($db, int $userId): array
	{
		return $db->fetchAll(
			'SELECT e.*, od.nom_objet AS objet_demande, op.nom_objet AS objet_propose, od.id_owner AS demande_owner_id, op.id_owner AS propose_owner_id, ud.username AS demande_owner_name, up.username AS propose_owner_name FROM echange_takalo e JOIN objet_takalo od ON od.id = e.id_objet_demande JOIN objet_takalo op ON op.id = e.id_objet_propose JOIN user_takalo ud ON ud.id = od.id_owner JOIN user_takalo up ON up.id = op.id_owner WHERE od.id_owner = ? OR op.id_owner = ? ORDER BY e.created_at DESC',
			[ $userId, $userId ]
		);
	}

	public static function findWithOwners($db, int $id)
	{
		return $db->fetchRow(
			'SELECT e.*, od.id_owner AS demande_owner_id, op.id_owner AS propose_owner_id FROM echange_takalo e JOIN objet_takalo od ON od.id = e.id_objet_demande JOIN objet_takalo op ON op.id = e.id_objet_propose WHERE e.id = ?',
			[ $id ]
		);
	}

	public static function updateStatus($db, int $id, string $status): void
	{
		$db->runQuery(
			'UPDATE echange_takalo SET status = ?, responded_at = NOW() WHERE id = ?',
			[ $status, $id ]
		);
	}
}
