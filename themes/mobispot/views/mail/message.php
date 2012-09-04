<table cellpadding="0" cellspacing="0" border="0" align="center">
    <tr>
        <a href="<?php echo Yii::app()->request->getBaseUrl(true);?>">
            <img src="<?php echo Yii::app()->request->getBaseUrl(true);?>/themes/mobispot/images/mail/logotype.png"
                 alt=""/>
        </a>
    </tr>
    <tr>
        <td align="center" height="100" valign="middle" style="color:#707070;font-family:Helvetica;">
            {{'User'|trans}}
            {% if params.name %}
            <a href="#" style="color:#8fb949;font-weight:bold;font-family:Helvetica;">{{params.name}}</a>
            {% endif %}
            {{'leave_a_comment_on_your_spot'|trans}}
        </td>
    </tr>
    <tr>
        <td width="700" height="" style="border:0px solid;border-radius:25px;background:#efefef;padding:30px;">
            <table cellpadding="0" cellspacing="0" border="0" align="center">
                <tr>
                    <td rowspan="3" width="150" valign="top" align="left" style="padding:5px;">
                        <img src="{{params.photo}}" style="border:1px solid #cccccc;border-radius:15px;" alt=""
                             width="106" height="106"/>
                    </td>
                    <td height="20"
                        style="padding:0px 0px 5px 40px;font-size: 12px;color: #707070;font-family:Helvetica;">
                        {% if params.date %}
                        {{params.date|date('d.m.Y')}}
                        {% endif %}
                        {% if params.phone %}
                        | {{params.phone}}
                        {% endif %}
                        {% if params.email %}
                        | {{params.email}}
                        {% endif %}
                    </td>
                </tr>
                <tr>
                    <td height="85" width="400"
                        style="border-radius:25px;background:#a6d9a1;color:#ffffff;font-family:Helvetica;"
                        align="center">
                        {% if params.comment %}
                        {{params.comment}}
                        {% endif %}
                    </td>
                </tr>
                <tr>
                    <td align="right" style="padding: 15px 20px 0px 0px">
                        <a href="#"><img src="http://{{host}}/{{ asset('img/mail/answer.png') }}" alt=""/></a>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td align="center" height="100" valign="middle"
            style="color: #999999;font-size: 10px;font-weight: bold;font-family:Helvetica;">
            Mobispot
        </td>
    </tr>
</table>