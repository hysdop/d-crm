<?php

use common\rbac\Migration;
use common\rbac\rule\OwnModelRule;

class m160203_095607_edit_own_model extends Migration
{
    public $db;

    public function up()
    {
        return;
        $rule = new OwnModelRule();
        $this->auth->add($rule);

        $role = $this->auth->getRole(\common\repositories\UserRepository::ROLE_USER);

        $editOwnModelPermission = $this->auth->createPermission('editOwnModel');
        $editOwnModelPermission->ruleName = $rule->name;

        $this->auth->add($editOwnModelPermission);
        $this->auth->addChild($role, $editOwnModelPermission);
    }

    public function down()
    {
        return;
        $permission = $this->auth->getPermission('editOwnModel');
        $rule = $this->auth->getRule('ownModelRule');

        $this->auth->remove($permission);
        $this->auth->remove($rule);
    }
}
