<div class="card">
    <div class="card-header">
        <h3>@isset($client)
                Клиент - {{ $client->name }}
            @else
                Создание нового клиента
            @endif</h3>
    </div>
    <form
        action="@isset($client) {{ route('admin.clients.update', $client) }} @else {{ route('admin.clients.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($client)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($client) ? $client->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($client) ? $client->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Тип</label>
                <input type="text" name="type" id="type" class="form-control @error('type') is-invalid @enderror"
                       value="{{ old('type', isset($client) ? $client->type : '') }}">
                @error('name')
                <span id="type-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="picture">Лого</label>
                @isset($client->picture)
                    <img src="{{$client->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($client) ? $client->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($client) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
