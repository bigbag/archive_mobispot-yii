<div id="main-container">
    <div id="cont-block" class="center">
        <div id="cont-block-900" class="center">
            <div id="zag-cont-block"><?php echo Yii::t('faq', 'Часто задаваемые вопросы');?></div>
            <div id="blockFAQ">
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
                <div id="myQuestion">
                    <span class="error"></span>
                    <span class="message"></span>
                    <a href="" class="btn-30">
                        <span class="btn-30-txt">
                            <?php echo Yii::t('faq', 'Задать свой вопрос');?>
                        </span>
                    </a>

                    <div id="myQuestion-form">
                        <form action="" method="post" id="set_question">

                            <?php echo CHtml::activeTextArea($form, 'question',
                            array(
                                'rows' => 3,
                                'class' => 'txtarea',
                                'placeholder' => Yii::t('faq', 'Вопрос'),
                            )); ?>

                            <div class="clear"></div>
                            <div class="txt-form name">
                                <div class="txt-form-cl">
                                    <?php echo CHtml::activeTextField($form, 'name',
                                    array(
                                        'class' => 'txt',
                                        'placeholder' => Yii::t('faq', 'Имя'),
                                    )); ?>
                                </div>
                            </div>
                            <div class="txt-form mail">
                                <div class="txt-form-cl">
                                    <?php echo CHtml::activeTextField($form, 'email',
                                    array(
                                        'class' => 'txt',
                                        'placeholder' => Yii::t('faq', 'Email'),
                                    )); ?>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="round-btn">
                                <div class="round-btn-cl">
                                    <input type="submit"
                                           value="<?php echo Yii::t('faq', 'Отправить');?>"/>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="clear"></div>
        </div>

    </div>
    <script type="text/javascript">
        var ACCORDION_MODE = false;
        $(document).ready(function () {
            $('#blockFAQ>ul>li>a').click(function () {
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
                $('span.message').html('<?php echo Yii::t('account', 'Ваш вопрос отправлен.')?>'+ '<br /><br />');

                setTimeout(function () {
                    $('span.message').hide();

                }, 3000);
            }

        }
    </script>