@extends('layouts.app')
@section('breadcrumbs', Breadcrumbs::render('admin.main.index'))
@section('content')
    <section class="content">
        <div class="card">
            <form
                action="{{ route('admin.main.update', $main) }}"
                method="POST"
                enctype="multipart/form-data">
                @csrf
                @isset($main)
                    @method('PUT')
                @endisset
                <div class="card-body">
                    @isset($main)
                        <div class="form-group">
                            <label for="desktop_video">Десктоп видео</label>
                            <video width="400" height="300" controls="controls">
                                <source src="{{$main->desktop_video}}">
                            </video>
                            <input type="file" name="desktop_video" id="desktop_video"
                                   class="form-control @error('desktop_video') is-invalid @enderror" accept="video/*">
                            @error('desktop_video')
                            <span id="desktop_video-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="mobile_video">Мобильное видео</label>
                            <video width="400" height="300" controls="controls">
                                <source src="{{$main->mobile_video}}">
                            </video>
                            <input type="file" name="mobile_video" id="mobile_video"
                                   class="form-control @error('mobile_video') is-invalid @enderror" accept="video/*">
                            @error('mobile_video')
                            <span id="mobile_video-error" class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    @else
                        <div>Видео не найдены</div>
                    @endif
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success confirm">{{'Обновить' }}</button>
                </div>
            </form>
        </div>
    </section>
@endsection
