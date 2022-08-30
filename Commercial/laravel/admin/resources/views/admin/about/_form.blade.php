<div class="card">
    <div class="card-header">
        <h3>@isset($aboutBlock)
                Блок - {{ $aboutBlock->title }}
            @else
                Создание нового блока
            @endif</h3>
    </div>
    <form
        action="@isset($aboutBlock) {{ route('admin.about.update', $aboutBlock) }} @else {{ route('admin.about.store') }} @endif"
        method="POST"
        enctype="multipart/form-data">
        @csrf
        @isset($aboutBlock)
            @method('PUT')
        @endisset

        <div class="card-body">
            <div class="form-group">
                <label for="sort">Сортировка</label>
                <input type="number" name="sort" id="sort" class="form-control @error('sort') is-invalid @enderror"
                       value="{{ old('sort', isset($aboutBlock) ? $aboutBlock->sort : 500) }}">
                @error('sort')
                <span id="sort-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="key">Ключ</label>
                <input type="text" name="key" id="key" class="form-control @error('key') is-invalid @enderror"
                       value="{{ old('key', isset($aboutBlock) ? $aboutBlock->key : '') }}">
                @error('key')
                <span id="key-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="title">Заголовок</label>
                <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror"
                       value="{{ old('title', isset($aboutBlock) ? $aboutBlock->title : '') }}">
                @error('title')
                <span id="title-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="subtitle">Подзаголовок</label>
                <input type="text" name="subtitle" id="subtitle"
                       class="form-control @error('subtitle') is-invalid @enderror"
                       value="{{ old('subtitle', isset($aboutBlock) ? $aboutBlock->subtitle : '') }}">
                @error('subtitle')
                <span id="subtitle-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="post">Описание</label>
                <textarea name="description" cols="40" rows="5"
                          class="form-control editor @error('description') is-invalid @enderror">
                        {{ old('description', isset($aboutBlock) ? $aboutBlock->description : '') }}
                </textarea>
                @error('description')
                <span id="description-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="picture">Картинка</label>
                @isset($aboutBlock->picture)
                    <img src="{{$aboutBlock->picture}}" width="200" height="200" alt="">
                @endif
                <input type="file" name="picture" id="picture"
                       class="form-control @error('picture') is-invalid @enderror"
                       value="{{ old('picture', isset($aboutBlock) ? $aboutBlock->picture : '') }}" accept="image/*">
                @error('picture')
                <span id="picture-error" class="error invalid-feedback">{{ $message }}</span>
                @enderror

            </div>

            <div class="form-group">
                @php
                    $whales=App\Models\Whales::all();
                    if (isset($aboutBlock->whale)){
                        $pickedWhale=App\Models\Whales::firstWhere('key',$aboutBlock->whale);
                    }
                @endphp
                <label for="whale">Кит: </label> <br>
                <img class="whale" width="200" height="200" src="{{isset($pickedWhale)?$pickedWhale->picture:''}}"
                     alt="">
                <select name="whale" id="whale">
                    <option value="null">Выберите значение</option>
                    @foreach($whales as $whale)
                        <option
                            value="{{$whale->key }}" {{isset($aboutBlock) ?$aboutBlock->whale==$whale->key? 'selected' : '':''}}>{{$whale->key }}</option>
                    @endforeach
                </select>
            </div>

            @isset($aboutBlock)
                @if($aboutBlock->key=='letter')
                    <div class="form-group">
                        <label for="post">Короткое описание</label>
                        <textarea name="short_description" cols="40" rows="5"
                                  class="form-control editor @error('description') is-invalid @enderror">
                        {{ old('short_description', isset($aboutBlock) ? $aboutBlock->short_description : '') }}
                </textarea>
                        @error('short_description')
                        <span id="short_description-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="signature">Подпись</label>
                        @isset($aboutBlock->signature)
                            <img src="{{$aboutBlock->signature}}" width="200" height="200" alt="">
                        @endif
                        <input type="file" name="signature" id="signature"
                               class="form-control @error('signature') is-invalid @enderror"
                               value="{{ old('signature', isset($aboutBlock) ? $aboutBlock->signature : '') }}"
                               accept="image/*">
                        @error('signature')
                        <span id="signature-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="CEO_name">Имя CEO</label>
                        <input type="text" name="CEO_name" id="CEO_name"
                               class="form-control @error('CEO_name') is-invalid @enderror"
                               value="{{ old('CEO_name', isset($aboutBlock) ? $aboutBlock->CEO_name : '') }}">
                        @error('CEO_name')
                        <span id="CEO_name-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                @elseif($aboutBlock->key=='summary')
                    <div class="form-group">
                        <label for="first_quarter_num">Значение первой четверти</label>
                        <input type="text" name="first_quarter_num" id="first_quarter_num"
                               class="form-control @error('first_quarter_num') is-invalid @enderror"
                               value="{{ old('first_quarter_num', isset($aboutBlock) ? $aboutBlock->first_quarter_num : '') }}">
                        @error('first_quarter_num')
                        <span id="first_quarter_num-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="first_quarter_title">Заголовок первой четверти</label>
                        <input type="text" name="first_quarter_title" id="first_quarter_title"
                               class="form-control @error('first_quarter_title') is-invalid @enderror"
                               value="{{ old('first_quarter_title', isset($aboutBlock) ? $aboutBlock->first_quarter_title : '') }}">
                        @error('first_quarter_title')
                        <span id="first_quarter_title-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="second_quarter_num">Значение второй четверти</label>
                        <input type="text" name="second_quarter_num" id="second_quarter_num"
                               class="form-control @error('second_quarter_num') is-invalid @enderror"
                               value="{{ old('second_quarter_num', isset($aboutBlock) ? $aboutBlock->second_quarter_num : '') }}">
                        @error('second_quarter_num')
                        <span id="second_quarter_num-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="second_quarter_title">Заголовок второй четверти</label>
                        <input type="text" name="second_quarter_title" id="second_quarter_title"
                               class="form-control @error('second_quarter_title') is-invalid @enderror"
                               value="{{ old('second_quarter_title', isset($aboutBlock) ? $aboutBlock->second_quarter_title : '') }}">
                        @error('second_quarter_title')
                        <span id="second_quarter_title-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="third_quarter_num">Значение третьей четверти</label>
                        <input type="text" name="third_quarter_num" id="third_quarter_num"
                               class="form-control @error('third_quarter_num') is-invalid @enderror"
                               value="{{ old('third_quarter_num', isset($aboutBlock) ? $aboutBlock->third_quarter_num : '') }}">
                        @error('third_quarter_num')
                        <span id="third_quarter_num-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="third_quarter_title">Заголовок третьей четверти</label>
                        <input type="text" name="third_quarter_title" id="third_quarter_title"
                               class="form-control @error('third_quarter_title') is-invalid @enderror"
                               value="{{ old('third_quarter_title', isset($aboutBlock) ? $aboutBlock->third_quarter_title : '') }}">
                        @error('third_quarter_title')
                        <span id="third_quarter_title-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fourth_quarter_num">Значение четвертой четверти</label>
                        <input type="text" name="fourth_quarter_num" id="fourth_quarter_num"
                               class="form-control @error('fourth_quarter_num') is-invalid @enderror"
                               value="{{ old('fourth_quarter_num', isset($aboutBlock) ? $aboutBlock->fourth_quarter_num : '') }}">
                        @error('fourth_quarter_num')
                        <span id="fourth_quarter_num-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="fourth_quarter_title">Заголовок четвертой четверти</label>
                        <input type="text" name="fourth_quarter_title" id="fourth_quarter_title"
                               class="form-control @error('fourth_quarter_title') is-invalid @enderror"
                               value="{{ old('fourth_quarter_title', isset($aboutBlock) ? $aboutBlock->fourth_quarter_title : '') }}">
                        @error('fourth_quarter_title')
                        <span id="fourth_quarter_title-error" class="error invalid-feedback">{{ $message }}</span>
                        @enderror
                    </div>

                @endif
            @endif

        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-success">{{ isset($aboutBlock) ? 'Обновить' : 'Создать' }}</button>
        </div>
    </form>
</div>
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/34.2.0/classic/ckeditor.js"></script>
    <script>
        $(document).ready(function () {
            let editorArr = $('.editor');
            $(editorArr).each(function () {
                ClassicEditor
                    .create(this)
                    .then(editor => {
                        console.log(editor);
                    })
                    .catch(error => {
                        console.error(error);
                    });
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
