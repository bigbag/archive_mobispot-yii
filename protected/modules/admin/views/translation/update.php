<?php $this->pageTitle = 'Переводы'; ?>
<?php
$this->breadcrumbs = array(
    'Админка' => array('/admin/'),
    'Содержимое',
    'Переводы' => array('index'),
    $model->name,
    'Редактировать',
);

?>

<h1>Редактировать перевод "<?php echo $model->name; ?>"</h1>
<form action="" method="post">
    <table>
        <tr>
            <th>English</th>
            <th>Русский</th>
        </tr>
        <?php foreach ($content_en as $key => $value): ?>
        <tr>
            <td colspan=2><?php echo $key; ?></td>
        </tr>
        <tr>
            <td>
                <textarea cols="50" rows="5" name="Translation_en[<?php echo $key; ?>]"><?php echo $value; ?></textarea>
            </td>
            <td>
                <textarea cols="50" rows="5" name="Translation_ru[<?php echo $key; ?>]"><?php echo $content_ru[$key]; ?></textarea>
            </td>
        </tr>
        <?php endforeach;?>
    </table>
    <?php echo CHtml::submitButton('Сохранить'); ?>
</form>



