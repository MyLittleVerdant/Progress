<div class="card">
    <div class="card-header">
        <h3>@isset($contact)
                Контакт - {{ $contact->name }}
            @else
                Создание нового контакта
            @endif</h3>
    </div>
    <form action="@isset($contact) {{ route('admin.contacts.update', $contact) }} @else {{ route('admin.contacts.store') }} @endif"
          method="POST"
          enctype="multipart/form-data">
        @csrf
        @isset($contact)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($contact) ? $contact->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="key">Ключ</label>
                <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                       value="{{ old('key', isset($contact) ? $contact->key : '') }}">
                @error('key')
                <span id="key-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Заголовок</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($contact) ? $contact->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="data">Данные</label>
                <input type="text" name="data" id="data" class="form-control @error('data') is-invalid @enderror"
                       value="{{ old('data', isset($contact) ? $contact->data : '') }}">
                @error('data')
                <span id="data-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($contact) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
