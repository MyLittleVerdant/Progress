<div class="card">
    <div class="card-header">
        <h3>@isset($partner)
                Партнёр - {{ $partner->name }}
            @else
                Создание нового партнёра
            @endif</h3>
    </div>
    <form
        action="@isset($partner) {{ route('admin.partners.update', $partner) }} @else {{ route('admin.partners.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($partner)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($partner) ? $partner->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($partner) ? $partner->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Описание</label>
                <textarea name="description" id="editor" cols="40" rows="5"
                          class="form-control @error('description') is-invalid @enderror">
                        {{ old('description', isset($partner) ? $partner->description : '') }}
                </textarea>
                @error('description')
                <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Сайт партнёра</label>
                <input type="text" name="link" id="link" class="form-control @error('link') is-invalid @enderror"
                       value="{{ old('link', isset($partner) ? $partner->link : '') }}">
                @error('link')
                <span id="link-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Цвет блока</label>
                <input type="text" name="color" id="color" class="form-control @error('color') is-invalid @enderror"
                       value="{{ old('color', isset($partner) ? $partner->color : '') }}">
                @error('color')
                <span id="color-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="picture">Лого</label>
                @isset($partner->picture)
                    <img src="{{$partner->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($partner) ? $partner->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($partner) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    console.log(editor);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
