<?php
namespace FreePBX\modules\Miscdests;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore($jobid){
		$configs = reset($this->getConfigs());
		foreach ($configs as $miscdests) {
				$this->FreePBX->Miscdests->upsert((int)$miscdests['id'], $miscdests['description'], $miscdests['destdial']);
		}
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
		$this->restoreLegacyDatabase($pdo);
	}
}
