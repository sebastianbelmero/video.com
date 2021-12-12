@extends('layouts.admin')

@section('title', 'Categories')
@section('content')

    <!-- Button trigger modal -->
    <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#newCategoryModal">
        Add New
    </button>

    <!-- New Modal -->
    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="newCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="add-new-category">
                <div class="modal-header">
                    <h5 class="modal-title" id="newCategoryModalLabel">Add Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="category" placeholder="Category" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" id="add-new-category">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCategoryModalLabel">Edit Categories</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Category</label>
                        <input type="text" class="form-control" id="newCategory" placeholder="Category" name="name">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Save</button>
                </div>
            </form>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="category-table"></tbody>
    </table>
@endsection
@push('custom-scripts')
    <script>
        const main = async () => {
            const result = await fetch('{{ route('admin.categories.get-categories') }}')
            const categories = await result.json()
            const table = document.getElementById('category-table')
            table.innerHTML = ''
            categories.forEach(category => {
                const row = document.createElement('tr')
                row.innerHTML = `
                <td>${category.id}</td>
                <td>${category.name}</td>
                <td>
                    <button onclick="editCategory(${category.id})" data-bs-toggle="modal" data-bs-target="#editCategoryModal" class="btn btn-primary btn-sm">Edit</button>
                    <button onclick="hapusCategory(${category.id})" class="btn btn-danger btn-sm">Delete</button>
                </td>
            `
                table.appendChild(row)
            })
        }
        main()

        document.getElementById('add-new-category').addEventListener('submit', async (e) => {
            e.preventDefault()
            const form = new FormData()
            form.append('_token', '{{ csrf_token() }}')
            form.append('name', document.getElementById('category').value)
            try {
                const result = await fetch('{{ route('admin.categories.store') }}', {
                    method: 'POST',
                    body: form
                })
                Swal.fire(
                    'Success',
                    await result.json().success,
                    'success'
                )

            } catch (error) {
                Swal.fire(
                    'Failed',
                    'Failed to add category',
                    'error'
                )
            }
            main()
        })

        const hapusCategory = async (id) => {
            Swal.fire({
                title: 'Delete Category',
                text: "This category will be deleted",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel'
            }).then(async (result) => {
                if (result.isConfirmed) {
                    const url = `{{ route('admin.categories.destroy', ':id') }}`
                    try {
                        const result = await fetch(url.replace(':id', id), {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }} '
                            }
                        })
                        Swal.fire(
                            'Success',
                            await result.json().success,
                            'success'
                        )
                    } catch (error) {
                        Swal.fire(
                            'Failed',
                            'Failed to delete category',
                            'error'
                        )
                    }
                    main()
                }
            })
        }


        const editCategory = async (id) => {
            const result = await fetch(`{{ route('admin.categories.edit', ':id') }}`.replace(':id', id))
            const category = await result.json()
            document.getElementById('newCategory').value = category.name
            document.getElementById('editCategoryModal').addEventListener('submit', async (e) => {
                e.preventDefault()
                const form = new FormData()
                form.append('_token', '{{ csrf_token() }}')
                form.append('name', document.getElementById('newCategory').value)
                try {
                    const result = await fetch(`{{ route('admin.categories.update', ':id') }}`
                        .replace(':id', id), {
                            method: 'POST',
                            body: form,
														headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }} '
                            }
                        })
                    Swal.fire(
                        'Success',
                        await result.json().success,
                        'success'
                    )
                } catch (error) {
                    Swal.fire(
                        'Failed',
                        'Failed to edit category',
                        'error'
                    )
                }
                main()
            })
        }
    </script>
@endpush
