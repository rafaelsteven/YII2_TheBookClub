<?php

namespace app\models;

use yii\db\ActiveRecord;

class Book extends ActiveRecord {

    public static function tableName() {
        return 'books';
    }
    public function rules()
    {
        return [
            [['title','author_id'], 'required'],
            ['author_id', 'integer'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'title' => 'Titulo',
        ];
    }
    public function getId() {
        return $this->book_id;
    }
    public function getAuthor() {
        //                                                 author.author_id/ book.author_id
        return $this
                ->hasOne(Author::Class, ['author_id'=> 'author_id'])
                ->one();

    }
    public function toString() {
        return sprintf("(%d) %s - %s",  $this->book_id, $this->title, $this->author->name);
    }

    public function getVotes()
    {
        return $this->hasMany(BookScore::class, ['book_id' => 'book_id'])->all();
    }

    public function getScore():string
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