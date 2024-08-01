@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <h5>Advertisement Edit</h5>
                <div class="float-end">
                    <a href="{{ route('advertisements.index') }}" class="btn btn-primary btn-sm">&larr; Back</a>
                </div>
            </div>
            <div class="card-body">
                <form action="{{ route('advertisements.update', $advertisement->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method("PUT")
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="title" class="col-md-12 col-form-label text-start">Title</label>
                                    <div class="col-md-12">
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ $advertisement->title }}">
                                        @if ($errors->has('title'))
                                        <span class="text-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                            </div>

                            <div class="col-sm-6">
                                <label for="date" class="col-md-12 col-form-label text-start">Date</label>
                                <div class="col-md-12">
                                <input type="date" class="form-control @error('date') is-invalid @enderror" id="date" name="date" value="{{ $advertisement->date }}">
                                @if ($errors->has('date'))
                                <span class="text-danger">{{ $errors->first('date') }}</span>
                                @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group col-md-6">
                        <label class="form-label">Upload Image</label>
                        <input type="file" name="upload" accept="image/*" onchange="previewFeatureImage(this)">
                        <img id="featureImagePreview" src="{{ $advertisement->image_url }}" alt="Feature Image" class="img-thumbnail" style="max-width: 100%">
                    </div>
                    <div class="form-group">
                        <input type="checkbox" class="form-check-input" id="popupcheck" name="ispopup" value="1"  {{ $advertisement->ispopup == 1 ? 'checked' : '0' }}>
                        <label class="form-label">Popup Advertisement</label>
                            <div class="form-check" id="closecheck">
                                <input type="checkbox" class="form-check-input" id="closepopup" name="isclosepopup" value="1" {{ $advertisement->isclosepopup == 1 ? 'checked' : '0' }}>
                                <label class="form-check-label" for="closepopup">Close Popup</label>
                            </div>
                    </div>


                    <div id="adTimeForm" style="display: none;">
                        <div class="form-group">
                            <label class="form-label">Advertising Time</label>
                            <input type="text" class="form-control" name="display_time" value="{{ $advertisement->display_time }}">
                        </div>
                    </div>
                    <div class="form-group" id="category">
                        <label class="form-label">Advertisement Category</label>
                        <select class="form-select" name="category">
                            <option value="none"></option>
                            <option value="sidebar" {{ $advertisement->category === 'sidebar' ? 'selected' : '' }}>Side Bar</option>
                            <option value="navbar" {{ $advertisement->category === 'navbar' ? 'selected' : '' }}>Nav Bar</option>
                        </select>
                    </div>
                    <div class="mb-3 row">
                        <label for="content" class="col-md-12 col-form-label text-start">Content</label>
                        <div class="col-md-12">
                            <input type="text" class="form-control @error('content') is-invalid @enderror" id="content" name="content" value="{{ $advertisement->content }}">
                            @if ($errors->has('content'))
                            <span class="text-danger">{{ $errors->first('content') }}</span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="author" class="col-md-12 col-form-label text-start">Author Name</label>
                        
                                <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author" value="{{ $advertisement->author }}">
                                @if ($errors->has('author'))
                                <span class="text-danger">{{ $errors->first('author') }}</span>
                                @endif
                        
                            </div>

                            <div class="col-sm-6 ">
                                <label class="form-label align-email">Contact Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ $advertisement->email }}">
                                @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-sm-6">
                                <label class="form-label">Contact Number</label>
                                <input type="tel" class="form-control @error('mobile') is-invalid @enderror" id="mobile" name="mobile" value="{{ $advertisement->mobile }}">
                                @if ($errors->has('mobile'))
                                <span class="text-danger">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Contact Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" id="address" name="address">{{ $advertisement->address }}</textarea>
                                @if ($errors->has('address'))
                                <span class="text-danger">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary me-2">Update Advertisement</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" href="{{ asset('css/style.css') }}">
<script>
$(document).ready(function () {
    toggleAdTimeForm();
    toggleCategory();
    $('#closepopup').change(function () {
        toggleAdTimeForm();
    });
    $('#popupcheck').change(function () {
        toggleCategory();
    });
function toggleAdTimeForm() {
    if ($('#closepopup').prop('checked')) {
        $('#adTimeForm').hide();
    } else {
        $('#adTimeForm').show();
    }
}
function toggleCategory() {
    if ($('#popupcheck').prop('checked')) {
        $('#closecheck').show();
        $('#category').hide();
    } else {
        $('#closepopup').prop('checked', false);
        $('#closecheck').hide();
        $('#adTimeForm').hide();
        $('#category').show();
    }
}
});
</script>
<script>
   
   function previewFeatureImage(input) {
       var preview = document.getElementById("featureImagePreview");
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
@endsection
