## SenPlus

### Install Commands logs

```textmate
11  composer require backpack/permissionmanager
12  php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="migrations"
13  php artisan migrate
14  php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider" --tag="config"
15  php artisan vendor:publish --provider="Backpack\PermissionManager\PermissionManagerServiceProvider"
16  composer require backpack/settings
17  php artisan vendor:publish --provider="Backpack\Settings\SettingsServiceProvider"
18  php artisan migrate
19  php artisan backpack:add-sidebar-content "<li class='nav-item'><a class='nav-link' href='{{ backpack_url('setting') }}'><i class='nav-icon fa fa-cog'></i> Settings</a></li>"
20  composer require backpack/filemanager
21  php artisan backpack:filemanager:install
22  git status
23  git add . && git commit -m update && git push origin master
24  chmod -R 777 public/uploads

```

* I was install backpack settings, backpack file manager and also backpack permission.

* Currently user have 2 roles `admin` and `editor`.


### Log chat explain

```textmate
với cả nó còn chia vòng một vòng 2

đúng rồi cả 12 câu đó e cần có quyền sửa khi cần
à, có chức năng này e mới nhớ ra trong bản mô tả của e chưa có
a thêm cho e chức năng tự động chấm điểm random toàn bộ các câu nhé
phòng trường hợp e demo cho khách hàng đỡ phải nhập tay mà bấm 1 nút nào đó nó tự random điểm hết cho e

nút đấy nó sẽ nằm ở đâu em?

trong giao diện quản trị của em, a có thể để nó ở trang đầu tiên của bài test

chức năng này chỉ Senplus có, khách hàng k có a nhé

phần câu hỏi cho user cá nhân là mình cũng có cố định 12 câu nhỉ

vâng
cá nhân là cố định

sau khi user trả lời xong 12 câu trong phần doanh nghiệp thì mình phải show cái bảng 4 tiêu chí và vẽ cái biểu đồ

từ cái dữ liệu trả lời ra cái bảng đó tính kiểu gì em nhỉ

em có công thức
em họp xong e gửi cho a nhé


Khảo sát sức mạnh nền móng - CSS - OCAI.xlsx

e giải thích nhé
mỗi vòng có 6 câu hỏi
thứ tự lần lượt: 
Câu 1 cho ra số liệu của Đặc điểm nổi trội
câu 2: phong cách lãnh đạo
vv... câu 6: tiêu chí thành công

vòng 1 là số liệu của cột đánh giá
vòng 2 là số liệu của cột cần thiết

mỗi câu hỏi có 4 khẳng định để chấm điểm
theo thứ tự từ trên xuống
số 1 -> gia đình
số 2 -> sáng tạo
số 3 -> thị trường
số 4 -> kiểm soát
số liệu được cộng trung bình và chia đều theo

ok anh hieu roai

vậy có tất cả 7 bảng số liệu, 
6 bảng chi tiết như trong excel và 
1 bảng tổng hợp là trung bình cộng của 6 bảng chi tiết

ok a!
tên các tiêu chí có thể có sự thay đổi a nhé, cái này e đang chốt lại chút với blđ vì họ muốn dùng từ khác
nhưng về cơ bản chỉ thay đổi chữ chứ không thay đổi phần công thức

```