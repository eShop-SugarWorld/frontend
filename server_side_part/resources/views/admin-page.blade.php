@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/admin-page.css') }}">
@endsection

@section('title', 'Admin page')

@section('main')
    <div class="container my-5 information">
        <div class="profile-wrapper">
            <div class="row">
                <div class="col-md-4 col-lg-3">
                    <div class="sidebar">
                        <h3 class="mb-4">Products settings</h3>
                        <div class="nav flex-column">
                            <button class="nav-link profile-tab active" onclick="showTab('product-list')">Product list</button>
                            <button class="nav-link profile-tab" onclick="showTab('add-product')">Add product</button>
                        </div>
                    </div>
                </div>

                <div class="col-md-8 col-lg-9">
                    <div class="tab-content active" id="product-list">
                        <h2 class="mb-4">Product List</h2>

{{--                        <div class="d-flex justify-content-between mb-4">--}}
{{--                            <div class="search-container">--}}
{{--                                <input--}}
{{--                                    type="text"--}}
{{--                                    class="form-control"--}}
{{--                                    id="productSearchInput"--}}
{{--                                    placeholder="Search products..."--}}
{{--                                    style="width: 250px;"--}}
{{--                                >--}}
{{--                            </div>--}}
{{--                        </div>--}}
                        <form method="GET" action="{{ route('admin') }}" class="d-flex mb-4" style="max-width: 400px;">
                            <div class="search-container">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control me-2"
                                    placeholder="Search products..."
                                    value="{{ request('search') }}"
                                >
                            </div>
                            <button type="submit" class="btn-custom">Search</button>
                        </form>


                        <div class="row">
                            @foreach($products as $product)
                                @php
                                    $image = $product->images->first();
                                    $base64 = null;
                                    $mimeType = "image/jpg";
                                    if ($image && $image->image_data) {
                                        $base64 = $image->image_data;

                                        $imageData = base64_decode($base64);
                                        $finfo = finfo_open(FILEINFO_MIME_TYPE);
                                        $mimeType = finfo_buffer($finfo, $imageData);
                                        finfo_close($finfo);
                                    }
                                @endphp
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card">
                                        @if($base64 ?? false)
                                            <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="card-img-top" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ $image ?? asset('images/placeholder.jpg') }}" class="card-img-top" alt="{{ $product->name ?? 'No image available' }}">
                                        @endif
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $product->name }}</h5>
                                            <p class="card-text clamp-3 " style="min-height: 70px">{{ Str::limit($product->description, 100) }}</p>
                                            <div class="d-flex justify-content-between">
                                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-edit">Edit</a>
                                                {{--                                                <button class="btn btn-edit">Edit</button>--}}
                                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-delete">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="tab-content" id="add-product">
                        <h2 class="mb-4">Add Product</h2>
                        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label for="productTitle" class="form-label">Product Title</label>
                                <input type="text" name="productTitle" class="form-control" id="productTitle" placeholder="Enter product title">
                            </div>
                            <div class="mb-3">
                                <label for="productDescription" class="form-label">Description</label>
                                <textarea name="productDescription" class="form-control" id="productDescription" rows="3" placeholder="Enter product description"></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Images</label>
                                <div class="d-flex gap-3 flex-wrap" id="imagePreviewContainer">

                                </div>
                                <div class="mt-2">
                                    <div class="upload-wrapper">
                                        <button type="button" class="upload-btn">📤 Upload Images</button>
                                        <input type="file" name="images[]" id="imageUpload" class="upload-input" accept="image/*" multiple>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Ingredients</label>
                                <select class="form-select" name="ingredients[]" multiple>
                                    @foreach($ingredients as $ingredient)
                                        <option value="{{ $ingredient->name }}">{{ $ingredient->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="productPrice" class="form-label">Price</label>
                                <div class="input-group" style="width: 200px;">
                                    <span class="input-group-text">$</span>
                                    <input
                                        type="number"
                                        name="productPrice"
                                        class="form-control"
                                        id="productPrice"
                                        value="1"
                                        min="1"
                                        step="any"
                                        required
                                    >
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="productCategory" class="form-label">Category</label>
                                <select class="form-select" id="productCategory" name="productCategory[]" multiple>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->name }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn btn-custom">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => {
                tab.classList.remove('active');
            });

            document.querySelectorAll('.profile-tab').forEach(tab => {
                tab.classList.remove('active');
            });

            document.getElementById(tabId).classList.add('active');

            document.querySelector(`button[onclick="showTab('${tabId}')"]`).classList.add('active');
        }
        document.addEventListener('DOMContentLoaded', () => {
            const imageUpload = document.getElementById('imageUpload');
            const container = document.getElementById('imagePreviewContainer');
            let selectedFiles = [];

            imageUpload.addEventListener('change', function (event) {
                container.innerHTML = '';
                selectedFiles = Array.from(event.target.files);

                selectedFiles.forEach((file, index) => {
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const imageWrapper = document.createElement('div');
                            imageWrapper.style.position = 'relative';
                            imageWrapper.style.display = 'inline-block';

                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail';
                            img.style.maxWidth = '150px';
                            img.style.maxHeight = '150px';
                            img.style.marginRight = '10px';

                            const deleteBtn = document.createElement('button');
                            deleteBtn.textContent = '✖';
                            deleteBtn.style.position = 'absolute';
                            deleteBtn.style.top = '5px';
                            deleteBtn.style.right = '5px';
                            deleteBtn.style.background = '#F3A2BE';
                            deleteBtn.style.border = 'none';
                            deleteBtn.style.borderRadius = '50%';
                            deleteBtn.style.color = '#fff';
                            deleteBtn.style.width = '24px';
                            deleteBtn.style.height = '24px';
                            deleteBtn.style.cursor = 'pointer';

                            deleteBtn.addEventListener('click', () => {
                                selectedFiles.splice(index, 1);
                                updateImagePreview();
                            });

                            imageWrapper.appendChild(img);
                            imageWrapper.appendChild(deleteBtn);
                            container.appendChild(imageWrapper);
                        };

                        reader.readAsDataURL(file);
                    }
                });
            });

            function updateImagePreview() {
                container.innerHTML = '';
                selectedFiles.forEach((file, index) => {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        const imageWrapper = document.createElement('div');
                        imageWrapper.style.position = 'relative';
                        imageWrapper.style.display = 'inline-block';

                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.className = 'img-thumbnail';
                        img.style.maxWidth = '150px';
                        img.style.maxHeight = '150px';
                        img.style.marginRight = '10px';

                        const deleteBtn = document.createElement('button');
                        deleteBtn.textContent = '✖';
                        deleteBtn.style.position = 'absolute';
                        deleteBtn.style.top = '5px';
                        deleteBtn.style.right = '5px';
                        deleteBtn.style.background = '#F3A2BE';
                        deleteBtn.style.border = 'none';
                        deleteBtn.style.borderRadius = '50%';
                        deleteBtn.style.color = '#fff';
                        deleteBtn.style.width = '24px';
                        deleteBtn.style.height = '24px';
                        deleteBtn.style.cursor = 'pointer';

                        deleteBtn.addEventListener('click', () => {
                            selectedFiles.splice(index, 1);
                            updateImagePreview();
                        });

                        imageWrapper.appendChild(img);
                        imageWrapper.appendChild(deleteBtn);
                        container.appendChild(imageWrapper);
                    };

                    reader.readAsDataURL(file);
                });

                const dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => dataTransfer.items.add(file));
                imageUpload.files = dataTransfer.files;
            }
        });

        const input = document.getElementById("productPrice");

        input.addEventListener("keydown", function (e) {

            if (
                ["e", "E", "+", "-"].includes(e.key) ||
                (e.key.length === 1 && !e.key.match(/[0-9\.]/)) ||
                (e.key === "." && input.value.includes("."))
            ) {
                e.preventDefault();
            }
        });

        input.addEventListener("input", function () {
            if (this.value < 1) {
                this.value = 1;
            }
        });

    </script>

@endsection
