@extends('layouts.app')

@section('content')

<div class="row ">
    <div class="col-8">

        <div class="card">
            <div class="card-header">
                    <h5>News Edit</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('newses.update', $news->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="mb-3 row">
                        <label for="name" class="col-md-12 col-form-label text-start">Name</label>
                        <div class="col-md-12">
                          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ $news->name }}">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-md-12 col-form-label text-start">Description</label>
                        <div class="col-md-12">
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="classic-editor">{{ $news->description }}</textarea>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary me-2">Update News</button>
                        <button type="reset" class="btn btn-light">Reset</button>
                    </div>

            </div>
        </div>
    </div>

    <div class="col-4">
        <div class="card">
            <div class="card-body">
                <div class="form-group" id="status">
                    <label class="form-label"><b>Status</b></label>
                    <select class="form-select" name="status">
                        <option value="choose" {{ $news->status === 'choose' ? 'selected' : '' }}>Choose</option>
                        <option value="draft" {{ $news->status === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="publish" {{ $news->status === 'publish' ? 'selected' : '' }}>Publish</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="form-group card-body1" id="categories">
                    <label class="form-label"><b>Categories</b></label>
                    @foreach($allCategoryOptions as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categorySelection[]" value="{{ $category->id }}" {{ in_array($category->id, $selectedCategory->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    <div id="addNewCategoryText" style="cursor: pointer; color: blue; text-decoration: underline;">Add New Category</div>

                    <div id="addNewCategoryContainer" style="display: none;">
                        <div class="form-group mt-3">
                            <label for="newCategory">Add New Category:</label>
                            <input type="text" class="form-control col-md-12" id="newCategory" name="newCategory">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addNewCategoryCheckbox('Category')">Add</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3 row card-body2">
                    <label class="form-label"><b>Site Selection</b></label>
                    <div class="col-md-12">
                        <!-- Existing site selections -->
                        @foreach($allSiteSelectionOptions as $site)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="siteSelection[]" value="{{ $site->id }}" {{ in_array($site->id, $selectedSiteSelection->pluck('id')->toArray()) ? 'checked' : '' }}>
                            <label class="form-check-label">{{ $site->name }}</label>
                        </div>
                        @endforeach

                        <div id="addNewSiteText" style="cursor: pointer; color: blue; text-decoration: underline;magrin-top:10px">Add New Site</div>

                        <div id="addNewSiteContainer" style="display: none;">
                            <div class="form-group mt-3">
                                <label for="newSite">Add New Site:</label>
                                <input type="text" class="form-control col-md-12" id="newSite" name="newSite">
                            </div>
                            <button type="button" class="btn btn-primary" onclick="addNewCheckbox('site')">Add</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="mb-3 row card-body2">
                    <label class="form-label"><b>Feature Image</b></label>
                    <img id="featureImagePreview" src="{{ $news->news_image_url }}" alt="Feature Image" class="img-thumbnail" style="max-width: 80px;margin-left:10px;margin-bottom:10px">
                    <input type="file" name="upload" accept="image/*" onchange="previewFeatureImage(this,'featureImagePreview')">
                </div>


            </div>
        </div>
    </div>
</div>
<script>

   function previewFeatureImage(input,id) {
       var preview = document.getElementById(id);
       var file = input.files[0];

       if (file) {
           var reader = new FileReader();
           reader.onload = function (e) {
               preview.src = e.target.result;
           }
           reader.readAsDataURL(file);
       }
       }

   </script>
  <script>
    document.getElementById('addNewSiteText').addEventListener('click', function () {
        var container = document.getElementById('addNewSiteContainer');
        container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
    });

    function addNewCheckbox() {
    var newSiteValue = document.getElementById('newSite').value;

    if (newSiteValue.trim() !== '') {
        saveNewSite(newSiteValue, function (siteId) {
            var newCheckbox = document.createElement('div');
            newCheckbox.className = 'form-check';
            newCheckbox.innerHTML = `
                <input class="form-check-input" type="checkbox" name="siteSelection[]" value="${siteId}">
                <label class="form-check-label">${newSiteValue}</label>
            `;

            document.querySelector('.card-body2').appendChild(newCheckbox);
            document.getElementById('newSite').value = '';

            document.getElementById('addNewSiteContainer').style.display = 'none';
        });
    } else {
        alert('Please enter a valid site name.');
    }


        function saveNewSite(siteName, callback) {
    // Send an AJAX request to store the new site
    $.ajax({
        type: 'POST',
        url: '{{ route('sites.store') }}',
        data: {
            '_token': '{{ csrf_token() }}',
            'name': siteName,
        },
        success: function (data) {
            console.log('New site saved:', data.id);
            callback(data.id); // Pass the saved site ID to the callback function
        },
        error: function (error) {
            console.error('Error saving new site:', error);
        }
    });
}

}
</script>
<script>
    document.getElementById('addNewCategoryText').addEventListener('click', function () {
        var container = document.getElementById('addNewCategoryContainer');
        container.style.display = (container.style.display === 'none' || container.style.display === '') ? 'block' : 'none';
    });

    function addNewCategoryCheckbox() {
        var newCategoryValue = document.getElementById('newCategory').value;

        if (newCategoryValue.trim() !== '') {
            saveNewCategory(newCategoryValue, function (categoryId) {
                var newCheckbox = document.createElement('div');
                newCheckbox.className = 'form-check';
                newCheckbox.innerHTML = `
                    <input class="form-check-input" type="checkbox" name="categorySelection[]" value="${categoryId}">
                    <label class="form-check-label">${newCategoryValue}</label>
                `;

                document.querySelector('.card-body1').appendChild(newCheckbox);
                document.getElementById('newCategory').value = '';

                document.getElementById('addNewCategoryContainer').style.display = 'none';
            });
        } else {
            alert('Please enter a valid category name.');
        }

        function saveNewCategory(categoryName, callback) {
            // Send an AJAX request to store the new category
            $.ajax({
                type: 'POST',
                url: '{{ route('categories.store') }}',
                data: {
                    '_token': '{{ csrf_token() }}',
                    'name': categoryName,
                },
                success: function (data) {
                    console.log('New category saved:', data.id);
                    callback(data.id); // Pass the saved category ID to the callback function
                },
                error: function (error) {
                    console.error('Error saving new category:', error);
                }
            });
        }
    }
</script>

@endsection
