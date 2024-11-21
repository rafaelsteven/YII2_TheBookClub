<?php

namespace app\models;

use yii\db\ActiveRecord;
use Exception;
class BookScore extends ActiveRecord
{
    public static function tableName()
    {
        return 'book_scores';  // Asegúrate de que el nombre sea correcto
    }

    public function getId()
    {
        return $this->book_score_id;
    }

    public function rules()
    {
       return[
        ['score','required'],
        ['score','integer'],
        ['book_id','default'],
            ]; 
    }
}