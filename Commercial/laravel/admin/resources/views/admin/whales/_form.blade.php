<div class="card">
    <div class="card-header">
        <h3>@isset($whale)
                Кит - {{ $whale->key }}
            @else
                Создание нового кита
            @endif</h3>
    </div>
    <form
        action="@isset($whale) {{ route('admin.whales.update', $whale) }} @else {{ route('admin.whales.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($whale)
            @method('PUT')
        @endisset

        <div class="card-body">

            <div class="form-group">
                <label for="key">Ключ</label>
                <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                       value="{{ old('key', isset($whale) ? $whale->key : '') }}">
                @error('key')
                <span id="key-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="picture">Картинка</label>
                @isset($whale->picture)
                    <img src="{{$whale->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($whale) ? $whale->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($whale) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
