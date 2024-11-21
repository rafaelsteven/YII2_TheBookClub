{use class="yii\helpers\Html"}
<h1>Todos los libros</h1>
<ol>
    {foreach $books as $book}
    <li>{Html::a($book->toString(),['book/detail','book_id'=>$book->id])}</li>
    {/foreach}
</ol>