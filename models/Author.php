<?php

namespace app\models;

use yii\db\ActiveRecord;

class Author extends ActiveRecord {

    public static function tableName() {
        return "authors";
    }

    public function getId() {
        return $this->author_id;
    }

    public function toString() {
        return sprintf("%s (%s)",$this->name, count($this->books));
    }
    public function getBooks(){
        return $this->hasMany(Book::class , ["author_id"=> "author_id"])
        ->all();
    }
    public static function getAuthorList(){
        $authors = self::find()->orderBy('name')->all();
        $ret = [];
        foreach($authors as $author)
        {
            $ret[$author->id] = $author->name;
        }
        return $ret;
    }

    public function rules()
    {
       return[
        ['name','required'],
        ['nationality','required']
        ]; 
    }

    public function getVotes()
    {
        return $this->hasMany(BookScore::class, ['book_id' => 'book_id'])
        ->viaTable('books',['author_id' => 'author_id'])
        ->all();
    }

    public function getScore()
    {
        $i = 0;
        $sum = 0;
        foreach($this->votes as $vote)
        {
            $i++;
            $sum += $vote->score;
        }
        if($i == 0)
        {
            return "Sin votos";
        }
        return sprintf("%0.2f (%d votos)", $sum/$i, $i);
    }
}