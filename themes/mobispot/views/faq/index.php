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
        <div class="row">
            <div class="seven columns columns">
                <div class="alert-box success messages" style="display: none;">
                    <?php echo Yii::t('account', 'Ваш вопрос отправлен.')?><a href="" class="close">&times;</a>
                </div>
                <div class="question-form" style="display: none;" ng-controller="FaqController">
                    <form action="" name="form">
                    <textarea rows="3" autocomplete="off" ng-model="faq.question" placeholder="<?php echo Yii::t('faq', 'Отправить'); ?>" name="QuestionForm[question]" required ></textarea>

                    <div class="row">
                        <div class="five mobile-two columns">
                            <input autocomplete="off" ng-model="faq.name" placeholder="<?php echo Yii::t('faq', 'Имя'); ?>" name="QuestionForm[name]" type="text" required/>
                        </div>
                        <div class="seven mobile-two columns">
                            <input autocomplete="off" ng-model="faq.email" placeholder="<?php echo Yii::t('faq', 'Email'); ?>" name="QuestionForm[email]" type="email" required/>
                        </div>
                    </div>
                    <div class="send">
                        <button class="m-button" ng-click="question(faq)" ng-disabled="form.$invalid">
                            <?php echo Yii::t('faq', 'Отправить'); ?>
                        </button>
                </form>
                </div>
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

</script>