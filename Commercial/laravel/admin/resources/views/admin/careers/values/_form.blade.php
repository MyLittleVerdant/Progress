<div class="card">
    <div class="card-header">
        <h3>@isset($value)
                Ценность - {{ $value->name }}
            @else
                Создание новой ценности
            @endif</h3>
    </div>
    <form action="@isset($value) {{ route('admin.careers.values.update', $value) }} @else {{ route('admin.careers.values.store') }} @endif"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @isset($value)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($value) ? $value->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($value) ? $value->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Описание</label>
                <textarea name="description" id="editor" cols="40" rows="5"
                          class="form-control @error('description') is-invalid @enderror">
                        {{ old('description', isset($value) ? $value->description : '') }}
                </textarea>
                @error('description')
                <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="picture">Картинка</label>
                @isset($value->picture)
                    <img src="{{$value->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($value) ? $value->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($value) ? 'Обновить' : 'Создать' }}</button>
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
