<?php
/**
 * Created by PhpStorm.
 * User: alt
 * Date: 11.05.17
 * Time: 15:23
 */

namespace frontend\forms;


use common\repositories\AddressRepository;

class AddressForm extends AddressRepository
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            //[['house_id'], 'required'],
        ]);
    }
}