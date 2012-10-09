<div class="page">
    <div class="title"><?php echo Yii::t('faq', 'Часто задаваемые вопросы');?></div>
    <div class="faq">
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
        <div class="get-question">
            <a href="" class="m-button">
                <?php echo Yii::t('faq', 'Задать свой вопрос');?>
            </a>
        </div>

        <div class="row question-form" style="display: none;">
            <div class="seven mobile-four columns columns">


                <form action="" method="post" id="set_question">
                    <?php echo CHtml::activeTextArea($form, 'question',
                    array(
                        'rows' => 3,
                        'class' => 'txtarea',
                        'placeholder' => Yii::t('faq', 'Вопрос'),
                    )); ?>

                    <div class="row">
                        <div class="five mobile-two columns">
                            <?php echo CHtml::activeTextField($form, 'name',
                            array(
                                'class' => 'txt',
                                'placeholder' => Yii::t('faq', 'Имя'),
                            )); ?>
                        </div>
                        <div class="seven mobile-two columns">
                            <?php echo CHtml::activeTextField($form, 'email',
                            array(
                                'class' => 'txt',
                                'placeholder' => Yii::t('faq', 'Email'),
                            )); ?>
                        </div>

                    </div>
                    <div class="send">
                        <input type="submit" class="m-button"
                           value="<?php echo Yii::t('faq', 'Отправить');?>"/>
                       </div>
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
        $('.get-question a.m-button').click(function () {
            $('.question-form').show();

            $('.get-question a.m-button').hide();
            return false;
        });
    });

    $(document).ready(function () {
        var options = {
            success:showsQuestionResponse,
            clearForm:false,
            url:'/ajax/setQuestion/'
        };

        $('.question-form').submit(function () {
            $(this).ajaxSubmit(options);
            $('.question-form span.error').hide();
            return false;
        });
    });

    function showsQuestionResponse(responseText) {
        if (responseText == 0) {

            $('span.error').html('<?php echo Yii::t('faq', 'Необходимо корректно заполнить все поля.');?>' + '<br /><br />');
        }
        else if (responseText == 1) {
            $('.get-question a.m-button').show();
            $('.question-form').hide();
            $('span.message').html('<?php echo Yii::t('account', 'Ваш вопрос отправлен.')?>' + '<br /><br />');

            setTimeout(function () {
                $('span.message').hide();

            }, 3000);
        }

    }
</script>