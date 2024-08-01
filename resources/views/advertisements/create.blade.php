@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <!-- Basic Inputs -->
        <div class="card">
            <div class="card-header">
                <h5>Create New Advertisement</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('advertisements.store') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}">
                                @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Date</label>
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ old('date') }}">
                                @if ($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Popup Advertisement</label><BR>
                                <div style="margin-left:30px">
                                    <input type="checkbox" class="form-check-input" id="closepopup" name="isclosepopup" value="1" >
                                    <label class="form-check-label" for="closepopup">Close Popup</label><BR>
                                    <input type="checkbox" class="form-check-input" id="popupcheck" name="ispopup" value="1" >
                                    <label class="form-label">Popup Advertisement</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group col-md-6">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="upload" accept="image/*" onchange="previewImage(this)">
                        <img id="featureImagePreview" src="#" alt="Feature Image Preview" style="max-width: 100%; max-height: 150px; display: none;">
                     </div>
                    <div id="adTimeForm" style="display: none;">
                        <div class="form-group">
                            <label class="form-label">Advertising Time</label>
                            <input type="text" class="form-control" name="display_time" value="{{ old('display_time') }}">
                        </div>
                    </div>
                    <div class="form-group" id="category" >
                        <label class="form-label">Advertisement Category</label>
                        <select class="form-select" name="category">
                            <option value="none" selected></option>
                            <option value="sidebar">Side Bar</option>
                            <option value="navbar">Nav Bar</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Content</label>
                        <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="{{ old('content') }}">
                        @if ($errors->has('content'))
                        <span class="text-danger">{{ $errors->first('content') }}</span>
                        @endif
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-4">
                                <label class="form-label">Author Name</label>
                                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ old('author') }}">
                                @if ($errors->has('author'))
                                <span class="text-danger">{{ $errors->first('author') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Contact Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-4">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ old('mobile') }}">
                                @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-12">
                                <label class="form-label">Contact Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}"></textarea>
                                @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary me-2">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        // Check the initial state of the checkbox
        toggleAdTimeForm();
        togglecategory();

        // Attach an event listener to the checkbox
        $('#closepopup').change(function () {
            toggleAdTimeForm();
        });
        $('#popupcheck').change(function () {
            togglecategory();
        });
        // Function to toggle the visibility of the additional form based on the checkbox state
        function toggleAdTimeForm() {
            if ($('#closepopup').prop('checked')) {
                $('#adTimeForm').hide();
            } else {
                $('#adTimeForm').show();
            }
        };
        function togglecategory(){
          if ($('#popupcheck').prop('checked')) {
                $('#closecheck').show();
                $('#category').hide();
            } else {
              $('#closecheck').hide();
                $('#category').show();
                $('#adTimeForm').hide();
            }
        }
    });
</script>
<script>
    function previewImage(input) {
      var preview = document.getElementById("featureImagePreview");
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
@endsection
