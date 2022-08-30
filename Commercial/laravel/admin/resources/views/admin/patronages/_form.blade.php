<div class="card">
    <div class="card-header">
        <h3>@isset($patronage)
                Меценат - {{ $patronage->name }}
            @else
                Создание нового мецената
            @endif</h3>
    </div>
    <form
        action="@isset($patronage) {{ route('admin.patronages.update', $patronage) }} @else {{ route('admin.patronages.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($patronage)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($patronage) ? $patronage->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Заголовок</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($patronage) ? $patronage->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="preview_description">Описание анонса</label>
                <textarea name="preview_description" id="preview_description" cols="40" rows="5"
                          class="editor form-control @error('preview_description') is-invalid @enderror">
                        {{ old('preview_description', isset($patronage) ? $patronage->preview_description : '') }}
                </textarea>
                @error('preview_description')
                <span id="preview_description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="detail_description">Детальное описание</label>
                <textarea name="detail_description"  cols="40" rows="5"
                          class="editor form-control @error('detail_description') is-invalid @enderror">
                        {{ old('detail_description', isset($patronage) ? $patronage->detail_description : '') }}
                </textarea>
                @error('detail_description')
                <span id="detail_description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Подробнее</label>
                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror"
                       value="{{ old('link', isset($patronage) ? $patronage->link : '') }}">
                @error('link')
                <span id="link-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="color">Цвет блока</label>
                <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror"
                       value="{{ old('color', isset($patronage) ? $patronage->color : '') }}">
                @error('color')
                <span id="color-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="preview_picture">Картинка анонса</label>
                @isset($patronage->preview_picture)
                    <img src="{{$patronage->preview_picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="preview_picture" id="preview_picture"
                       class="form-control @error('preview_picture') is-invalid @enderror"
                       value="{{ old('preview_picture', isset($patronage) ? $patronage->preview_picture : '') }}"
                       accept="image/*">
                @error('preview_picture')
                <span id="preview_picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group">
                <label for="detail_picture">Детальная картинка</label>
                @isset($patronage->detail_picture)
                    <img src="{{$patronage->detail_picture}}" width="200" height="200" alt="">
                    <a href="{{ route('admin.patronages.deletePicture', $patronage->id) }}"
                       class="delete-detailPic-btn btn btn-danger"><i
                            class="fa fa-trash"></i>
                        Удалить</a>
                @endif
                <input type="file" name="detail_picture" id="detail_picture"
                       class="form-control @error('detail_picture') is-invalid @enderror"
                       value="{{ old('detail_picture', isset($patronage) ? $patronage->detail_picture : '') }}"
                       accept="image/*">
                @error('detail_picture')
                <span id="detail_picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($patronage) ? 'Обновить' : 'Создать' }}</button>
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
@endpush
