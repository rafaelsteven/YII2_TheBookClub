{use class="yii\widgets\ActiveForm" type="block"}
{use class="app\models\Author"}
{title}Crear Libro{/title}

<h1>{$this->title}</h1>
{ActiveForm id="new-author" assign="form"}
    {$form->field($author, 'name')}
    {$form->field($author, 'nationality')->dropDownList(['EC'=>'ecuador'])}
    <input type="submit" value="guardar">
{/ActiveForm}