@extends('layouts.app')

@section('additional-css')
    <link rel="stylesheet" href="{{ asset('css/admin-page.css') }}">
@endsection

@section('title', 'Edit Product')

@section('main')
    <div class="container my-5 information">
        <div class="profile-wrapper">
            <div class="row">
                <div class="tab-content active">
                    <h2 class="mb-4">Edit Product</h2>
                    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="productTitle" class="form-label">Product Title</label>
                            <input type="text" name="productTitle" class="form-control" id="productTitle" value="{{ $product->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="productDescription" class="form-label">Description</label>
                            <textarea name="productDescription" class="form-control" id="productDescription" rows="3" required>{{ $product->description }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Current Images</label>

                            @if($product->images->isEmpty())
                                <p class="text-muted fst-italic">No images uploaded for this product.</p>
                            @else
                                <div class="d-flex gap-3 flex-wrap">
                                    @foreach($product->images as $image)
                                        @php
                                            $base64 = $image->image_data;
                                            $imageData = base64_decode($base64);
                                            $mimeType = finfo_buffer(finfo_open(FILEINFO_MIME_TYPE), $imageData);
                                        @endphp
                                        <div class="position-relative text-center image-box">
                                            <img src="data:{{ $mimeType }};base64,{{ $base64 }}" class="img-thumbnail" style="width: 150px; height: 150px; object-fit: cover;">
                                            <div class="form-check mt-2">
                                                <input type="checkbox" class="form-check-input custom-checkbox" name="delete_images[]" value="{{ $image->id }}" id="delete_{{ $image->id }}">
                                                <label class="form-check-label" for="delete_{{ $image->id }}">Delete</label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>



                        <div class="mb-3">
                            <label class="form-label">Upload New Images</label>
                            <div class="d-flex gap-3 flex-wrap" id="imagePreviewContainer"></div>
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
                                    <option value="{{ $ingredient->name }}"
                                        {{ $product->ingredients->contains('name', $ingredient->name) ? 'selected' : '' }}>
                                        {{ $ingredient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="productPrice" class="form-label">Price</label>
                            <div class="input-group" style="width: 200px;">
                                <span class="input-group-text">$</span>
                                <input type="number"
                                       name="productPrice"
                                       class="form-control"
                                       id="productPrice"
                                       value="{{ old('productPrice', $product->price) }}"
                                       step="0.5"
                                       min="1"
                                       required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="productCategory" class="form-label">Category</label>
                            <select class="form-select" id="productCategory" name="productCategory[]" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->name }}"
                                        {{ $product->categories->contains('name', $category->name) ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn-update">Update Product</button>
                            <a href="{{ route('admin') }}" class="btn-cancel">Cancel</a>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelector('.upload-btn').addEventListener('click', () => {
                document.getElementById('imageUpload').click();
            });

            document.getElementById('imageUpload').addEventListener('change', function (event) {
                const container = document.getElementById('imagePreviewContainer');
                container.innerHTML = '';

                const files = event.target.files;

                Array.from(files).forEach(file => {
                    if (file && file.type.startsWith('image/')) {
                        const reader = new FileReader();

                        reader.onload = function (e) {
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail';
                            img.style.maxWidth = '150px';
                            img.style.maxHeight = '150px';
                            img.style.marginRight = '10px';
                            container.appendChild(img);
                        };

                        reader.readAsDataURL(file);
                    }
                });
            });
            const input = document.getElementById("productPrice");

            input.addEventListener("keydown", function (e) {
                if (
                    ["e", "E", "+", "-"].includes(e.key) ||
                    (e.key.length === 1 && !e.key.match(/[0-9\.]/)) || // Дозволяємо тільки цифри і точку
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
        });
    </script>
@endsection
