        <?php if (!(isset($socContent['dinamyc']) && isset($socContent['tweet_author']))): ?>
        <div class="spot-item<?php if (isset($socContent['tweet_author'])): ?> spot-item_twi<?php endif; ?>">
            <div class="item-area type-mess">
        
                <?php /* Avatar *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['photo'])): ?>
                    <div class="user-avatar"><img src="<?php echo $socContent['photo']; ?>">
                    </div>
                <?php endif; ?>
                <?php /* Username *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['soc_username'])): ?>
                    <div class="author-row"><a class="authot-name" <?php if (isset($socContent['soc_url'])) echo 'href="' . $socContent['soc_url'] . '"'; ?>><?php echo $socContent['soc_username']; ?></a></div>
                <?php endif; ?>
                <?php /* Tweet *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['tweet_author']) && isset($socContent['tweet_username']) && isset($socContent['tweet_text']) && isset($socContent['soc_url']) && isset($socContent['tweet_id'])): ?>
                    <div class="mess-body">
                        <div class="author-row"><a class="authot-name" href="<?php echo $socContent['soc_url']; ?>"><?php echo $socContent['tweet_author']; ?></a><a class="user-name" href="<?php echo $socContent['soc_url']; ?>">@<?php echo $socContent['tweet_username']; ?></a></div>
                        <a href="<?php echo $socContent['soc_url']; ?>" data-show-count="false" data-size="large">Follow</a>
                        <script>!function(d, s, id) {
                                var js, fjs = d.getElementsByTagName(s)[0], p = /^http:/.test(d.location) ? 'http' : 'https';
                                if (!d.getElementById(id)) {
                                    js = d.createElement(s);
                                    js.id = id;
                                    js.src = p + '://platform.twitter.com/widgets.js';
                                    fjs.parentNode.insertBefore(js, fjs);
                                }
                            }(document, 'script', 'twitter-wjs');</script>
                        <p><?php echo $socContent['tweet_text']; ?></p>
                        <footer>
                            <?php if (isset($socContent['tweet_datetime'])): ?>
                                <div class="left timestamp"><?php echo $socContent['tweet_datetime']; ?></div>
                            <?php endif; ?>
                            <div class="right actions">
                                <a href="https://twitter.com/intent/tweet?in_reply_to=<?php echo $socContent['tweet_id']; ?>"><i>&#xf112;</i><span>Reply</span></a>
                                <a href="https://twitter.com/intent/retweet?tweet_id=<?php echo $socContent['tweet_id']; ?>"><i>&#xf079;</i><span>Retweet</span></a>
                                <a href="https://twitter.com/intent/favorite?tweet_id=<?php echo $socContent['tweet_id']; ?>"><i>&#xf005;</i><span>Favorite</span></a>
                            </div>
                        </footer>
                    </div>
                <?php endif; ?>
                <?php /* Text post *//////////////////////////////////////////////////////////////////////////////////  ?>
                <?php if (isset($socContent['last_status'])): ?>
                    <p><?php echo $this->hrefActivate($socContent['last_status']); ?></p>
                <?php endif; ?>
                <?php /* Text link *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['link_href']) && isset($socContent['link_text'])): ?>
                    <a href="<?php echo $this->hrefActivate($socContent['link_href']); ?>"><?php echo $socContent['link_text']; ?></a>
                    <?php if (isset($socContent['link_descr'])): ?>
                        <p><?php echo $socContent['link_descr']; ?></p>
                    <?php endif; ?>
                <?php endif; ?>
                <?php /* Vimeo video *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['vimeo_last_video'])): ?>
                    <div class="item-area text-center" id="div_<?php echo $dataKey; ?>">
                        <iframe
                            id="vimeo_<?php echo $dataKey; ?>" class="video-vimeo" src="http://player.vimeo.com/video/<?php echo $socContent['vimeo_last_video']; ?>" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen 
                            <?php if (isset($socContent['vimeo_video_width'])): ?>
                            rel="<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>"
                            <?php endif; ?>>
                        </iframe>
                        <?php if (isset($socContent['vimeo_last_video_counter'])): ?>
                            <p><?php echo Yii::t('eauth', 'View count: ') . $socContent['vimeo_last_video_counter']; ?></p>
                        <?php endif; ?>
                        <?php if (empty($socContent['dinamyc']) and isset($socContent['vimeo_video_width']) and isset($socContent['vimeo_video_height']) and ($socContent['vimeo_video_width'] > 0) and ($socContent['vimeo_video_height'] > 0)): ?>
                            <script type="text/javascript">
                                $(document).ready(function() {
                                    $('#vimeo_<?php echo $dataKey; ?>').width($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>);
                                    $('#vimeo_<?php echo $dataKey; ?>').css('min-height', '10px');
                                    $('#vimeo_<?php echo $dataKey; ?>').height(($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>) /<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>);
                                });
                                $(window).resize(function() {
                                    $('#vimeo_<?php echo $dataKey; ?>').width($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>);
                                    $('#vimeo_<?php echo $dataKey; ?>').height(($('body').width() -<?php echo isset($socContent['photo']) ? '146' : '80'; ?>) /<?php echo $socContent['vimeo_video_width'] / $socContent['vimeo_video_height']; ?>);
                                });
                            </script>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php /* Checkin *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['venue_name'])): ?>
                    <div class="item-area text-center">
                        <p><?php echo Yii::t('eauth', 'в ') . $socContent['venue_name'] ?><?php if (isset($socContent['venue_address'])): ?>, <?php echo $socContent['venue_address'] ?><?php endif; ?>
                        </p>
                        <?php if (isset($socContent['checkin_shout'])): ?>
                            <p><?php echo $socContent['checkin_shout'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($socContent['checkin_date'])): ?>
                            <p><?php echo $socContent['checkin_date'] ?></p>
                        <?php endif; ?>
                        <?php if (isset($socContent['checkin_photo'])): ?>
                            <img src="<?php echo $socContent['checkin_photo']; ?>">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php /* Image *////////////////////////////////////////////////////////////////////////////////// ?>
                <?php if (isset($socContent['last_img'])): ?>
                    <div class="item-area text-center">
                        <?php if (isset($socContent['last_img_href'])): ?>
                            <a href="<?php echo $socContent['last_img_href']; ?>">
                            <?php endif; ?>
                            <?php if (isset($socContent['last_img_msg'])): ?>
                                <p><?php echo $this->hrefActivate($socContent['last_img_msg']); ?></p>
                            <?php endif; ?>
                            <img src="<?php echo $socContent['last_img']; ?>">
                            <?php if (isset($socContent['last_img_story'])): ?>
                                <p><?php echo $this->hrefActivate($socContent['last_img_story']); ?></p>
                            <?php endif; ?>
                            <?php if (isset($socContent['last_img_href'])): ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <?php /* Map *//////////////////////////////////////////////////////////////////////////////////  ?>
                <?php if (isset($socContent['place_lat']) && isset($socContent['place_lng'])): ?>
                    <div class="item-area text-center">
                        <?php if (isset($socContent['place_msg'])): ?>
                            <p><?php echo $socContent['place_msg']; ?></p>
                        <?php endif; ?>
                        <div id="map_canvas_<?php echo $dataKey; ?>" style="width:400px; height:200px; margin:0 auto"></div>
                        <?php if (empty($socContent['dinamyc'])): ?>
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
                    </div>
                <?php endif; ?>
                <?php /* YouTube video *//////////////////////////////////////////////////////////////////////////////////  ?>
                <?php if (isset($socContent['ytube_video_link']))
                {
                    ?>
                    <?php if (isset($socContent['ytube_video_flash']))
                    {
                        ?>
                        <div class="item-area text-center">
                            <object>
                                <param name="movie" value="<?php echo $socContent['ytube_video_flash']; ?>"></param>
                                <param name="allowFullScreen" value="true"></param>
                                <embed class="yt_player" id="player_<?php echo $dataKey; ?>" src="<?php echo $socContent['ytube_video_flash']; ?>"
                                        <?php if (isset($socContent['ytube_video_rel'])): ?>
                                            rel="<?php echo $socContent['ytube_video_rel']; ?>"
                                        <?php endif; ?>
                                       type="application/x-shockwave-flash"
                                       <?php if (isset($socContent['ytube_video_rel'])): ?>
                                           width="100%" height="480"
                                       <?php else: ?>
                                           width="120" height="90"
                            <?php endif; ?>
                                       allowfullscreen="true"></embed>
                            </object>
                            <?php if (isset($socContent['ytube_video_rel']) and empty($socContent['dinamyc'])): ?>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                        $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['ytube_video_rel']; ?>);
                                    });
                                    $(window).resize(function() {
                                        $('#player_<?php echo $dataKey; ?>').height($('#player_<?php echo $dataKey; ?>').width() /<?php echo $socContent['ytube_video_rel']; ?>);
                                    });
                                </script>
                            <?php endif; ?>
                            <?php if (isset($socContent['ytube_video_view_count'])): ?>
                                <p><?php echo Yii::t('eauth', 'View count: ') . $socContent['ytube_video_view_count']; ?></p>
                        <?php endif; ?>
                        </div>
                    <?php } ?>
                <?php } ?>
        <?php /* list *//////////////////////////////////////////////////////////////////////////////////   ?>
            <?php if (!empty($socContent['list'])): ?>
                <?php if (!empty($socContent['list']['title'])): ?>
                <h4><?php echo $socContent['list']['title']; ?></h4>
                <?php endif; ?>
                <ul>
                <?php foreach ($socContent['list']['values'] as $li): ?>
                    <?php if (!empty($li['href']) && !empty($li['title'])): ?>
                        <li><a class="authot-name" href="<?php echo $li['href']; ?>"><?php echo $li['title']; ?></a><?php if (!empty($li['comment'])): ?> - <?php echo $li['comment']; ?><?php endif; ?></li>
                    <?php elseif (!empty($li['title'])): ?>
                        <li><?php echo $li['title']; ?>
                            <?php if (!empty($li['comment'])): ?> - <?php echo $li['comment']; ?><?php endif; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php /* list2 *//////////////////////////////////////////////////////////////////////////////////   ?>
            <?php if (!empty($socContent['list2'])): ?>
                <?php if (!empty($socContent['list2']['title'])): ?>
                <h4><?php echo $socContent['list2']['title']; ?></h4>
                <?php endif; ?>
                <ul>
                <?php foreach ($socContent['list2']['values'] as $li): ?>
                    <?php if (!empty($li['href']) && !empty($li['title'])): ?>
                        <li><a class="authot-name" href="<?php echo $li['href']; ?>"><?php echo $li['title']; ?></a><?php if (!empty($li['comment'])): ?> - <?php echo $li['comment']; ?><?php endif; ?></li>
                    <?php elseif (!empty($li['title'])): ?>
                        <li><?php echo $li['title']; ?>
                            <?php if (!empty($li['comment'])): ?> - <?php echo $li['comment']; ?><?php endif; ?></li>
                    <?php endif; ?>
                <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        <?php /* html *//////////////////////////////////////////////////////////////////////////////////   ?>
            <?php if (isset($socContent['html'])): ?>
                <?php echo $socContent['html']; ?>
            <?php endif; ?>
        <?php /* Follow button *//////////////////////////////////////////////////////////////////////////////////   ?>
                    <?php if (isset($socContent['soc_url']) and !isset($socContent['tweet_author']) and empty($socContent['dinamyc'])): ?>
                    <a href="<?php echo $socContent['soc_url']; ?>" class="spot-button soc-link" >
                        <span><?php echo $socContent['invite']; ?></span>
                        <?php if (isset($socContent['inviteClass']) && (strlen($socContent['inviteClass']) > 0)): ?>
                            <i class="i-soc <?php echo $socContent['inviteClass']; ?> round"><?php if (isset($socContent['inviteValue']) && (strlen($socContent['inviteValue']) > 0)) echo $socContent['inviteValue']; ?></i>
                    <?php endif; ?>
                    </a>
        <?php endif; ?>
        
            </div>
        </div>
        <?php endif; ?>