Cài Microsoft SQL server 2000 Personal Edition (phải là Personal Edition nha bà con):
- Chạy file setup.exe
- Chọn "SQL Server 2000 Component"
- Chọn "Install Database Server"
- Nhấn Next
- Đánh dấu chọn vào "Local Computer" và nhấn Next
- Đánh dấu chọn vào phần "Create a new instance of SQL Server,or install Client" và nhấn Next
- Nhập vào tên bạn và tên công ty trong trường "Name", "Company"
- Chọn Yes trong phần Agreement
- Đánh dấu chọn vào "Server and Client Tools" và nhấn Next
- Đánh dấu chọn vào "Default" và nhấn Next
- Đánh dấu chọn vào "Typical" và nhấn Next
- Đánh dấu chọn vào "Use the same account for each service.Auto start SQL Server Service"
- Đánh dấu chọn vào "Use the Local System account" và nhấn Next
- Đánh dấu chọn vào "Windows Authenticatication Mode" và nhấn Next
- Nhấn Next đến quá trình cài đặt.
Sau khi cài đặt xong thì khởi động máy để khởi tạo hoạt động của SQL Server.
Cài đặt IIS
--> vào ControlPannel --> Add or Remove Programs --> chọn phần Add/remove Windows components -->Click đánh dấu vào Internet informations services (IIS) --> NEXT ...đến đây bạn phải bỏ CD cài đặt HĐH WinXP của bạn vào ...đợi ...sau đó bạn mở IE browser lên gỏ thử vào add dòng này http://localhost/ nếu có trang web hiện ra thì bạn thành công rùi đó ...tiếp tục
Thiếp lập IP:
Vào Control panel:
Chọn Add Hardware
Nhấn Next
Chọn Yes,…. Nhấn next
Hiện ra 1 cái bảng, kéo xuống dưới cùng thấy Add anew hardware device, chọn nó rồi Next.
Chọn Install the hardware that I manually select from a list (Advanced), Next.
Chọn Network Adapter, Next.
Chọn Microsoft Loopack Adapter, next, ok gì đó cho xong hết.
Vào Start/Run. Gõ cmd
Gõ ipconfig, Enter.
Xem cái dòng đầu tiên có số có dạng như thế này: 169.25.19.24, đó là IP của máy bạn.
cài MUserver ...
Giải nén cái Muserver vào D:\muserver
Tạo New Folder với tên là db trong thư mục muserver
Tạo database
Start --> Program --> Microsoft SQL Server 2000 --> Enterprise Manager
Bấm phải chuột vào Databases --> chọn New Database...
-Tab General: gõ vào MuOnline
- Tab Data files: bấm vào nút ... và chọn thư mục D:\muserver\db
- Tab Transaction Log: bấm vào nút ... và chọn thư mục D:\muserver\db
bấm OK
Bấm phải chuột vào MuOnline --> All Task --> Restore Database..
- Restore: chọn From Device
- Bấm vào Select Devices.. --> Add..
- Files Name : bấm vào nút ... và chọn D:\muserver\db baks\MuOnline, bấm OK 2 lần
- Chọn Tab Option đánh dấu vào mục Force restore over existing database
Mục Restore As: sửa các đường dẫn bên dưới vào thư mục db VD: D:\muserver\db\MuOnline_data.mdf và bấm Ok
Làm tương tự cho database Ranking
Start --> Program --> Microsoft SQL Server 2000 --> Enterprise Manager
chọn mục Security --> bấm phải chuột vào Logins và chọn New Login..
- Tab General:
+ Name: click vào nút ... chọn tên nào bắt đầu bằng IUSR_xxxxxxx ( xxxxxxx: là tên của SQL server), bấm Add, bấm OK
+ Default: Database chọn MuOnline
- Tab Server Roles: đánh dáu mục System Administrators
- Tab Database Access: chọn MuOnline và Ranking
2. Tạo các ODBC: chạy file ODBC để registry. Sau đó làm các bước sau.
Vào Start --> ControlPanel --> Performance & Maintenance --> Administrator Tool --> Data Sources (ODBC)
Chọn Tab System DSN: bạn thấy có rất nhiều mục phải không nào?
Double click vào MuOnline
Mục Server: Điền vào dấu “.” (dấu chấm). bấm nút Next 3 lần, bấm Finish (không thôi thì nhấn phím Enter 1 lần), và OK
Như vậy là bạn đã có được 1 ODBC, bạn làm tương tư cho các cái còn lại từ cái LocalServer
Thiết lập Server
Các IP trong các tập tin sau đây phải giống nhau :
D:\Muserver\CS\Data\Connectserverlist.dat
D:\Muserver\data\lang\chs\commonloc.cfg
D:\Muserver\data\commonserver.cfg
D:\Muserver\CS\Connectserverlist.dat
D:\Muserver\CS\Serverinfo.dat
D:\Muserver\data\IpList.dat
D:\Muserver\CS\Data\ServerList.dat
Ví dụ như ban đầu trong đó IP đã là 169.254.25.129 thì sửa nó lại thành IP của bạn đã có được ở trên.
vào Dataserver 1&2, vào thư mục data mở file wz_update lên chỉnh skipupdate=1
Tạo file login
Tạo 1 shortcut của file main vào properties của shortcut ở ô Target thêm vào connect /uIP /p44405
Ví dụ đây là shortcut của tôi [ "D:\Muoffline\main.exe" connect /192.168.1.30 /p44405 ]
Chỉnh Ram ảo, cần thiết để có thể chơi.
Click chuột phải, vào properties của Mycomputer -->tag Advanced --> chọn settings của dòng Performance --> Tag Advanced --> Change -->chọn những ở cứng còn trống nhiều --> click
chọn custom size ...dòng đầu gõ dung lượng sử dụng, dòng hai gõ dung lượng tối đa cho phép lấy---> nhấn SET --> OK (lấy khoảng 2K là được)

còn đây là các file:
ODBC
muserver
main.exe copy cái này đè vào file main của client Mu để chạy
MuEditor chình sửa nhân vật, account, item ..v..v
patch gameserver chép các file trong đây vào thư mục gameserver.
