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
                <h5 class="card-title">Add New Post</h5>
                <hr />

                <form action="{{ route('admin.posts.store') }}" method='post' enctype='multipart/form-data'>
                    @csrf

                    <div class="form-body mt-4">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="border border-3 p-4 rounded">
                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Title</label>
                                        <input type="text" value='{{ old("title") }}' name='title' required class="form-control" id="inputProductTitle">

                                        @error('title')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductTitle" class="form-label">Post Slug</label>
                                        <input type="text" value='{{ old("slug") }}' class="form-control" required name='slug' id="inputProductTitle">

                                        @error('slug')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Excerpt</label>
                                        <textarea required class="form-control" name='excerpt' id="inputProductDescription" rows="3">{{ old("excerpt") }}</textarea>

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
                                                            <option value="{{ $key }}">{{ $category }}</option>
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
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="inputProductDescription" class="form-label">Post Thumbnail</label>
                                                <input id='thumbnail' required name='thumbnail' id="file" type="file">

                                                @error('thumbnail')
                                                <p class='text-danger'>{{ $message }}</p>
                                                @enderror

                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="inputProductDescription" class="form-label">Post Content</label>
                                        <textarea name='body' id='post_content' class="form-control" id="inputProductDescription" rows="3">{{ old("body") }}</textarea>

                                        @error('body')
                                        <p class='text-danger'>{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <button class='btn btn-primary' type='submit'>Add Post</button>

                                </div>
                            </div>

                        </div>
                    </div>
                </form>

            </div>
        </div>


    </div>
</div>
<!--end page wrapper -->
@endsection

@section("script")
<script src="{{ asset('admin_dashboard_assets/plugins/select2/js/select2.min.js') }}"></script>

<script>
    $(document).ready(function () {
        
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