<!-- @include('admin.includes.navbar') -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

@extends('admin.layouts.master')
@section('title', 'Quản lí bảo hành')
@section('content')
<div class="p-3">
            <!-- Nút mở Modal -->
            <!-- <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#warehouseModal">
                <i class='bx bx-plus'></i>
            </button> -->
            <table class="table table-hover shadow-sm">
                <thead>
                    <tr>
                    <th scope="col">ID khách hàng</th>
                    <th scope="col">ID sản phẩm</th>
                    <th scope="col">Chi phí bảo hành</th>
                    <th scope="col">Thời điểm bảo hành</th>
                    <th scope="col">Số seri</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    </tr>
                </tbody>
            </table>

            <nav aria-label="Page navigation example" class="d-flex justify-content-center">
                <ul class="pagination">
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                    </li>
                    <li class="page-item"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
            </nav>
</div>
@endsection