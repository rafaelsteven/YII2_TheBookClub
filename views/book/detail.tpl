{use class="yii\helpers\Html"}
{use class="yii\widgets\ActiveForm" type="block"}
{use class="Yii"}
{title}{$book->title}{/title}

<h1>{$this->title}</h1>

<p>Un libro de {Html::a($book->author->name, ['author/detail' , 'id' => $book->author->id])}.</p>
<p>El promedio de este libro es: {$book->getScore()}</p>
{assign "user" Yii::$app->user->identity}
<p>
{if $user->hasBook($book->id)}
{Html::a('Ya no lo quiero', ['book/all'])}
    {if $user->hasVotedFor($book->id)}
        Ya votaste
        Tu voto fue de: {$user->getVotedForBook($book->id)->score}
    {else}
        {ActiveForm id="new-score" assign="forma" action=['book/score']}
            {$forma->field($book_score,'score')->dropDownList([
                1=>'✨',
                2=>'✨✨',
                3=>'✨✨✨',
                4=>'✨✨✨✨',
                5=>'✨✨✨✨✨'
                ])}
                {$forma->field($book_score, 'book_id')->hiddenInput()->label(false)}
                <input type="submit" value="Calificar">
        {/ActiveForm}
    {/if}
{else}
{Html::a('tengo este libro',
['book/i-own-this-book','book_id' => $book->id])}
{/if}
</p>
