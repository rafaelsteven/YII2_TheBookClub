{use class="yii\helpers\Html"}
<h1>Todos los Autores</h1>
<ol>
    {foreach $authors as $author}
    <li>{Html::a($author->toString(),['author/detail','id'=>$author->id])}</li>
    {/foreach}
</ol>