@extends('frontend.layout_home')

@section('content')
    <main>
        @include('frontend.partials.sort_block')
        <div class="editInfoBlock editBlock">
            <div class="fixCen">
                <h2 class="title">Thông tin doanh nghiệp</h2>
                <a href="javascript:void(0)" class="btnEdit btnEditHomeUser" data-edit="#CorInfo" title="Chỉnh sửa">
                    <span>Chỉnh sửa</span>
                    <img src="/frontend/assets/img/i_pen.png" alt="" class="imgFull">
                </a>
                <div class="box">
                    <form action="{{ route('frontend.post_profile') }}" method="POST" id="CorInfo" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <input type="hidden" name="company_id" value="{{ $company->id }}" />
                        <div class="form-group">
                            <label class="left" for="nameOfCor">* Tên doanh nghiệp</label>
                            <input type="text" name="name" class="right" id="nameOfCor" value="{{ $company->name }}" disabled style="font-weight: bold;">
                        </div>
                        <div class="form-group">
                            <label class="left" for="nameOfBrand">Tên thương hiệu</label>
                            <input type="text" name="brand_name" class="right" id="nameOfBrand" value="{{ $company->brand_name }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="mainOffice">Trụ sở chính</label>
                            <input type="text" name="main_address" class="right" id="mainOffice" value="{{ $company->main_address }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="left" for="phoneNumber">* Số điện thoại</label>
                            <input type="tel" name="contact_phone" class="right" id="phoneNumber" value="{{ $company->contact_phone }}" disabled>
                        </div>
                        <div class="form-group db">
                            <div class="current">
                                <label class="left" for="logoOfCor">* Logo</label>
                                @if ($company->logo)
                                    <div class="imgThumb right">
                                        <img src="{{ url($company->logo) }}" />
                                    </div>
                                @endif
                            </div>
                            <div class="edit disabled" id="editLogoCor">
                                <label class="left" for="uploadBlock">* Logo</label>
                                <div id="uploadBlock" class="right">
                                    <p><strong>Cập nhật logo doanh nghiệp</strong></p>
                                    <p>
                                        Logo sẽ hiển thị với tất cả mọi người, <br>Logo được hiển thị trên các hồ sơ của doanh nghiệp
                                    </p>
                                    <p>
                                        <input name="logo" type="file" id="btnEditImg"/>
                                        <span>File ảnh không quá 1mb</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="left" for="businessSector">* Lĩnh vực kinh doanh</label>
                            <select type="text" name="business_field_id" class="right" id="businessSector" disabled>
                                @foreach (\App\Models\Business::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="numberOfStaff">* Số lượng nhân viên</label>
                            <select type="text" name="employee_number_id" class="right" id="numberOfStaff" disabled>
                                @foreach (\App\Models\Employee::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="averageRevenue">Doanh thu bình quân năm</label>
                            <select type="text" name="average_income_id" class="right" id="averageRevenue" disabled>
                                @foreach (\App\Models\Income::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="left" for="totalResources">Tổng nguồn vốn</label>
                            <select type="text" id="total_fund_id" class="right" id="totalResources" disabled>
                                @foreach (\App\Models\Fund::all() as $content)
                                    <option value="{{ $content->id }}">{{ $content->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="button" onclick="window.location.reload(); return false;">Bỏ qua</button>
                            <button type="button" class="myBtn btnSave">Lưu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('after_scripts')
    <script>
        $(function(){
            $('.btnSave').click(function(){
                $('#CorInfo').submit();
                return false;
            });
        });
    </script>
@endsection

