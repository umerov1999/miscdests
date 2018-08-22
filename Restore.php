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
    $tables = array_flip($tables+$unknownTables);
    if(!isset($tables['miscdests'])){
      return $this;
    }
    $bmo = $this->FreePBX->Miscdests;
    $bmo->setDatabase($pdo);
    $configs = $bmo->mdlist(true);
    $bmo->resetDatabase();
    foreach ($configs as $miscdests) {
      $bmo->upsert((int)$miscdests['id'], $miscdests['description'], $miscdests['destdial']);
    }
    return $this;
  }
}
