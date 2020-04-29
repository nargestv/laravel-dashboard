@extends('Admin.master')

@section('content')
    <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
        <div class="page-header head-section">
            <h2>مقام ها</h2>
            <div class="btn-group head-section">
                <a href="{{ route('permissions.create') }}" class="btn btn-sm btn-danger">ایجاد دسترسی</a>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <th>نام دسترسی</th>
                    <th>توضیحات</th>
                    <th>تنظیمات</th>
                </tr>
                </thead>
                <tbody>
                @foreach($permissions as $permission)
                    <tr>
                        <td>{{ $permission->name }}</td>
                        <td>{{ $permission->label }}</td>
                        <td>0</td>
                        <td>
                            <form action="{{ route('permissions.destroy' , [$permission->id]) }}" method="POST">
                                @method('DELETE')
                                @csrf
                                <div class="btn-group btn-group-xs">
                                    <a href="{{ route('permissions.edit', [$permission->id]) }}"  class="btn btn-primary">ویرایش</a>
                                    <button type="submit" class="btn btn-danger">حذف</button>
                                </div>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div style="text-align: center">
            {!! $permissions->render() !!}
        </div>
    </div>
@endsection
