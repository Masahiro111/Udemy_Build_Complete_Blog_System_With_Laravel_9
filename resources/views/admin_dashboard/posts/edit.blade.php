@extends("admin_dashboard.layouts.app")

@section("style")

<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet" />
<link href="{{ asset('admin_dashboard_assets/plugins/select2/css/select2-bootstrap4.css') }}" rel="stylesheet" />

@endsection

@section("wrapper")
<!--start page wrapper -->
<div class="page-wrapper">
    <div class="page-content">
        <!--breadcrumb-->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Posts</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item"><a href="javascript:;"><i class="bx bx-home-alt"></i></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Posts</li>
                    </ol>
                </nav>
            </div>
        </div>
        <!--end breadcrumb-->

        <div class="card">
            <div class="card-body p-4">
                <h5 class="card-title">Edit Post: {{ $post->title }}</h5>
                <hr />

                <div class="mt-4">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="border border-3 p-4 rounded">
                                <form
                                      action="{{ route('admin.posts.update', $post) }}"
                                      method='post'
                                      enctype='multipart/form-data'>
                                    @csrf
                                    @method('PUT')

                                    <div class="form-body ">

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Post Title</label>
                                            <input type="text" value='{{ old("title", $post->title) }}' name='title' required class="form-control" id="inputProductTitle">

                                            @error('title')
                                            <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Post Slug</label>
                                            <input type="text" value='{{ old("slug", $post->slug) }}' class="form-control" required name='slug' id="inputProductTitle">

                                            @error('slug')
                                            <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post Excerpt</label>
                                            <textarea required class="form-control" name='excerpt' id="inputProductDescription" rows="3">{{ old("excerpt", $post->excerpt) }}</textarea>

                                            @error('excerpt')
                                            <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductTitle" class="form-label">Post Category</label>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="rounded">
                                                        <div class="mb-3">
                                                            <select required name='category_id' class="single-select">
                                                                @foreach($categories as $key => $category)
                                                                <option {{ $post->category_id === $key ? 'selected' : '' }} value="{{ $key }}">{{ $category }}</option>
                                                                @endforeach
                                                            </select>

                                                            @error('category_id')
                                                            <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <div class='row'>

                                                <div class='col-md-8'>


                                                    <div class="card">
                                                        <div class="card-body">
                                                            <label for="inputProductDescription" class="form-label">Post Thumbnail</label>
                                                            <input id='thumbnail' name='thumbnail' id="file" type="file">

                                                            @error('thumbnail')
                                                            <p class='text-danger'>{{ $message }}</p>
                                                            @enderror

                                                        </div>
                                                    </div>

                                                </div>

                                                <div class='col-md-4 text-center'>
                                                    <img style='width: 100%' src="/storage/{{ $post->image ? $post->image->path : 'placeholders/thumbnail_placeholder.svg' }}" class='img-responsive' alt="Post Thumbnail">
                                                </div>

                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="inputProductDescription" class="form-label">Post Content</label>
                                            <textarea name='body' id='post_content' class="form-control" id="inputProductDescription" rows="3">{{ old("body", str_replace('../../../', '/', $post->body) ) }}</textarea>

                                            @error('body')
                                            <p class='text-danger'>{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <button class='btn btn-primary' type='submit'>Update Post</button>
                                </form>

                                <form action="{{ route('admin.posts.destroy', $post) }}">
                                    @csrf
                                    @method('DELETE')

                                    <button type='submit' class='btn btn-danger'>Delete Post</button>
                                </form>

                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>


</div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/Drag-And-Drop/dist/imageuploadify.min.js') }}"></script>
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
        // $('#image-uploadify').imageuploadify();
        
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        $('.multiple-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });
        setTimeout(() => {
            $(".general-message").fadeOut();
        }, 5000);
    });
</script>
@endsection