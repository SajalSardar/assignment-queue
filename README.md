<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Login Info

-   **User Name:** admin@mail.com
-   **Password:** 12345678

## Controller

-   **UserInfoController:** Implemented upload and store process methos.
-   **uploadCsvFileReportController:** Implemented report generation methods in this controller.

## Table

-   **User_infos Table:** Stored user data in this table.
-   **csv_file_upload_reports:** Stored uploaded file short report in this table.

## Jobs

-   **ProcessUserInfoCsv:** Implemented Job Process in this file.

## Use 3rd party packages

-   **Laravel ui**
-   **yajra/laravel-datatables**
-   **laravolt/avatar**
-   **php-flasher/flasher-toastr-laravel**

## View

-   **layouts/backendapp:** Master app.
-   **home.blade:** Uploaded form html markup.
-   **user_info/index.blade:** Displayed all data in this file.
-   **user_info/report.blade:** Displayed uploaded csv file report in this file.
