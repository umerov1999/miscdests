<?php
namespace FreePBX\modules\Miscdests;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = $this->getConfigs();
    foreach ($configs as $miscdest) {
        $this->FreePBX->Miscdests->upsert($miscdest['id'], $miscdests['description'], $miscdests['destdial']);
    }
  }
}