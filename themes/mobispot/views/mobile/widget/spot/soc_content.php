<div id="block-<?php echo $dataKey;?>" class="spot-item">
    <div class="item-area type-itembox">
        <div class="item-head">
            <a href="<?php echo $socContent['soc_url']; ?>" class="type-link">
                <?php $socInf = new SocInfo;?>
                <img class="soc-icon" src="/themes/mobispot/socialmediaicons/<?php echo $socInf->getSmallIcon($socContent['soc_url']);?>" height="36"> <span class="link"><?php echo $socContent['soc_url']; ?></span>
            </a>
        </div>
        <div class="type-mess item-body">
        <?php /* Avatar *////////////////////// ?>
        <?php if (isset($socContent['photo'])): ?>
            <div class="item-user-avatar"><img width="50" height="50" src="<?php echo $socContent['photo']; ?>"></div>
        <?php endif; ?>
            <?php if (!isset($socContent['avatar_before_mess_body']) || !$socContent['avatar_before_mess_body']): ?>
            <div class="mess-body">
            <?php endif; ?>
            <?php /* Username  and sub-line *////////////////////// ?>
            <?php if (!empty($socContent['soc_username']) || !empty($socContent['color-header']) || !empty($socContent['sub-time'])): ?>
                <div class="author-row">
                    <?php if (isset($socContent['soc_username'])): ?>
                    <a class="authot-name" href="<?php echo $socContent['soc_url']; ?>"><?php echo $socContent['soc_username']; ?></a>
                    <?php endif; ?>
                    <?php if (isset($socContent['color-header'])): ?>
                    <h3 class="color"><?php echo $socContent['color-header']; ?></h3>
                    <?php endif; ?>
                    <?php if (isset($socContent['sub-time'])): ?>
                    <b class="time"><?php echo $socContent['sub-time']; ?></b>
                    <?php endif; ?>
                    <span class="sub-line">
                    <?php if (isset($socContent['sub-line'])): ?>
                    <?php echo $socContent['sub-line']; ?>
                    <?php elseif(isset($socContent['venue_name'])): ?>
                    <span class="icon">&#xe018;</span><?php echo Yii::t('eauth', 'at ') . $socContent['venue_name'] ?>
                        <?php if (isset($socContent['venue_address'])): ?>
                        , <?php echo $socContent['venue_address'] ?>
                        <?php endif; ?>
                    <?php endif; ?>
                    </span>
                </div>
            <?php elseif (isset($socContent['youtube_video_link'])): ?>
                <div class="author-row">
                    <h3><a class="color" href="<?php echo $socContent['soc_url']; ?>"><?php echo strip_tags($socContent['youtube_video_link']); ?></a></h3>
                    <span class="sub-line"></span>
                </div>
            <?php endif; ?>
            <?php if (isset($socContent['avatar_before_mess_body']) and $socContent['avatar_before_mess_body']): ?>
            <div class="mess-body">
            <?php endif; ?>
            <?php /* Tweet *////////////////////// ?>
            <?php if (isset($socContent['tweet_author']) && isset($socContent['tweet_username']) && isset($socContent['tweet_text']) && isset($socContent['soc_url']) && isset($socContent['tweet_id'])): ?>
                    <div class="author-row"><a class="authot-name" href="<?php echo $socContent['soc_url']; ?>"><?php echo $socContent['tweet_author']; ?></a><a class="user-name <?php if (!empty($socContent['dinamic'])): ?>sub-line<?php endif; ?>" href="<?php echo $socContent['soc_url']; ?>">@<?php echo $socContent['tweet_username']; ?></a>
                    <?php if (empty($socContent['dinamic'])): ?>
                        <a href="<?php echo $socContent['soc_url']; ?>/followers" class="count-followers">Followers: <span><?php if (isset($socContent['followers_count'])) echo $socContent['followers_count']; ?></span></a>
                        <iframe style="width: 157px; height: 28px;" data-twttr-rendered="true" title="Twitter Follow Button" class="twitter-follow-button twitter-follow-button" src="http://platform.twitter.com/widgets/follow_button.1381275758.html#_=1381386016242&amp;id=twitter-widget-0&amp;lang=en&amp;screen_name=<?php echo $socContent['tweet_username']; ?>&amp;show_count=false&amp;show_screen_name=true&amp;size=l" allowtransparency="true" id="twitter-widget-0" frameborder="0" scrolling="no"></iframe>
                    <?php endif; ?>
                    </div>
                    <p><?php echo $socContent['tweet_text']; ?></p>
                    <footer>
                        <?php if (isset($socContent['footer-line'])): ?>
                            <?php echo $socContent['footer-line']; ?>
                        <?php endif; ?>
                        <?php if (isset($socContent['tweet_datetime'])): ?>
                            <div class="left timestamp"><?php echo $socContent['tweet_datetime']; ?></div>
                        <?php endif; ?>
                        <?php if (empty($socContent['dinamic'])): ?>
                        <div class="right actions">
                            <a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $socContent['tweet_id']; ?>"><i>&#xf112;</i><span>Reply</span></a>
                            <a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $socContent['tweet_id']; ?>"><i>&#xf079;</i><span>Retweet</span></a>
                            <a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $socContent['tweet_id']; ?>"><i>&#xf005;</i><span>Favorite</span></a>
                        </div>
                        <?php endif; ?>
                    </footer>
            <?php endif; ?>
            <?php /* Text post *//////////////////////  ?>
            <?php if (isset($socContent['last_status'])): ?>
                <p><?php echo $this->hrefActivate($socContent['last_status']); ?></p>
            <?php endif; ?>
            <?php /* Text link *////////////////////// ?>
            <?php if (isset($socContent['link_href']) && isset($socContent['link_text'])): ?>
                <a href="<?php echo $socContent['link_href']; ?>"><?php echo $socContent['link_text']; ?></a>
                <?php if (isset($socContent['link_descr'])): ?>
                    <p><?php echo $socContent['link_descr']; ?></p>
                <?php endif; ?>
            <?php endif; ?>
            <?php /* Vimeo video *////////////////////// ?>
            <?php if (isset($socContent['vimeo_last_video'])): ?>
                <div id="div_<?php echo $dataKey; ?>">
                    <iframe
                        id="vimeo_<?php echo $dataKey; ?>" class="video-vimeo" src="http://player.vimeo.com/video/<?php echo $socContent['vimeo_last_video']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen
                        <?php if (isset($socContent['vimeo_video_width'])): ?>
                        rel="<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>"
                        <?php endif; ?>>
                    </iframe>
                    <?php if (isset($socContent['vimeo_last_video_counter'])): ?>
                    <footer>
                        <span><?php echo $socContent['vimeo_last_video_counter']. Yii::t('spot', ' views'); ?></span>
                    </footer>
                    <?php endif; ?>
                    <?php if (empty($socContent['dinamic']) and isset($socContent['vimeo_video_width']) and isset($socContent['vimeo_video_height']) and ($socContent['vimeo_video_width'] > 0) and ($socContent['vimeo_video_height'] > 0)): ?>
                        <script type="text/javascript">
                            $(document).ready(function () {
                                $('#vimeo_<?php echo $dataKey; ?>').width($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>);
                                $('#vimeo_<?php echo $dataKey; ?>').css('min-height', '10px');
                                $('#vimeo_<?php echo $dataKey; ?>').height(($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>) /<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>);
                            });
                            $(window).resize(function () {
                                $('#vimeo_<?php echo $dataKey; ?>').width($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>);
                                $('#vimeo_<?php echo $dataKey; ?>').height(($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>) /<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>);
                            });
                        </script>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
            <?php /* Checkin *////////////////////// ?>
            <?php if (isset($socContent['venue_name'])): ?>
                    <?php if (isset($socContent['checkin_shout'])): ?>
                        <p><?php echo $socContent['checkin_shout'] ?></p>
                    <?php endif; ?>
                    <?php if (isset($socContent['checkin_photo'])): ?>
                        <img src="<?php echo $socContent['checkin_photo']; ?>">
                    <?php endif; ?>
            <?php endif; ?>
            <?php /* Image *////////////////////// ?>
            <?php if (isset($socContent['last_img']) && empty($socContent['shared_link'])): ?>
                    <?php //if (isset($socContent['last_img_href'])): ?>
                    <?php //<a href="<?php echo $socContent['last_img_href']; ?>
                    <?php //endif; ?>
                    <?php if (isset($socContent['last_img_msg'])): ?>
                        <p><?php echo $this->hrefActivate($socContent['last_img_msg']); ?></p>
                    <?php endif; ?>
                    <img src="<?php echo $socContent['last_img']; ?>">
                    <?php if (isset($socContent['last_img_story'])): ?>
                        <p><?php echo $this->hrefActivate($socContent['last_img_story']); ?></p>
                    <?php endif; ?>
            <?php endif; ?>
            <?php /* Shared Link *////////////////////// ?>
            <?php if (!empty($socContent['shared_link'])): ?>
                <?php if (isset($socContent['last_img_msg'])): ?>
                    <p><?php echo $this->hrefActivate($socContent['last_img_msg']); ?></p>
                <?php endif; ?>
                <a href="<?php echo $socContent['shared_link']; ?>" class="thumbnail">
                <?php if (!empty($socContent['youtube_video_link']) && !empty($socContent['youtube_video_flash'])):?>
                    <object>
                        <param name="movie" value="<?php echo $socContent['youtube_video_flash']; ?>"></param>
                        <param name="allowFullScreen" value="true"></param>
                        <embed class="yt_player" style="max-width:100%" id="player_<?php echo $dataKey; ?>" src="<?php echo $socContent['youtube_video_flash']; ?>"
                                <?php if (isset($socContent['youtube_video_rel'])): ?>
                                    rel="<?php echo $socContent['youtube_video_rel']; ?>"
                                    width="100%"
                                <?php endif; ?>
                                type="application/x-shockwave-flash"
                                allowfullscreen="true">
                        </embed>
                    </object>
                    <?php if (isset($socContent['youtube_video_rel']) and empty($socContent['dinamic'])): ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['youtube_video_rel']; ?>);
                        });
                        $(window).resize(function () {
                            $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['youtube_video_rel']; ?>);
                        });
                    </script>
                    <?php endif; ?>
                <?php elseif (isset($socContent['last_img'])): ?>
                <img src="<?php echo $socContent['last_img']; ?>">
                <?php endif; ?>
                <?php if (isset($socContent['link_name'])): ?>
                    <h4><?php echo $socContent['link_name']; ?></h4>
                <?php endif; ?>
                <?php if (isset($socContent['link_caption'])): ?>
                    <span class="sub-txt"><?php echo $socContent['link_caption']; ?></span>
                <?php endif; ?>
                <?php if (isset($socContent['link_description'])): ?>
                    <p><?php echo $this->hrefActivate($socContent['link_description']); ?></p>
                <?php endif; ?>
                <?php if (isset($socContent['last_img_story'])): ?>
                    <p><?php echo $this->hrefActivate($socContent['last_img_story']); ?></p>
                <?php endif; ?>
                </a>
            <?php endif; ?>
            <?php /* Map *//////////////////////  ?>
            <?php if (isset($socContent['place_lat']) && isset($socContent['place_lng'])): ?>
                    <?php if (isset($socContent['place_msg'])): ?>
                        <p><?php echo $socContent['place_msg']; ?></p>
                    <?php endif; ?>
                    <div id="map_canvas_<?php echo $dataKey; ?>" style="width:400px; height:200px; margin:0 auto"></div>
                    <?php if (empty($socContent['dinamic'])): ?>
                    <script type="text/javascript">
                        var initLat = <?php echo $socContent['place_lat']; ?>;
                        var initLng = <?php echo $socContent['place_lng']; ?>;
                        var latlng = new google.maps.LatLng(initLat, initLng);

                        var mapOptions = {
                            zoom: 9,
                            center: latlng,
                            mapTypeId: google.maps.MapTypeId.ROADMAP
                        }
                        map = new google.maps.Map(document.getElementById('map_canvas_<?php echo $dataKey; ?>'), mapOptions);

                        marker = new google.maps.Marker({
                            map: map,
                            position: latlng,
                            draggable: false
                        });
                    </script>
                    <?php endif; ?>
                    <p><?php echo $socContent['place_name']; ?></p>
            <?php endif; ?>
            <?php /* YouTube video *//////////////////////  ?>
            <?php   if (!empty($socContent['youtube_video_link'])
                        && !empty($socContent['youtube_video_flash'])
                        && empty($socContent['shared_link'])
                    ):?>
                <object>
                    <param name="movie" value="<?php echo $socContent['youtube_video_flash']; ?>"></param>
                    <param name="allowFullScreen" value="true"></param>
                    <embed class="yt_player" id="player_<?php echo $dataKey; ?>" src="<?php echo $socContent['youtube_video_flash']; ?>"
                            <?php if (isset($socContent['youtube_video_rel'])): ?>
                                rel="<?php echo $socContent['youtube_video_rel']; ?>"
                            <?php endif; ?>
                            type="application/x-shockwave-flash"
                            <?php if (isset($socContent['youtube_video_rel'])): ?>
                               width="100%" height="480"
                            <?php else: ?>
                               width="120" height="90"
                            <?php endif; ?>
                           allowfullscreen="true"></embed>
                </object>
                <?php if (isset($socContent['youtube_video_rel']) and empty($socContent['dinamic'])): ?>
                    <script type="text/javascript">
                        $(document).ready(function () {
                            $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['youtube_video_rel']; ?>);
                        });
                        $(window).resize(function () {
                            $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['youtube_video_rel']; ?>);
                        });
                    </script>
                <?php endif; ?>
                <?php if (isset($socContent['view_count'])): ?>
                    <footer>
                        <span><?php echo $socContent['view_count'] . ' ' . Yii::t('spot', 'views'); ?></span>
                    </footer>
                <?php endif; ?>
            <?php endif; ?>
            <?php /* list *//////////////////////   ?>
                <?php if (!empty($socContent['list'])): ?>
                    <?php if (!empty($socContent['list']['title'])): ?>
                    <h4><?php echo $socContent['list']['title']; ?></h4>
                    <?php endif; ?>
                        <table class="j-list">
                        <?php foreach ($socContent['list']['values'] as $li): ?>
                        <tr>
                            <td>
                            <?php if (!empty($li['href']) && !empty($li['title'])): ?>
                                <span><a class="authot-name" href="<?php echo $li['href']; ?>"><?php echo $li['title']; ?></a></span>
                            <?php else:?>
                                <span><?php if (isset($li['title'])) echo $li['title']; ?></span>
                            <?php endif; ?>
                            </td>
                            <td><?php if (isset($li['comment'])) echo $li['comment']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </table>
                <?php endif; ?>
            <?php /* list2 *//////////////////////   ?>
                <?php if (!empty($socContent['list2'])): ?>
                    <?php if (!empty($socContent['list2']['title'])): ?>
                    <h4><?php echo $socContent['list2']['title']; ?></h4>
                    <?php endif; ?>
                        <table class="j-list">
                        <?php foreach ($socContent['list2']['values'] as $li): ?>
                        <tr>
                            <td>
                            <?php if (!empty($li['href']) && !empty($li['title'])): ?>
                                <span><a class="authot-name" href="<?php echo $li['href']; ?>"><?php echo $li['title']; ?></a></span>
                            <?php else:?>
                                <span><?php if (isset($li['title'])) echo $li['title']; ?></span>
                            <?php endif; ?>
                            </td>
                            <td><?php if (isset($li['comment'])) echo $li['comment']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </table>
                <?php endif; ?>
            <?php /* html *////////////////////// ?>
                <?php if (isset($socContent['html'])): ?>
                    <?php echo $socContent['html']; ?>
                <?php endif; ?>
            <?php /* footer-line *////////////////////// ?>
                <?php if (!empty($socContent['footer-line'])): ?>
                    <footer>
                        <span><?php echo $socContent['footer-line']; ?></span>
                    </footer>
                <?php endif; ?>
            <?php /* likes *////////////////////// ?>
                <?php if (!empty($socContent['likes-block'])): ?>
                    <div class="likes-block"><?php echo $socContent['likes-block']; ?></div>
                <?php endif; ?>
            <?php /* Follow button *////////////////////// ?>
                <?php if ((!empty($socContent['soc_url']) ||
                            !empty($socContent['follow_url']))
                            and !isset($socContent['tweet_author'])
                            and empty($socContent['dinamic'])
                            and isset($socContent['invite'])
                            and empty($socContent['follow_button'])): ?>
                    <a href="<?php  if (!empty($socContent['follow_url']) && empty($socContent['follow_service']))
                                        echo $socContent['follow_url'];
                                    elseif (empty($socContent['follow_service']))
                                        echo $socContent['soc_url']; ?>"
                    <?php if (!empty($socContent['follow_service']) && !empty($socContent['follow_param'])): ?>
                        ng-click="followSocial( '<?php echo $socContent['follow_service'] ?>'
                                                ,'<?php echo $socContent['follow_param'] ?>'
                                                ,'block-<?php echo $dataKey;?>')"
                    <?php endif; ?>
                    class="spot-button soc-link" ><?php echo $socContent['invite']; ?>
                        <?php if (isset($socContent['inviteClass']) && (strlen($socContent['inviteClass']) > 0)): ?>
                            <i class="i-soc <?php echo $socContent['inviteClass']; ?> round">
                            <?php if (isset($socContent['inviteValue']) && (strlen($socContent['inviteValue']) > 0))
                                    echo $socContent['inviteValue']; ?>
                            </i>
                        <?php endif; ?>
                    </a>
                <?php elseif(!empty($socContent['follow_button']) and empty($socContent['dinamic'])): ?>
                    <div class="text-center">
                    <?php echo $socContent['follow_button']; ?>
                    </div>
                <?php endif; ?>
            <?php /* "Move your link" panel *////////////////////// ?>
<?php /*?>
            <?php if (!empty($socContent['dinamic'])): ?>
            <div class="spot-cover slow">
                <div class="spot-activity">
                    <a class="button unbind-spot round" ng-click="unBindSocial(spot, <?php echo $dataKey; ?>, $event)">&#xe003;</a>
                    <a class="button remove-spot round" ng-click="removeContent(spot, <?php echo $dataKey; ?>, $event)">&#xe00b;</a>
                </div>
                <div class="move-spot"><i></i>
                    <span>
                        <?php echo Yii::t('spot', 'Move your link'); ?>
                    </span>
                </div>
            </div>
            <?php endif; ?>
<?php*/ ?>
            </div>
            <?php if (!empty($socContent['dinamic'])): ?>
                <div class="item-control">
                    <span class="move move-top"></span>
                        <div class="spot-activity">
                            <a class="button round" ng-click="unBindSocial(spot, <?php echo $dataKey; ?>, $event)">&#xe003;</a>
                            <a class="button round" ng-click="removeContent(spot, <?php echo $dataKey; ?>, $event)">&#xe00b;</a>
                        </div>
                    <span class="move move-bottom"></span>
                </div>
            <?php endif ?>
            </div>
        </div>


    </div>
