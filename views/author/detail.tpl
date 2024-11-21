
{use class="yii\helpers\Html"}
<h1>Detalle de author</h1>
<h2>{$author->toString()}</h2>

<p>El promedio de todas sus obras es: {$author->score}</p>

<h3>Libros:</h3>
<ol>
{foreach $author->books as $book}
<li>{Html::a($book->title, ['book/detail', 'book_id' => $book->id])}</li>
{/foreach}
</ol>
