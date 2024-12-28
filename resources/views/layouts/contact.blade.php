@extends('layouts.index')
@section('content')
<section class="bg-success py-5">
    <div class="container">
        <div class="row align-items-center py-5">
            <div class="col-md-8 mx-auto">
                <h1 class="mb-4 text-uppercase text-center text-white font-weight-bold">Thông Tin Của Tôi</h1>
                <table class="table table-bordered table-striped table-hover bg-white text-dark">
                    <tbody>
                        <tr>
                            <th scope="row" class="w-25">Tên:</th>
                            <td>Nguyễn Minh Nhựt</td>
                        </tr>
                        <tr>
                            <th scope="row">Tuổi:</th>
                            <td>24</td>
                        </tr>
                        <tr>
                            <th scope="row">Ngày sinh:</th>
                            <td>21/12/2000</td>
                        </tr>
                        <tr>
                            <th scope="row">Lớp:</th>
                            <td>18CSI01</td>
                        </tr>
                        <tr>
                            <th scope="row">Ngành:</th>
                            <td>Công nghệ thông tin (UDPM)</td>
                        </tr>
                        
                        <tr>
                            <th scope="row">Quê quán:</th>
                            <td>Đồng Tháp</td>
                        </tr>
                        <tr>
                            <th scope="row">Email:</th>
                            <td>22661135@kthcm.edu.vn</td>
                        </tr>
                        <tr>
                            <th scope="row">SĐT:</th>
                            <td>0813310032</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection