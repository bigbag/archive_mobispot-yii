<div class="page">
    <div class="title"><?php echo Yii::t('faq', 'Часто задаваемые вопросы');?></div>
    <div class="content faq">
        <ul>
            <?php foreach ($model as $row): ?>
            <li class="mmenu">
                <a href="#" class="akordeon"><span><?php echo $row->question;?></span></a>

                <div class="answer">
                    <?php echo $row->answer;?>
                </div>
            </li>
            <?php endforeach;?>
        </ul>

        <a href="" class="btn-30">
                        <span class="btn-30-txt">
                            <?php echo Yii::t('faq', 'Задать свой вопрос');?>
                        </span>
        </a>

        <div class="row">
            <div class="seven columns">
                <form action="" method="post" id="set_question">
                    <?php echo CHtml::activeTextArea($form, 'question',
                    array(
                        'rows' => 3,
                        'class' => 'txtarea',
                        'placeholder' => Yii::t('faq', 'Вопрос'),
                    )); ?>

                    <div class="row">
                        <div class="five columns">
                            <?php echo CHtml::activeTextField($form, 'name',
                            array(
                                'class' => 'txt',
                                'placeholder' => Yii::t('faq', 'Имя'),
                            )); ?>
                        </div>
                        <div class="seven columns">
                            <?php echo CHtml::activeTextField($form, 'email',
                            array(
                                'class' => 'txt',
                                'placeholder' => Yii::t('faq', 'Email'),
                            )); ?>
                        </div>

                    </div>
                </form>

            </div>
        </div>
        <div class="row">
            <div class="seven columns">
                <form action="" method="post" id="set_question">



                    <div class="row">
                        <div class="three columns">

                        </div>
                        <div class="four columns">

                        </div>
                    </div>
                    <input type="submit"
                           value="<?php echo Yii::t('faq', 'Отправить');?>"/>
                </form>
            </div>
        </div>


    </div>
</div>
<script type="text/javascript">
    var ACCORDION_MODE = false;
    $(document).ready(function () {
        $('.faq>ul>li>a').click(function () {
            th = $(this).parent();
            if (ACCORDION_MODE && !th.hasClass('active')) {
                th.parent().find('>li>div.answer').slideUp(300);
                th.parent().find('>li').removeClass('active');
            }
            th.find('>div.answer').slideToggle(300, function () {
                th.toggleClass('active');
            });
            return false;
        });
    });

    $(document).ready(function () {
        $('#myQuestion a').click(function () {
            $('#myQuestion-form').show();

            $('#myQuestion a.btn-30').hide();
            return false;
        });
    });

    $(document).ready(function () {
        var options = {
            success:showsQuestionResponse,
            clearForm:false,
            url:'/ajax/setQuestion/'
        };

        $('#set_question').submit(function () {
            $(this).ajaxSubmit(options);
            $('#myQuestion-form span.error').hide();
            return false;
        });
    });

    function showsQuestionResponse(responseText) {
        if (responseText == 0) {

            $('span.error').html('<?php echo Yii::t('faq', 'Необходимо корректно заполнить все поля.');?>' + '<br /><br />');
        }
        else if (responseText == 1) {
            $('#myQuestion a.btn-30').show();
            $('#myQuestion-form').hide();
            $('span.message').html('<?php echo Yii::t('account', 'Ваш вопрос отправлен.')?>' + '<br /><br />');

            setTimeout(function () {
                $('span.message').hide();

            }, 3000);
        }

    }
</script>