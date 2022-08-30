<div class="card">
    <div class="card-header">
        <h3>@isset($member)
                Сотрудник - {{ $member->name }}
            @else
                Создание нового сотрудника
            @endif</h3>
    </div>
    <form
        action="@isset($member) {{ route('admin.team.update', $member) }} @else {{ route('admin.team.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($member)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($member) ? $member->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="name">Полное имя</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror"
                       value="{{ old('name', isset($member) ? $member->name : '') }}">
                @error('name')
                <span id="name-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Должность</label>
                <input type="text" name="post" id="post" class="form-control @error('post') is-invalid @enderror"
                       value="{{ old('post', isset($member) ? $member->post : '') }}">
                @error('post')
                <span id="post-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="picture">Фото</label>
                @isset($member->picture)
                    <img src="{{$member->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($member) ? $member->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($member) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
