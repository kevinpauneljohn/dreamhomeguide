@extends('dashboard.layouts.app')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold mb-0">Upload Property Images</h3>
            <small class="text-muted">Property: {{ $property->title }}</small>
        </div>

        <button class="btn btn-light border px-4" onclick="window.history.back()">
            Back
        </button>

    </div>

    <div class="card card-default mb-3">
        <div class="card-body">
            <input type="hidden" name="property_id" value="{{ $property->id }}">
            <div id="actions" class="row">
                <div class="col-lg-6">
                    <div class="btn-group w-100">
                      <span class="btn btn-success col fileinput-button">
                        <i class="fas fa-plus"></i>
                        <span>Add files</span>
                      </span>
                        <button type="submit" class="btn btn-primary col start">
                            <i class="fas fa-upload"></i>
                            <span>Start upload</span>
                        </button>
                        <button type="reset" class="btn btn-warning col cancel">
                            <i class="fas fa-times-circle"></i>
                            <span>Cancel upload</span>
                        </button>
                    </div>
                </div>
                <div class="col-lg-6 d-flex align-items-center">
                    <div class="fileupload-process w-100">
                        <div id="total-progress" class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table table-striped files" id="previews">
                <div id="template" class="row mt-2">
                    <div class="col-auto">
                        <span class="preview"><img src="data:," alt="" data-dz-thumbnail /></span>
                    </div>
                    <div class="col d-flex align-items-center">
                        <p class="mb-0">
                            <span class="lead" data-dz-name></span>
                            (<span data-dz-size></span>)
                        </p>
                        <strong class="error text-danger" data-dz-errormessage></strong>
                    </div>
                    <div class="col-4 d-flex align-items-center">
                        <div class="progress progress-striped active w-100" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0">
                            <div class="progress-bar progress-bar-success" style="width:0%;" data-dz-uploadprogress></div>
                        </div>
                    </div>
                    <div class="col-auto d-flex align-items-center">
                        <div class="btn-group">
                            <button class="btn btn-primary start">
                                <i class="fas fa-upload"></i>
                                <span>Start</span>
                            </button>
                            <button data-dz-remove class="btn btn-warning cancel">
                                <i class="fas fa-times-circle"></i>
                                <span>Cancel</span>
                            </button>
                            <button data-dz-remove class="btn btn-danger delete">
                                <i class="fas fa-trash"></i>
                                <span>Delete</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="property-images-table" class="table table-striped table-hover w-100 border">
                <thead>
                <tr>
                    <th width="100px">Thumbnail</th>
                    <th>Name</th>
                    <th class="w-25">Title</th>
                    <th width="200px">Is Thumbnail</th>
                    <th width="80px">Action</th>
                </tr>
                </thead>
            </table>
        </div>
    </div>


    <!-- Modal -->
    <form class="edit-image-form">
        @csrf
        <div class="modal fade" id="edit-image-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Image Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img src="#" class="img-fluid w-100 border" alt="...">
                            </div>
                            <div class="col-md-6">
                                <div class="form-group title">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" class="form-control" id="title">
                                </div>
                                <div class="form-group mt-2 is_thumbnail">
                                    <label for="is_thumbnail">Is Thumbnail</label>
                                    <select name="is_thumbnail" id="is_thumbnail" class="form-control">
                                        <option value="0">No</option>
                                        <option value="1">Yes</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary save">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('scripts')
    @vite(['resources/js/dashboard/properties/property-gallery.js','resources/js/dashboard/properties/EditImageModal.js'])
@endpush
