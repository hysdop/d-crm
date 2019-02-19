<?php

use common\rbac\Migration;
use common\repositories\UserRepository;

class m170626_082259_roles extends Migration
{
    public $db;

    public function up()
    {
        $this->auth->removeAll();

        /** Создаем роли */
        $manager = $this->auth->createRole(UserRepository::ROLE_MANAGER);
        $manager->description = UserRepository::$rolesList[UserRepository::ROLE_MANAGER];
        $this->auth->add($manager);

        $measurer = $this->auth->createRole(UserRepository::ROLE_MEASURER);
        $measurer->description = UserRepository::$rolesList[UserRepository::ROLE_MEASURER];
        $this->auth->add($measurer);

        $booker = $this->auth->createRole(UserRepository::ROLE_BOOKER);
        $booker->description = UserRepository::$rolesList[UserRepository::ROLE_BOOKER];
        $this->auth->add($booker);

        $boss = $this->auth->createRole(UserRepository::ROLE_BOSS);
        $boss->description = UserRepository::$rolesList[UserRepository::ROLE_BOSS];
        $this->auth->add($boss);

        /** Создаем разрешения */
        $permissionViewAllComings = $this->auth->createPermission('viewAllComings');
        $permissionViewAllComings->description = 'Видеть все обращения в компанию';
        $this->auth->add($permissionViewAllComings);

        $permissionViewAllMeasurements = $this->auth->createPermission('viewAllMeasurements');
        $permissionViewAllMeasurements->description = 'Видеть все замеры в компании';
        $this->auth->add($permissionViewAllMeasurements);

        // ----------------------------------------
        $this->auth->addChild($boss, $permissionViewAllComings);
        $this->auth->addChild($boss, $permissionViewAllMeasurements);

        /** ROOT permissions */
        $root = $this->auth->createRole(UserRepository::ROLE_ROOT);
        $root->description = UserRepository::$rolesList[UserRepository::ROLE_ROOT];
        $this->auth->add($root);

        $rootPermission = $this->auth->createPermission('loginToBackend');
        $rootPermission->description = 'Доступ в админ панель';
        $this->auth->add($rootPermission);
        $this->auth->addChild($boss, $rootPermission);
        $this->auth->addChild($manager, $rootPermission);
        /** --------------- */

        $this->auth->assign($boss, 3);
        $this->auth->assign($measurer, 2);
        $this->auth->assign($manager, 1);
        $this->auth->assign($root, 3);
    }

    public function down()
    {
        $this->auth->remove($this->auth->getRole(UserRepository::ROLE_ROOT));
        $this->auth->remove($this->auth->getRole(UserRepository::ROLE_BOSS));
        $this->auth->remove($this->auth->getRole(UserRepository::ROLE_MANAGER));
        $this->auth->remove($this->auth->getRole(UserRepository::ROLE_BOOKER));
        $this->auth->remove($this->auth->getRole(UserRepository::ROLE_MEASURER));
    }
}
