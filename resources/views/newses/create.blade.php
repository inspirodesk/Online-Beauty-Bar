@extends('layouts.app')

@section('content')
<form action="{{ route('newses.store') }}" method="post" enctype="multipart/form-data">
            @csrf
<div class="row">
    <div class="col-sm-9">
      <!-- Basic Inputs -->
        <div class="card">
            <div class="card-header">
            <h5>Create New News</h5>
            </div>

                <div class="card-body">
                    <div class="form-group">
                        <label class="form-label">News Title</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                            <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label" >Content</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="classic-editor"  name="description">{{ old('description') }}</textarea>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary me-2">Save</button>
                        <button type="reset" class="btn btn-primary-outline">Reset</button>
                    </div>
                </div>
        </div>
    </div>
    <!-- Second Col Start Area Col-4 -->
    <div class="col-3">
        <!-- News Status Area -->
        <div class="card">
            <div class="card-body" id="status">
                <p style="margin-bottom:10px"><b>Status</b></p>
                <select class="form-select" id="validationTooltip04" required="" name="status">
                <option selected="" value="choose">Choose...</option>
                <option selected="" value="draft">Draft</option>
                <option selected="" value="publish">Publish</option>
                </select>
            </div>
        </div>

        <!-- News Category Area -->
        <div class="card">
                <div class="card-body">
                    <p style="margin-bottom:10px"><b>Categories</b></p>
                    <div class = "categorycheck">
                    @foreach ($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="categoryCheckbox{{ $loop->index }}" name="categorySelection[]" value="{{ $category->id }}">
                            <label class="form-check-label" for="categoryCheckbox{{ $loop->index }}">{{ $category->name }}</label>
                        </div>
                    @endforeach
                    </div>
                    <!-- Add New Site -->
                    <div id="addNewCategoryText" style="cursor: pointer; color: blue; text-decoration: underline;">Add New Category</div>

                    <div id="addNewCategoryContainer" style="display: none;">
                        <div class="form-group mt-3">
                            <label for="newCategory">Add New Category:</label>
                            <input type="text" class="form-control col-md-12" id="newCategory" name="newCategory">
                        </div>
                        <button type="button" class="btn btn-primary" onclick="addNewCategoryCheckbox('Category')">Save</button>
                    </div>
                </div>
        </div>



        <!-- Site Selection Area -->
        <div class="card">
            <div class="card-body">
                <p style="margin-bottom:10px"><b>Sites</b></p>
                    <div class = "sitecheck">
                    @foreach ($sites as $site)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="siteCheckbox{{ $loop->index }}" name="siteSelection[]" value="{{ $site->id }}">
                            <label class="form-check-label" for="siteCheckbox{{ $loop->index }}">{{ $site->name }}</label>
                        </div>
                    @endforeach
                    </div>
                    <!-- Add New Site -->
                <div id="addNewSiteText" style="cursor: pointer; color: blue; text-decoration: underline;">Add New Site</div>

                <div id="addNewSiteContainer" style="display: none;">
                    <div class="form-group mt-3">
                        <label for="newSite">Add New Site:</label>
                        <input type="text" class="form-control col-md-12" id="newSite" name="newSite">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="addNewCheckbox('site')">Save</button>
                </div>
            </div>
        </div>

        <!-- Featured Image -->
        <div class="card">
                <div class="card-body">
                    <div class="mb-3 row card-body2">
                        <label class="form-label"><b>Feature Image</b></label>
                        <input type="file" name="upload" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                        <img id="featureImagePreview" src="#" alt="Feature Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
                    </div>
                </div>
        </div>

</div>
</form>

<script>
    function previewImage(input, previewId) {
      var preview = document.getElementById(previewId);
      var file = input.files[0];
      var reader = new FileReader();

      reader.onload = function (e) {
        preview.src = e.target.result;
        preview.style.display = 'block';
      };

      if (file) {
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

            document.querySelector('.sitecheck').appendChild(newCheckbox);
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

                document.querySelector('.categorycheck').appendChild(newCheckbox);
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
