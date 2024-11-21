<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;
class UserBook extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_books';  // Asegúrate de que el nombre sea correcto
    }

    public function getId()
    {
        return $this->user_book_id;
    }
}