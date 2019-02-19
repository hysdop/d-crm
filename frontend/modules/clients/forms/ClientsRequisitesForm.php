<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 02.06.17
 * Time: 11:51
 */

namespace frontend\modules\clients\forms;


use common\repositories\ClientsRequisitesRepository;

class ClientsRequisitesForm extends ClientsRequisitesRepository
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ogrn'], 'string', 'max' => 15],
            [['inn'], 'string', 'max' => 12],
            [['kpp', 'bik'], 'string', 'max' => 9],
            [['okpo'], 'string', 'max' => 10],
            [['ras', 'corr_account'], 'string', 'max' => 20],
            [['bank'], 'string', 'max' => 255],
        ];
    }
}