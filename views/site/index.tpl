{use class="Yii"}
{use class="yii\helpers\Html"}
<h1>Indice de sitio</h1>

{if Yii::$app->user->isGuest}
hola invitado, {Html::a('login',['site/login'])}
{else}
{assign "user" Yii::$app->user->identity}
<p>hola {$user->username} 👋</p>
<p>has votado {$user->voteCount} veces y promedio de {$user->voteAvg}</p>
{/if}

<p>Hay {$book_count} libros en el sistema</p>
<p>{Html::a('crear libro',['book/new'])}  </p>
<p>{Html::a('crear author',['author/new'])}</p>