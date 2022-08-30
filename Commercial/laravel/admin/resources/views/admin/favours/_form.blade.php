<div class="card">
    <div class="card-header">
        <h3>@isset($favour)
                Услуга - {{ $favour->title }}
            @else
                Создание новой услуги
            @endif</h3>
    </div>
    <form
        action="@isset($favour) {{ route('admin.favours.update', $favour) }} @else {{ route('admin.favours.store') }} @endif"
        method="POST" id="element"
        enctype="multipart/form-data">
        @csrf
        @isset($favour)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($favour) ? $favour->sort : 500) }}">
            </div>
            <div class="form-group">
                <label for="key">Ключ</label>
                <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                       value="{{ old('key', isset($favour) ? $favour->key : '') }}">
                @error('key')
                <span id="key-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', isset($favour) ? $favour->title : '') }}">
                @error('title')
                <span id="title-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="editor" cols="40" rows="5"
                          class="form-control editor @error('description') is-invalid @enderror">
                        {{ old('description', isset($favour) ? $favour->description : '') }}
                </textarea>
                @error('description')
                <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="link">Подробнее</label>
                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror"
                       value="{{ old('link', isset($favour) ? $favour->link : '') }}">
                @error('link')
                <span id="link-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="preview_picture">Превью фото</label>
                @isset($favour->preview_picture)
                    <img src="{{$favour->preview_picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="preview_picture" id="preview_picture"
                       class="form-control @error('preview_picture') is-invalid @enderror"
                       value="{{ old('preview_picture', isset($favour) ? $favour->preview_picture : '') }}"
                       accept="image/*">
                @error('preview_picture')
                <span id="preview_picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group">
                @php
                    $whales=App\Models\Whales::all();
                    if (isset($favour->whale)){
                        $pickedWhale=App\Models\Whales::firstWhere('key',$favour->whale);
                    }
                @endphp
                <label for="whale">Кит: </label> <br>
                <img class="whale" width="200" height="200" src="{{isset($pickedWhale)?$pickedWhale->picture:''}}"
                     alt="">
                <select name="whale" id="whale">
                    <option value="null">Выберите значение</option>
                    @foreach($whales as $whale)
                        <option
                            value="{{$whale->key }}" {{isset($favour) ?$favour->whale==$whale->key? 'selected' : '':''}}>{{$whale->key }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group responsive">
                <label for="picture">Фотогалерея</label>
                <div class="pictures">
                    @isset($favour->medias)
                        @php(
                            $pictures=$favour->medias()->where('type','=','photo')->orderBy('sort','asc')->get()
                        )
                        @foreach( $pictures as $picture)
                            <div class="picture">
                                <img src="{{$picture->file}}" width="200" height="200" alt="">
                                <label for="picture_sort_{{$picture->id}}">Сортировка</label>
                                <input type="number" name="picture_sort_{{$picture->id}}"
                                       id="picture_sort_{{$picture->id}}"
                                       class="form-control"
                                       value="{{ old('sort', isset($picture) ? $picture->sort : 500) }}">
                                <label for="picture_title_{{$picture->id}}">Заголовок</label>
                                <input type="text" name="picture_title_{{$picture->id}}"
                                       id="picture_title_{{$picture->id}}"
                                       class="form-control sub_input"
                                       value="{{ old('picture_title_'.$picture->id, $picture->title?? '') }}">
                                <label for="picture_subtitle_{{$picture->id}}">Подзаголовок</label>
                                <input type="text" name="picture_subtitle_{{$picture->id}}"
                                       id="picture_subtitle_{{$picture->id}}"
                                       class="form-control sub_input"
                                       value="{{ old('picture_subtitle_'.$picture->id, $picture->subtitle?? '') }}">
                                <a href="{{ route('admin.medias.delete', $picture) }}"
                                   class="delete-media-btn btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                    Удалить</a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <input type="file" name="pictures[]" id="picture" multiple
                       class="form-control @error('pictures') is-invalid @enderror" accept="image/*">
                @error('pictures')
                <span id="pictures-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="video">Видеогалерея</label>
                <div class="videos">
                    @isset($favour->medias)
                        @php(
                                $videos=$favour->medias()->where('type','=','video')->orderBy('sort','asc')->get()
                            )
                        @foreach($videos as $video)
                            @php($poster=\App\Models\Medias::query()->where(['relation_id'=>$video->id,'relation_name'=>'video'])->first())
                            <div class="video">
                                <video width="200" height="200" controls="controls"
                                       poster="@isset($poster) {{$poster->getAttribute('file')}} @endif">
                                    <source src="{{$video->file}}">
                                </video>
                                <label for="poster_{{$video->id}}">Постер</label>
                                @isset($poster)
                                    <img src="{{$poster->getAttribute('file')}}" id="poster_{{$video->id}}" width="200"
                                         height="200" alt="">
                                @endif
                                <input type="file" name="poster_{{$video->id}}" id="poster_{{$video->id}}"
                                       class="form-control poster-input"
                                       value="{{ old('poster', isset($poster) ? $poster->getAttribute('file') : '') }}"
                                       accept="image/*">
                                <label for="video_sort_{{$video->id}}">Сортировка</label>
                                <input type="number" name="video_sort_{{$video->id}}"
                                       id="video_sort_{{$video->id}}"
                                       class="form-control"
                                       value="{{ old('sort', isset($video) ? $video->sort : 500) }}">

                                <a href="{{ route('admin.medias.delete', $video) }}"
                                   class="delete-media-btn btn btn-danger"><i class="fa fa-trash"></i>
                                    Удалить</a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <input type="file" name="videos[]" id="video" multiple
                       class="form-control @error('videos') is-invalid @enderror" accept="video/*">
                @error('videos')
                <span id="videos-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="section">
                <h3>Списки</h3>
                <input type="checkbox" id="useList" name="useList" class="left"
                       @if (isset($favour)&&$favour->list===1)checked @endif>
                <label for="scales">Использовать списки</label>
                <div id="list">
                    @isset($favour->details)
                        @foreach($favour->details as $detail)
                            <div class="list-point point_{{$detail->id}}">
                                <div class="delete-point">
                                    <a href="{{ route('admin.favour_detail.delete', $detail) }}"
                                       class="delete-favour_detail-btn btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                        Удалить</a>
                                </div>
                                <div class="form-group">
                                    <label for="sort_old_{{$detail->id}}">Сортировка</label>
                                    <input type="number" name="sort_old_{{$detail->id}}" id="sort_old_{{$detail->id}}"
                                           class="form-control"
                                           value="{{ old('sort', isset($detail) ? $detail->sort : 500) }}">
                                </div>
                                <div class="form-group">
                                    <label for="title_old_{{$detail->id}}">Заголовок пункта</label>
                                    <input type="text" name="title_old_{{$detail->id}}" id="title_old_{{$detail->id}}"
                                           class="form-control"
                                           value="{{ old('title_old_'.$detail->id, $detail->title?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="description_old_{{$detail->id}}">Описание пункта</label>
                                    <textarea name="description_old_{{$detail->id}}"
                                              id="description_old_{{$detail->id}}"
                                              cols="40" rows="5"
                                              class="form-control editor">
                                        {{ old('description_old_'.$detail->id, $detail->description?? '') }}
                                     </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="subtitle_old_{{$detail->id}}">Подзаголовок пункта</label>
                                    <input type="text" name="subtitle_old_{{$detail->id}}"
                                           id="subtitle_old_{{$detail->id}}"
                                           class="form-control"
                                           value="{{ old('subtitle_old_'.$detail->id, $detail->subtitle?? '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="list_old_{{$detail->id}}">Список</label>
                                    <textarea name="list_old_{{$detail->id}}" id="list_old_{{$detail->id}}" cols="40"
                                              rows="5"
                                              class="form-control editor">
                                         {{ old('list_old_'.$detail->id,$detail->list?? '') }}
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="picture_old_{{$detail->id}}">Фото пункта</label>
                                    @isset($detail->picture)
                                        <img src="{{$detail->picture}}" width="200" height="200" alt="">
                                    @endif
                                    <input type="file" name="picture_old_{{$detail->id}}"
                                           id="picture_old_{{$detail->id}}"
                                           class="form-control"
                                           value="{{ old('picture_old_'.$detail->id,$detail->picture??'') }}"
                                           accept="image/*">
                                </div>

                                <div class="form-group responsive">
                                    <label for="photo_gallery_old_{{$detail->id}}">Фотогалерея</label>
                                    <div class="photo_gallery">
                                        <div class="pictures">
                                            @isset($detail->medias)
                                                @php(
                                                    $pictures=$detail->medias()->where('type','=','photo')->orderBy('sort','asc')->get()
                                                )
                                                @foreach( $pictures as $picture)
                                                    <div class="picture">
                                                        <img src="{{$picture->file}}" width="200" height="200" alt="">
                                                        <label for="picture_sort_{{$picture->id}}">Сортировка</label>
                                                        <input type="number" name="picture_sort_{{$picture->id}}"
                                                               id="picture_sort_{{$picture->id}}"
                                                               class="form-control"
                                                               value="{{ old('sort', isset($picture) ? $picture->sort : 500) }}">
                                                        <label for="picture_title_{{$picture->id}}">Заголовок</label>
                                                        <input type="text" name="picture_title_{{$picture->id}}"
                                                               id="picture_title_{{$picture->id}}"
                                                               class="form-control sub_input"
                                                               value="{{ old('picture_title_'.$picture->id, $picture->title?? '') }}">
                                                        <label
                                                            for="picture_subtitle_{{$picture->id}}">Подзаголовок</label>
                                                        <input type="text" name="picture_subtitle_{{$picture->id}}"
                                                               id="picture_subtitle_{{$picture->id}}"
                                                               class="form-control sub_input"
                                                               value="{{ old('picture_subtitle_'.$picture->id, $picture->subtitle?? '') }}">
                                                        <a href="{{ route('admin.medias.delete', $picture) }}"
                                                           class="delete-media-btn btn btn-danger">
                                                            <i class="fa fa-trash"></i>
                                                            Удалить</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <input type="file" name="photo_gallery_old_{{$detail->id}}[]"
                                           id="photo_gallery_old_{{$detail->id}}"
                                           multiple
                                           class="form-control" accept="image/*">
                                </div>

                                <div class="form-group">
                                    <label for="video_gallery_old_{{$detail->id}}">Видеогалерея</label>
                                    <div class="video_gallery">
                                        <div class="videos">
                                            @isset($detail->medias)
                                                @php(
                                                        $videos=$detail->medias()->where('type','=','video')->orderBy('sort','asc')->get()
                                                    )
                                                @foreach($videos as $video)
                                                    @php($poster=\App\Models\Medias::query()->where(['relation_id'=>$video->id,'relation_name'=>'video'])->first())
                                                    <div class="video">
                                                        <video width="200" height="200" controls="controls"
                                                               poster="@isset($poster) {{$poster->getAttribute('file')}} @endif">
                                                            <source src="{{$video->file}}">
                                                        </video>
                                                        <label for="poster_{{$video->id}}">Постер</label>
                                                        @isset($poster)
                                                            <img src="{{$poster->getAttribute('file')}}"
                                                                 id="poster_{{$video->id}}" width="200"
                                                                 height="200" alt="">
                                                        @endif
                                                        <input type="file" name="poster_{{$video->id}}"
                                                               id="poster_{{$video->id}}"
                                                               class="form-control poster-input"
                                                               value="{{ old('poster', isset($poster) ? $poster->getAttribute('file') : '') }}"
                                                               accept="image/*">
                                                        <label for="video_sort_{{$video->id}}">Сортировка</label>
                                                        <input type="number" name="video_sort_{{$video->id}}"
                                                               id="video_sort_{{$video->id}}"
                                                               class="form-control"
                                                               value="{{ old('sort', isset($video) ? $video->sort : 500) }}">
                                                        <a href="{{ route('admin.medias.delete', $video) }}"
                                                           class="delete-media-btn btn btn-danger"><i
                                                                class="fa fa-trash"></i>
                                                            Удалить</a>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <input type="file" name="video_gallery_old_{{$detail->id}}[]"
                                           id="video_gallery_old_{{$detail->id}}" multiple
                                           class="form-control" accept="video/*">
                                </div>
                            </div>

                        @endforeach
                    @endif
                </div>

                <button type="button" class="btn btn-info add-point">+</button>
            </div>


        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success confirm">{{ isset($favour) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>

@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
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

        });
    </script>
    <script>
        var whales = {!! json_encode($whales->toArray()) !!};
        $("#whale").change(function () {
            var pickedWhale = $(this).val();
            if (pickedWhale == 'null') {
                $('img.whale').attr('src', '');
            } else {
                var src = whales.filter(whale => whale.key == pickedWhale)[0]['picture'];
                $('img.whale').attr('src', src);
            }

        });
    </script>
@endpush
