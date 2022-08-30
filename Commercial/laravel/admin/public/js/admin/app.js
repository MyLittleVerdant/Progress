$(document).ready(function () {
    $('.delete-news-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить новость?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-member-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить сотрудника?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-client-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить клиента?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-contact-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить контакт?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-partner-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить партнёра?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-patronage-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить мецената?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-career_value-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить ценность?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-aboutBlock-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить этот блок?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-favour-btn').click(function (e) {
        e.preventDefault();
        var answer = confirm('Вы уверены, что хотите удалить услугу?');
        if (answer) {
            var form = $(this).closest('form');
            form.submit();
        }
    })

    $('.delete-media-btn').click(function (e) {
        e.preventDefault();
        var urlDel = $(this).attr('href');
        var answer = confirm('Вы уверены, что хотите удалить файл?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: urlDel,
                    type: 'delete', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": parseInt(urlDel.match(/.*medias\/(\d+)/)[1]) // method and token not needed in data
                    },
                    success: function (response) {
                        if (response.error === false) {

                            location.reload()
                        } else {

                        }
                        // console.log(response.error); // see the reponse sent
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });

        }
    })

    $('.delete-favour_detail-btn').click(function (e) {
        e.preventDefault();
        var urlDel = $(this).attr('href');
        var answer = confirm('Вы уверены, что хотите удалить пункт?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: urlDel,
                    type: 'delete', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": parseInt(urlDel.match(/.*favour_detail\/(\d+)/)[1]) // method and token not needed in data
                    },
                    success: function (response) {
                        if (response.error === false) {

                            location.reload()
                        } else {

                        }
                        // console.log(response.error); // see the reponse sent
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText); // this line will save you tons of hours while debugging
                        // do something here because of error
                    }
                });

        }
    })

    /**
     * Добавление формы создания пункта услуги
     */
    var newPoint = 1;
    $('.add-point').click(function () {
        var template = `<div class='list-point point_${newPoint}'>` +
            "                <div class='form-group'>\n" +
            `<label for="sort_new_${newPoint}">Сортировка</label>
            <input type="number" name="sort_new_${newPoint}" id="sort_new_${newPoint}" class="form-control">` +
            `                    <label for="title_new_${newPoint}">Заголовок пункта</label>` +
            `                    <input type='text' name="title_new_${newPoint}" id='title_new_${newPoint}'` +
            "                           class='form-control' >\n" +
            "                </div>\n" +
            "\n" +
            "                <div class='form-group'>\n" +
            "                    <label for='description_{{$detail->id}}'>Описание пункта</label>\n" +
            `                    <textarea name='description_new_${newPoint}' id='description_new_${newPoint}'` +
            "                              cols='40' rows='5'\n" +
            "                              class='form-control editor'>\n" +
            "                     </textarea>\n" +
            "                </div>\n" +
            "\n" +
            "                <div class='form-group'>\n" +
            `                    <label for='subtitle_new_${newPoint}'>Подзаголовок пункта</label>` +
            `                    <input type='text' name='subtitle_new_${newPoint}' id='subtitle_new_${newPoint}'` +
            "                           class='form-control'>\n" +
            "                </div>\n" +
            "\n" +
            "                <div class='form-group'>\n" +
            `                    <label for='list_new_${newPoint}'>Список</label>\n` +
            `                    <textarea name='list_new_${newPoint}' id='list_new_${newPoint}' cols='40' rows='5'\n` +
            "                              class='form-control editor'>\n" +
            "                    </textarea>\n" +
            "                </div>\n" +
            "\n" +
            "                <div class='form-group'>\n" +
            `                    <label for='picture_new_${newPoint}'>Фото пункта</label>\n` +
            `                    <input type='file' name='picture_new_${newPoint}' id='picture_new_${newPoint}'\n` +
            "                           class='form-control' accept='image/*'>\n" +
            "                </div>\n" +

            '                 <div class="form-group">\n' +
            `                                  <label for="photo_gallery_new_${newPoint}">Фотогалерея</label>\n` +
            `                                    <input type="file" name="photo_gallery_new_${newPoint}[]" id="photo_gallery_new_${newPoint}" multiple\n` +
            '                                        class="form-control" accept="image/*">\n' +
            '                            </div>\n' +
            '\n' +
            '                            <div class="form-group">\n' +
            `                                <label for="video_gallery_new_${newPoint}">Видеогалерея</label>\n` +
            `                                <input type="file" name="video_gallery_new_${newPoint}[]" id="video_gallery_new_${newPoint}" multiple\n` +
            '                                       class="form-control" accept="video/*">\n' +
            '                            </div>' +
            "            </div>";

        newPoint++;
        $('#list').append(template);
        let editorArr = $('.editor');
        $(editorArr).each(function () {
            if (!$(this).next().hasClass('ck-editor')) {
                ClassicEditor
                    .create(this)
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        })
    })

    /**
     * Добавление формы создания кнопки соц. сети
     */
    var newSocial = 1;
    $('.add-social').click(function () {
        var template = `<div class="list-social social_${newSocial}">
                                        <div class="form-group">
                                            <label for="name_new_${newSocial}">Наименование</label>
                                            <input type="text" name="name_new_${newSocial}"
                                                   id="name_new_${newSocial}"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="link_new_${newSocial}">Ссылка</label>
                                            <input type="text" name="link_new_${newSocial}"
                                                   id="link_new_${newSocial}"
                                                   class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="picture_new_${newSocial}">Картинка</label>
                                            <input type="file" name="picture_new_${newSocial}"
                                                   id="picture_new_${newSocial}"
                                                   class="form-control " accept="image/*">
                                        </div>
                                    </div>`

        newSocial++;
        $('#list').append(template);
    })

    $('.delete-social-btn').click(function (e) {
        e.preventDefault();
        var urlDel = $(this).attr('href');
        var answer = confirm('Вы уверены, что хотите удалить соц. сеть ?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: urlDel,
                    type: 'delete', // replaced from put
                    dataType: "JSON",
                    data: {
                        "id": parseInt(urlDel.match(/.*social\/(\d+)/)[1])
                    },
                    success: function (response) {
                        if (response.error === false) {

                            location.reload()
                        } else {

                        }
                        // console.log(response.error); // see the reponse sent
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });

        }
    })

    $('img').each(function () {
        if ($(this).attr('src') == '') {
            $(this).remove();
        }
    })

    $('.delete-detailPic-btn').click(function (e) {
        e.preventDefault();
        var urlDel = $(this).attr('href');
        var answer = confirm('Вы уверены, что хотите удалить детальную картинку ?');
        if (answer) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax(
                {
                    url: urlDel,
                    type: 'delete',
                    dataType: "JSON",
                    data: {
                        "id": parseInt(urlDel.match(/.*\/(\d+)/)[1])
                    },
                    success: function (response) {
                        if (response.error === false) {

                            location.reload()
                        } else {

                        }
                        // console.log(response.error); // see the reponse sent
                    },
                    error: function (xhr) {
                        console.log(xhr.responseText);
                    }
                });

        }
    })

});

