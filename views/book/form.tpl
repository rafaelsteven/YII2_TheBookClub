{use class="yii\widgets\ActiveForm" type="block"}
{use class="app\models\Author"}
{title}Crear Libro{/title}

<h1>{$this->title}</h1>
{ActiveForm id="new-book" assign="form"}
    {$form->field($book, 'title')}
    {$form->field($book, 'author_id')->dropDownList(Author::getAuthorList())}
    <input type="submit" value="guardar">
{/ActiveForm}