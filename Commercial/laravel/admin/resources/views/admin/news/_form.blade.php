<div class="card">
    <div class="card-header">
        <h3>@isset($news)
                Новость - {{ $news->preview_title }}
            @else
                Создание новой новости
            @endif</h3>
    </div>
    <form action="@isset($news) {{ route('admin.news.update', $news) }} @else {{ route('admin.news.store') }} @endif"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @isset($news)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="preview_title">Заголовок анонса</label>
                <input type="text" name="preview_title" id="preview_title"
                       class="form-control @error('preview_title') is-invalid @enderror"
                       value="{{ old('preview_title', isset($news) ? $news->preview_title : '') }}">
                @error('preview_title')
                <span id="preview_title-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="detail_title">Детальный заголовок</label>
                <input type="text" name="detail_title" id="detail_title"
                       class="form-control @error('detail_title') is-invalid @enderror"
                       value="{{ old('detail_title', isset($news) ? $news->detail_title : '') }}">
                @error('detail_title')
                <span id="detail_title-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="date">Дата</label>
                <input type="date" name="date" id="date"
                       class="form-control @error('date') is-invalid @enderror"
                       value="{{ old('date', isset($news) ? date('Y-m-d', strtotime($news->date)) : '') }}"
                       max="9999-12-31">
                @error('date')
                <span id="date-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="preview_description">Описание анонса</label>
                <textarea name="preview_description" cols="40" rows="5"
                          class="editor form-control @error('preview_description') is-invalid @enderror">
                        {{ old('preview_description', isset($news) ? $news->preview_description : '') }}
                </textarea>
                @error('preview_description')
                <span id="preview_description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="detail_description">Детальное описание</label>
                <textarea name="detail_description" cols="40" rows="5"
                          class="editor form-control @error('detail_description') is-invalid @enderror">
                        {{ old('detail_description', isset($news) ? $news->detail_description : '') }}
                </textarea>
                @error('detail_description')
                <span id="detail_description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="main_picture">Заглавная картинка</label>
                @isset($news->main_picture)
                    <img src="{{$news->main_picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="main_picture" id="main_picture" width="50"
                       class="form-control @error('main_picture') is-invalid @enderror"
                       value="{{ old('main_picture', isset($news) ? $news->main_picture : '') }}" accept="image/*">
                @error('main_picture')
                <span id="main_picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group">
                <label for="preview_picture">Картинка анонса</label>
                @isset($news->preview_picture)
                    <img src="{{$news->preview_picture}}" width="180" height="180" alt="">
                @endif
                <input type="file" name="preview_picture" id="preview_picture"
                       class="form-control @error('preview_picture') is-invalid @enderror"
                       value="{{ old('main_picture', isset($news) ? $news->preview_picture : '') }}" accept="image/*">
                @error('preview_picture')
                <span id="preview_picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($news) ? 'Обновить' : 'Создать' }}</button>
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
