@extends('layouts.admin')

@section('title', 'Add New Product')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">Add New Product</h1>
        <p class="text-muted mb-0">Create a new product for your burger shop</p>
    </div>
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>Back to Products
    </a>
</div>

<div class="admin-card">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row g-4">
                <div class="col-md-6">
                    <label for="name" class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                           id="name" name="name" value="{{ old('name') }}" 
                           placeholder="Enter product name" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="category" class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                    <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>                        <option value="" selected disabled>Select Category</option>
                        <option value="burger" {{ old('category') == 'burger' ? 'selected' : '' }}>Burger</option>
                        <option value="chicken" {{ old('category') == 'chicken' ? 'selected' : '' }}>Chicken</option>
                        <option value="sides" {{ old('category') == 'sides' ? 'selected' : '' }}>Sides</option>
                        <option value="beverage" {{ old('category') == 'beverage' ? 'selected' : '' }}>Beverage</option>
                    </select>
                    @error('category')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="price" class="form-label fw-semibold">Price <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price') }}" 
                               step="0.01" min="0" placeholder="0.00" required>
                    </div>
                    @error('price')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-md-6">
                    <label for="available" class="form-label fw-semibold">Availability</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" role="switch" 
                               id="available" name="available" value="1" 
                               {{ old('available', '1') == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="available">Available for Order</label>
                    </div>
                </div>
                
                <div class="col-12">
                    <label for="description" class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                    <textarea class="form-control @error('description') is-invalid @enderror" 
                              id="description" name="description" rows="4" 
                              placeholder="Describe your product..." required>{{ old('description') }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="col-12">
                    <label for="image" class="form-label fw-semibold">Product Image <span class="text-danger">*</span></label>
                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                           id="image" name="image" accept="image/*" required>
                    <div class="form-text">Upload a square image for best results (recommended: 500x500px)</div>
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    
                    <div class="mt-3" id="image-preview-container" style="display: none;">
                        <label class="form-label">Image Preview</label>
                        <div>
                            <img id="image-preview" src="#" alt="Preview" 
                                 class="img-thumbnail rounded" style="max-height: 200px;">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-top pt-4 mt-4">
                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i>Reset Form
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Product
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            
            reader.onload = function(e) {
                document.getElementById('image-preview').src = e.target.result;
                document.getElementById('image-preview-container').style.display = 'block';
            };
            
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
@endsection
