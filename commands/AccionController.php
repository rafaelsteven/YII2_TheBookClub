<?php

namespace app\commands;


use yii\console\Controller;
use yii\console\ExitCode;

use app\models\Book;
use app\models\Author;
class AccionController extends Controller {

    /**
     * Summary of actionSuma
     */
    public function actionSuma($a,$b) {
        $result = $a + $b;
        printf("%0.2f\n", $result);
        return ExitCode::OK;
    }

    /**
     * libros
     */
    public function actionBooks($file){
        $f = fopen($file,"r");
        while(!feof($f)){
            $data = fgetcsv($f);
            if(!empty($data[0]) && !empty($data[2]) ) {
                $author = Author::find()
                                ->where(["name"=>$data[2]])
                                ->one();
                if(empty($author)) {
                    $author = new Author();
                    $author->name = $data[2];
                    $author->save();
                }
                $book = new Book;
                $book->title     = $data[1];
                $book->author_id = $author->author_id;
                $book->save();
                printf("%s\n", $book->toString());
            }
        }
        fclose($f);
        return ExitCode::OK;
    }

    /**
     * author
     */
    public function actionGetAuthor($author_id){
        // $author = Author::find()->where(["author_id"=>$author_id] )->one();
        $author = Author::findOne($author_id);
        if(empty($author)) {
            printf("No existe el author\n");
            return ExitCode::DATAERR;
        }

        printf("%s:\n", $author->toString());
        foreach($author->books as $book){
            printf("%s\n", $book->toString());
        }
        return ExitCode::OK;
    }

    public function actionBook($book_id){
        $book = Book::findOne($book_id);
        if(empty($book)) {
            printf("No se encontro el libro");
            return ExitCode::DATAERR;
        }
        printf("%s\n", $book->toString());
        return ExitCode::OK;
    }

}