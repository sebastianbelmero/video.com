@extends('layouts.admin')

@section('title', 'Videos')
@section('content')
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newVideoModal">
        Add New
    </button>

    <!-- New Modal -->
    <div class="modal fade" id="newVideoModal" tabindex="-1" aria-labelledby="newVideoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="add-new-video" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="newVideoModalLabel">Add Videos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" placeholder="Title" name="title">
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" placeholder="Description"
                            name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <select class="form-control" id="category" name="idCategory">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="url" class="form-label">Video</label>
                        <input type="text" class="form-control" id="url" name="url">
                    </div>
                    <div class="mb-3">
                        <label for="cover" class="form-label">Cover</label>
                        <input type="text" class="form-control" id="cover" name="cover">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Cover</th>
                <th>Title</th>
                <th>Description</th>
                <th>Category</th>
                <th>Url</th>
                <th>Action</th>
            </tr>
        <tbody id="video-table">
    </table>
    </thead>
@endsection

@push('custom-scripts')
    <script>
        const main = async () => {
            const response = await fetch(`{{ route('admin.videos.get-videos') }}`);
            const videos = await response.json();
            const videoTable = document.getElementById('video-table');
            videoTable.innerHTML = '';
            videos.forEach(video => {
                const tr = document.createElement('tr');
                tr.innerHTML = `
                <td>${video.id}</td>
                <td><img src="${video.cover_image}" width="100" height="100"></td>
                <td>${video.title}</td>
                <td>${video.description}</td>
                <td>${video.category.name}</td>
                <td>${video.video_url}</td>
                <td>
                    <button class="btn btn-primary">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </td>
            `;
                videoTable.appendChild(tr);
            });
        }
        main()

        document.getElementById('add-new-video').addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(e.target);
            formData.append('_token', '{{ csrf_token() }}')
            const response = await fetch(`{{ route('admin.videos.store') }}`, {
                method: 'POST',
                body: formData
            });
            Swal.fire(
                'Success',
                await result.json().success,
                'success'
            )
            main()
        });
    </script>
@endpush
