@extends('layouts.app')
{{--@section('breadcrumbs', Breadcrumbs::render('admin.footer.index'))--}}
@section('content')
    <section class="content">
        <div class="card">
            <form
                action="@isset($footer) {{ route('admin.footer.update', $footer) }} @else {{ route('admin.footer.store') }} @endif"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @isset($footer)
                    @method('PUT')
                @endisset
                <div class="card-body">
                    @isset($footer)
                        <div class="form-group">
                            <label for="policy">Политика обработки персональных данных</label>
                            <input type="text" name="policy" id="policy"
                                   class="form-control @error('policy') is-invalid @enderror"
                                   value="{{ old('policy', $footer->policy) }}">
                            @error('policy')
                            <span id="policy-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="phone">Телефон</label>
                            <input type="text" name="phone" id="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone', $footer->phone) }}">
                            @error('phone')
                            <span id="phone-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <h3>Соц. сети</h3>
                        <div id="list">
                            @isset($footer->socials)
                                @foreach($footer->socials as $social)
                                    <div class="list-social social_{{$social->id}}">
                                        <div class="delete-point">
                                            <a href="{{ route('admin.social.delete', $social) }}"
                                               class="delete-social-btn btn btn-danger">
                                                <i class="fa fa-trash"></i>
                                                Удалить</a>
                                        </div>
                                        <div class="form-group">
                                            <label for="name_old_{{$social->id}}">Наименование</label>
                                            <input type="text" name="name_old_{{$social->id}}"
                                                   id="name_old_{{$social->id}}"
                                                   class="form-control"
                                                   value="{{ old('name', isset($social) ? $social->name : '') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="link_old_{{$social->id}}">Ссылка</label>
                                            <input type="text" name="link_old_{{$social->id}}"
                                                   id="link_old_{{$social->id}}"
                                                   class="form-control"
                                                   value="{{ old('link', isset($social) ? $social->link : '') }}">
                                        </div>
                                        <div class="form-group">
                                            <label for="picture_old_{{$social->id}}">Картинка</label>
                                            @isset($social->picture)
                                                <img src="{{$social->picture}}" width="200" height="200" alt="">
                                            @endif
                                            <input type="file" name="picture_old_{{$social->id}}"
                                                   id="picture_old_{{$social->id}}"
                                                   class="form-control "
                                                   value="{{ old('picture', isset($social) ? $social->picture : '') }}"
                                                   accept="image/*">
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-info add-social">+</button>
                    @else
                        <div>Данные футера не найдены</div>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success confirm">{{'Обновить' }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
