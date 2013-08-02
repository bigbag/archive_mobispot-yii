$(document).ready(function() {

    var wrap = $("#wrapper");
    var item_w;

    preview();

    $(window).resize(function(){
        preview();
    });

    function preview() {
        item_w = 100/Math.floor(wrap.width()/230);
        $("#works-preview li").css("width", item_w+"%");
    }

    $("#game15").jqPuzzle();

    $("#hide-logo").click(function(){
        $(this).hide();
        $("#header h1").animate({
            "top":"-58px"
        }, 300);
        $("#game").animate({
            "bottom":"35px"
        }, 300);
        return false;
    });

    $("#return-logo").click(function(){
        $("#hide-logo").show();
        $("#header h1").animate({
            "top":"18px"
        }, 300);
        $("#game").animate({
            "bottom":"-48px"
        }, 300);
        return false;
    });

    $("#chat a").click(function(){
        window.open("https://siteheart.com/webconsultation/494446", "siteheart_494446", "width=550,height=400,top=30,left=30,modal=yes,alwaysRaised=yes,resizable=yes");
        return false;
    });

    $("a.dyn").click(function(){
        var c_img = $(this).parent().find("a.dyn-current");
        var elem = $(this);
        $(c_img.attr("href")).hide();
        $(elem.attr("href")).show();
        c_img.removeClass("dyn-current");
        elem.addClass("dyn-current");
        return false;
    });

    $("#game .close").live("click", function() {
        $(this).parent().remove();
        return false;
    });

    ////////// Загрузка файлов /////////////////////////////////////////////////////

    if($('#file-loader').length){
		/*
        // HTML5 upload
        var dropbox = $('#file-drag'),
        defaulText = dropbox.html(),
		errorBlock = $('#file-loader .error'),
        maxFileSize = 10000000; // максимальный размер файла - 10 мб.

        if (window.FormData === undefined) {
            dropbox.html('Если у вас есть для нас файлы, вы можете их загрузить.');
            defaulText = dropbox.html();
            $('#file-button').find('span').html('Выберите файл');
        }


		dropbox[0].ondragover = function() {
			$(this).addClass('hover');
			return false;
		};

		dropbox[0].ondragleave = function() {
			$(this).removeClass('hover');
			return false;
		};

		dropbox[0].ondrop = function(event) {
			$(this).removeClass('hover');
			var files = event.dataTransfer.files;

			for(i=0;i<files.length;i++) {
				if (files[i].size > maxFileSize) {
					errorBlock.text('Файл слишком большой!').fadeIn(400).delay(1500).fadeOut(400);
					return false;
				} else {
					$(this).prepend('<div class="progress"></div><div class="progress-bar"></div>');
					uploadFile(files[i], '/uploader/sfile', $(this));  // путь до исполняющего файла
				}
			}
			event.preventDefault();
			event.stopPropagation();

			return false;
		};


        function uploadFile(file, url, d) {

			if(window.FileReader !== undefined) {
				var reader = new FileReader();

				reader.onload = function() {
					var xhr = new XMLHttpRequest();

					xhr.upload.addEventListener("progress-bar", function(e) {
						if (e.lengthComputable) {
							var progress = Math.round((e.loaded * 100) / e.total);
							d.find('.progress-bar').css('width',progress + '%');
						}
					}, false);

					// ... можно обрабатывать еще события load и error объекта xhr.upload ...

					xhr.onreadystatechange = function () {
						if (this.readyState == 4) {
							if(this.status == 200) {
								var request = $.parseJSON(this.response);
								console.log("ok");
								if(!request.upload_file)
								{
									d.find('.progress-bar').css('width','100%');
									d.find('.progress-bar').fadeOut(600, function(){
										$(this).remove();
									});
									d.find('.progress').fadeOut(600, function(){
										$(this).remove();
									});
									dropbox.not('.drop').addClass('drop').html('');
									// var request = $.parseJSON(this.response);
									dropbox.append($(   '<div class="uploaded-file">'+
										'<div class="filename '+request.file+'">'+request.filename+'&nbsp;<a class="delete-file" href="#" title="Удалить файл">Удалить файл</a></div>'+
										'<input type="hidden" value="'+request.link+'" name="user_file[]">'+
										'</div>'));
								}
								else errorBlock.text(request.upload_file).fadeIn(400).delay(1500).fadeOut(400);
							} else {
								// ... ошибка! ...
								errorBlock.text('Упс! Неверный формат данных!'+this.status).fadeIn(400).delay(1500).fadeOut(400);
							}
						}
					};

					xhr.open("POST", url);

					var boundary = "xxxxxxxxx";

					// Устанавливаем заголовки
					xhr.setRequestHeader('Content-type', 'multipart/form-data; boundary="' + boundary + '"');
					xhr.setRequestHeader('Cache-Control', 'no-cache');

					// Формируем тело запроса
					var body = "--" + boundary + "\r\n";
					body += "Content-Disposition: form-data; name='upload_file'; filename='" + unescape( encodeURIComponent(file.name)) + "'\r\n";
					body += "Content-Type: application/octet-stream\r\n\r\n";
					body += reader.result + "\r\n";
					body += "--" + boundary + "--";




					if (!XMLHttpRequest.prototype.sendAsBinary) {

						XMLHttpRequest.prototype.sendAsBinary = function(datastr) {
							function byteValue(x) {
								return x.charCodeAt(0) & 0xff;
							}
							var ords = Array.prototype.map.call(datastr, byteValue);
							var ui8a = new Uint8Array(ords);
							this.send(ui8a.buffer);
						}
					}

					if(xhr.sendAsBinary) {
						// только для firefox
						xhr.sendAsBinary(body);
					} else {
						// chrome (так гласит спецификация W3C)
						xhr.send(body);
					}
				};


				// Читаем файл
				reader.readAsBinaryString(file);
			}

			}; */

		var dropbox = $('#file-drag'),
        defaulText = dropbox.html(),
		errorBlock = $('#file-loader .error'),
		total_bites = 0,
        maxFileSize = 10 * 1024 * 1024; // максимальный размер файла - 10 мб.

		if (window.FormData === undefined) {
            dropbox.html('Если у вас есть для нас файлы, вы можете их загрузить.');
            defaulText = dropbox.html();
            $('#file-button').find('span').html('Выберите файл');
        }

		var dnd = {
        ready : function()
        {
          dropbox.bind(
              'dragenter',
              function(e) {
				$(this).addClass('hover');
                e.preventDefault();
                e.stopPropagation();
              }
            )
            .bind(
              'dragover',
              function(e) {
				//$(this).addClass('hover');
                e.preventDefault();
                e.stopPropagation();
              }
            )
			.bind(
              'dragleave',
              function(e) {
				$(this).removeClass('hover');
                e.preventDefault();
                e.stopPropagation();
              }
            )
            .bind(
              'drop',
              function(e) {
                if (e.originalEvent.dataTransfer.files.length) {
					$(this).removeClass('hover');
					e.preventDefault();
					e.stopPropagation();
					var files_arr = e.originalEvent.dataTransfer.files;
					for(i=0;i<files_arr.length;i++) {
						total_bites = total_bites + files_arr[i].size;
					}

					if (total_bites < maxFileSize) {
						dnd.upload(files_arr);
						$(this).prepend('<div class="progress"></div><div class="progress-bar"></div>');
						//console.log(total_bites);
					} else {
						errorBlock.text('Файлы не должны превышать 10Мб!').fadeIn(400).delay(1500).fadeOut(400);
						total_bites = 0;
						return false;
					}
                }
              }
            );
        },

        upload : function(files)
        {
          // This is a work-around for Safari occaisonally hanging when doing a
          // file upload.  For some reason, an additional HTTP request for a blank
          // page prior to sending the form will force Safari to work correctly.

          $.get('/upload/files/blank.html');

          var http = new XMLHttpRequest();

          $('div.progress-bar').css('width', 0);

          //$('div#uploadComplete').fadeOut(
          //  'normal',
          //  function() {
          //    $('div#uploadProgress').fadeIn();
          //  }
          //);

          if (http.upload && http.upload.addEventListener) {
            http.upload.addEventListener(
              'progress',
              function(e) {
                if (e.lengthComputable) {
                  var progress = Math.round((e.loaded * 100) / e.total);
                  var progressDiv = $('div.progress-bar');
                  progressDiv.css('width', progress + '%');
                }
              },
              false
            );

                    http.onreadystatechange = function () {

                        if (this.readyState == 4) {
                            if(this.status == 200) {
                                $('div.progress-bar').fadeOut(600);
                                var result = $.parseJSON(this.response);
                                //console.log(this);
                                if(result.files) {
                                    //console.log(result);
                                    dropbox.not('.drop').addClass('drop').html('');
                                    for(i=0;i<result.files.length;i++) {
                                        dropbox.append($('<div class="uploaded-file">'+
                                            '<div class="filename '+result.files[i].file+'">'+result.files[i].filename+'&nbsp;<a class="delete-file" href="#" title="Удалить файл">Удалить файл</a></div>'+
                                            '<input type="hidden" value="'+result.files[i].link+'" name="user_file[]">'+ /*+result.filename+*/
                                            '</div>'));
                                    }
                                }
                                if(result.errors) {
                                    errorBlock.text(result.errors[0].message.upload_file).fadeIn(400).delay(1500).fadeOut(400);
                                }
                            } else {
                                // ... ошибка! ...
                                errorBlock.text('Упс! Неверный формат данных!').fadeIn(400).delay(1500).fadeOut(400);
                            }
                        }
                    };

            http.upload.addEventListener(
              'load',
              function(e) {
                $('div.progress-bar')
                  .css('width', '100%');

                //$('div#uploadProgress').fadeOut(
                //  'normal',
                //  function() {
                //    $('div#uploadComplete').fadeIn();
                //  }
                //);
              }
            );
          }

          if (typeof(FormData) != 'undefined') {
            var form = new FormData();

            form.append('path', '/');

            for (var i = 0; i < files.length; i++) {
              form.append('file[]', files[i]);
            }

            http.open('POST', '/uploader/sfile');
            http.send(form);
          }
        },

        getFileSize : function(bytes)
        {
          switch (true) {
            case (bytes < Math.pow(2,10)): {
              return bytes + ' Bytes';
            };
            case (bytes >= Math.pow(2,10) && bytes < Math.pow(2,20)): {
              return Math.round(bytes / Math.pow(2,10)) +' KB';
            };
            case (bytes >= Math.pow(2,20) && bytes < Math.pow(2,30)): {
              return Math.round((bytes / Math.pow(2,20)) * 10) / 10 + ' MB';
            };
            case (bytes > Math.pow(2,30)): {
              return Math.round((bytes / Math.pow(2,30)) * 100) / 100 + ' GB';
            };
          }
        }
      };

      $(document).ready(dnd.ready);






        // AJAX upload
        $.ajax_upload('#user-file',{
            action : '/uploader/sfile', // путь до исполняющего файла
            name : 'file[]',
            onComplete : function(file, response){
                var result = $.parseJSON(response);
                //console.log(result);
                if(result.status) {
                    dropbox.not('.drop').addClass('drop').html('');
                    dropbox.append($('<div class="uploaded-file">'+
                        '<div class="filename '+result.files[0].file+'">'+result.files[0].filename+'&nbsp;<a class="delete-file" href="#" title="Удалить файл">Удалить файл</a></div>'+
                        '<input type="hidden" value="'+result.files[0].link+'" name="user_file[]">'+ /*+result.filename+*/
                        '</div>'));
                    this.enable();
                } else {
                    errorBlock.text(result.errors[0].message.upload_file).fadeIn(400).delay(1500).fadeOut(400);
                }
            }
        });

        // Удаление
        $('.delete-file').live('click', function(){
            var removeBlock = $(this).parent().parent();
            var pathRemoving = removeBlock.find('input').val(); // путь удаляемой картинки

            $.ajax({
                type: 'POST',
                url: '/uploader/dfile', // путь до исполняющего файла
                data: 'remove_path='+ pathRemoving,
                dataType: 'text',
                success: function(){
                    removeBlock.remove();
                    if($('.uploaded-file').length == 0) dropbox.html(defaulText).removeClass('drop');
                }
            });
            return false;
        });
    };
    ////////////////////////////////////////////////////////////////////////////////

    /**
     * @author tages
     */
    $('a[href^="http://"]').not('a[href*="//15web.ru"]').each(function () {
        $(this).attr('rel','nofollow');
        $(this).wrap('<noindex></noindex>');
    });
    $('a[href^="https://"]').not('a[href*="//15web.ru"]').each(function () {
        $(this).attr('rel','nofollow');
        $(this).wrap('<noindex></noindex>');
    });

    ////////////////////////////////////////////////////////////////////////////////
    // Пятнашки
	/*var clicked15 = 0;
    $('.jqp-piece').live('click',function(){
		if(!clicked15) {
			$.ajax({
				type: 'POST',
				url: '/ajax_competition/go',
				success: function(){

				}
			});
			clicked15 = 1;
		}
    });*/

});